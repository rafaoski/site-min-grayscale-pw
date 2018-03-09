<?php namespace ProcessWire;?>
<div id='body'>

<?php if(!count($page->images)) {
    echo "<h2>$page->title</h2>";
} ?>

<div class='grid-2-col portfolio'>

    <?php 
    // If Page Has Images
        if(count($page->images)): ?>

    <div class='flex-center'>

        <a href="<?=$page->images->first->url?>">

            <img src="<?=$page->images->first()->url?>" alt="<?=$page->tille?>">

        </a>

        <?php // SHARE BUTTONS
              echo toAny(['t','f','g-p','e']); ?>

    </div><!-- /.flex-center -->

<?php endif; // END COUNT IMAGES ?>

<?php if($page->txtarea_1): ?>

        <blockquote>

            <?=$page->txtarea_1;?>

        </blockquote>

<?php endif; ?>

        <?php if(count($page->tag_ref)): ?>    

            <ul class='flex-cat'>

            <li><h3><?=$t_str['tags'];?></h3></li>

                <?php // Shw Tags
                    foreach($page->tag_ref as $item) {
                        echo "<li><a href='$item->url'>$item->title</a></li>";
                    }
                ?>
                
            </ul>

        <?php endif; ?>

    </div><!-- /.portfolio-->

    <?=$page->body;?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

    <h3><?=$t_str['random-p'];?></h3>

        <ul>
        <?php $posts = pages()->get('/blog/')->children('limit=12,sort=random');  // Sort Random => Refresh Page To Get Random Posts
            foreach ($posts as $post) {
                    echo "<li><a href='{$post->url}'>{$post->title}</a></li>"; 
                }
        ?>
        </ul>

</div><!-- /#sidebar -->