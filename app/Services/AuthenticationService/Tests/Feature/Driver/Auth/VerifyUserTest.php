<?php

namespace App\Services\AuthenticationService\Tests\Feature\Driver\Auth;

use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifyUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }

    public function test_verify_exist_user(): void
    {
        $user_service = $this->app->make(UserInterface::class);
        $user = $user_service->index(['paginate' => false, 'role_id' => [Role::DRIVER->value]])->first();

        $response = $this->postJson('/api/driver/v1/auth/verify', [
            'username' => $user->mobile,
            'password' => 'password'
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'auth'
                ]
            ]);
    }

    public function test_verify_not_exist_user(): void
    {
        $response = $this->postJson('/api/driver/v1/auth/verify', [
            'username' => '09' . rand(100000000, 999999999),
            'password' => 'password'
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'data' => [
                    'username' => [__('authentication::authentication.incorrect')]
                ]
            ]);
    }
}
