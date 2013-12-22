<h1>
<?php 

if(isset($title)) { echo $title; }

?>
</h1>

<!-- Error handling if a user tried to submit an empty post -->
	<?php if(isset($error)): ?>
		<div class='error' align = "center">

			Cannot submit empty post! Please try again.
		<br><br>
		</div>
	<?php endif; ?>


<!-- if a $post_id has been set, this means that the user is actually editing a prior post.
User needs to be redirected to posts/p_edit/post_id instead -->

	<?php if(isset($post_id)): ?>
		<form method='POST' action='/posts/p_edit/<?=$post_id?>'>
	<?php else: ?>
		<form method='POST' action='/posts/p_add'>
	<?php endif; ?>

<div class="row-fluid">
	<div class = "span12" align = "center">

<!-- if the $post_id is set, then pre-populate text area with prior post -->
		<textarea rows="10" cols="50" name="content" data-content="Please post any content related to the latest news." data-rel="popover" class="input-lg form-control" data-original-title="" title=""><?php if(isset($post_id)): ?><?=$post?><?php endif; ?></textarea>
		
		
	</div>
	<div class = "span12" align = "right">
		<button type='submit' class='btn btn-primary' value='Post'><i class = "icon-pencil"></i>
		
		<?php 

		if(isset($editmode)) {
		
			echo "Update Post";
		} else {
		
			echo "Create Post";
		}
		
		?>
				
		
		
		!</button>
	</div>
</div>


</form>