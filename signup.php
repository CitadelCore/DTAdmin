<?php
include_once 'server/config.php';
include_once 'server/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php if (login_check($mysqli) != true) : ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <title>TOWER DTAdmin <?php echo $release; ?> <?php if ($devmode == true) { echo "Developer"; }?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">TOWER DTAdmin <?php echo $release; ?> <?php if ($devmode == true) { echo "Developer"; }?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><b>Guest</b> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Login</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Registration</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form" id="profilecreate" data-toggle="validator" action="javascript:confirmProfileCreateForm()">
                                  <div class="form-group">
                                      <label>Username</label>
                                      <input class="form-control" id="username" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" required>
                                      <p class="help-block">Your unique User ID.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Password</label>
                                      <input class="form-control" type="password" id="password" data-minlength="1" maxlength="25" required>
                                      <p class="help-block">Your password. Make it secure.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Confirm Password</label>
                                      <input class="form-control" type="password" id="passwordconfirm" data-match="#password" data-match-error="Your password dosen't match." data-minlength="1" maxlength="25" required>
                                      <p class="help-block">Confirm your password, just in case.</p>
                                  </div>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-rocket fa-fw"></i>Create account</button>
                                  <button type="reset" class="btn btn-default"><i class="fa fa-refresh fa-fw"></i>Reset form</button>
                                  <p class="help-block with-errors" id="createerrorblock"></p>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>First Name</label>
                                      <input class="form-control" id="firstname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" required>
                                      <p class="help-block">Your legal first name.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Last Name</label>
                                      <input class="form-control" id="lastname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" required>
                                      <p class="help-block">Your legal last name.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Email Address</label>
                                      <input class="form-control" id="email" data-minlength="7" maxlength="70" required>
                                      <p class="help-block">For sending alerts. Only @towerdevs.xyz addresses are allowed.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Invite Key</label>
                                      <input class="form-control" id="invitekey" data-minlength="7" maxlength="50" value="<?php if (isset($_GET['invitekey'])) { echo htmlentities($_GET['invitekey']); } ?>" <?php if (isset($_GET['invitekey'])) { echo "disabled"; } ?>>
                                      <p class="help-block">Enter a custom Invite Key.</p>
                                  </div>
                              </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <footer class="navbar-fixed-bottom" style="text-align:center; font-size:80%;">
            TOWER DTAdmin © 2016 <a href="https://www.towerdevs.xyz">TOWER Devs</a>. All rights reserved. Unauthorized access to this web page may result in prosecution.
          </footer>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery-3.1.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/raphael.min.js"></script>
    <script src="js/morris.min.js"></script>
    <!--<script src="data/morris-data.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <script src="js/sha512.min.js"></script>
    <script src="js/signup_php.js"></script>

</body>
<?php else : ?>
<head>
  <title>Redirecting...</title>
  <script src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
   $(document).ready(function(){
       window.location.href = "panel.php";
   });
</script>
</head>
<body>
  You're already logged in, so we're redirecting you to the panel...
</body>
<?php endif; ?>
</html>
