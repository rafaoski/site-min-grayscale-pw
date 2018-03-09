<?php namespace ProcessWire;
$tiled_gal = $pages->find("template=blog-post|portfolio|about-single, images!=0, sort=random, limit=10");?>

<div id='body' pw-prepend>

    <div class="tiled-gallery">

    <?php foreach ($tiled_gal as $key) { 

    if(count($key->images)) {

        echo "<a href='{$key->url}'>
                <img class='lazyload' data-src='{$key->images->first->url}' alt='{$key->title}'>
                    <div class='middle'>
                        <h3>{$key->title}</h3>
                    </div>
            </a>";
        } 

    } ?>

    </div><!-- /.tiled-gallery -->

</div><!-- /#body -->