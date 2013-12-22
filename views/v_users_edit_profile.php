
<h2>Name: <?= $user->first_name ?> <?= $user->last_name ?></h2>
<br />
<h2>Bio: </h2>
<!--Edit or fill in user's short bio-->
<?php $form->open($name = 'form', $action = '/users/p_edit_profile/', $html = NULL, $method = 'post'); ?>

        <?=$form->textarea('bio'); ?><br />
        
        <input type='submit'>

</form>

<br /><br />
        
<img src="<?=$avatar?>" alt="<?= $user->first_name ?>">
