<?php namespace ProcessWire; ?>

<div class="hero-content lazyload"
            style='background-image: url("<?php // echo $page->images->getRandom()->url;?>")'
        <?php if(input()->urlSegment(1) && page()->template->name == 'authors'):
        // USER PAGE IMAGE            
                    $name_slug = input()->urlSegment(1);
                    $get_user = users()->get("txt_2=$name_slug");
        // USER IMAGE
            echo count($get_user->images) ? "data-src='{$get_user->images->first()->url}'>" : "'>";
        // USER NAME    
            echo "<h1>{$get_user->txt_1}</h1>";

        else:

        // DEFAULT IMAGES         
            echo count($page->images) ? "data-src='{$page->images->getRandom()->url}'>" : "'>";
        // PAGE HEADLINE OR TITLE    
            echo "<h1>{$c_opt['head_tit']}</h1>";

        endif; ?>
            
        <div class='tags-content'>

            <?php // https://processwire.com/talk/topic/15939-pages-find-with-pagination-issue/
                // GET TAGS PAGE CHILDREN
                $tags = $pages->get("/tags/")->children("limit=12,start=0,sort=random");

            foreach($tags as $tag):
            // IF PAGES HAS TAG
                    if($tag->numTags()) { ?>

            <div class="item">
                <a class='tag-link' href='<?=$tag->url?>'>
                    <span class='num-tags'><?=$tag->numTags()?></span>
                        <?=$tag->title;?>
                </a>
            </div>

            <?php }

                endforeach; ?>

        </div><!-- /.tags-content -->

</div><!-- /.hero-content -->