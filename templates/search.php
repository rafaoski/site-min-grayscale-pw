<?php namespace Processwire;?>

<div id='body' pw-append>

	<?php

	// search.php template file
	// See README.txt for more information. 

	// look for a GET variable named 'q' and sanitize it
	$q = $sanitizer->text($input->get->q); 

	// did $q have anything in it?
	if($q) { 

		// Sanitize for placement within a selector string. This is important for any 
		// values that you plan to bundle in a selector string like we are doing here.
		$q = $sanitizer->selectorValue($q); 

		// Search the title and body fields for our query text.
		// Limit the results to 50 pages. 
		$selector = "title|body~=$q, limit=20"; 

		// If user has access to admin pages, lets exclude them from the search results.
		// Note that 2 is the ID of the admin page, so this excludes all results that have
		// that page as one of the parents/ancestors. This isn't necessary if the user 
		// doesn't have access to view admin pages. So it's not technically necessary to
		// have this here, but we thought it might be a good way to introduce has_parent.
		if($user->isLoggedin()) $selector .= ", has_parent!=2"; 

		// Find pages that match the selector
		$matches = $pages->find($selector); 

		// did we find any matches? ...
		if($matches->count) {

			// we found matches
			echo "<h3>{$t_str['found']} $matches->count {$t_str['matching']}</h3>";
			
			// output navigation for them (see TIP below)
			echo "<ul class='nav'>";

			foreach($matches as $match) {
				echo "<li><a href='$match->url'>$match->title</a>";
				echo "<div class='summary'>$match->summary</div></li>";
			}

			echo "</ul>";
			
			// TIP: you could replace everything from the <ul class='nav'> above
			// all the way to here, with just this: renderNav($matches); 

		} else {
			// we didn't find any
			echo "<h3>{$t_str['no-found']}</h3>";
		}

	} else {
		// no search terms provided
		echo "<h3>{$t_str['search-sidebar']}</h3>";
	}

	?>

</div><!-- end content -->
