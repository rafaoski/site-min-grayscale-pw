<?php namespace ProcessWire;

/**
 * ProcessWire Bootstrap API Ready 
 * ===============================
 * This ready.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after the current page has been determined and the API is fully ready 
 * to use, but before the current page has started rendering. This file receives a 
 * copy of all ProcessWire API variables. This file is an idea place for adding your
 * own hook methods. 
 *
 */

/** @var ProcessWire $wire */

/**
 * Example of a custom hook method
 * 
 * This hook adds a “numPosts” method to pages using template “category”.
 * The return value is the quantity of posts in category.
 *
 * Usage:
 * ~~~~~
 * $numPosts = $page->numPosts(); // returns integer
 * numPosts = $page->numPosts(true); // returns string like "5 posts"
 * ~~~~~
 *
 */
// Show Num Posts
$wire->addHook('Page(template=category)::numPosts', function($event) {
	/** @var Page $page */
	$page = $event->object;

	// only category pages have numPosts
	if($page->template != 'category') return;

	// find number of posts
	$numPosts = $event->pages->count("template=blog-post, cat_ref=$page");

	if($event->arguments(0) === true) {
		// if true argument was specified, format it as a "5 posts" type string
		$numPosts = sprintf(_n('%d post', '%d posts', $numPosts), $numPosts);
	}

	$event->return = $numPosts;
});

// Show Num Posts from template tag
$wire->addHook('Page(template=tag)::numTags', function($event) {
	/** @var Page $page */
	$page = $event->object;
									
	// only tag pages have numPosts
	if($page->template != 'tag') return;

	// find number of posts
	$numPosts = $event->pages->count("template=blog-post|portfolio|about-single, tag_ref=$page");

	if($event->arguments(0) === true) {
		// if true argument was specified, format it as a "5 posts" type string
		$numPosts = sprintf(_n('%d post', '%d posts', $numPosts), $numPosts);
	}

	$event->return = $numPosts;
}); 

// Limit Words
$wire->addHook('Page::summarize', function($event) {
    
	$fieldName = $event->arguments(0);
	if(!$fieldName) throw new WireException("No field provided");
  
	// get max length or use 300 as default if none provided
	$maxLength = (int) $event->arguments(1);
	if(!$maxLength) $maxLength = 300;
  
	$page = $event->object;
	$value = $page->get($fieldName);
  
	if(!strlen($value)) {
	  // requested value is blank, nothing more to do
	  $event->return = '';
	  return;
	}
  
	// get beginning of value, without any HTML in it (if any)
	$value = mb_substr(strip_tags($value), 0, $maxLength);
  
	// if output formatting on, make sure value is entity encoded
	if($page->of()) $value = $event->sanitizer->entities1($value);
  
	if(strlen($value) >= $maxLength) {
	  // limit length of returned value between words
	  // by truncating to the last space character
	  $value = substr($value, 0, strrpos($value, ' '));
	  // append an ellipsis to indicate there is more
	  $value .= ' [ &hellip; ] 	';
	}
  
	$event->return = $value;
  });

// USER PAGE ADD USER SLUG
wire()->addHookAfter('Pages::saveReady', function($event) {
    $page = $event->arguments('page');
    if ($page->template != 'user') return;
    $page->of(false);
	if($page->isChanged('txt_1')) {
	  $page->txt_2 = sanitizer()->pageName($page->txt_1);
	}
});

// https://processwire.com/api/ref/page/get-languages/
// Returns PageArray of languages, or null if language support is not active.
if(count(page()->getLanguages())) {
	
// Add status 1 ( Activate Language ) => I needed this to block user IP in many languages in contact Page
// https://processwire.com/talk/topic/4383-how-to-set-language-active-via-api/
	wire()->addHookAfter('Pages::added', function($event) {
		$page = $event->arguments('page');
		if ($page->template != 'contact-item') return '';
			foreach (languages() as $lang) $page->set("status$lang", 1);
			$page->save();
		});
	}
