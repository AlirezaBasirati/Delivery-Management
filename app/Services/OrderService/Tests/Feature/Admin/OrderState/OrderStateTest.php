<?php

namespace App\Services\OrderService\Tests\Feature\Admin\OrderState;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Models\OrderState;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrderStateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = Statics::selectAdminUser();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create(): void
    {
        $data = OrderState::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->postJson('/api/admin/v1/order-states', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'title' => $data['title'],
                    'name'  => $data['name'],
                ]
            ]);
    }

    public function test_update()
    {
        $data = OrderState::factory()->create()->toArray();
        $id = $data['id'];

        $data = OrderState::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->patchJson('/api/admin/v1/order-states/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'title' => $data['title'],
                    'name'  => $data['name'],
                ]
            ]);
    }

    public function test_list()
    {
        OrderState::factory()->count(100)->create();

        $response = $this->actingAs($this->user)
            ->getJson('/api/admin/v1/order-states');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll('id', 'title', 'name')
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = OrderState::factory()->create()->toArray();

        $response = $this->actingAs($this->user)
            ->getJson('/api/admin/v1/order-states/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'title' => $data['title'],
                    'name'  => $data['name'],
                ]
            ]);
    }

    public function test_delete()
    {
        $data = OrderState::factory()->create()->toArray();

        $response = $this->actingAs($this->user)
            ->delete('/api/admin/v1/order-states/' . $data['id']);

        $response->assertOk();
    }


    /** @dataProvider invalidCreateData */
    public function test_create_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->user)
            ->post('/api/admin/v1/order-states', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public function invalidCreateData(): array
    {
        $this->refreshApplication();
        $data = OrderState::factory()->make()->toArray();

        // title
        $title_required = $data;
        unset($title_required['title']);

        $title_string = $data;
        $title_string['title'] = rand();

        $title_max_character = $data;
        $title_max_character['title'] = $title_max_character['title'] . fake()->text(30);

        // name
        $name_required = $data;
        unset($name_required['name']);

        $name_string = $data;
        $name_string['name'] = rand();

        $name_max_character = $data;
        $name_max_character['name'] = $name_max_character['name'] . fake()->text(30);

        return [
            'title.required'          => [$title_required, 'title'],
            'title.string'            => [$title_string, 'title'],
            'title.max_character'     => [$title_max_character, 'title'],
            'name.required'           => [$name_required, 'name'],
            'name.string'             => [$name_string, 'name'],
            'name.max_character'      => [$name_max_character, 'name'],
        ];
    }


    /** @dataProvider invalidUpdateData */
    public function test_update_validation(array $data, string $invalid)
    {
        $static_message = OrderState::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson('/api/admin/v1/order-states/' . $static_message->id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public function invalidUpdateData(): array
    {
        $this->refreshApplication();
        $data = OrderState::factory()->make()->toArray();

        // title
        $title_string = $data;
        $title_string['title'] = rand();

        $title_max_character = $data;
        $title_max_character['title'] = $title_max_character['title'] . fake()->text(30);

        // name
        $name_string = $data;
        $name_string['name'] = rand();

        $name_max_character = $data;
        $name_max_character['name'] = $name_max_character['name'] . fake()->text(30);

        return [
            'title.string'          => [$title_string, 'title'],
            'title.max_character'   => [$title_max_character, 'title'],
            'name.string'           => [$name_string, 'name'],
            'name.max_character'    => [$name_max_character, 'name'],
        ];
    }
}
