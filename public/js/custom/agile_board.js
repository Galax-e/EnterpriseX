
$(document).ready(function(){

    $("#todo, #inprogress, #completed").sortable({
        connectWith: ".connectList",
        update: function( event, ui ) {

            var todo = $( "#todo" ).sortable( "toArray" );
            var inprogress = $( "#inprogress" ).sortable( "toArray" );
            var completed = $( "#completed" ).sortable( "toArray" );
            $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "<br/>" + "Completed: " + window.JSON.stringify(completed));

            var todos = window.JSON.stringify(todo);
            console.log([1, 2, 3].shift());
        
        }
    }).disableSelection();

});

$(function(){
    $("#add_task").click( () => {
        var description = $("#add_task_description").val();
        $("#add_task_description").val('');
        var data = {description: description};
        $.ajax({
            url: "create_todo",
            method: "GET",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data: {description: description},
            dataType: "json"
        }).done(function(result){
            // console.log(result.html);
            $('.new_todos').html(result.html).attr({'hidden': false, 'id': result.id});
            $('.new_todos').removeClass('new_todos');
            $( "<li class='new_todos warning-element' hidden='true'></li>" ).insertBefore( "#"+result.id );                                              
        }).fail(function(error){
            console.log(error);
        })
    });

    $(".delete_todo").click( function() {

        var todo_name = $(this).attr('id');
        var todo_id = todo_name.split('-')[1];

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
    })
})