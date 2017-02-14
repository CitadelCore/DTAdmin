@extends('layouts/template')

@php
$runningserver = "";
if ($runningservers != 1) {
$runningserver = s;
}
@endphp

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
        <h1 class="page-header">Dashboard</h1><h4>You're logged in as {{ $username }}</b>.<h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-3 col-md-6">
    <div class="panel panel-red">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-check fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{{ $pendingappeals }}</div>
                    <div>Pending Appeals</div>
                </div>
            </div>
        </div>
        <a href="bans.php">
            <div class="panel-footer">
                <span class="pull-left">Manage Bans</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-tasks fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{{ $runningservers }}</div>
                    <div>{{ $runningserver }}</div>
                </div>
            </div>
        </div>
        <a href="servers.php">
            <div class="panel-footer">
                <span class="pull-left">Manage Servers</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-yellow">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bug fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{{ $last24errors }}</div>
                    <div>Lua errors in the last 24 hours</div>
                </div>
            </div>
        </div>
        <a href="bugs.php">
            <div class="panel-footer">
                <span class="pull-left">See Errors</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-support fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div class="huge">{{ $supportrequests }}</div>
                    <div>Support Requests</div>
                </div>
            </div>
        </div>
        <a href="tickets.php">
            <div class="panel-footer">
                <span class="pull-left">See Requests</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
</div>
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Player counts
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        View
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Last 24 hours</a>
                        </li>
                        <li><a href="#">Last 7 days</a>
                        </li>
                        <li><a href="#">Last month</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#">SmartChart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div id="morris-area-chart"></div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Administrative Actions
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                        View
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Last 24 hours</a>
                        </li>
                        <li><a href="#">Last 7 days</a>
                        </li>
                        <li><a href="#">Last month</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#">SmartChart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="table-responsive">
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.col-lg-4 (nested) -->
                <div class="col-lg-8">
                    <div id="morris-bar-chart"></div>
                </div>
                <!-- /.col-lg-8 (nested) -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-clock-o fa-fw"></i> Server Timeline
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <ul class="timeline">
              This feature is currently not available.
            </ul>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-8 -->
<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bell fa-fw"></i> Notifications Panel
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="list-group">
             This feature is currently not available.
            </div>
            <!-- /.list-group -->
            <a href="alerts.php" class="btn btn-default btn-block">View All Alerts</a>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Server Uptime
        </div>
        <div class="panel-body">
          This feature is currently not available.
            <a href="statistics.php#serveruptime" class="btn btn-default btn-block">View Details</a>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="chat-panel panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-comments fa-fw"></i> Chat
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li>
                        <a href="#">
                            <i class="fa fa-refresh fa-fw"></i> Refresh
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-check-circle fa-fw"></i> Available
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-times fa-fw"></i> Busy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-clock-o fa-fw"></i> Away
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <i class="fa fa-sign-out fa-fw"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <ul class="chat">
              This feature is currently not available.
            </ul>
        </div>
        <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="input-group">
                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-sm" id="btn-chat">
                        Send
                    </button>
                </span>
            </div>
        </div>
        <!-- /.panel-footer -->
    </div>
    <!-- /.panel .chat-panel -->
</div>
@endsection
