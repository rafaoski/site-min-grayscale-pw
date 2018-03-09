<?php namespace ProcessWire;
// $tags = page()->children("limit=80, sort=random");
$tags = page()->children("limit=80");?>

<div id='body' pw-prepend>

    <div class='tags-content'>

    <?php foreach($tags as $tag):

           if($tag->numTags()) { ?>

    <div class="item">

        <a class='tag-link' href='<?=$tag->url?>'>
                <span class='num-tags'><?=$tag->numTags()?></span>
                <?=$tag->title?>
        </a>

    </div>

<?php }

    endforeach; ?>

    </div><!-- /.tags-contentl -->

<?php
    // BASIC PAGINATION
    echo basicPagination($tags,$t_str);
?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

    <h3><?=$t_str['show-p']?></h3>

        <ul>
            <?php $possts = pages()->get('/blog/')->children();
                foreach ($possts as $post) {
                        echo "<li><a href='{$post->url}'>{$post->title}</a></li>";
                    }
            ?>
        </ul>

</div><!-- /#sidebar -->
