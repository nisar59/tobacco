@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        @include('forms.customer',[
            'model'=>$model,
            'method'=>'POST'
        ])
    </div>
@endSection