<?php

use App\User;

class AuthTest extends TestCase
{

    public function test_if_it_logs_the_user_in() {

        $user = factory(User::class)->create();

        $response = $this->json('post', '/api/v1/login',
            [
                'login' => $user->login,
                'password' => $user->password
            ]);

        $response->seeJson(['success' => true]);
        $response->assertResponseStatus(200);
        $response->seeJsonContains('token', false);
    }

}
