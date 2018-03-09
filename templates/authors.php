<?php namespace ProcessWire;

// We recommend that you trigger a "404 not found" error when you come across an unrecognized URL segment.
// https://processwire.com/docs/tutorials/how-to-use-url-segments/page3
    if($input->urlSegment2) throw new Wire404Exception();

// If has author name http://proc-starter.loc/authors/rafal-olszewicz
if($input->urlSegment(1)):

// GET USER NAME
    $name_slug = $input->urlSegment(1);
// Get User
    $get_user = $users->get("txt_2=$name_slug");

// If id not Exsists.We recommend that you trigger a "404 not found" error when you come across an unrecognized URL segment.
if($get_user->id == false ) {
    throw new Wire404Exception();
}

// $posts = pages()->get("/blog/")->children("created_users_id=$get_user->id, limit=12");
// FIND ITEMS FROM 2 ANOTHER TEMPLATES ( blog-post|portfolio )
   $posts = pages()->find("template=blog-post|portfolio,created_users_id=$get_user->id, limit=12");
?>


<div id='body'>

<div class='grid-3-col'>

    <?php foreach ($posts as $post) : ?>

<article class='blog-post'>

<h3><?=$post->title?></h3>

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

    <img class='lazyload' data-src="<?=$thumb->url?>" alt="<?=$img_desc?>" height='<?=$image->height?>'>

</a>

<?php endif; // END => count($post->images)?>

    <p><?= readMore($post,$t_str['read-m']); ?></p>

</article>

  <?php endforeach; // END $posts  ?>

</div><!-- /.grid-3-col -->

<?php

// TRANSLATABLE PAGINATION
echo basicPagination($posts,$t_str);

 else : ?>

<div id='body'>

<div class='authors-content grid-3-col'>

<?php
// https://processwire.com/api/selectors/#access_control
$all_users = pages()->find("template=user, roles=guest, name!=guest, check_access=0, limit=12");
// OR ADD CUSTOM ROLE ( editor )
// $all_users = pages()->find("template=user, roles=editor, check_access=0, limit=12");
if (!count($all_users)) echo "<h1>{$t_str['no-user']}</h1>";

// Foreach Loop Childrens => limit = 12 posts
        foreach($all_users as $user): ?>

    <div class="single-author">

    <h3>
        <a href='<?=$user->txt_2?>'>
            <?=$user->txt_1?>
        </a>
    </h3>

    <?php
    // If Page Has Images
        if(count($user->images)):

    // https://processwire.com/api/ref/page-image/size/

        // Get an image to resize
            $image = $user->images->first();

        // Create 400x300 thumbnail cropped to center
            $thumb = $image->size(640, 420);

        // Description
            $img_desc = $image->description ? $image->description : $t_str['author'] . ': ' . $user->txt_1;
    ?>

        <a class='flex-center' href='<?=$user->txt_2?>'>

            <img class='lazyload' data-src="<?=$thumb->url?>" alt="<?=$img_desc?>" height='<?=$thumb->height?>'>

        </a>

    <?php endif; // END COUNT IMAGES ?>

    </div><!-- /.single-author -->

    <?php endforeach; // END $all_users ?>


</div><!-- /.authors-content -->

<?php 
// EDIT PAGE
    echo pageEdit($page,$t_str['edit']);
// BASIC PAGINATION
    echo basicPagination($all_users,$t_str);

endif; // END => $input->urlSegment(1) ?>

</div><!-- /#body -->

<div id='sidebar' pw-append>

<?php 
    if($input->urlSegment(1)) {
        echo $get_user->sidebar;
    }    
?>

    <h3><?=$t_str['s-cat'];?></h3>

        <ul>
            <?php $categories = pages()->get('/categories/')->children('limit=12');
                foreach ($categories as $category) {
                        echo "<li><a href='{$category->url}'>{$category->title}</a></li>";
                    }
            ?>
        </ul>

</div><!-- /#sidebar -->
