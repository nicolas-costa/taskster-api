<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{

    use SoftDeletes;

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
