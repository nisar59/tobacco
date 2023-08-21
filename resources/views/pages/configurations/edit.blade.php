@extends('layouts.custom_app')
@section('content')
{{--<div class="row">--}}
    {{--<div class='col-md-12'>--}}
        {{--<div class='card'>--}}
            {{--<div class="card-body">--}}
                {{--@include('forms.configuration',[--}}
                {{--'route'=>route('listings.update',$model->id),--}}
                {{--'method'=>'PUT'--}}
                {{--])--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<div id="page-content">
    @include('forms.configuration',[
        'model'=>$model,
        'method'=>'POST'
    ])
</div>
@endSection