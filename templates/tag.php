<?php namespace ProcessWire; 
// Get Pages if Has Categories 
// $posts = pages()->get('/blog/')->children("tag_ref=$page, limit=16");
// GET FROM 2 ANOTHER TEMPLATES ( blog-post|portfolio )
$posts = pages()->find("template=blog-post|portfolio|about-single, tag_ref=$page, limit=16");
if(!count($posts)) throw new Wire404Exception();?>

<div id='body' pw-prepend>

<div class='category-content grid-2-col'>

    <?php // Foreach Loop Childrens => limit = 12 posts
        foreach($posts as $post):?>

<article class='blog-post'>

<h3><?=$post->title?></h3>

<?php 
// If Page Has Images
    if(count($post->images)):

// https://processwire.com/api/ref/page-image/size/ 

    // Get an image to resize
        $image = $post->images->first();

    // Create 400x300 thumbnail cropped to center
        $thumb = $image->size(640, 320);

    // Description
        $img_desc = $image->description ? $image->description : $post->title;
?>

<a class='flex-center' href="<?=$post->url?>">

    <img class='lazyload' data-src="<?=$thumb->url?>" alt="<?=$img_desc?>" height='<?=$image->height?>'>

</a>

<?php endif; ?>

    <blockquote>

        <?=readMore($post,$t_str['read-m']);?>

    </blockquote>

</article>

    <?php endforeach; ?>

</div><!-- /.category-content -->

<?php
    // BASIC PAGINATION
    echo basicPagination($posts,$t_str);
?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

<h3><?=$t_str['random-p']?></h3>

    <ul>
        <?php $categories = pages()->get('/categories/')->children('limit=12'); 
            foreach ($categories as $category) {
                    echo "<li><a href='{$category->url}'>{$category->title}</a></li>"; 
                }
        ?>
    </ul>  
      
</div><!-- /#sidebar -->
