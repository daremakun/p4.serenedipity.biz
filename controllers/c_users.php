<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();

    }
    	/*-------------------------------------------------------------------------------------------------
      
        -------------------------------------------------------------------------------------------------*/
    public function index() {
    
    	    # Select all users from database
            $view_users = DB::instance(DB_NAME)->select_rows('SELECT * FROM users');
               
            # Setup view
            $this->template->content = View::instance('v_users_view_all');
            $this->template->title = "Users";
            
               
            # Pass data to the view
            $this->template->content->view_users = $view_users;
            
            # Render template
            echo $this->template;
    }
        /*-------------------------------------------------------------------------------------------------
      Error Handling
        -------------------------------------------------------------------------------------------------*/
    public function signup($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Validate that the user has entered a valid login name
        -------------------------------------------------------------------------------------------------*/
    public function p_signup() {

        
        $at_sign = strpos($_POST['email'], '@');

        # Error code 1 indicates invalid login name
        if($at_sign === false) {
            Router::redirect('/users/signup/1');
        }

        ## if the email has already been created, then alert the person signing up
        $email = $_POST['email'];
        $q = "SELECT created FROM users WHERE email = '".$email."'";
        $emailexists = DB::instance(DB_NAME)->select_field($q);

        # Error code 2 indicates that user already exists
        if(isset($emailexists)){
            Router::redirect('/users/signup/2');
        }

        ## Ensure that the user has entered a first name

        # Error code 3 indicates that user needs a first name
        if(strlen($_POST['first_name'])<1){
            Router::redirect('/users/signup/3');
        }

        ## Ensure password is greater than 5 characters
        # Error code 4 indicates that password is too short
        if(strlen($_POST['password'])<6) {
            Router::redirect('/users/signup/4');
        }

        # Give user the default avatar and profile photo
        $_POST['avatar'] = "sample.jpg";

        # Store time stamp data from user
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert('users', $_POST);

        # Redirect to the login page, and inform them that they have signed up
        # Currently using $error = 2 as the indication that they have signed up
        Router::redirect('/users/login/2');

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Error Handling
        -------------------------------------------------------------------------------------------------*/
    public function login($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title = "Login";

        # Pass data to the view
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Login checkpoint
        -------------------------------------------------------------------------------------------------*/
    public function p_login() {

        # Sanitize the user entered data
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available

        $q = 'SELECT token
				FROM users
				WHERE email = "'.$_POST['email'].'"
				AND password = "'.$_POST['password'].'"';

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if(!$token) {

            # Send them back to the login page
            # Error code 1 indicates that they have incorrect login credentials
            Router::redirect("/users/login/1");

        }
        	# But if we did, login succeeded!
        	else {

            # Store this token in a cookie using setcookie()
            setcookie("token", $token, strtotime('+1 year'), '/', false);

            # Send them to the main page
            Router::redirect('/users/profile');
        }
    } # End of Method
        /*-------------------------------------------------------------------------------------------------
        Logout
        -------------------------------------------------------------------------------------------------*/
    public function logout() {
        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    } # End of Method
        /*-------------------------------------------------------------------------------------------------
      	Make sure user is logged in if they want to use anything in this controller
        -------------------------------------------------------------------------------------------------*/
	public function profile() {
    
            # If user is blank, redirect them to the login page
            if(!$this->user) {
                    
                    Router::redirect('/users/login');
               }
            
            # If user is logged in:
            # Setup view
            $this->template->content = View::instance('v_users_profile');
            $this->template->title = "Profile of ".$this->user->first_name;
  
  	// Keep track of the current page for nav 
       	$this->template->current= 'users-profile';
                  
                  $avatar = $this->user->avatar;
                  
                  # Pass data to the view
                  $this->template->content->avatar = $avatar;                         
            
            # Render template
            echo $this->template;
    }
    	/*-------------------------------------------------------------------------------------------------
        
        -------------------------------------------------------------------------------------------------*/
    public function edit_profile() {
    
            # If user is blank, redirect them to the login page
            if(!$this->user) {
                    
                    Router::redirect('/users/login');
               }
    
            # Setup the view
            $this->template->content = View::instance('v_users_edit_profile');
            $this->template->title = "Edit profile of ".$this->user->first_name;
            
            $avatar = $this->user->avatar;
            
            # Pass data to the view
            $this->template->content->avatar = $avatar; 
                        
            # Select user's data from the database
                 $q = "SELECT *
                         FROM users 
                         WHERE user_id = ".$this->user->user_id;
                                         
                 $this_user = DB::instance(DB_NAME)->select_row($q);
                 
                 # Create new form object and pass form data to the view
                 $this->template->content->form = New Form($this_user);
            
            # Render template            
            echo $this->template;
    }
    	/*-------------------------------------------------------------------------------------------------
        
        -------------------------------------------------------------------------------------------------*/
    public function p_edit_profile() { 
    
            # Prevent special characters
            $_POST['bio'] = htmlentities($_POST['bio']);
    
            # Update users bio information
                $data = Array("bio" => $_POST['bio']);
           
                DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);
           
                # Redirect to profile page
                Router::redirect("/users/profile");
    
    }
    	/*-------------------------------------------------------------------------------------------------
       
        -------------------------------------------------------------------------------------------------*/
    public function upload_avatar() {
    
            # If user is blank, redirect to the login page
            if(!$this->user) {
                    
                    Router::redirect('/users/login');
            }
    
            # Setup the view
            $this->template->content = View::instance('v_users_upload_avatar');
            $this->template->title = "Upload avatar of ".$this->user->first_name;
            
            $avatar = $this->user->avatar;
            
            # Pass data to the view
            $this->template->content->avatar = $avatar;
            
            # Render template
            echo $this->template;
    
    }
    	/*-------------------------------------------------------------------------------------------------
       
        -------------------------------------------------------------------------------------------------*/
    public function p_upload_avatar() {
   
                   if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                    
                    # Upload avatar picture
                    $avatar = Upload::upload($_FILES, "/uploads/avatars/", array("jpg", "jpeg", "gif", "png"), $this->user->user_id);
                    
                    
                    $extentions = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                    if (!in_array($_FILES['avatar']['type'], $extentions)) {
                            echo "Error! .jpg, .jpeg, .png, .gif images only. Please <a href='/users/upload_avatar/'>try again.</a>";
                    }
                    
                    else {
            
                       # Update database
                       $data = Array("avatar" => $avatar);
                    
                    DB::instance(DB_NAME)->update("users", $data, "WHERE  user_id = ".$this->user->user_id);
                    
                    $file_path = APP_PATH.'/uploads/avatars/'. $avatar;

                    
	                    # Create new image object and resize it
	                    $imgObj = new Image($file_path);
	                   
	                   $imgObj->resize(150,150, "auto");
	
	                    $imgObj->save_image($file_path, 100);
	                    
                 
                    
                    # Render template
                    Router::redirect("/users/upload_avatar?uploaded=true" ); 
                    
                    }
            } 
            
            else {
                    echo "Error! You haven't chosen any image. Please <a href='/users/upload_avatar/'>try again.</a>";
            }

    } # End of Method

} # end of the class
