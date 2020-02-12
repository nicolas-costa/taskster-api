<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
      'title',
      'content',
      'color',
      'done',
      'schedule',
      'user_id',

    ];

    protected $casts = [
        'done' => 'boolean',
        'user_id' => 'integer'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
