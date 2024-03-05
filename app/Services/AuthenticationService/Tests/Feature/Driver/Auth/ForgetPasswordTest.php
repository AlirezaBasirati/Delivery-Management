<?php

namespace App\Services\AuthenticationService\Tests\Feature\Driver\Auth;

use App\Services\AuthenticationService\Repository\V1\Common\User\UserInterface;
use App\Services\AuthorizationService\Enumerations\V1\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }

    public function test_forget_exist_user(): void
    {
        $user_service = $this->app->make(UserInterface::class);
        $user = $user_service->index(['paginate' => false, 'role_id' => [Role::DRIVER->value]])->first();

        $response = $this->postJson('/api/driver/v1/auth/forget', [
            'username' => $user->mobile
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'messages' => [
                    [
                        'text' => __('messages.otp_send_successful')
                    ]
                ]
            ]);
    }

    public function test_forget_not_exist_user(): void
    {
        $response = $this->postJson('/api/driver/v1/auth/forget', [
            'username' => rand(100000000, 999999999)
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'data' => [
                    'username' => [
                        __('validation.exists', ['attribute' => __('validation.attributes.username')])
                    ]
                ]
            ]);
    }

}
