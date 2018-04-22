@extends('layouts.dialog')

@section('header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Agile board</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('/home')}}">Home</a>
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
@endsection

@section('content')
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>To-do</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                            <div class="input-group">
                                <input type="text" id="add_task_description" placeholder="Add new task. " autofocus class="input input-sm form-control">
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

        <script>
            
            $(function(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
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

                function addTask() {
                    var description = $("#add_task_description").val();
                    var t_id = $("#team_id").val();
                    var p_id = $("#project_id").val();
                    
                    var data = {description: description, project_id: p_id, team_id: t_id, _token: "{{ csrf_token() }}"};
                    // console.log(data)
                    $("#add_task_description").val('');
                    // var data = {description: description};
                    $.ajax({
                        url: "create_todo",
                        method: "POST",
                        data: data,
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

            });

            // $(function(){

                
                
            // })
        </script>
@endsection