<?php
session_start();
require_once 'class/Autoloader.php';
spl_autoload_register(['Autoloader','load']);
spl_autoload_register(['Autoloader','loadAndLog']);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['action'] == 'auth'){
        if(isset($_POST['login']) && isset($_POST['pass'])){
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $authId = User::login($pass, $login);
            if($authId != null) {
                $_SESSION['authId'] = $authId;
            }
        }
    } elseif ($_POST['action'] == 'logOut') {
        User::logout();
        session_destroy();
    } elseif ($_POST['action'] == 'catAdd') {
        if(isset($_POST['category'])){
            $category = $_POST['category'];
            $cat = new Category($category);
            $cat->addCategory();
        }
    } elseif ($_POST['action'] == 'catDel') {
        if(isset($_POST['cat'])){
            $cat = $_POST['cat'];
            Category::delCategory($cat);
        }
    } elseif ($_POST['action'] == 'postAdd') {
        if(isset($_POST['cat']) && isset($_POST['title']) && isset($_POST['content'])){
            $cat = $_POST['cat'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            if($_FILES['file']['name'] != "") {
                move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/' . $_FILES['file']['name']);
                $file = '/img/' . $_FILES['file']['name'];
                $post = new Post($cat, $title, $content, $file);
                $post->addPost();
            }else{
                $post = new Post($cat, $title, $content, "");
                $post->addPost();
            }
        }
    } elseif ($_POST['action'] == 'postDel') {
        if(isset($_POST['post'])){
            $post = $_POST['post'];
            Post::delPost($post);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <?php if (isset($_SESSION['authId']) == false) { ?>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="auth">
            <div class="form-group">
                <label for="login">Login:</label>
                <input name="login" type="text" class="form-control" id="login">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input name="pass" type="password" class="form-control" id="pass">
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    <?php } else { ?>
        <form action="" class="col-md-offset-11" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="logOut">
            <button type="submit" class="btn btn-default">LogOut</button>
        </form><br><br>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="catAdd">
            <div class="form-group">
                <label for="category">Category:</label>
                <input name="category" type="text" class="form-control" id="category">
            </div>
            <button type="submit" class="btn btn-default">Add category</button>
        </form><br><br>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="catDel">
            <div class="form-group">
                <label for="sel">Select category:</label>
                <select name="cat" multiple class="form-control" id="sel">
                    <?php
                    $result = Category::getCategories();
                    foreach ($result as $item) { ?>
                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Delete category</button>
        </form><br><br>
        <form enctype="multipart/form-data" action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="postAdd">
            <div class="form-group">
                <label for="title">Title:</label>
                <input name="title" type="text" class="form-control" id="title">
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" class="form-control" id="content" style="resize: vertical;"></textarea>
            </div>
            <div class="form-group">
                <label class="btn btn-default btn-file">
                    Browse Image<input type="file" name="file" style="display: none;">
                </label>
            </div>
            <div class="form-group">
                <label for="sel">Select category:</label>
                <select name="cat" class="form-control" id="sel">
                    <?php
                    $result = Category::getCategories();
                    foreach ($result as $item) { ?>
                        <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Add post</button>
        </form><br><br>
        <form action="" method="post" style="border: 3px solid gray; border-radius: 15px; padding: 10px;">
            <input name="action" type="hidden" value="postDel">
            <div class="form-group">
                <label for="sel">Select post:</label>
                <select multiple name="post" class="form-control" id="sel">
                    <?php
                    $result = array_reverse(Post::getPosts(), true);
                    foreach ($result as $item) { ?>
                        <option value="<?= $item['id'] ?>"><?= $item['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Delete post</button>
        </form>
    <?php } ?>
</div>
</body>
</html>