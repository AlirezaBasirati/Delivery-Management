<?php

namespace App\Services\MessageService\Tests\Feature\Admin\StaticMessageGroup;

use App\Services\FleetService\Models\Driver;
use App\Services\MessageService\Models\StaticMessageGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StaticMessageGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshApplication();
        $this->seed();

        /** @var Driver $driver */
        $driver = Driver::query()
            ->where('status', true)
            ->where('is_free', true)
            ->first();

        $this->driver = $driver;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create(): void
    {
        $data = StaticMessageGroup::factory()->make()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/admin/v1/static-message-groups', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'title'   => $data['title'],
                    'name'    => $data['name'],
                    'reserve' => $data['reserve']
                ]
            ]);
    }

    public function test_update()
    {
        $data = StaticMessageGroup::factory()->create()->toArray();
        $id = $data['id'];

        $data = StaticMessageGroup::factory()->make()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->patchJson('/api/admin/v1/static-message-groups/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'      => $id,
                    'title'   => $data['title'],
                    'name'    => $data['name'],
                    'reserve' => $data['reserve']
                ]
            ]);
    }

    public function test_list()
    {
        StaticMessageGroup::factory()->count(100)->create();

        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/admin/v1/static-message-groups');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll('id', 'title', 'name', 'reserve')
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = StaticMessageGroup::factory()->create()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/admin/v1/static-message-groups/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'      => $data['id'],
                    'title'   => $data['title'],
                    'name'    => $data['name'],
                    'reserve' => $data['reserve']
                ]
            ]);
    }

    public function test_delete()
    {
        $data = StaticMessageGroup::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this->actingAs($this->driver->user)
            ->delete('/api/admin/v1/static-message-groups/' . $id);

        $response->assertOk();
    }


    /** @dataProvider invalidCreateData */
    public function test_create_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->driver->user)
            ->post('/api/admin/v1/static-message-groups', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidCreateData(): array
    {
        $data = StaticMessageGroup::factory()->create()->toArray();

        $title_required = $data;
        $title_string = $data;

        unset($title_required['title']);
        $title_string['title'] = rand();

        $message_required = $data;
        $message_string = $data;

        unset($message_required['name']);
        $message_string['name'] = rand();

        return [
            'title.required' => [$title_required, 'title'],
            'title.string'   => [$title_string, 'title'],

            'name.required' => [$message_required, 'name'],
            'name.string'   => [$message_string, 'name'],
        ];
    }


    /** @dataProvider invalidUpdateData */
    public function test_update_validation(array $data, string $invalid)
    {
        $static_message = StaticMessageGroup::factory()->create();

        $response = $this->actingAs($this->driver->user)
            ->patchJson('/api/admin/v1/static-message-groups/' . $static_message->id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidUpdateData(): array
    {
        $data = StaticMessageGroup::factory()->create()->toArray();

        $title_string = $data;
        $title_string['title'] = rand();

        $message_string = $data;
        $message_string['name'] = rand();

        return [
            'title.string' => [$title_string, 'title'],
            'name.string'  => [$message_string, 'name']
        ];
    }
}
