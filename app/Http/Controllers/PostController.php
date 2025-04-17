<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function deletePost(Post $post) {
        //Laravel has a policy, and middleware is a more organized method of performing this. It's not within the scope of this tutorial.
        //This same comment is in the function showEditScreen()
        if (auth()->user()->id == $post['user_id']) {
            //Laravel models have pre-built functions. This includes delete(), which does what it says - deletes the post.
            $post->delete();
        }

        return redirect("/");
    }

    public function updatePostFromEditScreen(Post $post, Request $request) {
        //Laravel has a policy, and middleware is a more organized method of performing this. It's not within the scope of this tutorial.
        //This same comment is in the function showEditScreen()
        //Return the user to the homepage if they aren't the author of this blog.
        if (auth()->user()->id !== $post['user_id']) {
            return redirect("/");
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        //strip_tags keeps people from storing html tags or malicious content in the database
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        //Laravel handles the update - no need for a SQL statement.
        $post->update($incomingFields);

        //As always, end by returning the user to the homepage
        return redirect("/");
        
    }

    //Laravel performs database lookup automatically since 'post' is named consistently.
    public function showEditScreen(Post $post) {
        //Laravel has a policy, and middleware is a more organized method of performing this. It's not within the scope of this tutorial.
        //Return the user to the homepage if they aren't the author of this blog.
        if (auth()->user()->id !== $post['user_id']) {
            return redirect("/");
        }

        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        //strip_tags keeps people from storing html tags or malicious content in the database
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        //grab the user's ID from the global auth()
        $incomingFields['user_id'] = auth()->id();

        Post::create($incomingFields);

        return redirect("/");
    }
}
