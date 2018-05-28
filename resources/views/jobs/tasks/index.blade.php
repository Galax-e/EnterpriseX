@extends('layouts.master')

@section('header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Task board</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('/home')}}">Home</a>
                        </li>
                        <li>
                            <a>Miscellaneous</a>
                        </li>
                        <li class="active">
                            <strong>Task board</strong>
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
                    <div class="ibox" >
                        <div class="ibox-content" style="border-color: green; border-top-width: 3px">
                            <h3>To-do</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                            <div class="input-group">
                                <input type="text" id="add_task_description" placeholder="Add new task. " autofocus class="input input-sm form-control">
                                <input type="hidden" id="team_id" name="team_id" value="{{ $team_id }}">
                                <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">
                                
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary" id="add_task"> <i class="fa fa-plus"></i> Add task</button>
                                </span>
                            </div>

                            <ul class="sortable-list connectList agile-list" id="todo">                                
                                <li class='new_tasks warning-element sortable-yes' hidden="true"></li>
                                @foreach($tasks as $task)                                  
                                    @if($task->status === 'todo')
                                        {{-- Add Auth::roles()->user; --}}
                                        <li class="warning-element sortable-<?php if(!$task->updated_by OR $task->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$task->id}}">
                                            <p>
                                                <label>{{ $task->description }}</label>
                                                <span class="pull-right">
                                                    <i class="fa fa-clock-o clock_icon" id="date_clock-{{$task->id}}" title="click to view date task was created"></i> 
                                                    <small id="task_date-{{$task->id}}" hidden>{{ date('M d, Y - h:iA', strtotime($task->created_at)) }}</small>
                                                </span>
                                            </p>
                                               
                                            <div class="agile-detail row" style="padding: 0 10px 0 10px">
                                                {{-- if user is the creator of task. For now use auth::user()--}}
                                                @if( $task->created_by === Auth::user()->id )
                                                    <a href="#" class="pull-right btn btn-sm btn-white delete_task" id="delete_task-{{$task->id}}"><i class="trash_task fa fa-trash"></i> Delete</a>
                                                @endif
                                                <a href="#" data-toggle="modal" data-target="#taskBoardModal" class="pull-right btn btn-sm btn-white task_info" id="task_info-{{$task->id}}"><i class="trash_task fa fa-info"></i> Info</a>
                                                {{--  <div class="">  --}}                                                
                                                <select class="js-example-basic-single" name="task_responsible" style="width: 55%;">
                                                    <option id="{{Auth::user()->name}}" value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                                    @if( $task->created_by === Auth::user()->id OR Auth::user()->hasRole('manager'))
                                                        @foreach($users as $team_member)
                                                            <option id="{{$team_member->name}}" value="{{$team_member->id}}">{{$team_member->name}}</option>    
                                                        @endforeach 
                                                    @endif                                                   
                                                </select>        
                                                @if($task->responsible)
                                                    <?php $user_responsible = \App\User::find($task->responsible);
                                                        $fNameInitial = explode(" ", $user_responsible->name)[0][0];
                                                        $lNameInitial = explode(" ", $user_responsible->name)[1][0];
                                                    ?>
                                                    <span><img title="responsible: {{$user_responsible->name}}" src="https://placehold.it/37x37/3a7a77/ffffff/&text={{$fNameInitial}}.{{$lNameInitial}}" class="img-circle" alt="User Image"></span>
                                                
                                                @endif
                                                {{--  </div>  --}}
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
                        <div class="ibox-content" style="border-color: blue; border-top-width: 3px">
                            <h3>In Progress</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="inprogress">
                                @foreach($tasks as $task)                                  
                                    @if($task->status === 'inprogress')
                                        <li class="warning-element sortable-<?php if(!$task->updated_by OR $task->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$task->id}}">
                                            {{ $task->description }}
                                            <div class="agile-detail">
                                                <a href="#" data-toggle="modal" data-target="#taskBoardModal" class="pull-right btn btn-xs btn-white task_info" id="task_info-{{$task->id}}"><i class="trash_task fa fa-info"></i> Info</a>
                                                <i class="fa fa-clock-o"></i> {{ date('M d, Y - h:i:s A', strtotime($task->created_at)) }}
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
                        <div class="ibox-content" style="border-color: red; border-top-width: 3px">
                            <h3>Completed</h3>
                            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                            <ul class="sortable-list connectList agile-list" id="completed">
                                @foreach($tasks as $task)                                  
                                    @if($task->status === 'done')
                                        <li class="warning-element sortable-<?php if(!$task->updated_by OR $task->updated_by === Auth::user()->id) {echo 'yes';} else {echo 'no';} ?>" id="task-{{$task->id}}">
                                            {{ $task->description }}
                                            <div class="agile-detail">
                                                <a href="#" data-toggle="modal" data-target="#taskBoardModal" class="pull-right btn btn-xs btn-white task_info" id="task_info-{{$task->id}}"><i class="trash_task fa fa-info"></i> Info</a>
                                                <i class="fa fa-clock-o"></i> {{ date('M d, Y - h:i:s A', strtotime($task->created_at)) }}
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal inmodal fade" id="taskBoardModal" tabindex="-1" role="dialog"  aria-hidden="true">
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

                        // move task
                        // console.log(event.target.id, ui.item[0].id)
                        // update task state
                        $.ajax( {
                            url: 'update_task_status',
                            method: 'GET',
                            dataType: "json",
                            data: {"status": event.target.id, "task_id": ui.item[0].id}
                        }).done( function(result) {
                            console.log("Moved task status");
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
                        url: "create_task",
                        method: "POST",
                        data: data,
                        dataType: "json"
                    }).done(function(result){
                        // console.log(result.html);
                        $('.new_tasks').html(result.html).attr({'hidden': false, 'id': 'task-'+result.id});
                        $('.new_tasks').removeClass('new_tasks');
                        $( "<li class='new_tasks warning-element' hidden='true'></li>" ).insertBefore( "#task-"+result.id );                                              
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

                $(document).on('click', '.delete_task', function() {
                    var task_name = $(this).attr('id');
                    var task_id = task_name.split('-')[1];
                    console.log(task_id)

                    $.ajax({
                        url: "delete_task",
                        method: "GET",
                        data: {task_id: task_id},
                        dataType: "json"
                    }).done(function(result){
                        $('#task-'+ task_id).remove();                                           
                    }).fail(function(error){
                        console.log(error);
                    })
                });
                
                $(document).on('click', '.warning-element', function() {
                    // console.log(this);
                })

                // In your Javascript (external .js resource or <script> tag)                
                $('.js-example-basic-single').select2({
                    placeholder: 'Choose responsible',
                    //theme: "classic",
                    templateResult: formatState,
                    // templateSelection: formatState
                });

                function formatState (state) {
                    if (!state.id) {
                        return state.text;
                    }
                    var splitName = state.text.split(' ');
                    var fNameInitial = splitName[0][0];
                    var lNameInitial = splitName[1][0]
                    // var baseUrl = "/user/pages/images/flags"; e25656/ffffff
                    var $state = $(

                        `<span><img src="https://placehold.it/37x37/3a7a77/ffffff/&text=${fNameInitial + lNameInitial}" class="img-circle" alt="User Image"><span style="margin-left: 10px">${state.element.text}</span></span>`
                        //'<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                    );
                    return $state;
                };              

                // toggle date visibility
                $('.clock_icon').on('click', function() {
                    var id = $(this).attr('id');
                    id = id.split('-')[1]
                    $("#task_date-"+ id).toggle();
                })

            });

            // $(function(){

                
                
            // })
        </script>
@endsection