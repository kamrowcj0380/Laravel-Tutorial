<?php 
    include("../public/header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <title>Homepage</title>
</head>
<body>
    @auth
    <div id="body-content">
        <div>
            <h2>Logged in, welcome to the homepage.</h2>
            <form action="/logout" method="POST">
                @csrf
                <button>Logout</button>
            </form>
        </div>

        <div class="generic-form">
            <h2>Create a new post</h2>
            <form action="/create-post" method="POST">
                @csrf
                <input type="text" name="title" placeholder="post title">
                <textarea name="body" placeholder="Write about something..."></textarea>
                <button>Post</button>
            </form>
        </div>

        <div id="post-list">
            <h2>All Posts</h2>
            @foreach($posts as $post)
            <div id="post">
                <div id="post-header">
                    <h3>{{ $post['title'] }}</h3>
                    <p>Authored by <strong><i class="username">{{ $post->user->name }}</i></strong>.</p>
                </div>
                <div id="post-content">
                    <p>{{ $post['body'] }}</p>
                    </div>
                <div id="post-footer">
                    <p id="edit-post"><a href="/edit-post/{{ $post->id }}">Edit</a></p>
                    <form action="/delete-post/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button id="delete-post">DELETE</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

    </div>

    @else
    <div class="generic-form">
        <h2>Register</h2>
        <form action="/register" method="POST">
            @csrf <!-- This protects the user from malicious third-party interception of cookies storing login information. CSRF is a cybersecurity method, not sure of the details... -->
            <input type="text" name="name" placeholder="name">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <button>Register</button>
        </form>
    </div>
    <div class="generic-form">
        <h2>Log In</h2>
        <form action="/login" method="POST">
            @csrf <!-- This protects the user from malicious third-party interception of cookies storing login information. CSRF is a cybersecurity method, not sure of the details... -->
            <input type="text" name="loginName" placeholder="name">
            <input type="password" name="loginPassword" placeholder="password">
            <button>Log In</button>
        </form>
    </div>

    @endauth

</body>
</html>