<?php

namespace App\Services\MessageService\Tests\Feature\Admin\StaticMessage;

use App\Services\FleetService\Models\Driver;
use App\Services\MessageService\Models\StaticMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StaticMessageTest extends TestCase
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
        $data = StaticMessage::factory()->make()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->postJson('/api/admin/v1/static-messages', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'group'     => [
                        'id' => $data['group_id']
                    ],
                    'title'     => $data['title'],
                    'message'   => $data['message'],
                    'is_active' => $data['is_active']
                ]
            ]);
    }

    public function test_update()
    {
        $data = StaticMessage::factory()->create()->toArray();
        $id = $data['id'];

        $data = StaticMessage::factory()->make()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->patchJson('/api/admin/v1/static-messages/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'        => $id,
                    'group'     => [
                        'id' => $data['group_id']
                    ],
                    'title'     => $data['title'],
                    'message'   => $data['message'],
                    'is_active' => $data['is_active']
                ]
            ]);
    }

    public function test_list()
    {
        StaticMessage::factory()->count(100)->create();

        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/admin/v1/static-messages');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll('id', 'title', 'message')
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = StaticMessage::factory()->create()->toArray();

        $response = $this->actingAs($this->driver->user)
            ->getJson('/api/admin/v1/static-messages/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'group'     => [
                        'id' => $data['group_id']
                    ],
                    'title'     => $data['title'],
                    'message'   => $data['message'],
                    'is_active' => $data['is_active']
                ]
            ]);
    }

    public function test_delete()
    {
        $data = StaticMessage::factory()->create()->toArray();
        $id = $data['id'];

        $response = $this->actingAs($this->driver->user)
            ->delete('/api/admin/v1/static-messages/' . $id);

        $response->assertOk();
    }


    /** @dataProvider invalidCreateData */
    public function test_create_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->driver->user)
            ->post('/api/admin/v1/static-messages', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidCreateData(): array
    {
        $data = StaticMessage::factory()->create()->toArray();

        $title_required = $data;
        $title_string = $data;

        unset($title_required['title']);
        $title_string['title'] = rand();

        $message_required = $data;
        $message_string = $data;

        unset($message_required['message']);
        $message_string['message'] = rand();

        $group_id_required = $data;
        $group_id_exists = $data;

        unset($group_id_required['group_id']);
        $group_id_exists['group_id'] = 'not-valid-id';

        return [
            'title.required' => [$title_required, 'title'],
            'title.string'   => [$title_string, 'title'],

            'message.required' => [$message_required, 'message'],
            'message.string'   => [$message_string, 'message'],

            'group_id.required' => [$group_id_required, 'group_id'],
            'group_id.exists'   => [$group_id_exists, 'group_id'],
        ];
    }


    /** @dataProvider invalidUpdateData */
    public function test_update_validation(array $data, string $invalid)
    {
        $static_message = StaticMessage::factory()->create();

        $response = $this->actingAs($this->driver->user)
            ->patchJson('/api/admin/v1/static-messages/' . $static_message->id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public static function invalidUpdateData(): array
    {
        $data = StaticMessage::factory()->create()->toArray();

        $title_string = $data;
        $title_string['title'] = rand();

        $message_string = $data;
        $message_string['message'] = rand();

        $group_id_exists = $data;
        $group_id_exists['group_id'] = 'not-valid-id';

        return [
            'title.string'    => [$title_string, 'title'],
            'message.string'  => [$message_string, 'message'],
            'group_id.exists' => [$group_id_exists, 'group_id'],
        ];
    }
}
