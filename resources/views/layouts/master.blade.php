<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('before_styles')
    
    <title>{{ isset($title) ? config('app.name').'::'.$title : config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500,600|Material+Icons" rel="stylesheet" type="text/css">
    
    <!-- other styles -->
    {{--  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">  --}}
     <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- BackPack Base CSS
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/overlays/backpack.bold.css') }}">

    @yield('after_styles')  -->

    <style>
        body{
            font-family: 'Google Sans', sans-serif;
            font-family: 'Roboto', sans-serif;
            font-family: 'Segoe UI', sans-serif;
            font-family: 'Montserrat', sans-serif;
            font-family: 'Lato', sans-serif;
            font-family: 'Source Sans Pro', sans-serif;
            font-family: 'FrescoSansPro-Normal';
            font-family: 'Helvetica';
            font-family: 'Hind', sans-serif;
            font-family:  proxima-nova "Source Sans Pro", sans-serif, Overpass, "Droid Sans", "open sans", "Helvetica Neue", Helvetica, Arial;
            
            font-size: 1rem/1.5 !important;
            /*font-size: 14px !important; */
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    
    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- GITTER -->
    <script src="{{ asset('js/plugins/gritter/jquery.gritter.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

</head>

<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">
<script type="text/javascript">
		/* Recover sidebar state */
		(function () {
			if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
				var body = document.getElementsByTagName('body')[0];
				body.className = body.className + ' sidebar-collapse';
			}
		})();
	</script>
    <!-- Site wrapper -->
    <div id="wrapper">

        <!-- Left side column. contains the sidebar -->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
      <!-- sidebar: style can be found in sidebar.less -->
     
        <!-- Sidebar user panel -->
        <li class="nav-header">
            <div class="dropdown profile-element"> 
                <span>
                    <img src="{{ backpack_avatar_url(Auth::user()) }}" class="img-circle" alt="User Image" style="width: 70px">
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong></span>
                    <span class="text-muted text-xs block">{{Auth::user()->username}} <b class="caret"></b></span> </span>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a href="profile.html">Profile</a></li>
                    @hasrole('member')
                        {{--  @if(Auth::user()->member->type === 'organization')
                            <li><a href="#">Task board</a></li>
                        @else
                            <li><a href="#">Issue board</a></li>
                        @endif  --}}
                    @endhasrole
                    @hasrole('owner')
                        <li><a href="#">Projects</a></li>
                    @endhasrole
                    <li><a href="mailbox.html">Mailbox</a></li>
                    <li class="divider"></li>
                    <li><a href="login.html">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                IN+
            </div>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-dashboard"></i>
                <span class="nav-label">Dashboard</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li><a href="{{url('home')}}"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a></li>
                @hasrole('member')
                    {{--
                    @if(Auth::user()->member->type === 'organization')
                        <li><a href="#"><i class="fa fa-plus"></i> <span class="nav-label">Create Task</span></a></li>
                        <li><a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Task Board</span></a></li>
                    @else
                        <li><a href="#"><i class="fa fa-plus"></i> <span class="nav-label">Create Issue</span></a></li>
                        <li><a href="#"><i class="fa fa-th"></i> <span class="nav-label">Issue Board</span></a></li>
                    @endif  
                    --}}
                    <li><a href="#"><i class="fa fa-users"></i> <span class="nav-label">Teams</span></a></li>
                    <li><a href="{{url('members_projects')}}"><i class="fa fa-suitcase"></i> <span class="nav-label">Projects</span></a></li>
                @endhasrole
                @hasrole('owner')
                    <li><a href="#"><i class="fa fa-plus"></i> <span class="nav-label">Create Client</span></a></li>
                    <li><a href="#"><i class="fa fa-suitcase"></i> <span class="nav-label">Clients</span></a></li>
                    <li><a href="#"><i class="fa fa-plus"></i> <span class="nav-label">Create Project</span></a></li>
                    <li><a href="{{route('projects')}}"><i class="fa fa-briefcase"></i><span class="nav-label">Projects</span></a></li>
                    <li><a href="#"><i class="fa fa-user-plus"></i> <span class="nav-label">Add Member</span></a></li>
                    <li><a href="#"><i class="fa fa-users"></i> <span class="nav-label">Members</span></a></li>
                @endhasrole
            </ul>
        </li>
        <li><a href="{{url('organizations')}}"><i class="fa fa-briefcase"></i> <span class="nav-label">Organizations</span></a></li>
        {{--  <li>
            <a href="{{route('projects')}}"><i class="fa fa-list-alt"></i> <span class="nav-label">Projects</span></a>
        </li>  --}}
        <li>
            <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="mailbox.html"><i class="fa fa-inbox"></i> <span class="nav-label">Inbox</span></a></li>
                <li><a href="mail_detail.html"><i class="fa fa-eye"></i> <span class="nav-label">Email view</span></a></li>
                <li><a href="mail_compose.html"><i class="fa fa-edit"></i> <span class="nav-label">Compose email</span></a></li>
                <li><a href="email_template.html"><i class="fa fa-file-text-o"></i> <span class="nav-label">Email Templates</span></a></li>
            </ul>
        </li>
        @hasrole('owner')
        <li>
            <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Project Mgmt.</span><span class="label label-warning pull-right">16/24</span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="#"><i class="fa fa-bar-chart"></i> <span class="nav-label">Project Analysis</span></a></li>
                <li><a href="#"><i class="fa fa-calendar-check-o"></i> <span class="nav-label">Calendar</span></a></li>
                <li><a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Archive</span></a></li>
            </ul>
        </li>
        @endhasrole
        {{--  <li>
            <a href="raise_ticket"><i class="fa fa-cubes"></i> <span class="nav-label">Issue Tracker</span></a>
        </li>   --}}
        <li>
            @role('admin')
                <a href="{{url('admin')}}"><i class="fa fa-wrench"></i> <span class="nav-label">Admin page</span></a>
            @endrole
        </li>  
        

        <!-- sidebar menu: : style can be found in sidebar.less 
        
          <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          <li><a href="{{  backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
          <li><a href="{{ backpack_url('log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
          
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="nav nav-second-level collapse">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
          <li><a href="{{ backpack_url('team') }}"><i class="fa fa-tag"></i> <span>Manage Teams</span></a></li>
          <li><a href="{{ backpack_url('client') }}"><i class="fa fa-tag"></i> <span>Manage Clients</span></a></li>
          <li><a href="{{ backpack_url('project') }}"><i class="fa fa-tag"></i> <span>Manage Projects</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>
          <li><a href="{{  backpack_url('language') }}"><i class="fa fa-flag-o"></i> <span>Languages</span></a></li>
          <li><a href="{{ backpack_url( 'language/texts') }}"><i class="fa fa-language"></i> <span>Language Files</span></a></li>
          <li><a href="{{backpack_url('page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
          <li><a href="{{ backpack_url('backup') }}"><i class="fa fa-hdd-o"></i> <span>Backups</span></a></li>
          <li><a href="{{ backpack_url('setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li> 
          -->
        </ul>
        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="http://webapplayers.com/inspinia_admin-v2.7.1/search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <!-- -->
                <?php $user = Auth::user(); 
                    #$user_member = $user->member;
                    #$organization = \App\Models\Organization::with('members')->get();
                ?>
                <li>
                    @if (config('app.deployment_type') === 'web')
                        <span>
                            {{--  Query if user is owner or not. If not, show button to create organization  --}}
                            @if(! $user->hasRole('owner') && ! $user->hasRole('admin'))
                                <a data-toggle="modal" data-target="#modalOrg" class="btn btn-primary" href="#">
                                <label style="font-size: 15px">Create Organization</label>
                                </a>
                            @endif
                        </span>
                    @endif
                </li>
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to EnterpriseX</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{ asset('img/a7.jpg')}}">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{ asset('img/a4.jpg')}}">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="{{ asset('img/profile.jpg')}}">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i>Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                @endguest                
            </ul>

        </nav>
        </div>
        
        <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

          @include('partials.modals')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

        <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> EnterpriseX &copy; 2018
                </div>
            </div>
            </div>
        </div>

        </div>
        <div class="small-chat-box fadeInRight animated">

            <div class="heading" draggable="true">
                <small class="chat-date pull-right">
                    02.19.2015
                </small>
                Small chat
            </div>

            <div class="content">

                <div class="left">
                    <div class="author-name">
                        Monica Jackson <small class="chat-date">
                        10:02 am
                    </small>
                    </div>
                    <div class="chat-message active">
                        Lorem Ipsum is simply dummy text input.
                    </div>

                </div>
                <div class="right">
                    <div class="author-name">
                        Mick Smith
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        Lorem Ipsum is simpl.
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Alice Novak
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        Check this stock char.
                    </div>
                </div>
                <div class="right">
                    <div class="author-name">
                        Anna Lamson
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        The standard chunk of Lorem Ipsum
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Mick Lane
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        I belive that. Lorem Ipsum is simply dummy text.
                    </div>
                </div>


            </div>
            <div class="form-chat">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control">
                    <span class="input-group-btn"> <button
                        class="btn btn-primary" type="button">Send
                </button> </span></div>
            </div>

        </div>
        <div id="small-chat">

            <span class="badge badge-warning pull-right">5</span>
            <a class="open-small-chat">
                <i class="fa fa-comments"></i>
            </a>
        </div>
        @include('partials.right_sidebar')
    </div>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    <!-- custom scripts -->
    {{--  <script src="{{ asset('js/custom/agile_board.js')}}"></script>  --}}
    <script src="{{ asset('js/custom/team.js')}}"></script>


    <script>
        $(document).ready(function(){

            $('#loading-example-btn').click(function () {
                btn = $(this);
                simpleLoad(btn, true)

                // Ajax example
                $.ajax().always(function () {
                    simpleLoad($(this), false)
                });
                simpleLoad(btn, false)
            });
        });

        function simpleLoad(btn, state) {
            if (state) {
                btn.children().addClass('fa-spin');
                btn.contents().last().replaceWith(" Loading");
            } else {
                setTimeout(function () {
                    btn.children().removeClass('fa-spin');
                    btn.contents().last().replaceWith(" Refresh");
                }, 2000);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            /*setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('EnterpriseX', 'Improve your productivity');

            }, 1300); */


            var data1 = [
                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
            ];
            var data2 = [
                [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
                    {
                        series: {
                            lines: {
                                show: false,
                                fill: true
                            },
                            splines: {
                                show: true,
                                tension: 0.4,
                                lineWidth: 1,
                                fill: 0.4
                            },
                            points: {
                                radius: 0,
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#d5d5d5",
                            borderWidth: 1,
                            color: '#d5d5d5'
                        },
                        colors: ["#1ab394", "#1C84C6"],
                        xaxis:{
                        },
                        yaxis: {
                            ticks: 4
                        },
                        tooltip: false
                    }
            );

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [300,50,100],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            } ;


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

            var doughnutData = {
                labels: ["App","Software","Laptop" ],
                datasets: [{
                    data: [70,27,85],
                    backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
                }]
            };


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };

            var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});
            

        });
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1; a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-4625583-2', 'webapplayers.com');
        ga('send', 'pageview');

    </script>
</body>

</html>
