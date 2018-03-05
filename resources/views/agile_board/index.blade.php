
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Set a meta reference to the CSRF token for use in AJAX request -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            {{--  <img alt="image" class="img-circle" src="{{ asset('img/profile_small.jpg')}}" />  --}}
                            <img src="{{ backpack_avatar_url(Auth::user()) }}" class="img-circle" style="width: 80px; height: 80px;" alt="User Image">
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
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
                    <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{url('home')}}">Home</a></li>
                        {{--  <li><a href="dashboard_2.html">Dashboard v.2</a></li>  --}}
                    </ul>
                </li>
                <li>
                    <a href="{{url('projects')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Projects</span></a>
                </li>
                {{--  <li>
                    <a href="{{route('agile_board')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Agile Board</span></a>
                </li>  --}}
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="graph_flot.html">Flot Charts</a></li>
                        <li><a href="graph_morris.html">Morris.js Charts</a></li>
                        <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                        <li><a href="graph_chartjs.html">Chart.js</a></li>
                        <li><a href="graph_chartist.html">Chartist</a></li>
                        <li><a href="c3.html">c3 charts</a></li>
                        <li><a href="graph_peity.html">Peity Charts</a></li>
                        <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a> 
            <form role="search" class="navbar-form-custom" action="http://webapplayers.com/inspinia_admin-v2.7.1/search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                @auth
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
                @endauth
                <!-- Authentication Links -->
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
                @endguest
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Agile board</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>Miscellaneous</a>
                        </li>
                        <li class="active">
                            <strong>Agile board</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>To-do</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                            <div class="input-group">
                                <input type="text" id="add_task_description" placeholder="Add new task. " class="input input-sm form-control">
                                <input type="hidden" id="team_id" name="team_id" value="{{ $t_id }}">
                                <input type="hidden" id="project_id" name="project_id" value="{{ $p_id }}">
                                
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-white" id="add_task"> <i class="fa fa-plus"></i> Add task</button>
                                </span>
                            </div>

                            <ul class="sortable-list connectList agile-list" id="todo">                                
                                <li class='new_todos warning-element sortable-yes' hidden="true"></li>
                                @foreach($todos as $todo)                                  
                                    @if($todo->status === 0)
                                        {{-- Add Auth::roles()->user; --}}
                                        <li class="warning-element sortable-<?php if(!$todo->updated_by OR $todo->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$todo->id}}">
                                            {{ $todo->description }}
                                            <div class="agile-detail">
                                                {{-- if user is the creator of todo. For now use auth::user()--}}
                                                @if( $todo->created_by === Auth::user()->id )
                                                    <a href="#" class="pull-right btn btn-xs btn-white delete_todo" id="delete_todo-{{$todo->id}}"><i class="trash_todo fa fa-trash"></i> Delete</a>
                                                @endif
                                                <a href="#" data-toggle="modal" data-target="#agileBoardModal" class="pull-right btn btn-xs btn-white todo_info" id="todo_info-{{$todo->id}}"><i class="trash_todo fa fa-info"></i> Info</a>
                                                <i class="fa fa-clock-o"></i> {{ date('M d, Y - h:i:s A', strtotime($todo->created_at)) }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>In Progress</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="inprogress">
                                @foreach($todos as $todo)                                  
                                    @if($todo->status === 1)
                                        <li class="warning-element sortable-<?php if(!$todo->updated_by OR $todo->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$todo->id}}">
                                            {{ $todo->description }}
                                            <div class="agile-detail">
                                                <a href="#" data-toggle="modal" data-target="#agileBoardModal" class="pull-right btn btn-xs btn-white todo_info" id="todo_info-{{$todo->id}}"><i class="trash_todo fa fa-info"></i> Info</a>
                                                <i class="fa fa-clock-o"></i> {{ date('M d, Y - h:i:s A', strtotime($todo->created_at)) }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                {{--  <li class="success-element" id="task9">
                                    Quisque venenatis ante in porta suscipit.
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                        <i class="fa fa-clock-o"></i> 12.10.2015
                                    </div>
                                </li>  --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Completed</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="completed">
                                @foreach($todos as $todo)                                  
                                    @if($todo->status === 2)
                                        <li class="warning-element sortable-<?php if(!$todo->updated_by OR $todo->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$todo->id}}">
                                            {{ $todo->description }}
                                            <div class="agile-detail">
                                                <a href="#" data-toggle="modal" data-target="#agileBoardModal" class="pull-right btn btn-xs btn-white todo_info" id="todo_info-{{$todo->id}}"><i class="trash_todo fa fa-info"></i> Info</a>
                                                <i class="fa fa-clock-o"></i> {{ date('M d, Y - h:i:s A', strtotime($todo->created_at)) }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal inmodal fade" id="agileBoardModal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-users modal-icon"></i>
                            <h4 class="modal-title">Create new team</h4>
                            <small class="font-bold">Enterprise-X is the leading support Software.</small>
                        </div>
                        <div class="modal-body">
                            
                            <p>
                                Modal Body
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>                                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    <h4>
                        Counts Number of projects: 
                    </h4>
                    <p>
                        Todo, In progress, and Completed
                    </p>

                    <div class="output p-m m white-bg"></div>


                </div>
            </div>


        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>

        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- jquery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Touch Punch - Touch Event Support for jQuery UI -->
    <script src="{{ asset('js/plugins/touchpunch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js')}}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js')}}"></script>

    <script>
        $(document).ready(function(){

            var drag_disabled = $('#disable_drag').val();

            $("#todo, #inprogress, #completed").sortable({
                items: "li:not(.sortable-no)",
                revert: true,
                //disabled: true,
                connectWith: ".connectList",
                receive: function( event, ui ) {

                    var todo = $( "#todo" ).sortable( "toArray" );
                    var inprogress = $( "#inprogress" ).sortable( "toArray" );
                    var completed = $( "#completed" ).sortable( "toArray" );
                    $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "<br/>" + "Completed: " + window.JSON.stringify(completed));

                    // move todo
                    // console.log(event.target.id, ui.item[0].id)
                    // update todo state
                    $.ajax( {
                        url: 'update_todo_status',
                        method: 'GET',
                        dataType: "json",
                        data: {"status": event.target.id, "task_id": ui.item[0].id}
                    }).done( function(result) {
                        console.log("Moved todo status");
                    }).fail(function(error) {
                        console.log(error);
                    });
                }
            }).disableSelection();

        });
    </script>
    <script>
        $(function(){

            function addTask() {
                var description = $("#add_task_description").val();
                var t_id = $("#team_id").val();
                var p_id = $("#project_id").val();

                $("#add_task_description").val('');
                // var data = {description: description};
                $.ajax({
                    url: "create_todo",
                    method: "POST",
                    data: {description: description, project_id: p_id, team_id: t_id, _token: "{{ csrf_token() }}"},
                    dataType: "json"
                }).done(function(result){
                    // console.log(result.html);
                    $('.new_todos').html(result.html).attr({'hidden': false, 'id': 'task-'+result.id});
                    $('.new_todos').removeClass('new_todos');
                    $( "<li class='new_todos warning-element' hidden='true'></li>" ).insertBefore( "#task-"+result.id );                                              
                }).fail(function(error){
                    console.log(error);
                })
            }

            $("#add_task").click( addTask );
            $('#add_task_description').keypress( (e) => {
                if(e.which == 13) {
                    addTask();
                }
            });

            $(document).on('click', '.delete_todo', function() {

                var todo_name = $(this).attr('id');
                var todo_id = todo_name.split('-')[1];
                console.log(todo_id)

                $.ajax({
                    url: "delete_todo",
                    method: "GET",
                    data: {todo_id: todo_id},
                    dataType: "json"
                }).done(function(result){
                    $('#task-'+ todo_id).remove();                                           
                }).fail(function(error){
                    console.log(error);
                })
            });
            $(document).on('click', '.warning-element', function() {
                // console.log(this);
            })
        })
    </script>

</body>

</html>

