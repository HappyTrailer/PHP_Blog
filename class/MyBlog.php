<?php
require_once 'Database.php';
class MyBlog
{
    private $db;

    function __construct($host, $login, $password, $dbName)
    {
        $this->db = new Database($host, $login, $password, $dbName);
    }

    public function GetCategories()
    {
        $this->db->connect();
        $result = $this->db->selectAll("SELECT * FROM Categories");
        $this->db->disconnect();
        return $result;
    }

    public function GetPosts()
    {
        $this->db->connect();
        $result = $this->db->selectAll("SELECT * FROM Posts");
        $this->db->disconnect();
        return $result;
    }

    function GetAuth($login, $pass)
    {
        $password = md5($pass);
        $this->db->connect();
        $result = $this->db->selectObject("SELECT id FROM Users WHERE login = '$login' AND password_hash = '$password'");
        $this->db->disconnect();
        return $result->id;
    }

    function AddCategory($category)
    {
        $this->db->connect();
        $this->db->insertQuery("INSERT INTO Categories(`name`) VALUES ('$category')");
        $this->db->disconnect();
    }

    function SendMessage($email, $message)
    {
        $this->db->connect();
        $this->db->insertQuery("INSERT INTO Requests(`email`, `message`) VALUES ('$email','$message')");
        $this->db->disconnect();
    }

    function DelCategory($cat)
    {
        $this->db->connect();
        $this->db->insertQuery("DELETE FROM Categories WHERE id = '$cat'");
        $this->db->disconnect();
    }

    function AddPost($cat, $title, $content, $file)
    {
        $user_id = (int)$_SESSION['authId'];
        $time = time();
        $this->db->connect();
        $this->db->insertQuery("INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src`) VALUES ('$title','$content', $user_id, $time, $time, $cat, '$file')");
        $this->db->disconnect();
    }

    function AddPostWithoutImg($cat, $title, $content)
    {
        $user_id = (int)$_SESSION['authId'];
        $time = time();
        $this->db->connect();
        $this->db->insertQuery("INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`,) VALUES ('$title','$content', $user_id, $time, $time, $cat)");
        $this->db->disconnect();
    }

    function DelPost($post)
    {
        $this->db->connect();
        $this->db->insertQuery("DELETE FROM Posts WHERE id = '$post'");
        $this->db->disconnect();
    }

    function GetLastPost()
    {
        $this->db->connect();
        $result = $this->db->selectObject("SELECT `id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src` FROM `Posts` ORDER BY id DESC LIMIT 1");
        $this->db->disconnect();
        return $result;
    }

    function GetUser($id)
    {
        $this->db->connect();
        $result = $this->db->selectObject("SELECT `name` FROM Users WHERE id = '$id'");
        $this->db->disconnect();
        return $result->name;
    }

    function AddUser($login, $pass, $secret, $name)
    {
        $password = md5($pass);
        $this->db->connect();
        $this->db->insertQuery("INSERT INTO `Users`(`login`, `password_hash`, `password_reset`, `name`) VALUES ('$login','$password','$secret','$name')");
        $this->db->disconnect();
    }
}