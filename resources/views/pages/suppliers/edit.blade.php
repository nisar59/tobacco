@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        @include('forms.supplier',[
            'model'=>$model,
            'method'=>'POST'
        ])
    </div>
@endSection