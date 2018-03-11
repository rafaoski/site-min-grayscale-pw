<?php namespace ProcessWire;
// Most options are in the file /inc/_options.php
?>
<!DOCTYPE html>
<html lang="<?=langPrefix($c_opt['home'],$c_opt['lang_pref']);?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
<?php // SIMPLE SEO
    include 'inc/_seo.php'; ?>
    
    <link rel="icon" href="<?=$c_opt['page_opt']->favicon ? $c_opt['page_opt']->favicon->url : ''?>"/>
    
    <style>
        <?php /* Simple PHP Contact Form Anti-Spam  ( See contact.php line: 59 <input name="firstname">)*/
            echo ".input-hidden {display: none;}\n"; ?>
    </style>
    
    <link rel="stylesheet" href="<?php echo $c_opt['t_url']?>assets/css/master.min.css">

    <?=hrefLang($c_opt['home'],$c_opt['lang_pref']);?>

</head>

<body id='top'>

<div id='wrapper' class="wrapper">

    <header id='header' class='header'>

        <a id='logo' class='logo' href='<?=$c_opt['home_url']?>'>

            <?php if($c_opt['page_opt']->logo): ?>

                <img class='lazyload' data-src="<?=$c_opt['page_opt']->logo->url;?>" alt="logo">

            <?php else: ?>

                <h3><?=$c_opt['page_opt']->txt_1 ? $c_opt['page_opt']->txt_1 : 'Add Site Name'?></h3>

            <?php endif; ?>

        </a>

        <nav id="top-nav" class='nav'>

        <label class='toggle-label' for="menu-toggle"><?=$t_str['menu'];?></label>

        <input type="checkbox" id="menu-toggle"/>

            <ul id='menu' class='topnav'>

            <?php 
            // LANGUAGES MENU
                if(page()->getLanguages()): ?>
            
                    <!-- language switcher / navigation -->
                    <ul id='lang-menu' class='languages' role='navigation'>
            
                        <?= menuLang($c_opt['home'],$c_opt['lang_pref']);?>
            
                    </ul>
            <?php endif; ?>

                <?=topNav($c_opt['home'])?>

            </ul>

        </nav><!-- /#top-nav-->

    </header>

    <div id="hero" class='hero'>

        <?php include 'inc/_hero-image.php'; ?>
        
    </div><!-- /#hero -->

    <main id='main' class='main'>

        <?php // SHOW IF IS NOT HOME PAGE
            if(page()->id != 1):?>

            <!-- breadcrumbs -->
            <div id='breadcrumbs' class='breadcrumbs' role='navigation' aria-label='You are here:'>
                <?php breadCrumbs($page);?>
            </div>

        <?php endif;?>

        <div id='body' class='main-body'>

            <?=page()->body;?>

            <?=pageEdit($page,$t_str['edit'])?>

        </div><!-- /#body -->

    </main>

    <div id='sidebar' class='sidebar'>

    <form class='search-form' action='<?php echo $pages->get('template=search')->url; ?>' method='get'>
    
        <input type='text' name='q' id='search' placeholder="<?=$t_str['search_label'];?>" required>
        
        <button><?=$t_str['search'];?></button>
        
	</form>

    <?php // SHOW IMAGES IF THIS PAGE HAS TEMPLATE []
        echo randImg(['home','blog','categories', 'category',
                    'authors','basic-page','contact','sitemap']);
        // SHOW SIDEBAR
        echo page()->sidebar; ?>

    </div><!-- /#sidebar -->

    <footer id='footer' class='footer'>

    <div class="powered">

        <p>
            <?= $t_str['powered-by'] . ' ' . "<a href='http://processwire.com'>{$t_str['processwire']}</a>"; ?>
        <?php
            if(user()->isLoggedin()) {
                // if user is logged in, show a logout link
                echo "&nbsp; / &nbsp; <a href='{$config->urls->admin}login/logout/'>{$t_str['logout']} ($user->name)</a>";
            } ?>
        </p>

    </div>

    <div class="s-prof">

        <?php // SHOW SOCIAL PROFILES
                echo svgProfiles($c_opt['page_opt']->txtarea_1,$t_str['add-prof']);
        ?>

    </div>

    </footer>

<?php
    // DEBUG REGIONS
    //    echo pwDebug();
?>

</div><!-- /#wrapper -->

<?php include 'inc/_scripts.php'; ?>

<!-- MARGUP REGION BOTTOM -->
<pw-region id="bottom-region"></pw-region>

</body>
</html>
