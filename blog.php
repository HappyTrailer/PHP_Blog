<?php
$result = GetLastPost();
$date_sec = $result->created_at;
$user = GetUser($result->user_id);
$month = (int)date('m', $date_sec);
$day = date('d', $date_sec);
$year = date('Y', $date_sec);
$time = new DateTime("@$date_sec");
?>
<header class="intro-header" style="background-image: url('img/post-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?=$result->title?></h1>
                    <h2 class="subheading"><?=$result->content?></h2>
                    <span class="meta">Posted by <a href="#"><?=$user?></a> on <?=$months["$month"] . ' ' . $day . ', ' . $year . ' - ' . $time->format('H:i')?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php
                $posts = array_reverse(GetPosts(), true);
                foreach ($posts as $post) { ?>
                    <div class="post-preview">
                        <a href="blog.php">
                            <h2 class="post-title">
                                <?= $post['title'] ?>
                            </h2>
                            <h3 class="post-subtitle">
                                <?= $post['content'] ?>
                            </h3>
                        </a>
                        <?php
                        $date_sec = $post['created_at'];
                        $user = GetUser($post['user_id']);
                        $month = (int)date('m', $date_sec);
                        $day = date('d', $date_sec);
                        $year = date('Y', $date_sec);
                        $time = new DateTime("@$date_sec");
                        ?>
                        <p class="post-meta">Posted by <a href="#"><?=$user?></a> on <?=$months["$month"] . ' ' . $day . ', ' . $year . ' - ' . $time->format('H:i')?></p>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
</article>
<hr>