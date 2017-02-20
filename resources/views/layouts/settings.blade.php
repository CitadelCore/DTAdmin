@extends('layouts/template')

@section('messages')
@endsection

@section('tasks')
@endsection

@section('alerts')
@endsection

@section('sidebar')
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
@endsection

@section('maincontent')
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
                      <p class="form-control-static">{{ $userid }}</p>
                      <p class="help-block">Your unique User ID.</p>
                  </div>
                  <div class="form-group">
                      <label>Permission Level</label>
                      <p class="form-control-static">{{ $permissionlevel }}</p>
                      <p class="help-block">Your user access level.</p>
                  </div>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i>Update profile</button>
                  <!--<button type="reset" class="btn btn-default" onclick="resetCreateForm()"><i class="fa fa-refresh fa-fw"></i>Reset form</button>-->
                  <button type="button" class="btn btn-default" onclick="openPasswordChangeModal()"><i class="fa fa-key fa-fw"></i>Change password</button>
                  <button type="button" class="btn btn-default" onclick="open2FALoadingModal()"><i class="fa fa-mobile fa-fw"></i>Manage Multi-Factor</button>
                  <button type="button" class="btn btn-danger" onclick="openAccountDeleteModal()"><i class="fa fa-trash fa-fw"></i>Delete account</button>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                      <label>First Name</label>
                      <input class="form-control" id="firstname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" placeholder="{{ $firstname }}">
                      <p class="help-block">Your legal first name.</p>
                  </div>
                  <div class="form-group">
                      <label>Last Name</label>
                      <input class="form-control" id="lastname" data-minlength="1" pattern="^[_A-z0-9]{1,}$" maxlength="25" placeholder="{{ $lastname }}">
                      <p class="help-block">Your legal last name.</p>
                  </div>
                  <div class="form-group">
                      <label>Email Address</label>
                      <input class="form-control" id="email" data-minlength="3" pattern="^[_A-z0-9]{1,}$@" maxlength="70" placeholder="{{ $email }}">
                      <p class="help-block">For sending alerts. Only @towerdevs.xyz addresses are allowed.</p>
                  </div>
              </form>
                </div>
                <!-- /.col-lg-6 (nested) -->
            </div>
            <!-- /.row (nested) -->
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
                    {!! $secretkeys !!}
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
  <form role="form" id="keyDeleteForm" action="javascript:deleteSecretKey('{{ $username }}')"><button type="submit" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i>Confirm deletion</button>
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
 <input type="hidden" id="keyDeleteId"></input>
 <div class="help-block with-errors" id="deleteerrorblock"></div>
</form>
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
<form role="form" id="passwordChangeForm" action="javascript:submitPasswordChange()">
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

<div class="modal fade" id="2FALoadingModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Loading</h5>
</div>
<div class="modal-body">
<p>Please wait while DTAdmin loads your multi-factor preferences.</p>
</div>
</div>
</div>
</div>

<div class="modal fade" id="2FAStatusModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Multi-Factor Authentication</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<p>The current status of the Multi-Factor service on your account.</p>
<p id="mfastatusblock"></p>
<p id="mfacontrolblock"></p>

<p id="mfastatuserrorblock"></p>
</div>
</div>
</div>
</div>

<div class="modal fade" id="2FAConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Enable Multi-Factor Authentication</h5>
</div>
<div class="modal-body">
<p>Your Multi-Factor token is ready for provisioning. Please scan this QR code and add the token to your device.</p>

<p id="qrcode"></p>

<form role="form" id="2faconfirm" action="javascript:submit2FAEnableConfirmModal()">
<div class="form-group">
<label>Token</label>
<input class="form-control" name="token" data-minlength="1"></input>
<p class="help-block">Enter the most recent security code from your token.</p>
</div>

<button class="btn btn-default"><i class="fa fa-mobile fa-fw"></i>Confirm</button>
</form>
<p id="mfaconfirmerrorblock"></p>
</div>
</div>
</div>
</div>

<div class="modal fade" id="2FAContinueModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Continue Multi-Factor Authentication</h5>
</div>
<div class="modal-body">
<p>To continue setup, please scan this QR code and add the token to your device.</p>

<p id="qrcodecontinue"></p>

<form role="form" id="2facontinue" action="javascript:submit2FAEnableContinueModal()">
<div class="form-group">
<label>Token</label>
<input class="form-control" name="tokencontinue" data-minlength="1"></input>
<p class="help-block">Enter the most recent security code from your token.</p>
</div>

<button class="btn btn-default"><i class="fa fa-mobile fa-fw"></i>Confirm</button>    <button type="button" class="btn btn-danger" onclick="removePending2FAToken()"><i class="fa fa-trash fa-fw"></i>Remove Token</button>
</form>
<p id="mfacontinueerrorblock"></p>
</div>
</div>
</div>
</div>

<div class="modal fade" id="2FADisableModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Disable Multi-Factor Authentication</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<p>Your Multi-Factor token is ready for deprovisioning. Please enter the most recent code from your token as well as your account password.</p>

<form role="form" id="2fadisable" action="javascript:submit2FADisableConfirmModal()">
<div class="form-group">
<label>Token</label>
<input class="form-control" name="tokendisable" data-minlength="1"></input>
<p class="help-block">Enter the most recent security code from your token.</p>
</div>
<div class="form-group">
<label>Password</label>
<input class="form-control" type="password" name="passworddisable" data-minlength="1"></input>
<p class="help-block">Enter your account password.</p>
</div>

<button class="btn btn-danger"><i class="fa fa-trash fa-fw"></i>Remove Token</button>
</form>
<p id="mfadisableerrorblock"></p>
</div>
</div>
</div>
</div>
@endsection
