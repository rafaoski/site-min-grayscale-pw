<?php namespace ProcessWire;?>

<div id='body' pw-append>

    <div class='grid-2-col blog-content'>

    <?php // Show Childrens limit = 12 posts
    $posts = page()->children('limit=12');

    // Foreach Loop Childrens => limit = 12 posts
        foreach($posts as $post): ?>

    <article class='blog-post'>

    <h3>-- <?=$post->title?> --</h3>

    <?php if($post->createdUser->txt_2) : ?>

    <h5 class='meta'>

       <?= ' ' . $t_str['date'] . ': ' . $post->date?>
            
    </h5>

    <?php endif;

    // If Page Has Images
        if(count($post->images)):

    // https://processwire.com/api/ref/page-image/size/ 

        // Get an image to resize
            $image = $post->images->first();

        // Create 400x300 thumbnail cropped to center
            $thumb = $image->size(640, 420);

        // Description
            $img_desc = $image->description ? $image->description : $post->title;
    ?>

<div class='flex-center'>

<div class="auth-content">

    <a href="<?=$post->url?>">
        <!-- SHOW THUMBNAIL + LAZY LOAD TUPOLA https://github.com/tuupola/jquery_lazyload -->     
        <img class='lazyload' data-src="<?=$thumb->url;?>" alt="<?=$img_desc;?>" height='<?=$thumb->height?>'>
    </a>

    <a href='<?= pages()->get("/authors/")->url . $post->createdUser->txt_2?>' class="aut-thumb">

<?php 
    // If Page Has Images
    if(count($post->createdUser->images)){

        // https://processwire.com/api/ref/page-image/size/ 
    
            // Get an image to resize
                $img_u = $post->createdUser->images->first();
    
            // Create 400x300 thumbnail cropped to center
                $thumb_u = $img_u->size(35, 35);
    
            // Description
                $img_desc_u = $img_u->description ? $img_u->description : $post->createdUser->txt_2;

                echo "<img src='{$thumb_u->url}' alt='{$img_desc_u}'>";
    }
?>
        <h3><?=$post->createdUser->txt_1;?></h3>

    </a>
    
</div>
        
</div>

    <?php endif; // END COUNT IMAGES ?>

        <h5 class='txt-comm'>
            <?php // IF COMMENTS
                if(count($post->comments) && $c_opt['page_opt']->check_1 == 0) {
                  // GET COUNT COMMENTS & COMMENTS URL 
                $id = $post->comments->last() ? $post->comments->last()->id : '#';
                echo $t_str['comments'] . " <a class='com-count' href='$post->url#Comment$id'>" . count($post->comments) . "</a>";
            }?>
        </h5>

    <?php if($post->body): ?>

        <blockquote>

            <?=readMore($post,$t_str['read-m']);?>

        </blockquote>

    <?php endif; ?>

    </article>

    <?php endforeach; ?>

    </div><!-- /.blog-content -->

<?php
    // BASIC PAGINATION
    echo basicPagination($posts,$t_str);
?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

<h3><?=$t_str['s-cat']?></h3>

    <ul>
        <?php $categories = pages()->get('/categories/')->children(); 
            foreach ($categories as $category) {
                    echo "<li><a href='{$category->url}'>{$category->title}</a></li>"; 
                }
        ?>
    </ul> 

</div><!-- /#sidebar -->