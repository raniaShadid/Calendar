<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title','start_date','end_date'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
