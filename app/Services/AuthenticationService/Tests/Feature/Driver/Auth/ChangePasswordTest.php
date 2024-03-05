<?php

namespace App\Services\AuthenticationService\Tests\Feature\Driver\Auth;

use App\Services\FleetService\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_check_exist_user(): void
    {
        $driver = Driver::factory()->create();
        $user = $driver->user;
        $password = (string)rand();

        $response = $this->actingAs($user)
            ->patchJson('/api/driver/v1/auth/change-password', [
                'password'              => $password,
                'password_confirmation' => $password
            ]);

        $response->assertSuccessful();
    }
}
