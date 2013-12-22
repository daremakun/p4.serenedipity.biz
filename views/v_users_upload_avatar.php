<!--Upload avatar-->

<h2>Uploaded avatar of <?= $user->first_name ?> </h2>
<br><br>

<?php
	if(isset($_GET['uploaded'])) {
	
	echo '<h1> Image Uploaded Successfully.</h1>'; 
	
	}

?>


<!--Upload files-->
<form method='POST' enctype="multipart/form-data" action='/users/p_upload_avatar/'>

        <input type='file' name='avatar'>
        <input type='submit'>

</form>

<br/>
<img src="<?= $user -> avatar . '?cachebust=' . time(); ?>" alt="<?= $user -> first_name ?>" />