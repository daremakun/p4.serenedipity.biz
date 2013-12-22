<!DOCTYPE html>
	<html>
		<head>


        	<title><?php
	if (isset($title))
		echo $title;
 ?></title>

        	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


			<!-- Common CSS/JSS -->
		
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
			
			<link rel="stylesheet" href="/css/main.css" type="text/css">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        
        	<link rel="stylesheet" href="/css/main.css" type="text/css" />
        	<link href='http://fonts.googleapis.com/css?family=Tangerine:400,300,700' rel='stylesheet' type='text/css'>

			<!-- Controller Specific CSS/JS -->
			<?php
				if (isset($client_files_head))
					echo $client_files_head;
 ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
		type="text/javascript"></script>

			<style type="text/css">
				@import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");
			</style>
			<style>
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}

	.navbar {
		margin-bottom: 20px;
	}
	a:link {
        color: #06F;
        text-decoration: none;
    }
    a:visited {
        text-decoration: none;
        color: #F00;
        font-weight:bolder;
    }
    a:hover {
        text-decoration: none;
        color: #990;
    }
    a:active {
        text-decoration: none;
        color: #93F;
        font-weight:bolder;
    }
</style>	
		</head>

	<body>

    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Serenedipity</a>
        </div>
        
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

                           <!-- Menu for users who are logged in -->
                        <?php if($user): ?>

                                <li class="<?php echo (isset($current) && $current == 'posts-index' ? 'active' : ''); ?>"><a href='/posts/index'>All Posts</a></li>
                                <li class="<?php echo (isset($current) && $current == 'posts-users' ? 'active' : ''); ?>"><a href='/posts/users'>View / Follow Members</a></li>
                                <li class="<?php echo (isset($current) && $current == 'posts-following' ? 'active' : ''); ?>"><a href='/posts/following'>Currently following</a></li>         
                                <li class="<?php echo (isset($current) && $current == 'posts-add' ? 'active' : ''); ?>"><a href='/posts/add'>Add posts</a> </li>                       
                        
                        <!-- Menu options for users who are not logged in -->
                        <?php else: ?>
                        
                                <li class="<?php echo (isset($current) && $current == 'users' ? 'active' : ''); ?>"><a href='/users'>Members</a></li>
                        
                        <?php endif; ?>
                        
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	
                        <!--If user logged in display menu-->
                        <?php if($user): ?>
                        
                                <li class="<?php echo (isset($current) && $current == 'users-profile' ? 'active' : ''); ?>"> <a href='/users/profile'>My Profile</a></li>
                                <li> <a href='/users/logout'>Logout</a></li>
                              
                
                        <!-- If user not logged in display menu -->
                        <?php else: ?>
                        
                                <li> <a href='/users/signup'>Sign up</a></li>
                                <li> <a href='/users/login'>Login</a></li>
                                
                
                        <?php endif; ?>
                        
          </ul>
        </div><!--/.nav-collapse -->
      </div>
		
      <div class="page-header">
        <h1>
        	<?php
        		
        		if(isset($title)) {
        			echo $title;
        		}
        	
        	?>
        </h1>
	</div>
	
	<div class="page-container">
   		<?php if(isset($content)) echo $content; ?>
     </div>

    </div> <!-- /container -->
	
         <script src="/js/main.js"></script>
         								
				<script type="text/javascript">
					function load() {
					var feed ="http://rss.cnn.com/rss/edition_world.rss";
					new GFdynamicFeedControl(feed, "feedControl");

				}
					google.load("feeds", "1");
					google.setOnLoadCallback(load);
				</script>
			
	</body>
</html>
