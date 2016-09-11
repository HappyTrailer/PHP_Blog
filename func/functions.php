<?php
function GetCategories()
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    $query = mysqli_query($connect, "SELECT * FROM Categories");
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    mysqli_close($connect);
    return $result;
}

function GetPosts()
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    $query = mysqli_query($connect, "SELECT * FROM Posts");
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    mysqli_close($connect);
    return $result;
}

function GetAuth($login, $pass)
{
    $password = md5($pass);
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    $query = mysqli_query($connect, "SELECT id FROM Users WHERE login = '$login' AND password_hash = '$password'");
    $result = mysqli_fetch_object($query);
    mysqli_close($connect);
    return $result->id;
}

function AddCategory($category)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "INSERT INTO Categories(`name`) VALUES ('$category')");
    mysqli_close($connect);
}

function SendMessage($email, $message)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "INSERT INTO Requests(`email`, `message`) VALUES ('$email','$message')");
    mysqli_close($connect);
}

function DelCategory($cat)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "DELETE FROM Categories WHERE id = '$cat'");
    mysqli_close($connect);
}

function AddPost($cat, $title, $content, $file)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    $user_id = (int)$_SESSION['authId'];
    $time = time();
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src`) VALUES ('$title','$content', $user_id, $time, $time, $cat, '$file')");
    mysqli_close($connect);
}

function AddPostWitoutImg($cat, $title, $content)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    $user_id = (int)$_SESSION['authId'];
    $time = time();
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`) VALUES ('$title','$content', $user_id, $time, $time, $cat)");
    mysqli_close($connect);
}

function DelPost($post)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "DELETE FROM Posts WHERE id = '$post'");
    mysqli_close($connect);
}

function GetUser($id)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    $query = mysqli_query($connect, "SELECT `name` FROM Users WHERE id = '$id'");
    $result = mysqli_fetch_object($query);
    mysqli_close($connect);
    return $result->name;
}

function GetLastPost()
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    if(mysqli_connect_errno()){
        exit();
    }
    $query = mysqli_query($connect, "SELECT `id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src` FROM `Posts` ORDER BY id DESC LIMIT 1");
    $result = mysqli_fetch_object($query);
    mysqli_close($connect);
    return $result;
}

function AddUser($login, $pass, $secret, $name)
{
    $connect = mysqli_connect('127.0.0.1', 'root', '', 'Blog');
    $password = md5($pass);
    if(mysqli_connect_errno()){
        exit();
    }
    mysqli_query($connect, "INSERT INTO `Users`(`login`, `password_hash`, `password_reset`, `name`) VALUES ('$login','$password','$secret','$name')");
    mysqli_close($connect);
}