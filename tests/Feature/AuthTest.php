<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_login_failed()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "123456",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $response->assertStatus(400)->assertJson([
            'success' => false,
        ]);

    }

    public function test_create_user()
    {
        $credentials = [
            "name"=>"asdsa",
            "email"=>"carlos@carlos.com",
            "password"=>"1234",
            "c_password"=>"1234"
        ];

        $response = $this->postJson('/api/auth/register', $credentials);
        $response->assertStatus(201) ->assertJson([
            'success' => true,
        ]);

    }

    public function test_login()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $response->assertStatus(200)->assertJsonStructure(['access_token']);

    }

    public function test_me()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response  = $this->postJson('/api/auth/login', $credentials);
        $token     = $response['access_token'];
        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/auth/me');
        $response2->assertStatus(200)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data'=>['name']]);
    }

}
