<?php

namespace App\Services\OrderService\Tests\Feature\Admin\OrderStatus;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Models\OrderStatus;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrderStatusTest extends TestCase
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
        $data = OrderStatus::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->postJson('/api/admin/v1/order-statuses', $data);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'code'        => $data['code'],
                    'title'       => $data['title'],
                    'name'        => $data['name'],
                    'for_driver'  => $data['for_driver'],
                    'reserve'     => $data['reserve'],
                    'sort'        => $data['sort'],
                    'state'       => [
                        'id' => $data['state_id']
                    ],
                    'next_status' => [
                        'id' => $data['next_status_id']
                    ]
                ]
            ]);
    }

    public function test_update()
    {
        $data = OrderStatus::factory()->create()->toArray();
        $id = $data['id'];

        $data = OrderStatus::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->patchJson('/api/admin/v1/order-statuses/' . $id, $data);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'          => $id,
                    'code'        => $data['code'],
                    'title'       => $data['title'],
                    'name'        => $data['name'],
                    'for_driver'  => $data['for_driver'],
                    'reserve'     => $data['reserve'],
                    'sort'        => $data['sort'],
                    'state'       => [
                        'id' => $data['state_id']
                    ],
                    'next_status' => [
                        'id' => $data['next_status_id']
                    ]
                ]
            ]);
    }

    public function test_list()
    {
        OrderStatus::factory()->count(100)->create();

        $response = $this->actingAs($this->user)
            ->getJson('/api/admin/v1/order-statuses');

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('messages', 'meta')
                ->has('data', 15, fn($json) => $json
                    ->hasAll('id', 'code', 'title', 'name')
                    ->etc()
                )
            );
    }

    public function test_show()
    {
        $data = OrderStatus::factory()->create()->toArray();

        $response = $this->actingAs($this->user)
            ->getJson('/api/admin/v1/order-statuses/' . $data['id']);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id'          => $data['id'],
                    'code'        => $data['code'],
                    'title'       => $data['title'],
                    'name'        => $data['name'],
                    'for_driver'  => $data['for_driver'],
                    'reserve'     => $data['reserve'],
                    'sort'        => $data['sort'],
                    'state'       => [
                        'id' => $data['state_id']
                    ],
                    'next_status' => [
                        'id' => $data['next_status_id']
                    ]
                ]
            ]);
    }

    public function test_delete()
    {
        $data = OrderStatus::factory()->create()->toArray();

        $response = $this->actingAs($this->user)
            ->delete('/api/admin/v1/order-statuses/' . $data['id']);

        $response->assertOk();
    }


    /** @dataProvider invalidCreateData */
    public function test_create_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->user)
            ->post('/api/admin/v1/order-statuses', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public function invalidCreateData(): array
    {
        $this->refreshApplication();
        $data = OrderStatus::factory()->make()->toArray();

        // next_status_id
        $next_status_id_required = $data;
        unset($next_status_id_required['next_status_id']);

        $next_status_id_exists = $data;
        $next_status_id_exists['next_status_id'] = 'not-valid-id';

        // state_id
        $state_id_required = $data;
        unset($state_id_required['state_id']);

        $state_id_exists = $data;
        $state_id_exists['state_id'] = 'not-valid-id';

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

        // sort
        $sort_required = $data;
        unset($sort_required['sort']);

        $sort_numeric = $data;
        $sort_numeric['sort'] = fake()->title;

        // code
        $code_required = $data;
        unset($code_required['code']);

        $code_string = $data;
        $code_string['code'] = rand();

        $code_max_character = $data;
        $code_max_character['code'] = $code_max_character['code'] . fake()->text(30);

        return [
            'next_status_id.required' => [$next_status_id_required, 'next_status_id'],
            'next_status_id.exists'   => [$next_status_id_exists, 'next_status_id'],
            'state_id.required'       => [$state_id_required, 'state_id'],
            'state_id.exists'         => [$state_id_exists, 'state_id'],
            'title.required'          => [$title_required, 'title'],
            'title.string'            => [$title_string, 'title'],
            'title.max_character'     => [$title_max_character, 'title'],
            'name.required'           => [$name_required, 'name'],
            'name.string'             => [$name_string, 'name'],
            'name.max_character'      => [$name_max_character, 'name'],
            'sort.required'           => [$sort_required, 'sort'],
            'sort.numeric'            => [$sort_numeric, 'sort'],
            'code.required'           => [$code_required, 'code'],
            'code.string'             => [$code_string, 'code'],
            'code.max_character'      => [$code_max_character, 'code'],
        ];
    }


    /** @dataProvider invalidUpdateData */
    public function test_update_validation(array $data, string $invalid)
    {
        $static_message = OrderStatus::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson('/api/admin/v1/order-statuses/' . $static_message->id, $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }


    public function invalidUpdateData(): array
    {
        $this->refreshApplication();
        $data = OrderStatus::factory()->make()->toArray();

        // next_status_id
        $next_status_id_exists = $data;
        $next_status_id_exists['next_status_id'] = 'not-valid-id';

        // state_id
        $state_id_exists = $data;
        $state_id_exists['state_id'] = 'not-valid-id';

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

        // sort
        $sort_numeric = $data;
        $sort_numeric['sort'] = fake()->title;

        // code
        $code_string = $data;
        $code_string['code'] = rand();

        $code_max_character = $data;
        $code_max_character['code'] = $code_max_character['code'] . fake()->text(30);

        return [
            'next_status_id.exists' => [$next_status_id_exists, 'next_status_id'],
            'state_id.exists'       => [$state_id_exists, 'state_id'],
            'title.string'          => [$title_string, 'title'],
            'title.max_character'   => [$title_max_character, 'title'],
            'name.string'           => [$name_string, 'name'],
            'name.max_character'    => [$name_max_character, 'name'],
            'sort.numeric'          => [$sort_numeric, 'sort'],
            'code.string'           => [$code_string, 'code'],
            'code.max_character'    => [$code_max_character, 'code'],
        ];
    }
}
