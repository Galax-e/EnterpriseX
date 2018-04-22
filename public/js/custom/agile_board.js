
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
        console.log(data)
        $("#add_task_description").val('');
        // var data = {description: description};
        $.ajax({
            url: "create_todo",
            method: "POST",
            data,
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