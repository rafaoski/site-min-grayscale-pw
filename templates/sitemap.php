<?php namespace ProcessWire;?>

<div id='body' pw-append>

<?php
    // https://processwire.com/talk/topic/20-how-do-i-create-a-sitemap-template-plus-how-to-deal-with-thousands-of-pages/
    function sitemapListPage($get_page) {

        // create a list item & link to the given page, but don't close the <li> yet
        echo "<li><a href='{$get_page->url}'>{$get_page->title}</a> ";

        // check if the get_page has children, if so start a nested list
        if($get_page->numChildren) {
                // start a nested list
                echo "<ul>";

                // loop through the children, recursively calling this function for each
                foreach($get_page->children as $child) sitemapListPage($child);

                // close the nested list
                echo "</ul>";
        }

        // close the list item
        echo "</li>";
    }

    // start the sitemap unordered list
    echo "<ul class='sitemap'>";

    // get the homepage and start the sitemap
    sitemapListPage($pages->get("/"));

    // close the unordered list
    echo "</ul>";
?>

</div><!-- /#body-->

<div id='sidebar' pw-append>

    <h3><?=$t_str['random-p']?></h3>
        <ul>
        <?php $posts = pages()->get('/blog/')->children('limit=12,sort=random');  // Sort Random => Refresh Page To Get Random Posts
            foreach ($posts as $post) {
                    echo "<li><a href='{$post->url}'>{$post->title}</a></li>"; 
                }
        ?>
        </ul>

</div><!-- /#sidebar -->