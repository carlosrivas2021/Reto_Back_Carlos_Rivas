<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_experience_create()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "company"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/experience', $arg);
        $response2->assertStatus(201)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_experience_update()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "company"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/experience', $arg);

        $arg = [
            "company"     => "newu",
            "description" => "backend 2.0",
            "start_date"  => "2021-01-31",
            "_id"         => $response2['data']['_id'],
            "type"        => "update",
        ];
        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/experience', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_experience_delete()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "company"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/experience', $arg);

        $arg = [
            "_id"  => $response2['data']['_id'],
            "type" => "delete",
        ];

        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/experience', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    public function test_experience_list_without_token()
    {
        $arg = [
            "type" => "list",
        ];

        $response = $this->postJson('/api/me/experience', $arg);
        $response->assertStatus(200)->assertJson([
            'status' => 'Authorization Token not found',
        ]);

    }

    public function test_study_create()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "academy"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/study', $arg);
        $response2->assertStatus(201)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_study_update()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "academy"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/study', $arg);

        $arg = [
            "academy"     => "newu",
            "description" => "backend 2.0",
            "start_date"  => "2021-01-31",
            "_id"         => $response2['data']['_id'],
            "type"        => "update",
        ];
        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/study', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_study_delete()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "academy"     => "newu",
            "description" => "backend",
            "start_date"  => "2021-01-31",
            "type"        => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/study', $arg);

        $arg = [
            "_id"  => $response2['data']['_id'],
            "type" => "delete",
        ];

        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/study', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    public function test_study_list_without_token()
    {
        $arg = [
            "type" => "list",
        ];

        $response = $this->postJson('/api/me/study', $arg);
        $response->assertStatus(200)->assertJson([
            'status' => 'Authorization Token not found',
        ]);

    }

    public function test_skill_create()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "name"       => "php",
            "time_using" => "5 years",
            "type"       => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/skill', $arg);
        $response2->assertStatus(201)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_skill_update()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "name"       => "php",
            "time_using" => "5 years",
            "type"       => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/skill', $arg);

        $arg = [
            "name"       => "php",
            "time_using" => "6 years",
            "_id"        => $response2['data']['_id'],
            "type"       => "update",
        ];
        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/skill', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ])->assertJsonStructure(['data' => ['_id']]);
    }

    public function test_skill_delete()
    {
        $credentials = [
            "email"    => "carlos@carlos.com",
            "password" => "1234",
        ];

        $response = $this->postJson('/api/auth/login', $credentials);
        $token    = $response['access_token'];

        $arg = [
            "name"       => "php",
            "time_using" => "5 years",
            "type"       => "create",
        ];

        $response2 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/skill', $arg);

        $arg = [
            "_id"  => $response2['data']['_id'],
            "type" => "delete",
        ];

        $response3 = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/me/skill', $arg);
        $response3->assertStatus(200)->assertJson([
            'success' => true,
        ]);
    }

    public function test_skill_list_without_token()
    {
        $arg = [
            "type" => "list",
        ];

        $response = $this->postJson('/api/me/skill', $arg);
        $response->assertStatus(200)->assertJson([
            'status' => 'Authorization Token not found',
        ]);

    }
}
