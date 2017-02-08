<?php
include_once 'server/config.php';
include_once 'server/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php if (login_check($mysqli) == true) : ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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

    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">

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
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        This feature is currently not available.
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="messages.php">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                      This feature is currently not available.
                        <li>
                            <a class="text-center" href="actions.php">
                                <strong>See All Actions</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                            This feature is currently not available.
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="alerts.php">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><b><?php echo htmlentities($_SESSION['username']); ?></b> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="signout.php"><i class="fa fa-sign-out fa-fw"></i> Signout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="panel.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Statistics<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="statistics.php#usercount">User Counts</a>
                                </li>
                                <li>
                                    <a href="statistics.php#adminaction">Disciplinary Actions</a>
                                </li>
                                <li>
                                    <a href="statistics.php#servereconomy">Server Economy</a>
                                </li>
                                <li>
                                    <a href="statistics.php#serveruptime">Server Uptime</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="bans.php"><i class="fa fa-ban fa-fw"></i> Ban Management</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-users fa-fw"></i> User Administration</a>
                        </li>
                        <li>
                            <a href="rcon.php"><i class="fa fa-window-maximize fa-fw"></i> Remote Console</a>
                        </li>
                        <li>
                            <a href="servers.php"><i class="fa fa-server fa-fw"></i> Server Management</a>
                        </li>
                        <li>
                            <a href="bugs.php"><i class="fa fa-bug fa-fw"></i> Server Stability</a>
                        </li>
                        <li>
                            <a href="syslog.php"><i class="fa fa-cogs fa-fw"></i> System Event Log</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <?php
        $statement = "SELECT userid, permissionlevel, firstname, lastname, email FROM members WHERE userid='" . $_SESSION['username'] . "' LIMIT 1";
        if ($stmt = $mysqli->prepare($statement)) {
            $stmt->execute();
            $stmt->bind_result($userid, $permissionlevel, $firstname, $lastname, $email);
            $stmt->fetch();
          }
         ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User Settings</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form" id="profileedit" data-toggle="validator" action="javascript:submitProfileEditForm()">
                                  <div class="form-group">
                                      <label>User ID</label>
                                      <p class="form-control-static"><?php echo $userid; ?></p>
                                      <p class="help-block">Your unique User ID.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Permission Level</label>
                                      <p class="form-control-static"><?php echo $permissionlevel; ?></p>
                                      <p class="help-block">Your user access level.</p>
                                  </div>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i>Update profile</button>
                                  <!--<button type="reset" class="btn btn-default" onclick="resetCreateForm()"><i class="fa fa-refresh fa-fw"></i>Reset form</button>-->
                                  <button type="button" class="btn btn-default" onclick="openPasswordChangeModal()"><i class="fa fa-key fa-fw"></i>Change password</button>
                                  <button type="button" class="btn btn-danger" onclick="openAccountDeleteModal()"><i class="fa fa-trash fa-fw"></i>Delete account</button>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>First Name</label>
                                      <input class="form-control" id="firstname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" placeholder="<?php echo $firstname; ?>" value="<?php echo $firstname; ?>" required>
                                      <p class="help-block">Your legal first name.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Last Name</label>
                                      <input class="form-control" id="lastname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" placeholder="<?php echo $lastname; ?>" value="<?php echo $lastname; ?>" required>
                                      <p class="help-block">Your legal last name.</p>
                                  </div>
                                  <div class="form-group">
                                      <label>Email Address</label>
                                      <input class="form-control" id="email" data-minlength="7" pattern="^[_A-z0-9]{1,}$@" maxlength="30" placeholder="<?php echo $email; ?>" value="<?php echo $email; ?>" required>
                                      <p class="help-block">For sending alerts. Only @towerdevs.xyz addresses are allowed.</p>
                                  </div>
                              </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                            <?php $stmt->close(); ?>
                        </div>
                        <div class="col-lg-12">
                            <h2 class="page-header">DTQuery Keys</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                  <div><a href="#" onclick="keyCreateFormModal()"><button type="button" class="btn btn-primary"><i class="fa fa-flash fa-fw"></i>Create a new secret key</button></a></div>
                                  <br>
                                  <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">
                                    <thead>
                                      <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Actions: activate to sort column descending" style="width: 90px;">Actions</th>
                                      <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Secret Key: activate to sort column descending" style="width: 50px;">Secret Key</th>
                                      <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Note: activate to sort column descending" style="width: 150px;">Note</th>
                                      <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Time Created: activate to sort column descending" style="width: 150px;">Time Created</th>
                                    </thead>
                                    <?php if ($stmt = $mysqli->prepare("SELECT secretid, userid, secretkey, note, timecreated
                                        FROM usersecrets WHERE userid='" . $_SESSION['user_id'] . "' LIMIT 20")) {
                                          $stmt->execute();
                                          $stmt->bind_result($secretid, $userid, $secretkey, $note, $timecreated);
                                          while($row = $stmt->fetch())
                                          { ?>
                                           <tr>
                                            <td><a href="#" onclick="deleteSecretKeyConfirm()"><button type="button" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i>Delete</button></a></td>
                                            <td><?php echo $secretkey; ?></td>
                                            <td><?php echo $note; ?></td>
                                            <td><?php echo $timecreated; ?></td>
                                          </tr>
                                         <?php } $stmt->close(); } ?>
                                       </table>
                                </div>
                            </div>
                        </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="modal fade" id="keyDeleteModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                 <div class="modal-dialog" role="document">
                  <div class="modal-content">
                   <div class="modal-header">
                    <h5 class="modal-title">Confirm deletion</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                    <div class="modal-body">
                     Are you sure?
                     This may break DTQuery servers that use this key!
                    </div>
                <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-danger" onclick="deleteSecretKey(<?php echo $secretid; ?>, <?php echo $_SESSION['user_id']; ?>)"><i class="fa fa-trash fa-fw"></i>Confirm deletion</button>
                 <div class="help-block with-errors" id="deleteerrorblock"></div>
                </div>
               </div>
              </div>
             </div>

             <div class="modal fade" id="keyCreateModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">
               <div class="modal-content">
                <div class="modal-header">
                 <h5 class="modal-title">Create secret key</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                 <div class="modal-body">
                  <p>This is for advanced use only. The DTQuery wizard should create a key and assign it to your account automatically.</p>
                  <form role="form" id="keyCreateForm" action="javascript:submitKeyCreateForm()">
                    <div class="form-group">
                        <label>Note</label>
                        <textarea class="form-control" name="keynote" rows="3"></textarea>
                        <p class="help-block">Enter an optional note to be stored with your key.</p>
                    </div>
                 </div>
             <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Generate key</button>
              <div class="help-block with-errors" id="createerrorblock"></div>
             </div>
           </form>
            </div>
           </div>
          </div>

          <div class="modal fade" id="passwordConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
           <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-header">
              <h5 class="modal-title">Security checkpoint</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
               </button>
             </div>
              <div class="modal-body">
               <p>Please re-enter your password to save changes.</p>
               <form role="form" id="checkpointForm" action="javascript:confirmProfileEditForm()">
                 <div class="form-group">
                     <label>Password</label>
                     <input class="form-control" type="password" name="cppassword"></input>
                 </div>
              </div>
          <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i>Save changes</button>
           <div class="help-block with-errors" id="cperrorblock"></div>
          </div>
        </form>
         </div>
        </div>
       </div>

       <div class="modal fade" id="passwordChangeModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
         <div class="modal-content">
          <div class="modal-header">
           <h5 class="modal-title">Change your password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
            </button>
          </div>
           <div class="modal-body">
            <p>Enter your current password and confirm your new one.</p>
            <form role="form" id="checkpointForm" action="javascript:submitPasswordChange()">
              <div class="form-group">
                  <label>Old Password</label>
                  <input class="form-control" type="password" name="oldpassword"></input>
                  <p class="help-block">Enter your old password.</p>
              </div>
              <div class="form-group">
                  <label>New Password</label>
                  <input class="form-control" type="password" name="newpassword"></input>
                  <p class="help-block">Enter your new password.</p>
                  <input class="form-control" type="password" name="newpasswordconfirm"></input>
                  <p class="help-block">Confirm your new password.</p>
              </div>
           </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-key fa-fw"></i>Change password</button>
        <div class="help-block with-errors" id="changeerrorblock"></div>
       </div>
     </form>
      </div>
     </div>
    </div>

    <div class="modal fade" id="accountDeleteModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog" role="document">
      <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title">Delete your account</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
       </div>
        <div class="modal-body">
         <p>Are you really really sure you want to delete your account? If you are, please confirm both your username and password.</p>
         <form role="form" id="accountDeleteForm" action="javascript:submitAccountDeleteForm()">
           <div class="form-group">
               <label>Username</label>
               <input class="form-control" name="deleteusername" data-minlength="1"></input>
               <p class="help-block">Enter your username.</p>
           </div>
           <div class="form-group">
               <label>Confirm Password</label>
               <input class="form-control" type="password" name="deletepassword"></input>
               <p class="help-block">Enter your password.</p>
           </div>
        </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
     <button type="submit" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i>Confirm deletion</button>
     <div class="help-block with-errors" id="removeerrorblock"></div>
    </div>
  </form>
   </div>
  </div>
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

    <script src="js/validator.min.js"></script>
    <script src="js/sha512.min.js"></script>
    <script src="js/edit_php.js"></script>


</body>
<?php else : ?>
<head>
  <title>Redirecting...</title>
  <script src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
   $(document).ready(function(){
       window.location.href = "login.php?signoutreason=Please+log+in.";
   });
</script>
</head>
<body>
  Please wait while you are redirected to the login page.
</body>
<?php endif; ?>
</html>
