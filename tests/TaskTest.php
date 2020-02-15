<?php

use Tymon\JWTAuth\Facades\JWTAuth;


use App\User;
use App\Task;


class TaskTest extends TestCase
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

        $tasks = factory(Task::class, 2)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->json('get', '/api/v1/tasks/0',
            [], $this->token);

        $response->assertResponseStatus(200);
        $response->seeJsonEquals([
            'success' => true,
            'status' => $tasks
        ]);

        $jsonContent = json_decode($response->response->getContent());

        foreach($jsonContent->status as $task) {
            $this->assertEquals($task->user_id, $this->user->id);
        }

    }

    /* @test **/
    public function test_if_it_shows_a_task_from_current_user() {

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->json('get', '/api/v1/task/'.$task->id,
            [], $this->token);
        $response->assertResponseStatus(200);
        $response->seeJsonEquals([
            'success' => true,
            'status' => $task
        ]);

        $jsonContent = json_decode($response->response->getContent());

        $this->assertEquals($jsonContent->status->user_id, $this->user->id);
    }
    /* @test **/
    public function test_if_it_sends_404_when_the_task_to_be_shown_is_not_found() {

        $response = $this->json('get', '/api/v1/task/'.-1,
            [], $this->token);
        $response->assertResponseStatus(404);

        $response->seeJsonEquals([
            'success' => false,
            'status' => 'Not found'
        ]);
    }

    /* @test **/
    public function test_if_it_deletes_a_task_from_current_user() {

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->json('delete', '/api/v1/task/delete/'.$task->id,
            [], $this->token);
        $response->assertResponseStatus(204);

        $this->notSeeInDatabase('tasks', [
            'id' => $task->id,
            'deleted_at' => null]);
    }

    /* @test **/
    public function test_if_it_sends_404_when_the_task_to_be_deleted_is_not_found() {

        $response = $this->json('delete', '/api/v1/task/delete/'.-1,
            [], $this->token);
        $response->assertResponseStatus(404);

        $response->seeJsonEquals([
            'success' => false,
            'status' => 'Not found'
        ]);
    }

    /* @test **/
    public function test_if_it_creates_a_new_task() {

        $task = factory(Task::class)->make();

        $response = $this->json('post', 'api/v1/task/create',
            $task->toArray(), $this->token);

        $response->assertResponseStatus(201);

        $this->seeInDatabase('tasks', $task->toArray());

        $jsonContent = $response->response->getContent();

        $this->assertJson($jsonContent);

        // the code bellow doesn't work due to a bug on laravel Issue number #11068
        //$response->seeJsonContains($jsonContent['status']);

    }

    /* @test **/
    public function test_if_it_updates_a_task() {

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id
        ]);

        $task->title = 'foo';
        $task->content = 'bar';

        $response = $this->json('put', 'api/v1/task/update/'.$task->id,
            $task->toArray(), $this->token);

        $response->assertResponseStatus(204);

        $this->seeInDatabase('tasks', $task->toArray());
    }

    public function test_if_it_sends_with_422_when_post_data_is_incomplete() {

        $response = $this->json('post', 'api/v1/task/create',
            [], $this->token);

        $response->assertResponseStatus(422);

    }

}
