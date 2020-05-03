<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Posts;
use App\Comments;
use Auth;
class CommentsController extends Controller
{
    //
   
    public function create(Request $request)
    {
        $data=json_decode($request->getContent());
        //$data = json_decode($request->getContent());
        //$data=json_decode($request->input('body'));
       
       $comment=new Comments();
       $comment->content=$data->content;
       $comment->user_id=Auth::id();
       $comment->posts_id=$data->postId;
       $comment->save();
       
    }
    public function getAll($post_id)
    {
        //$post->comments()->with('user')->get();
       // {{@App\Posts::find(1)->user->name}}
        //$posts = Posts::get();
        //$post=Posts::where('id', $post_id)->first();
        $comments=Comments::where('posts_id',$post_id)->orderBy('created_at','desc')->get();
        
        foreach($comments as $comment)
        {
            $comment->username=Comments::find($comment->id)->user->name;
         
        }
       
       return $comments;
       
    }
    
    protected function update(Request $request)
    {
       $this->content=$request->input('post');
       $post->ownerId=Auth::id();
       $post->save();
       return redirect('/home');
    }
    public function delete(REQUEST $request)
    {
       $data=json_decode($request->getContent()); 
       
       if(!empty($data->id))
        {
            Comments::where('id',$data->id)->delete();
            return;
        }
        else if(empty($data->id))
           
        Comments::where('user_id',$data->userId)->where('posts_id',$data->postId)->where('content',$data->content)->first()->delete();
          
      
      
        
    }
}