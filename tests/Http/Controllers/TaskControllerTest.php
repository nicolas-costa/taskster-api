<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;
use App\Task;

class TaskControllerTest extends TestCase
{
    private $token = null;
    private $user = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->token = [
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($this->user)
        ];
    }

    public function testListUsersTasks()
    {
        $tasks = factory(Task::class, 2)
            ->create(
                [
                    'user_id' => $this->user->id
                ]
            );

        $response = $this
            ->actingAs($this->user)
            ->json(
                'get',
                '/api/v1/tasks?offset=0',
                [],
                $this->token
            );

        $response->assertResponseStatus(200);

        $jsonContent = json_decode($response->response->getContent());

        $this->assertCount($tasks->count(), $jsonContent->status);

        foreach($jsonContent->status as $task) {
            $this->assertEquals($task->user_id, $this->user->id);
        }

    }

    public function testReturnASpecificTask()
    {
        $task = factory(Task::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this
            ->actingAs($this->user)
            ->json(
                'get',
                '/api/v1/tasks/' . $task->id,
                [],
                $this->token
            );

        $response->assertResponseStatus(200);

        $jsonContent = json_decode($response->response->getContent());

        $this->assertEquals($jsonContent->status->user_id, $this->user->id);
    }

    public function testNotFoundWhenTaskDoesNotExist()
    {
        $response = $this
            ->actingAs($this->user)
            ->json(
                'get',
                '/api/v1/tasks/'.-1,
                [],
                $this->token
            );

        $response->assertResponseStatus(404);

        $response->seeJsonEquals([
            'success' => false,
            'status' => 'Not found'
        ]);
    }

    public function testEmptyBodyWhenDeletesAnUserTask()
    {
        $task = factory(Task::class)->create(
            [
                'user_id' => $this->user->id
            ]
        );

        $response = $this
            ->actingAs($this->user)
            ->json(
                'delete',
                '/api/v1/tasks/' . $task->id,
                [],
                $this->token
            );

        $response->assertResponseStatus(204);

        $this->notSeeInDatabase('tasks',
            [
                'id' => $task->id,
                'deleted_at' => null
            ]
        );
    }

    public function testNotFoundWhenTaskToDeleteDoesNotExist()
    {
        $response = $this
            ->actingAs($this->user)
            ->json(
                'delete',
                '/api/v1/tasks/'.-1,
                [],
                $this->token
            );

        $response->assertResponseStatus(404);

        $response->seeJsonEquals(
            [
                'success' => false,
                'status' => 'Not found'
            ]
        );
    }
}
