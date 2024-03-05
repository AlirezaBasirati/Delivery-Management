<?php

namespace App\Services\AuthenticationService\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        $data = [
            [
                'id' => '99c73d00-4526-4731-a31d-a2e9ab2c7113',
                'name' => 'Laravel Personal Access Client',
                'secret' => '1mkxgkXZclUB6WKBs5bBxbWgLzqKOpT0IsDk34PI',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => '99c73d00-483b-49a2-93b9-18bd47a5b30b',
                'name' => 'Laravel Password Grant Client',
                'secret' => 'HvOqfss0Qa8rhrH9nwVfqSgmQmGLgvQbmiOccNkL',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('oauth_clients')->upsert($data, 'id');

        DB::table('oauth_personal_access_clients')->upsert([
            'id' => 1,
            'client_id' => '99c73d00-4526-4731-a31d-a2e9ab2c7113',
            'created_at' => $now,
            'updated_at' => $now
        ], 'client_id');
    }
}
