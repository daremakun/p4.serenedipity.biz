<!--Upload avatar-->
<h2>Upload avatar of <?= $user->first_name ?> </h2>
<br><br>

<!--Upload files-->
<form method='POST' enctype="multipart/form-data" action='/users/p_upload_avatar/'>

        <input type='file' name='avatar'>
        <input type='submit'>

</form>