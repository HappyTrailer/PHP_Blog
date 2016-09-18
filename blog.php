<?php
$result = Post::getLastPost();
?>
<header class="intro-header" style="background-image: url('<?=$result->img_src?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?=$result->title?></h1>
                    <h4><?=Category::getCategory($result->category_id)?></h4>
                    <h2 class="subheading"><?=$result->content?></h2>
                    <span class="meta">Posted by <?=Post::getPostStr($result)?></span>
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
                $posts = array_reverse(Post::getPosts(), true);
                foreach ($posts as $post) { ?>
                    <div class="post-preview">
                        <a href="#">
                            <h2 class="post-title">
                                <?= $post['title'] ?>
                            </h2>
                            <h4>
                                <?=Category::getCategory($post['category_id'])?>
                            </h4>
                            <h3 class="post-subtitle">
                                <?= $post['content'] ?>
                            </h3>
                        </a>
                        <p class="post-meta">Posted by <?=Post::getPostStr($result)?></p>
                        <img class="img-responsive" src="<?=$post['img_src']?>" alt="">
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
</article>
<hr>