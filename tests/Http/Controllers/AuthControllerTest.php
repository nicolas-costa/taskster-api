<?php

namespace Tests\Http\Controllers;

use App\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testLogsTheUserIn()
    {
        $user = factory(User::class)->create();

        $response = $this->json(
            'post',
            '/api/v1/login',
            [
                'login' => $user->login,
                'password' => "123456"
            ]
        );

        $response->assertResponseOk();
        $response->seeJsonStructure(
            [
                'success',
                'token'
            ]
        );
    }

    public function testUnauthorized()
    {
        $response = $this->json('post', '/api/v1/login',
            [
                'login' => 'foo',
                'password' => 'bar'
            ]
        );

        $response->assertResponseStatus(401);
        $response->seeJsonEquals(
            [
                'success' => false,
                'status' => 'Unauthorized'
            ]
        );
    }
}
