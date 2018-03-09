<?php namespace ProcessWire;?>

<!-- https://github.com/tuupola/jquery_lazyload  -->
<!-- // PURE JAVASCRIPT "Scroller" CLASS (OOP) https://codepen.io/DevWL/pen/ZWewPO -->
<script src="<?=$c_opt['t_url'];?>assets/js/all-min.js" async></script>

<!-- https://github.com/dobarkod/cookie-banner -->
<script type="text/javascript" id="cookiebanner"
    src="<?=$c_opt['t_url'];?>assets/js/cookiebanner.min.js"
    data-height="20px" data-position="bottom"
    data-message="<?=$t_str['c_message']?>"
    data-linkmsg='<?=$t_str['c_linkmsg']?>'
    data-moreinfo="<?=$pages->get('/cookie-info/')->url?>"
    data-bg="rgb(45, 44, 44)"
    defer>
</script>

<script>
    /* https://developer.mozilla.org/en-US/docs/Web/Events/load */
    window.addEventListener("load", function(){
        lazyload();
    });
</script>

<script>
/* ADD GOOGLE FONTS WITH WEBFONTLOADER ( BETTER PAGESPEED )
    https://github.com/typekit/webfontloader
    https://fonts.google.com/?subset=latin-ext&selection.family=Comfortaa|Limelight|Montserrat
*/
WebFontConfig = {
        google: {
        families: ['Montserrat','Limelight','Righteous']
    }
};
    (function(d) {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);
    })(document);

</script>
<?php
    // GOGLE ANALYTICS CODE
        // echo gAnalitycs('XAA120');
?>