@extends('layouts.dialog')

@section('header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Teams board</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>App views</a>
                        </li>
                        <li class="active">
                            <strong>Teams board</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
@endsection

@section('content')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                <?php $teams = DB::table('teams')->where('created_by', Auth::user()->id)->orderBy('created_at', 'DESC')->get(); ?>
                @foreach($teams as $team)
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>EX-{{$team->id}} - {{$team->name}}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="img/a8.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a4.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a1.jpg"></a>
                            </div>
                            <h4>Info about {{$team->name}}</h4>
                            <p>
                                {{$team->description}}
                            </p>
                            <div>
                                <span>Status of current project:</span>
                                <div class="stat-percent">61%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 61%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">PROJECTS</div>
                                    43
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">RANKING</div>
                                    1th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">BUDGET</div>
                                    $705,913 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                </div>
            </div>


        </div>
@endsection