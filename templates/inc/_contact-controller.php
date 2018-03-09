<?php namespace ProcessWire;

// RESET ERROR MESSAGE
$err_mess = '';

// https://processwire.com/api/ref/session-c-s-r-f/
if($session->CSRF->hasValidToken()) {
    if($input->post->firstname) {
        $err_mess .= "<h1>{$t_str['blocked']}</h1>";
    } 

// FIND TOO MANY MESSAGE ( CHECK CONTACT PAGE CUSTOM OPTIONS )
$find_all_ip = pages()->find("template=contact-item,txt_1=$user_ip,include=hidden");
// Max messages for one IP Adress
$max_messages = $page->int_1 ? $page->int_1 : 12;
if(count($find_all_ip) >= $max_messages ) {   
$c = count($find_all_ip);
// DIE DIE 
die("<h1>{$t_str['too-many']} ($c) MAX ({$max_messages})</h1>");    
// OR ERROR -- 404 -- BAD REQUEST     
   // throw new Wire404Exception();
// OR Redirect
//    $session->redirect($homepage->httpUrl);
}

// Set your adress E-Mail in contact page  
$e_mail = page()->email_1 ? page()->email_1 : 'user@gmail.com';

// https://processwire.com/api/variables/sanitizer/
$m_name = $sanitizer->text($input->post->name);
$m_from = $sanitizer->email($input->post->email);
$m_message = $sanitizer->text($input->post->message);
$phone = $sanitizer->text($input->post->phone);

if(strlen($m_name) > 70 ) {
// ERROR MESSAGE
    $err_mess .= $t_str['limit-70'];
}

if(strlen($m_from) > 70 ) {
// ERROR MESSAGE
      $err_mess .= $t_str['limit-70'];
  }

  if(strlen($m_message) > 1500 ) {
// ERROR MESSAGE
    $err_mess .= $t_str['limit-1500'];
  }

// https://www.noupe.com/development/php-regular-expressions.html
$p = $input->post->phone;
if($p != '' && !preg_match('/^[0-9 \-\+\(\)]+$/',$phone)) {
    // ERROR MESSAGE
    $err_mess .= $t_str['phone-format'];
}  

 // IF SOME ERRORS
 if($err_mess) {
  die("<h1>$err_mess <a href='{$page->url}'>{$t_str['s-again']}</a></h1>");
}

if($m_name && $m_from  && $m_message) {
    $ph_nr = $phone ? "<h3>{$t_str['phone']}: $phone</h3>" : '';
        $html = "<html><body>
                      <h1>{$t_str['y-message']}</h1>
                      <h3>{$t_str['name']}: $m_name</h3>
                      <h3>{$t_str['e-mail']}: $m_from</h3> 
                              $ph_nr
                      <p><b>{$t_str['message']}:</b> $m_message</p>
                 </body></html>"; 

  // https://processwire.com/api/ref/mail/
// $m = wireMail();
    $m = $mail->new();
    // separate method call usage
    $m->to($e_mail); // specify CSV string or array for multiple addresses
    $m->from($m_from);
    $m->subject($t_str['message-s']);
    $m->bodyHTML("$html");
    $m->send();

// If Enable Save Messages in Contact Page 
if(page()->check_1) {
// https://processwire.com/talk/topic/352-creating-pages-via-api/
// https://processwire.com/api/variables/pages/
// save to log that can be viewed via the pw backend
  $p = new Page();
// Page template single item  
  $p->template = 'contact-item';
// Page parent to save messages
  $p->parent = page()->id; // or use id => $p->parent = 1017;
// Save Page with e-mail, date time, user ip
  $p->title = $m_from . ' - ' . date("Y.m.d | H:i") . ' - IP - ' . $user_ip;
// Save Message
  $p->body = $html;
// Save ip
  $p->txt_1 = $user_ip;
// Save E-Mail
  $p->txt_2 = $m_from;
// Add status hidden ( no show pages in sitemap or sitemap.xml ), https://processwire.com/api/ref/page/add-status/ 
  $p->addStatus(Page::statusHidden);
// Finish => Save Page   
  $p->save();
}

echo 
"<h2>{$t_str['y-message']}:</h2>
 <h3>{$t_str['name']}: $m_name</h3>
 <h4>{$t_str['e-mail']}: $m_from</h4>
      $ph_nr
<h4>{$t_str['message']}:</h4> <p>$m_message</p>";

} else {
    echo '<h1>' . $t_str['fill-fields'] . "<a href='{$page->url}'>{$send_again}</a>" . '</h1>';
}
// IF CSRF TOKEN NOT FOUND
} else {
    echo "<h3> {$t_str['s-wrong']} <a href='./' class='text-error'> {$t_str['refresh']} </a></h3>";
}