<?php namespace ProcessWire;
// Limit Messages
$limit_children = $page->int_2 ? $page->int_2 : 1500;
if($page->numChildren > $limit_children) {
  // https://processwire.com/talk/topic/1293-how-to-set-unpublished-for-a-page-in-the-api/
    $page->addStatus(Page::statusUnpublished);
    $page->save();
}
// Get User IP
$user_ip = $session->getIP();

// Disable IP From Contact Page ( txtarea_1 )
$check_ip = explode(',', $sanitizer->text($page->txtarea_1));
if(in_array($user_ip,$check_ip)) {    
// DIE DIE 
die("<h1>{$t_str['blocked']}</h1>");  
}

// Disable IP From User Page ( check_1=1 )
$disable_user = pages()->find("template=contact-item,txt_1=$user_ip,check_1=1,include=hidden");
if(count($disable_user)) {
  // DIE DIE 
  die("<h1>{$t_str['blocked']}</h1>");  
}
?>

<div id='body' pw-prepend>
  
<?php
// https://processwire.com/api/variables/input/
// https://processwire.com/api/ref/input/
if($input->post->submit) :

// Controll Sumbmit Form
include 'inc/_contact-controller.php';

// GET DEFAULT FORM
else : 
// GET CSRF PROTECTION
    $tokenName = $this->session->CSRF->getTokenName();
    $tokenValue = $this->session->CSRF->getTokenValue();    
?>

<form id='contact-form' class="c-form form" action="./" method='post'>

<input name="firstname" type="text" id="simple-anti-spam" class="input-hidden" placeholder="<?=__('DO NOT FILL IN THIS FIELD !!!')?>"  autocomplete="off">

<input type="hidden" id="_post_token" name="<?=$tokenName?>" value="<?=$tokenValue?>">

<div class="contact-grid">

    <div class="name">
      <label class="label-name"><?=$t_str['name'];?></label>
      <input name='name' type="text" class="input-1" placeholder="<?=$t_str['name'];?>" autocomplete="off" required>
    </div>

    <div class="email">
      <label class="label-email"><?=$t_str['e-mail'];?></label>
        <input name='email' type="email" class="input-2" placeholder="<?=$t_str['e-mail'];?>" required>
    </div>

    <div class="phone">
      <label class="label-phone"><?=$t_str['phone'];?></label>
        <input name='phone' type="text" class="input-3" placeholder="<?=$t_str['phone'];?>">
    </div>

    <div class="message">
      <label class="label-message"><?=$t_str['message'];?></label>
      <textarea name='message' class="input-4" placeholder="<?=$t_str['message'];?>" rows="8" required></textarea>
    </div>

  </div><!-- /.contact-grid -->

      <input name='submit' type="submit" class="btn-def" value='<?=$t_str['submit'];?>'>
      <button class="btn-def" type="reset"><?=$t_str['cancel'];?></button>

</form>

<?php endif;?>

</div><!-- /#body -->