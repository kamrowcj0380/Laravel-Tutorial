<?php 
    include("../public/header.html");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
    <title>Edit Post</title>
</head>
<body>
    <div class="generic-form">
        <h1>Edit Post</h1>
        <form action="/edit-post/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{ $post->title }}">
            <textarea name="body">{{ $post->body }}</textarea>
            <button>Save Changes</button>
        </form>
    </div>
</body>
</html>