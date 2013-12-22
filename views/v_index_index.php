<!--If not logged in user display sign up and login forms-->
<h2>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h2>
<p>
        If you love news, events and life, this is the place to share them and learn about new adventures. Amazing how much we can learn from some serenity!
</p>
<?php if(!$user): ?>


        <div id="signup-block">
        <h3>New to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?>?
                <!-- Display the signup module -->
                <?= $signup ?>
        </div>
        
         
        <div id="login-block">
        <h3>Got an account?</h3>
        <!-- Display the login module -->
                <?=$login?>
        </div>

<!--If user logged in display welcome message-->
<?php else: ?>

        <img src="<?= $user->avatar ?>" alt="<?= $user->first_name ?>">
        <h1>Welcome to <?=APP_NAME?><?= ', '.$user->first_name ?></h1>

<?php endif; ?>




