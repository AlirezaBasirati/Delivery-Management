<?php

namespace App\Services\OrderService\Tests\Feature\Customer\Order;

use App\Services\AuthenticationService\Models\User;
use App\Services\OrderService\Tests\Feature\Statics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');

        $this->user = Statics::selectCustomerUser();
    }

    /**
     * create an order from admin
     *
     * @return void
     */
    public function test_create_order(): void
    {
        $order = Statics::orderData();

        $response = $this->actingAs($this->user)
            ->postJson('/api/admin/v1/orders', $order);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id'
                ]
            ]);
    }

    /** @dataProvider invalidCreateData */
    public function test_create_validation(array $data, string $invalid)
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/admin/v1/orders', $data);

        $response->assertInvalid($invalid, responseKey: 'data');
    }

    public function invalidCreateData(): array
    {
        $this->refreshApplication();
        $data = Statics::orderData();

        // code
        $code_string = $data;
        $code_string['code'] = rand();

        $code_max_character = $data;
        $code_max_character['code'] = $code_max_character['code'] . fake()->text(40);

        // parcel_value
        $parcel_value_integer = $data;
        $parcel_value_integer['parcel_value'] = fake()->title;

        // type
        $type_enum = $data;
        $type_enum['type'] = fake()->title;

        // cod_amount
        $cod_amount_integer = $data;
        $cod_amount_integer['cod_amount'] = fake()->title;

        // package_quantity
        $package_quantity_integer = $data;
        $package_quantity_integer['package_quantity'] = fake()->title;

        // items
        $items_array = $data;
        $items_array['items'] = fake()->title;

        // items.*.material_code
        $material_code_required = $data;
        unset($material_code_required['items'][0]['material_code']);

        $material_code_string = $data;
        $material_code_string['items'][0]['material_code'] = rand();

        // items.*.name
        $items_name_required = $data;
        unset($items_name_required['items'][0]['name']);

        $items_name_string = $data;
        $items_name_string['items'][0]['name'] = rand();

        // items.*.quantity
        $quantity_required = $data;
        unset($quantity_required['items'][0]['quantity']);

        $quantity_numeric = $data;
        $quantity_numeric['items'][0]['quantity'] = fake()->title;

        // items.*.size
        $size_string = $data;
        $size_string['items'][0]['size'] = rand();

        // items.*.weight
        $weight_numeric = $data;
        $weight_numeric['items'][0]['weight'] = fake()->title;

        // locations
        $locations_required = $data;
        unset($locations_required['locations']);

        $locations_array = $data;
        $locations_array['locations'] = fake()->title;

        // locations.*.latitude
        $latitude_required = $data;
        unset($latitude_required['locations'][0]['latitude']);

        $latitude_invalid = $data;
        $latitude_invalid['locations'][0]['latitude'] = fake()->latitude(90, 100);

        // locations.*.longitude
        $longitude_required = $data;
        unset($longitude_required['locations'][0]['longitude']);

        $longitude_invalid = $data;
        $longitude_invalid['locations'][0]['longitude'] = fake()->longitude(180, 190);

        // locations.*.name
        $locations_name_required = $data;
        unset($locations_name_required['locations'][0]['name']);

        $locations_name_string = $data;
        $locations_name_string['locations'][0]['name'] = rand();

        // locations.*.address
        $locations_address_required = $data;
        unset($locations_address_required['locations'][0]['address']);

        $locations_address_string = $data;
        $locations_address_string['locations'][0]['address'] = rand();

        // locations.*.phone
        $locations_phone_required = $data;
        unset($locations_phone_required['locations'][0]['phone']);

        $locations_phone_string = $data;
        $locations_phone_string['locations'][0]['phone'] = rand();

        // locations.*.postal_code
        $postal_code_string = $data;
        $postal_code_string['locations'][0]['postal_code'] = rand();

        $postal_code_digits = $data;
        $postal_code_digits['locations'][0]['postal_code'] = fake()->postcode() . rand(1000000000, 9999999999);

        // type
        $locations_type_required = $data;
        unset($locations_type_required['locations'][0]['type']);

        $locations_type_enum = $data;
        $locations_type_enum['locations'][0]['type'] = fake()->title;

        return [
            'code.string'                  => [$code_string, 'code'],
            'code.max_character'           => [$code_max_character, 'code'],
            'parcel_value.string'          => [$parcel_value_integer, 'parcel_value'],
            'type.enum'                    => [$type_enum, 'type'],
            'cod_amount.string'            => [$cod_amount_integer, 'cod_amount'],
            'package_quantity.string'      => [$package_quantity_integer, 'package_quantity'],
            'items.array'                  => [$items_array, 'items'],
            'material_code.required'       => [$material_code_required, 'items.0.material_code'],
            'material_code.string'         => [$material_code_string, 'items.0.material_code'],
            'items.name.required'          => [$items_name_required, 'items.0.name'],
            'items.name.string'            => [$items_name_string, 'items.0.name'],
            'quantity.required'            => [$quantity_required, 'items.0.quantity'],
            'quantity.string'              => [$quantity_numeric, 'items.0.quantity'],
            'size.string'                  => [$size_string, 'items.0.size'],
            'weight.numeric'               => [$weight_numeric, 'items.0.weight'],
            'locations.required'           => [$locations_required, 'locations'],
            'locations.array'              => [$locations_array, 'locations'],
            'latitude.required'            => [$latitude_required, 'locations.0.latitude'],
            'latitude.invalid'             => [$latitude_invalid, 'locations.0.latitude'],
            'longitude.required'           => [$longitude_required, 'locations.0.longitude'],
            'longitude.invalid'            => [$longitude_invalid, 'locations.0.longitude'],
            'location.name.required'       => [$locations_name_required, 'locations.0.name'],
            'location.name.string'         => [$locations_name_string, 'locations.0.name'],
            'location.address.required'    => [$locations_address_required, 'locations.0.address'],
            'location.address.string'      => [$locations_address_string, 'locations.0.address'],
            'location.phone.required'      => [$locations_phone_required, 'locations.0.phone'],
            'location.phone.string'        => [$locations_phone_string, 'locations.0.phone'],
            'location.postal_code.string'  => [$postal_code_string, 'locations.0.postal_code'],
            'location.postal_code.digits'  => [$postal_code_digits, 'locations.0.postal_code'],
            'location.type.required'       => [$locations_type_required, 'locations.0.type'],
            'location.type.enum'           => [$locations_type_enum, 'locations.0.type'],
        ];
    }
}
