<?php namespace ProcessWire; ?>

<div id='body' pw-prepend>

    <div class='categories-content'>

<?php 
// SHOW PAGE CHILDREN
$categories = page()->children("limit=12");

foreach($categories as $category):
    // If there are pages with this category show in ready.php
        if($category->numPosts()): ?>

    <div class="category">

            <a class='catlink' href='<?=$category->url?>'>

                <span><?php // Show Hook numPosts in _ready.php
                        echo $category->numPosts()?></span>

                        <?=$category->title?>

<?php 
// If Page Has Images
    if(count($category->images)):

// https://processwire.com/api/ref/page-image/size/ 

    // Get an image to resize
        $image = $category->images->first();

    // Create 400x300 thumbnail cropped to center
        $thumb = $image->size(160, 80);

    // Description
        $img_desc = $image->description ? $image->description : $category->title;
?>
    <hr>
        <img class='flex-center lazyload' data-src="<?=$thumb->url?>" alt="<?=$img_desc?>" height='<?=$thumb->height?>'>
        
        <?php endif; // END COUNT IMAGES ?>

            </a>

        </div><!-- /.category -->

    <?php endif;

        endforeach; ?>
        
    </div><!-- /.categories-content grid-4-col -->

<?php
    // BASIC PAGINATION
    echo basicPagination($categories,$t_str);
?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

<h3><?=$t_str['show-p']?></h3>

    <ul>
        <?php $posts = pages()->get('/blog/')->children(); 
            foreach ($posts as $post) {
                    echo "<li><a href='{$post->url}'>{$post->title}</a></li>"; 
                }
        ?>
    </ul> 

</div><!-- /#sidebar -->