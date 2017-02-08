<!DOCTYPE html>
<html lang="en">
 <head>
   <title>TOWER DTAdmin 1.2</title>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="css/tower.css" rel="stylesheet">
   <script src="js/jquery-3.1.1.min.js"></script>
   <script src="js/validator.min.js"></script>
   <script src="js/sha512.min.js"></script>
   <script src="js/servercontrol.js"></script>
   <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
   <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <script type="text/javascript">
    $(document).ready(function(){
        $('#loadModal').modal('show');
    });
</script>
 </head>
 <body>
   <br><br><br>

<div id="loadModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Please wait.</h4>
      </div>
      <div class="modal-body">
        <p>Connecting to the backend...</p>
        <div class="loader" style="text-align:center"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<div id="progressModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Please wait.</h4>
      </div>
      <div class="modal-body">
        <p>Logging you in securely...</p>
        <div class="loader" style="text-align:center"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<div id="errorModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Error</h4>
      </div>
      <div class="modal-body">
        <p style='color:red'>There was an error connecting to the backend. Please try again later.</p>
        <br>
        <a href="mailto:support@towerdevs.xyz">Contact support</a>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    	  <div class="modal-dialog">
				<div class="loginmodal-container">
					<h1><i class="fa fa-wrench"></i> Login to DTAdmin</h1><br>
				  <form id="loginform" role="form" name="loginform" action="javascript:submitCredentials()">
            <div id="username-status-block" class="form-group">
				        <input type="text" maxlength="20" pattern="^[_A-z0-9]{1,}$" name="userid" placeholder="User ID" data-error="Your User ID is invalid." required>
            </div>
          <div class="help-block with-errors" id="username-error-block"></div>
            <div id="password-status-block" class="form-group">
					     <input type="password" data-minlength="6" name="password" placeholder="Password" data-error="Your password is invalid." required>
            </div>
          <div class="help-block with-errors" id="password-error-block"></div>
            <div id="login-status-block" class="form-group">
					     <input type="submit" name="login" class="login loginmodal-submit" value="Login">
            </div>
          <div class="help-block with-errors" id="login-error-block"></div>
          <div style="color:red"><?php if(isset($_GET['signoutreason'])) { echo htmlspecialchars($_GET['signoutreason']); } ?></div>
				  </form>

				  <div class="login-help">
					<a href="mailto:support@towerdevs.xyz">Contact Support</a> - <a href="forgot.php">Forgot Password?</a> - <a href="signup.php">Register</a><br>
          This is a private server. Attempting to gain unauthorized entry may be a criminal offence. Your IP address, <?php echo $_SERVER['REMOTE_ADDR']; ?>, has been logged in our database.
				  </div>
				</div>
			</div>
		  </div>

<script src="js/bootstrap.min.js"></script>
</script>
 </body>
 <footer class="navbar-fixed-bottom" style="text-align:center; font-size:80%;">
 TOWER DTAdmin © 2016 <a href="https://www.towerdevs.xyz">TOWER Devs</a>. All rights reserved. Unauthorized access to this web page may result in prosecution.
</footer>
</html>
