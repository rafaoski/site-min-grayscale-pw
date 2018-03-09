<?php namespace ProcessWire; ?>

<div id='body'>

<article class='blog-post'>

    <?php if($page->createdUser->txt_2) : ?>

<h5 class='meta'>

    <?= ' ' . $t_str['date'] . ': ' . $page->date?>
    
</h5>

<?php endif; ?>

<?php

// If Page Has Images
    if(count($page->images)):

// https://processwire.com/api/ref/page-image/size/

    // Get an image to resize
        $image = $page->images->first();

    // Create 400x300 thumbnail cropped to center
        $thumb = $image->size(640, 420);

    // Description
        $img_desc = $image->description ? $image->description : $page->title;
?>

<a class='flex-center' href="<?=$image->url?>">

<!-- SHOW THUMBNAIL + LAZY LOAD TUPOLA https://github.com/tuupola/jquery_lazyload -->
    <img class='lazyload' data-src="<?=$thumb->url;?>" alt="<?=$img_desc;?>" height='<?=$thumb->height?>'>
</a>

<?php endif; // END COUNT IMAGES ?>

    <ul class='flex-cat'>
        <?php
        // Categories
            if(count($page->cat_ref)) {
                echo "<li><h3>{$t_str['categories']}</h3></li>";
                // Show Categories
                    foreach($page->cat_ref as $item) {
                        echo "<li><a href='$item->url'>$item->title</a></li>";
                    }
            }
        // Tags
            if(count($page->tag_ref)) {
                echo "<li><h3>{$t_str['tags']}</h3></li>";
                // Show Tags
                    foreach($page->tag_ref as $item) {
                        echo "<li><a href='$item->url'>$item->title</a></li>";
                    }
            }
        ?>
    </ul>

<?php
// SHARE BUTTONS
    echo toAny();
// PAGE BODY
    echo $page->body;
// EDIT BUTTON
 echo pageEdit($page,$t_str['edit']);
?>

</article>

<?php // SHOW COMMENTS
    if($c_opt['page_opt']->check_1 == 0) {
        echo commentsPagination($t_str);
    }
?>

</div><!-- /#body -->

<div id='sidebar' class='blog-sidebar' pw-append>

<h3><?= $t_str['author'] . ': ' . $page->createdUser->txt_1;?></h3>

<a class="auth flex-center" href='<?= pages()->get("/authors/")->url . $page->createdUser->txt_2?>'>

<?php 
    // If Page Has Images
    if(count($page->createdUser->images)){

        // https://processwire.com/api/ref/page-image/size/ 

            // Get an image to resize
                $img_u = $page->createdUser->images->first();

            // Create 400x300 thumbnail cropped to center
                $thumb_u = $img_u->size(640, 420);

            // Description
                $img_desc_u = $img_u->description ? $img_u->description : $page->createdUser->txt_2;

                echo "<img src='{$thumb_u->url}' alt='{$img_desc_u}'>";
    }
?>

</a>

<?=$page->createdUser->sidebar?>


<h3><?=$t_str['random-p']?></h3>

    <ul>
        <?php // Sort Random => Refresh Page To Get Random Posts
            $posts = pages()->get('/blog/')->children('limit=12,sort=random');
            foreach ($posts as $post) {
                    echo "<li><a href='{$post->url}'>{$post->title}</a></li>";
                }
        ?>
    </ul>

</div><!-- /#sidebar -->

<pw-region id="bottom-region">

<?php if(page()->comments && $c_opt['page_opt']->check_1 == 0): ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="<?=urls()->FieldtypeComments?>comments.css">

    <script defer src='<?=urls()->FieldtypeComments?>comments.min.js'></script>

<?php endif; ?>

</pw-region>
