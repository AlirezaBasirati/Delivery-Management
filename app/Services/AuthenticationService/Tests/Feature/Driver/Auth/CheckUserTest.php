<?php

namespace App\Services\AuthenticationService\Tests\Feature\Driver\Auth;

use App\Services\FleetService\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }

    public function test_check_exist_user(): void
    {
        $driver = Driver::factory()->create();
        $user = $driver->user;

        $response = $this->postJson('/api/driver/v1/auth/check', [
            'username' => $user->mobile,
            'otp'      => false
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'data' => [
                    'exist'        => true,
                    'has_password' => true
                ]
            ]);
    }

    public function test_check_not_exist_user(): void
    {
        $response = $this->postJson('/api/driver/v1/auth/check', [
            'username' => '09' . rand(100000000, 999999999),
            'otp'      => false
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'data' => [
                    'exist'        => false,
                    'has_password' => false
                ]
            ]);
    }
}
