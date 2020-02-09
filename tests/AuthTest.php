<?php

use App\User;

class AuthTest extends TestCase
{

    public function test_if_it_logs_the_user_in() {

        $user = factory(User::class)->create();

        $response = $this->json('post', '/api/v1/login',
            [
                'login' => $user->login,
                'password' => 123456
            ]);

        $response->assertResponseStatus(200);
        $response->seeJsonStructure(['success',
            'token']);
    }

    public function test_if_it_doesnt_log_in_with_invalid_credentials() {

        $response = $this->json('post', '/api/v1/login',
            [
                'login' => 'foo',
                'password' => 'bar'
            ]);

        $response->assertResponseStatus(401);
        $response->seeJsonEquals([
            'success' => false,
            'status' => 'Unauthorized'
        ]);
    }
}
