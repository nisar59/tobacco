@extends('layouts.custom_app')
@section('styles')
    <style>
        .circle-input {
            background-repeat: no-repeat;
            background-size: 20px 100%; /* equal to the height */
            height: 20px;
            padding-left: 150px; /* equal to background-size in X-axis */
        }
    </style>
@endSection
@section('content')
    <div id="page-content">
        @include('forms.purchase_order',[
            'model'=>$model,
            'method'=>'POST'
        ])
    </div>
@endSection

@section('script')
    <script type="text/javascript">

        $(document).on('change', '.supplier-filters', function () {
            $('.supplier-filters').each(function () {
                var data = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{url('purchase/supplier')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': data
                    },
                    dataType: "json",
                    success: function (responce) {
                        $('#s_name').val(responce.supplier_name);
                        $('#s_phone').val(responce.contact_number);
                        $('#s_address').val(responce.address);
                        $('#s_email').val(responce.email_id);

                        // $('#tobacco_purchase_supplier tbody').html("");
                    }
                });
            });
        });

        $('.supplier-filters').select2();
        $('.filtered-product').select2();

        $(document).on('click', '.add-filtered-product', function () {
            var data = $('#product_id').find(":selected").val();
            if(data!==''){
                $.ajax({
                    type: "POST",
                    url: "{{url('purchase/product')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': data
                    },
                    dataType: "json",
                    success: function (responce) {
                        var row = $("<tr>" +
                            "<td  class='text-center'><input style='margin: 10px 0 10px 0 !important;' id='p_id_"+responce.id+"' type='hidden' readonly name='p_id[]' value='"+responce.id+"'></td>" +
                            "<td>" +
                            "<input id='p_uu_id_"+responce.id+"' type='text' style='border: 0!important;margin: 10px 0 0 0 !important;' value='"+responce.uuid+"' readonly='readonly'><br>" +
                            "<span class='label label-info' id='p_details' style='margin: 10px 0 10px 0 !important;'><i class='fa fa-clock-o'></i>&nbsp;&nbsp;" + responce.manufacturer.charAt(0).toUpperCase() + responce.manufacturer.slice(1).toLowerCase() + ' ' + responce.packing + ' ' + responce.flavour.charAt(0).toUpperCase() + responce.flavour.slice(1).toLowerCase() + ' ' + responce.name.charAt(0).toUpperCase() + responce.name.slice(1).toLowerCase() + "</span>" +
                            "</td>" +
                            "<td class='text-left'><strong style='margin-left: 20px' class='label label-info'>x </strong><input id='p_unit_qty_"+responce.id+"' type='number' data-value='"+responce.id+"' onchange='update_qty_amounts(this.id)' name='p_unit_qty[]' value='1' class='unit_qty' style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;' ></td>" +
                            "<td class='text-center'><strong style='margin-left: 20px' class='label label-info'>$ </strong><input id='p_unit_price_"+responce.id+"' type='number' data-value='"+responce.id+"' onchange='update_price_amounts(this.id)' name='p_unit_price[]' value='"+ responce.unit_price +"' class='unit_price' style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;' ></td>" +
                            "<td class='text-center'><strong style='margin-left: 20px' class='label label-info'>$ </strong><input id='p_total_price_"+responce.id+"' name='p_total_price[]' value='"+ responce.unit_price +"' class='p_total_price' readonly='readonly' style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;' ></td>" +
                            "<td class='text-center'><button class='btn btn-danger btnDelete'><i class='fa fa-trash'></i></button></td>" +
                            "</tr>");
                        $('#tobacco_purchase_order tbody').append(row);
                        update_price_total();
                    }
                });
            }
        });

        $("#tobacco_purchase_order").on('click', '.btnDelete', function () {
            $(this).closest('tr').remove();
            update_price_total();
        });

        function update_qty_amounts(id)
        {
            var qty = $("#"+id).val();
            var data_value = $("#"+id).data('value');
            var price = $("#p_unit_price_"+data_value).val();
            var amount = (qty*price);
            $("#p_total_price_"+data_value).val(amount);

            update_price_total();
        }

        function update_price_amounts(id)
        {
            var price = $("#"+id).val();
            var data_value = $("#"+id).data('value');
            var qty = $("#p_unit_qty_"+data_value).val();
            var amount = (qty*price);
            amount = amount.toLocaleString('en-US');
            $("#p_total_price_"+data_value).val(amount);

            update_price_total();

        }

        function update_price_total() {
            var total = 0;
            $('.p_total_price').each(function(){
                var valueData = this.value.replace(/,/g, "");
                total += parseFloat(valueData)
            });
            total = total.toLocaleString('en-US');
            $("#order_total").val(total);
        }

        setTimeout(function () {
            $("div.alert").remove();
        }, 5000); // 5 secs
    </script>
@endsection