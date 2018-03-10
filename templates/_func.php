<?php namespace ProcessWire;
// https://manual.phpdoc.org/HTMLSmartyConverter/HandS/phpDocumentor/tutorial_tags.param.pkg.html

/**
 * @param Page $root
 * https://processwire.com/docs/tutorials-old/quick-start/navigation/
 */
function topNav($root) {
    // $root = pages()->get("/");
    $children = $root->children();
    $children->prepend($root);
    $out = '';
        foreach($children as $child) {
            $child->id == wire('page')->id ? $class = 'active' : $class = 'no-active';
            $out .= "<li class='{$class}'><a class='nav-item' href='{$child->url}'>{$child->title}</a></li>";
        }
    return $out;
}

/**
 * @param Page $home
 * Get home page from _options.php => $c_opt['home']
 * @param string $lang_pref 
 *  Default language prefix => 'en'
 */
function menuLang($home,$lang_pref) {

    if(count(page()->getLanguages()) == 0 ) return '';

        $out = '';

        foreach(languages() as $language) {

            if(!page()->viewable($language)) continue; // is page viewable in this language?
            
			if($language->id == user()->language->id) {
				$out .= "<li class='current'>";
			} else {
				$out .= "<li>";
            }
            
			$url = page()->localUrl($language); 
            $hreflang = $home->getLanguageValue($language, 'name'); 

            $hreflang == 'home' ? $hreflang = $lang_pref : '';
            // $out .= "<a hreflang='$hreflang' href='$url'>$language->title</a></li>";
            $out .= "<a hreflang='$hreflang' href='$url'>" . strtoupper($hreflang) . "</a></li>";
            
        }
    // RETURN MENU 
        return $out;
    }

/**
 * @param Page $home
 * Get home page from _options.php => $c_opt['home']
 * @param string $lang_pref
 * Default language prefix => 'en'
 */
    function hrefLang($home,$lang_pref) {

        if(count(page()->getLanguages()) == 0 ) return '';
    
        $out = '';
    
        // handle output of 'hreflang' link tags for multi-language
        // this is good to do for SEO in helping search engines understand
        // what languages your site is presented in	
        foreach(languages() as $language) {
            // if this page is not viewable in the language, skip it
            if(!page()->viewable($language)) continue;
            // get the http URL for this page in the given language
            $url = page()->localHttpUrl($language); 
            // hreflang code for language uses language name from homepage
            $hreflang = $home->getLanguageValue($language, 'name');
            $hreflang == 'home' ? $hreflang = $lang_pref : ''; 
            // output the <link> tag: note that this assumes your language names are the same as required by hreflang. 
            $out .= "\n\t<link rel='alternate' hreflang='$hreflang' href='$url' />";
        }
    
        return $out . "\n";
        
    }

/**
 * @param Page $home
 * Get home page from _options.php => $c_opt['home']
 * @param string $lang_pref
 * Default language prefix => 'en'
 */
function langPrefix($home,$lang_pref) {

    if(count(page()->getLanguages()) == 0 ) return $lang_pref;

    // handle output of 'hreflang' link tags for multi-language
    // this is good to do for SEO in helping search engines understand
    // what languages your site is presented in	
    foreach(languages() as $language) {
        // if this page is not viewable in the language, skip it
        if(!page()->viewable($language)) continue;
        // get the http URL for this page in the given language
        $url = page()->localHttpUrl($language); 
        // hreflang code for language uses language name from homepage
        $hreflang = $home->getLanguageValue($language, 'name');

        $hreflang == 'home' ? $hreflang = $lang_pref : ''; 

        if(page()->httpUrl == $url) {
            return $hreflang;
        }
    }
 
}

/**
 * @param Page $page->parents()
 */
function breadCrumbs($page) {
    $i = 0;
    $count = count($page->parents());

    // breadcrumbs are the current page's parents
        foreach($page->parents() as $item) {
            $i++;
            $i <= $count ? $rhomb = "\\" : $rhomb = '';
            echo "<span><a href='$item->url'>$item->title $rhomb</a></span> ";

            // If has author name http://proc-starter.loc/authors/rafal-olszewicz
         }

         if(input()->urlSegment(1) && page()->template->name == 'authors') {
            // $pages()->get()
                $name_slug = input()->urlSegment(1);
            // Get User
                $get_user = users()->get("txt_2=$name_slug");
                echo "<span><a href='$page->url'>$page->title \</a></span> ";
                echo $get_user ? "<span>{$get_user->txt_1}</span>" : '';

        } else {
            // optionally output the current page as the last item
            echo "<span>$page->title</span> ";
        }
}

/**
 * START PAGINATION https://processwire.com/api/modules/markup-pager-nav/
 * You must check Admin \ Setup \ Templates \ Urls => Allow Page Numbers
 * https://processwire.com/docs/admin/setup/templates/#allow-page-numbers
 * @param Page $items
 */
function basicPagination($items,$t_str) {
// $p_next = $p_prev = 'Add Translate String to _options.php';

// GET TRANSLATE FROM _options.php
isset($t_str['p_next']) ? $p_next = $t_str['p_next'] : $p_next = 'Add p_next to _options.php => $t_str[]';

isset($t_str['p_prev']) ? $p_prev = $t_str['p_prev'] : $p_prev = 'Add p_prev to _options.php => $t_str[]';

        return $items->renderPager(array(
            'nextItemLabel' => $p_next,
            'previousItemLabel' => $p_prev,
            'listMarkup' => "<ul class='MarkupPagerNav'>{out}</ul>",
            'itemMarkup' => "<li class='{class}'>{out}</li>",
            'linkMarkup' => "<a href='{url}'><span>{out}</span></a>"
        ));

}

/**
 * @param array $t_str
 * Translate from inc/_options.php
 */
function commentsPagination($t_str) {

  isset($t_str['c_name']) ? $cite = $t_str['c_name'] : $cite = 'Add c_name to _options.php => $t_str[]';
  isset($t_str['c_e-mail']) ? $email = $t_str['c_e-mail'] : $email = 'Add c_e-mail to _options.php => $t_str[]';
  isset($t_str['c_text']) ? $text = $t_str['c_text'] : $text = 'Add c_text to _options.php => $t_str[]';
  isset($t_str['c_submit']) ? $submit = $t_str['c_submit'] : $submit = 'Add c_submit to _options.php => $t_str[]';
  isset($t_str['c_comments']) ? $comments_l = $t_str['c_comments'] : $comments_l = 'Add c_comments to _options.php => $t_str[]';
  isset($t_str['c_added']) ? $added = $t_str['c_added'] : $added = 'Add c_added to _options.php => $t_str[]';
  isset($t_str['c_in_day']) ? $in_day = $t_str['c_in_day'] : $in_day = 'Add c_in_day to _options.php => $t_str[]';
  isset($t_str['c_reply']) ? $reply = $t_str['c_reply'] : $reply = 'Add c_reply to _options.php => $t_str[]';
  isset($t_str['c_join']) ? $join = $t_str['c_join'] : $join = 'Add c_join to _options.php => $t_str[]';
  isset($t_str['c_approved']) ? $approved = $t_str['c_approved'] : $approved = 'Add c_approved to _options.php => $t_str[]';
  isset($t_str['c_thanks']) ? $thanks = $t_str['c_thanks'] : $thanks = 'Add c_thanks to _options.php => $t_str[]';
  isset($t_str['c_errors']) ? $errors = $t_str['c_errors'] : $errors = 'Add c_errors to _options.php => $t_str[]';
  isset($t_str['c_prev']) ? $prev = $t_str['c_prev'] : $prev = 'Add c_prev to _options.php => $t_str[]';
  isset($t_str['c_next']) ? $next = $t_str['c_next'] : $next = 'Add c_next to _options.php => $t_str[]';

    if (page()->comments) {
$comm = '';

        $limit = 12;
        $start = (input()->pageNum - 1) * $limit;
        $comments = page()->comments->slice($start, $limit);

        $comm .= $comments->render(array(
         'headline' => "<h3 class=''>" . $comments_l . "</h3>",
         'commentHeader' => $added . '{cite}' . $in_day . ' {created} {stars} {votes}',
         'dateFormat' => 'm/d/y - H:i',
         'encoding' => 'UTF-8',
        //  'admin' => false, // shows unapproved comments if true
         'replyLabel' => $reply,
       ));

       $comm .= page()->comments->renderForm(array(
         'headline' => '<h2>' . $join . '</h2>',
         'pendingMessage' => $approved,
         'successMessage' => $thanks,
         'errorMessage' => $errors,
         'attrs' => array(
         'id' => 'CommentForm',
         'action' => './',
         'method' => 'post',
         'class' => 'comm-form c-form',
         'rows' => 5,
         'cols' => 50,
         ),
         'labels' => array(
                 'cite' => $cite,
                 'email' => $email,
                 'text' => $text ,
                 'submit' => $submit,
             ),
         ));

         $comm .= "<p class='link-pagination'>";

                  if(input()->pageNum > 1) {
                    $comm .= "<a class='btn mx-1' href='./page" . (input()->pageNum - 1) . "'>" .  $prev . "</a>";
                  }
                  if($start + $limit < count(page()->comments)) {
                    $comm .= "<a class='btn mx-1'  href='./page" . (input()->pageNum + 1) . "'>" . $next . "</a>";
                  }
                  $comm .= "</p>";

             return $comm;
    }

 }


/**
 * @param string $social_url
 * @param string $label
 * Usage with fields echo socialProfiles($page->txtarea,'no icons')
 */
function svgProfiles($social_url,$label) {

    if($social_url) {

      $profile = explode(",", $social_url);
      $soc = ['twitter','facebook','youtube','plus',
              'linkedin','instagram','rss','@'];

      $out = '';

foreach ($profile as $key) {

$tooltip = '';

    for($i=0; $i<count($soc); $i++) {

        if (strpos(strtolower($key), $soc[$i]) !== false) {

            if($soc[$i] == 'rss') $key = pages()->get("/blog/")->httpUrl.'rss';
            if($soc[$i] == 'plus') $soc[$i] = 'google-plus';
            if($soc[$i] == 'youtube') $soc[$i] = 'play-circle';
            if($soc[$i] == '@') {

				$soc[$i] = 'mail';
				$key = 'mailto:'.$key;

      }

            $out .= "<a href='" . sanitizer()->text($key) . "' target='_blank'>";

                $img_url = urls()->templates . 'assets/icons/';

                $out .= "<img class='lazyload' data-src='{$img_url}{$soc[$i]}.svg' alt='profile-$soc[$i]' width='32px'>";

            $out .= "</a>";
        }
    }

}

 return $out;

        } else {

            return '<h2>' . $label . '</h2>';

        }
}


/**
 * @param array $opt
 * ADD TO ANY DEFAULT USAGE: echo toAny();
 * echo toAny(['t','e'])
 */
function toAny($opt=['t','f','g-p','l','r','e','g-m']) {

  $out = '';

	$out .= "<!-- AddToAny BEGIN -->

	<div class='a2a_kit a2a_kit_size_32 a2a_default_style m-2'>

    <a class='a2a_dd' href='https://www.addtoany.com/share'></a>";

    if(in_array('f', $opt)) $out .= "<a class='a2a_button_facebook'></a>";

    if(in_array('t', $opt)) $out .= "<a class='a2a_button_twitter'></a>";

    if(in_array('g-p', $opt)) $out .= "<a class='a2a_button_google_plus'></a>";

    if(in_array('l', $opt)) $out .= "<a class='a2a_button_linkedin'></a>";

    if(in_array('r', $opt)) $out .= "<a class='a2a_button_reddit'></a>";

    if(in_array('e', $opt)) $out .= "<a class='a2a_button_email'></a>";

    if(in_array('g-m', $opt)) $out .= "<a class='a2a_button_google_gmail'></a>";

	$out .= "</div>

	<script async src='https://static.addtoany.com/menu/page.js'></script>
    <!-- AddToAny END -->";

    return $out;
}

/**
* @param  Page $post
* @param  string $label
*/
function readMore($post,$label) {
    // Simple Limit words($post->body) to 155
        $out = '';
        $out .= sanitizer()->text($post->body, ['maxLength' => 155]);
        $out .= "[ ... ]";
        $out .= "<a class='btn-def' href='{$post->url}'>";
        $out .= $label;
        $out .= "</a>";
        return $out;
    }


// PW DEBUG => USAGE => echo pwDebug()
function pwDebug() {
    if(config()->debug && user()->isSuperuser()) {
        // display region debugging info
        $out = "<div id='debug' class='debug-regions'>";
        $out .= "<!--PW-REGION-DEBUG-->";
        $out .= "</div>";
        return $out;
    }
}


/**
* @param array $items = ['home','blog','blog-post'] 
* 
*/
function randImg($items = []) {

$out = '';
$get_user = '';
// If Default Page Has Images
  if(in_array(page()->template->name, $items)):

    // GET USER IMAGE    
        if(input()->urlSegment(1) && page()->template->name == 'authors') {
    // Get user name
        $name_slug = input()->urlSegment(1);
    // Get user 
        $get_user = users()->get("txt_2=$name_slug");

    // Get an image from user page
    if(count($get_user->images)) {
    // GET FIRST IMAGE
        $image = $get_user->images->first();
    // CHANGE SIZE    
        $u_img = $image->size(640, 320);
    // Return Image
        $out .= "<a href='{$u_img->url}'>";
        $out .= "<img class='lazyload' data-src='{$u_img->url}' alt='{$u_img->description}' width='{$u_img->width}' />";
        $out .= '</a>';
    }
}

if(count(page()->images) && input()->urlSegment(1) == false) {
// GET RANDOM IMAGES    
    $image = page()->images->getRandom();
// CHANGE SIZE  
    $r_img = $image->size(640, 320);
// Return Image
    $out .= "<a href='{$r_img->url}'>";
    $out .= "<img class='lazyload' data-src='{$r_img->url}' alt='{$r_img->description}' width='{$r_img->width}' />";
    $out .= '</a>';

}
    return $out;
    
endif;

}


/**
 * @param string $code Google Analytics Tracking Code
 * https://developers.google.com/analytics/devguides/collection/analyticsjs/
 */
function gAnalitycs($code)
{
return"\n
<!-- Google Analytics -->
<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '$code', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
<!-- End Google Analytics -->\n";
}

/**
* @param  Page $page
*/
function pageEdit($page,$label) {
    if($page->editable()) {
        $edit = page()->editUrl;
        return "<a class='btn-def edit-page' href='{$edit}'>{$label}</a>";
    }
}

/**
* @param  bool $trash
* TRASH DEMO DATA => USAGE: trashDemoData($trash = true);
*/
 function trashDemoData($trash = false) {
    // IF TRUE
    if($trash == true) {
        // GET ID ALL PAGES TO TRASH
        $arr_p = [
            '1105','1115','1066','1068','1069','1073','1075',
            '1076','1059','1112','1108','1036','1035','1034',
            '1033','1026','1029','1030','1031','1071','1113',
            '1120','1121','1114','1116','1117','1118','1106',
            '1107','1109','1087'
        ];
            foreach ($arr_p as $key) {
                $trash_p = pages()->get($key);
            // IF PAGE EXSIST
                if($trash_p->name == true) {
            // PAGE TO TRASH
                    pages()->trash($trash_p);
                // OR DELETE
                    // pages()->delete($trash_p);
                }
            }
        }

    }
