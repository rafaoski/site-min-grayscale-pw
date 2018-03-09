<?php namespace ProcessWire;
// https://moz.com/blog/how-long-should-your-meta-description-be-2018
// https://processwire.com/blog/posts/processwire-2.6.18-updates-pagination-and-seo/
    echo $input->pageNum > 1  ? "<meta name='robots' content='noindex,follow'>" : '';
// IF SINGLE AUTHOR ( USER PAGE )  
    if(input()->urlSegment(1) && page()->template->name == 'authors'):
// Get User    
    $name_slug = input()->urlSegment(1);
    $get_user = users()->get("txt_2=$name_slug"); 
?>
    <meta id='description' name="description" content="<?=$get_user->summary?>">
    <title id='title'><?=$get_user->get("headline|txt_1");?></title>
    <meta id='og-url' property="og:url" content="<?=page()->httpUrl . $get_user->txt_2?>" />
    <meta id='og-title' property="og:title" content="<?=$get_user->get("headline|txt_1");?>" />
    <meta id='og-desc' property="og:description" content="<?=$get_user->summary?>">
    
<?php // IF USER HAS IMAGES
    echo count($get_user->images) ?  "\r<meta id='og-image' property='og:image' content='{$get_user->images->first->httpUrl()}' />" : '';

// DEFAULT PAGE SEO    
  else: ?>
    
    <meta id='description' name="description" content="<?=page()->summary?>">
    <title id='title'><?=$c_opt['head_tit']?></title>
    <meta id='og-url' property="og:url" content="<?=page()->httpUrl?>" />
    <meta id='og-type' property="og:type" content="website" /> 
    <meta id='og-title' property="og:title" content="<?=$c_opt['head_tit']?>" />
    
<?php 
// IF PAGE HAS SUMMARY
    echo  page()->summary ? "<meta id='og-desc' property='og:description' content='{$page->summary}'>\n" : '';
// IF PAGE HAS IMAGES
    echo count(page()->images) ? "<meta id='og-image' property='og:image' content='{$page->images->first->httpUrl()}' />\n" : '';

endif; ?>

    <meta property='og:site_name' content='<?=$c_opt['page_opt']->txt_1 ? $c_opt['page_opt']->txt_1 : ''?>'/>


