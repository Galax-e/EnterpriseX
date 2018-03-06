@extends('layouts.dialog')

@section('header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Issue list</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>App views</a>
                        </li>
                        <li class="active">
                            <strong>Issue list</strong>
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
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Issue list</h5>
                            <div class="ibox-tools">
                                <a data-toggle="modal" data-target="#myModal5" class="btn btn-primary btn-xs">Add new issue</a>
                            </div>
                            <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-calendar modal-icon"></i>
                                            <h4 class="modal-title">Add new issue</h4>
                                            <small class="font-bold">Enterprise-X is the leading support Software.</small>
                                        </div>
                                        <div class="modal-body">
                                            <form method="GET" action="create_ticket" >
                                                <div class="form-group has-feedback">
                                                    <input type="text" name="description" class="form-control" placeholder="Full description of issue or task" value="" required autofocus/>
                                                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                </div>
                                       </div>
                                         <div class="modal-footer">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                            </form>
                                             <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">

                            <div class="m-b-lg">

                                <div class="input-group">
                                    <input type="text" placeholder="Search issue by name..." class=" form-control">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-white"> Search</button>
                                    </span>
                                </div>
                                <div class="m-t-md">

                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-comments"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-user"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-list"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-pencil"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-print"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-cogs"></i> </button>
                                    </div>
                                    <strong>Found {{$count}} issues.</strong>
                                </div>

                            </div>

                            <div class="table-responsive">
                            <table class="table table-hover issue-tracker">
                                <tbody>
                            <?php $issues = DB::table('agile_boards')->where('created_by', Auth::user()->id)->orderBy('created_at', 'DESC')->get(); ?>
                            @foreach($issues as $issue)
                                <tr>
                                    <td>
                                        @if($issue->status == "0" || $issue->status == "1")
                                           <span class="label label-primary">Added</span>
                                        @elseif($issue->type == "issue" && $issue->status == "2")
                                            <span class="label label-warning">Fixed</span>
                                        @elseif( $issue->status == "2")
                                            <span class="label label-primary">Done</span>
                                        @endif
                                    </td>
                                    <td class="issue-info">
                                        <a href="#">
                                        @if($issue->type == "issue")
                                            ISSUE-800000000000{{$issue->id}}
                                        @else
                                            TASK-800000000000{{$issue->id}}
                                        @endif
                                        </a>

                                        <small>
                                            {{$issue->description}}
                                        </small>
                                    </td>
                                    <td>
                                    <?php $users = DB::table('users')->where('id', $issue->created_by)->get(); ?>
                                    @foreach($users as $user)
                                        {{$user->name}}
                                    @endforeach
                                    </td>
                                    <td>
                                        {{ date('M d, Y h:i:s A', strtotime($issue->created_at)) }}
                                    </td>
                                    <td>
                                    <?php $days_ago = date('Ymd') - date('Ymd', strtotime($issue->created_at)); ?>
                                    @if($days_ago == 0)
                                        <span class="pie">1,10</span>
                                    @else
                                         <span class="pie"><?php echo $days_ago+1; ?>,10</span>
                                    @endif 
                                       
                                    <?php echo $days_ago;?> day(s)
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-white btn-xs"> Tag</button>
                                        <button class="btn btn-white btn-xs"> Mag</button>
                                    </td>
                                    <td class="text-left">
                                    <form method="GET" action="delete_ticket" ><input type="hidden" name="id" value="{{$issue->id}}">
                                        <button class="btn btn-white btn-xs" title="Delete Ticket"><i class="fa fa-trash"></i></button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                           
                                </tbody>
                            </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
@endsection
