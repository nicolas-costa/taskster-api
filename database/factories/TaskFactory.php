<?php

use App\Task;
use App\User;

$factory->define(Task::class, function(Faker\Generator $faker) {

   return [
       'title' => $faker->firstName,
       'content' => $faker->text(120),
       'color' => $faker->safeColorName,
       'done' => 0,
       'schedule' => $faker->dateTime()->format('Y-m-d h:i:s'),
       'user_id' => function() {
            return factory(User::class)->create()->id;
       },
   ];
});
