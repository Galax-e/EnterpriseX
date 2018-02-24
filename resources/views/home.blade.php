@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
                <button id="click">Click</button>
            </div>
        </div>
    </div>
</div>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 $(function() {
     $('#click').click( function() {
     console.log('here')
    $.ajax( {
        url: "agile_board",
        method: "POST",
        data: {description: "Dummy"},
        dataType: "text"
    }).done(function(result){
        console.log(result);
    }).fail(function(error){
        console.log(error);
    })
 })
 })

</script>
@endsection