@extends('layouts.custom_app')
@section('content')
    <div class="row">
        @include('cards.sale_order')
    </div>
@endSection

@section('script')
    <script type="text/javascript">
        $("#imageresource").on("click", function() {
            var imgagep = $('#imagepreview').attr('src', $('#imageresource').attr('src'));
            $('#imagemodal').modal('show');
        });
    </script>
@endsection