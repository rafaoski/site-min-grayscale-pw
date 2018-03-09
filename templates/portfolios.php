<?php namespace ProcessWire;
// Return this page’s children
$portfolios = page()->children("limit=27,sort=random");?>

<div id='body' pw-prepend>

    <div class='p-cont flexbin flexbin-margin'>

    <?php
        foreach($portfolios as $portfolio):

        // RANDOM SIZE FOR IMAGES
            $a = ["320", "420", "520", "260"];

        // GET RANDOM SIZES
            $rand = $a[rand(0,sizeof($a)-1)];

        // If Page Has Images
            if(count($portfolio->images)):

        // Get an image to resize
            $image = $portfolio->images->first();

        // Create 400x300 thumbnail cropped to center
            $thumb = $image->size($rand, 420);

        // Description
            $img_desc = $image->description ? $image->description : $portfolio->title;
    ?>

        <a class='item' href='<?=$portfolio->url?>'>

            <h5><?=$portfolio->title?></h5>

            <img class='lazyload' data-src="<?=$thumb->url?>" alt="<?=$img_desc?>" height='<?=$rand?>'>

        </a>

<?php endif; // END COUNT IMAGES

        endforeach; ?>

    </div><!-- /.p-cont -->

<?php
    // BASIC PAGINATION
    echo basicPagination($portfolios,$t_str);
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
