<?php

use Tymon\JWTAuth\Facades\JWTAuth;


use App\User;
use App\Task;


class ListsTest extends TestCase
{
    private $token = null;
    private $user = null;

    public function setUp() : void {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->token = [
            'Authorization' => 'Bearer '.JWTAuth::fromUser($this->user)
        ];
    }

    /* @test **/
    public function test_if_it_lists_the_users_tasks() {

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->json('get', '/api/v1/tasks/0',
            [], $this->token);

        $response->assertResponseStatus(200);
        $response->seeJsonEquals([
            'success' => true,
            'status' => [
                $task
            ]
        ]);
    }
}
