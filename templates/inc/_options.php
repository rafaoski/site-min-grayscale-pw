<?php namespace ProcessWire;
// CUSTOM OPTIONS
$c_opt = [
// GET HOME
    'home' => $pages->get("/"),
// SOME URL
    'home_url' => $pages->get("/")->url,
// TEMPLATE URL
    't_url' => urls()->templates,
// GET SOME FIELDS like healine or title
    'head_tit' => $page->get("headline|title"),
// GET SOME IMPORTANT OPTIONS FROM PAGE options
    'page_opt' => $pages->get('/options/'),
// DEFAULT LANGUAGE PREFIX
    'lang_pref' => 'en' 
];

// TRANSLATED STRINGS => https://processwire.com/api/multi-language-support/code-i18n/
// USAGE => echo $t_str['name'];
$t_str = [
// BASIC PAGINATION
    'p_prev' => __('&laquo; Previous'),
    'p_next' => __('Next &raquo;'),
// COMMENTS FORM
    'c_name' => __('Name'),
    'c_e-mail' => __('Email'),
    'c_text' => __('Comment'),
    'c_submit' => __('Submit'),
    'c_comments' => __('Comments'),
    'c_added' => __('Added '),
    'c_in_day' => __(' in day '),
    'c_reply' => __('Reply'),
    'c_join' => __('Join The Discussion'),
    'c_approved' => __('Your comment must be approved by admin'),
    'c_thanks' => __('Thanks Your comment has been saved'),
    'c_errors' => __('There were errors and the comment was not approved'),
    'c_prev' => __('&laquo; Previous'),
    'c_next' => __('Next &raquo;'),
// CONTACT PAGE
    'name' => __('Name'),
    'e-mail' => __('Email'),
    'submit' => __('Submit'),
    'phone' => __('Phone'),
    'message' => __('Message'),
    'y-message' => __('Your Message'),
    'message-s' => __('Message Subject'),
    's-again' => __('Send it again'),
    'fill-fields' => __('Fill in the field correctly'),
    's-wrong' => __('Something is wrong so try again'),
    'blocked' => __('YOU ARE BLOCKED THIS TIME :)'),
    'refresh' => __('Refresh'),
    'comments' => __('Comments'),
    'cancel' => __('Cancel'),
    'too-many' => __('Too Many Messages'),
    'limit-70' => __('Too Many Letters => Limit = 70'),
    'limit-1500' => __('Too Many Letters => Limit = 1500'),
    'phone-format' => __('The phone number should be in this format (+99) 99-315-8 ... Only Numbers, Spaces, Parentheses !!!'),
// PAGES
    'categories' => __('Categories'),
    's-cat' => __('Show Categories'),
    'tags' => __('Tags'),
    'random-p' => __('See the Best Posts'),
    'show-p' => __('Show Posts'),
    'date' => __('Date'),
    'read-m' => __('Read More &raquo;'),
    'no-user' => __('No User Found'),
    'add-prof' => __('Add Social Profiles'),
    'author' => __('Author'),
    'demo-trash' => __('If you click on the button Demo Pages Will Be Moved To Trash'),
    'in-trash' => __('Your pages are in the trash !!!'),
    'powered-by' => __('Powered by'),
    'processwire' => __('ProcessWire CMS'),
    'logout' => __('Logout'),
    'edit' => __('Edit Page'),
    'menu' => __('Menu'),
// SEARCH PAGE
    'found' => __('Found'),
    'matching' => __('Page (s) matching your search'),
    'no-found' => __('Unfortunately, no results were found.'),
    'search-sidebar' => __('Enter the search term in the search field (in the right sidebar)'),
// SEARCH FORM
    'search' => __('Search'),
    'search_label' => __('What are you looking for?'),   
// COOKIE INFO
    'c_message' => __('Wee use cookies to improve your browsing experience.'),
    'c_linkmsg' => __('Learen more'),
// RSS
    'last-posts' => __('Last Posts')
];
