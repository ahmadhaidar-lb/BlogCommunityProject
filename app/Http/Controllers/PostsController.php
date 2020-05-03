<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePosts;
use DB;
use App\User;
use App\Posts;
use App\Comments;
use Auth;
use App\likes;
use App\Http\Controllers\LikesController;
class PostsController extends Controller
{
    //
    
    
    public function create(StorePosts $request)
    {
    
        $post=new Posts();
      
        $image = $request->file('image');
        
        $mimeTypes=['jpeg','gif','png','bmp','svg+xml','jpg'];
       
        if($image)
        {
            $extension = $image->getClientOriginalExtension();
            if(in_array($extension, $mimeTypes)){
                
                Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
                $post->mime = $image->getClientMimeType();
                $post->original_filename = $image->getClientOriginalName();
                $post->filename = $image->getFilename().'.'.$extension;
                

            }
        }
       
       $post->video_url=$request->input('video');
       $post->title=$request->input('title');
       $post->content=$request->input('post');
       $post->user_id=Auth::id();
       $post->category=$request->category; 
     
       $post->save();
      
       return redirect('/home');
    }
    public function getAll()
    {
        //$post->comments()->with('user')->get();
       // {{@App\Posts::find(1)->user->name}}
        //$posts = Posts::get();
        $posts=Posts::orderBy('created_at','desc')->paginate(4);

        foreach($posts as $post)
        {
            
            $post->username=Posts::find($post->id)->user->name;
            $post->counter=$post->getTotalCommentsAttribute();
        }
       return $posts;
       
    }
    public function getAllByCategory($category)
    {
        //$post->comments()->with('user')->get();
       // {{@App\Posts::find(1)->user->name}}
        //$posts = Posts::get();
        $posts=Posts::where('category',$category)->orderBy('created_at','desc')->paginate(5);
     
              
        foreach($posts as $post)
        {
            
            $post->username=Posts::find($post->id)->user->name;
            $post->counter=$post->getTotalCommentsAttribute();
        }
       return $posts;
       
    }
    public function getPost($id)
    {
        $post=Posts::where('id', $id)->first();
        $post->username=Posts::find($post->id)->user->name;
        $post->counter=$post->getTotalCommentsAttribute();
        return $post;
    }
    protected function update(StorePosts $request,$id)
    {
        
        $post=Posts::where('id', $id)->first();
        
        $image = $request->file('imagee');
      
        $mimeTypes=['jpeg','gif','png','bmp','svg+xml'];
       
        if($image)
        {
            $extension = $image->getClientOriginalExtension();
            if(in_array($extension, $mimeTypes)){
                
                Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
                $post->mime = $image->getClientMimeType();
                $post->original_filename = $image->getClientOriginalName();
                $post->filename = $image->getFilename().'.'.$extension;


            }
        }
       $post->video_url=$request->input('video');
       $post->content=$request->input('post');
       $post->title=$request->input('title');
       $post->category=$request->category; 
       $post->save();
       return redirect('/home');
    }
    public function delete($id)
    {
       $comments=Comments::where('posts_id',$id)->orderBy('created_at','desc')->get();
       foreach($comments as $comment)
       {
           $comment->delete();
       }
       Posts::where('id',$id)->first()->delete();
       return redirect('/home');
    }
    public function addLike(Request $request)
    {
       $data=json_decode($request->getContent());
       $post=Posts::where('id',$data->postId)->first();
       $like=likes::where('user_id',Auth::id())->where('posts_id',$data->postId)->first();
       $likeAdd=new LikesController();
       if($like)
       {
        $post->likesCount=$post->likesCount-1;
        $post->save();  
        $likeAdd->deleteLike($data);   
       }
       else{
       $post->likesCount=$post->likesCount+1;
       $post->save();
       
       
       $likeAdd->addLike($data);
       }
    }
    public function isLikedByUser($id)
    {
        $post=likes::where('posts_id', $id)->where('user_id',Auth::id())->first();
        return $post;
    }
}
