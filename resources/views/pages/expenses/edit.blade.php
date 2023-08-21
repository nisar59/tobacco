@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        @include('forms.expense',[
            'model'=>$model,
            'method'=>'POST'
        ])
    </div>
@endSection