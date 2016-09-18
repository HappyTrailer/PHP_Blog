<?php
class Post
{
    private $id;
    private $cat;
    private $title;
    private $content;
    private $file;

    function __construct($cat, $title, $content, $file)
    {
        $this->cat = $cat;
        $this->title = $title;
        $this->content = $content;
        $this->file = $file;
    }

    public function addPost()
    {
        $user_id = User::getCurrentUser();
        $time = time();
        if($this->file != "")
            Database::insertQuery("INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src`) VALUES ('$this->title','$this->content', $user_id, $time, $time, $this->cat, '$this->file')");
        else
            Database::insertQuery("INSERT INTO Posts(`title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`,) VALUES ('$this->title','$this->content', $user_id, $time, $time, $this->cat)");
    }

    public static function getPosts()
    {
        $result = Database::selectAll("SELECT * FROM Posts");
        return $result;
    }

    public static function delPost($post)
    {
        Database::insertQuery("DELETE FROM Posts WHERE id = '$post'");
    }

    public static function getLastPost()
    {
        $result = Database::selectObject("SELECT `id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `category_id`, `img_src` FROM `Posts` ORDER BY id DESC LIMIT 1");
        return $result;
    }

    public static function getPostStr($post)
    {
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $date_sec = $post->created_at;
        $user = User::getUserName($post->user_id);
        $month = $months[(int)date('m', $date_sec) - 1];
        $day = date('d', $date_sec);
        $year = date('Y', $date_sec);
        $time = new DateTime("@$date_sec");
        $time->setTimezone(new DateTimeZone('Europe/Kiev'));
        return "<a href='#'>$user</a>" . " on " . $month . " " . $day . ", " . $year . " - " . $time->format('H:i');
    }

    function __get($name)
    {
        Log::error("Вызвано неизвестное поле класса " . __CLASS__ . " - $name");
        return null;
    }

    function  __set($name, $value)
    {
        Log::error("Присвоение значения " . $value . " неизвестному полю класса " . __CLASS__ . " - $name");
    }

    function __call($name, $arguments)
    {
        Log::error("Вызван неизвесный метод класса " . __CLASS__ . " - " . $name . " с аргументами - " . $arguments);
    }

    function  __toString()
    {
        Log::warning("Вызван вывод объекта класса " . __CLASS__);
        return $this->name . "";
    }
}