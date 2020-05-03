<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $fillable = [
        'content',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function comments() {
        return $this->hasMany('App\Comments');
    }
    public function likes() {
        return $this->hasMany('App\Likes');
    }

    public function getTotalCommentsAttribute()
    {
       return $this->comments()->count();
    }
}
