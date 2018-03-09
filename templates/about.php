<?php namespace ProcessWire;

// Return this page’s children
$posts = page()->children('limit=12');?>

<div id='body' pw-append>

<div class='grid-2-col blog-content'>

<?php // Foreach Loop Childrens => limit = 12 posts
    foreach($posts as $post):?>

<article class='blog-post'>

<h3>-- <?=$post->title?> --</h3>

<?php 
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

<a class='flex-center' href="<?=$post->url?>">

<!-- SHOW THUMBNAIL + LAZY LOAD TUPOLA https://github.com/tuupola/jquery_lazyload -->     
    <img class='lazyload' data-src="<?=$thumb->url;?>" alt="<?=$img_desc;?>" height='<?=$thumb->height?>'>

</a>

<?php endif; // END COUNT IMAGES 

    if(count($post->tag_ref)): ?>    

        <ul class='flex-cat'>

        <li><h3><?=$t_str['tags'];?></h3></li>

            <?php // Shw Tags
                foreach($post->tag_ref as $item) {
                    echo "<li><a href='$item->url'>$item->title</a></li>";
                }
            ?>
            
        </ul>

    <?php endif; ?>

    <blockquote><?php 
                    echo $sanitizer->text($post->txtarea_1, ['maxLength' => 155]);?> [ ... ]
        <a class='btn-def' href="<?=$post->url?>">
            <?=$t_str['read-m'];?>
        </a>
    </blockquote>

</article>

<?php endforeach; ?>

</div><!-- /.blog-content -->

<?php
    // BASIC PAGINATION
    echo basicPagination($posts,$t_str);
?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

<h3><?=$t_str['s-cat'];?></h3>

    <ul>
        <?php $categories = pages()->get('/categories/')->children(); 
            foreach ($categories as $category) {
                    echo "<li><a href='{$category->url}'>{$category->title}</a></li>"; 
                }
        ?>
    </ul> 

</div><!-- /#sidebar -->