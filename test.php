{{--<td>--}}
    {{--<table class="table table-bordered table-vcenter remove-margin-bottom">--}}
        {{--<thead style="background-color: rgba(255,24,44,0.7);color:white;">--}}
        {{--<tr>--}}
            {{--<th style="font-size: small" class="text-center">#</th>--}}
            {{--<th style="font-size: small" class="text-center">UUID</th>--}}
            {{--<th style="font-size: small">Product</th>--}}
            {{--<th style="font-size: small" class="text-center">Qty.</th>--}}
            {{--<th style="font-size: small" class="text-center">Price.</th>--}}
            {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@foreach($purchase->purchaseDetails as $key=>$details)--}}
        {{--<tr>--}}
            {{--<th style="font-size: small" class="text-center">{{$key+1}}</th>--}}
            {{--<th style="font-size: small" class="text-center">{{$details->product->uuid}}</th>--}}
            {{--<th style="font-size: small">{{$details->product->name}}-{{$details->product->manufacturer}}-{{$details->product->flavour}}-{{$details->product->packing}}</th>--}}
            {{--<th style="font-size: small" class="text-center">{{$details->quantity}}.</th>--}}
            {{--<th style="font-size: small" class="text-center">{{number_format($details->unit_price)}}.</th>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
        {{--</table>--}}
    {{--</td>--}}

<!--<td>-->
<!--    <table class="table table-bordered table-vcenter remove-margin-bottom">-->
<!--        <thead style="background-color: rgba(255,24,44,0.7);color:white;">-->
<!--        <tr>-->
<!--            <th style="font-size: small" class="text-center">UUID</th>-->
<!--            <th style="font-size: small" class="text-center">#</th>-->
<!--            <th style="font-size: small">Product</th>-->
<!--            <th style="font-size: small" class="text-center">Qty.</th>-->
<!--            <th style="font-size: small" class="text-center">Price.</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody>-->
<!--        @foreach($sale->salesDetails as $key=>$details)-->
<!--        <tr>-->
<!--            <th style="font-size: small" class="text-center">{{$details->product->uuid}}</th>-->
<!--            <th style="font-size: small" class="text-center">{{$key+1}}</th>-->
<!--            <th style="font-size: small">{{$details->product->name}}-{{$details->product->manufacturer}}-{{$details->product->flavour}}-{{$details->product->packing}}</th>-->
<!--            <th style="font-size: small" class="text-center">{{$details->quantity}}.</th>-->
<!--            <th style="font-size: small" class="text-center">{{number_format($details->unit_price)}}.</th>-->
<!--        </tr>-->
<!--        @endforeach-->
<!--        </tbody>-->
<!--    </table>-->
<!--</td>-->


<!--@foreach($purchases as $key=>$purchase)-->
<!--<tr>-->
<!--    <td class="text-center">{{date('F jS, Y',strtotime($purchase->order_date))}}</td>-->
<!--    <td class="text-center">Purchase</td>-->
<!--    <td>{{$purchase->invoice_number}}</td>-->
<!--    <td class="text-center">-</td>-->
<!--    <td class="text-center">{{number_format($purchase->invoice_price)}}</td>-->
<!--    <td class="text-center">{{number_format($purchase->invoice_price)}}</td>-->
<!--</tr>-->
<!--@if($purchase->status == 1)-->
<!--<tr>-->
<!--    <td class="text-center">{{date('F jS, Y',strtotime($purchase->order_date))}}</td>-->
<!--    <td class="text-center">Payment</td>-->
<!--    <td>{{$purchase->invoice_number}}</td>-->
<!--    <td class="text-center">{{number_format($purchase->invoice_price)}}</td>-->
<!--    <td class="text-center">-</td>-->
<!--    <td class="text-center">-</td>-->
<!--</tr>-->
<!--@endif-->
<!--@endforeach-->


<!--@foreach($sales as $key=>$sale)-->
<!--<tr>-->
<!--    <td class="text-center">{{date('F jS, Y',strtotime($sale->sale_date))}}</td>-->
<!--    <td class="text-center"><span class="">Sale</span></td>-->
<!--    <td><span class="">{{$sale->invoice_number}}</span></td>-->
<!--    <td class="text-center"><span class="">{{number_format($sale->invoice_price)}}</span></td>-->
<!--    <td class="text-center"><span class="">-</span></td>-->
<!--    <td class="text-center"><span class="">{{number_format($sale->invoice_price)}}</span></td>-->
<!--</tr>-->
<!--@if($sale->status == 1)-->
<!--<tr>-->
<!--    <td class="text-center">{{date('F jS, Y',strtotime($sale->sale_date))}}</td>-->
<!--    <td class="text-center"><span class="">Received</span></td>-->
<!--    <td><span class="">{{$sale->invoice_number}}</span></td>-->
<!--    <td class="text-center"><span class="">-</span></td>-->
<!--    <td class="text-center"><span class="">{{number_format($sale->invoice_price)}}</span></td>-->
<!--    <td class="text-center"><span class="">-</span></td>-->
<!--</tr>-->
<!--@endif-->
<!--@endforeach-->


<!--@if(!empty($expenseTypesGp) && $expenseTypesGp!=null)-->
<!--@foreach($expenseTypesGp as $expenseType)-->
<!--<tr>-->
<!--    <td style="padding-left:18px">-->
<!--        <h4>-->
<!--            <a href="javascript:void(0)"><strong>{{$expenseType->lable}}</strong></a><br>-->
<!--            <small></small>-->
<!--        </h4>-->
<!--    </td>-->
<!--    <td class="text-center "><a-->
<!--                href="javascript:void(0)">{{\App\Helpers\GeneralHelper::getExpense($expenseType->value,$date1,$date2)}}</a>-->
<!--    </td>-->
<!--</tr>-->
<!--@endforeach-->
<!--@endif-->