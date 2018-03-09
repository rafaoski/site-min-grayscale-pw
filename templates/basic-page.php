<?php namespace ProcessWire;
// REMOVE DEMO DATA
if($page->name == 'trash-demo' && $user->isSuperuser()) {
// REMOVE DEMO DATA
echo "<div id='body' pw-prepend>"; ?>

<blockquote>
    <h3><?=$t_str['demo-trash'];?></h3>
</blockquote>

<form class='flex-center' method='POST' action="./">
    <input type="hidden" name='remove' value='remove'>
    <button class='btn-remove'><?=__('Trash Demo Data');?></button>
</form>

<?php if($input->post->remove) echo trashDemoData(true) . "<h3>{$t_str['in-trash']}</h3>";

 echo "</div>";

} else { ?>

<div id="body" pw-prepend>

</div>

<?php } ?>
