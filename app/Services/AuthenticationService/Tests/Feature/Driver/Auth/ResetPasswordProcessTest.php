<?php

namespace App\Services\AuthenticationService\Tests\Feature\Driver\Auth;

use App\Services\AuthenticationService\Models\Temporary;
use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordProcessTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }

    public function test_reset_password_process_after_login(): void
    {
        $user_service = $this->app->make(UserInterface::class);
        $user = $user_service->index(['paginate' => false, 'role_id' => [Role::DRIVER->value]])->first();

        $code = (string) rand(1000, 9999);

        Temporary::query()->updateOrCreate([
            'mobile' => $user->mobile
        ], [
            'code'    => $code,
            'retries' => 1,
            'send_at' => now()
        ]);

        $response = $this->postJson('/api/driver/v1/auth/reset', [
            'username' => $user->mobile,
            'code'     => $code
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'code'
                ]
            ]);

        $code = $response->json('data.code');
        $password = (string) rand();

        $response = $this->postJson('/api/driver/v1/auth/set-password', [
            'code'                  => $code,
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'auth'
                ]
            ]);
    }
}
