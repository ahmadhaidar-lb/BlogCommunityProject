<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Posts;
use App\Comments;
use App\likes;
use Auth;
class LikesController extends Controller
{
    //
    
    public function addLike($request)
    {
        $like=new likes();
        $like->user_id=Auth::id();
        $like->posts_id=$request->postId;
        $like->save();

    }
    public function deleteLike($request)
    {
        $like =new likes();
        $like->user_id=Auth::id();
        $like->posts_id=$request->postId;
        Likes::where('user_id',$like->user_id)->where('posts_id',$like->posts_id)->first()->delete();
    }
}
