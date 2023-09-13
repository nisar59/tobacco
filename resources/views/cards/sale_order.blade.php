<div id="page-content">
	<!-- END Invoice Header -->

	<!-- Invoice Block -->
	<div class="block full">
		<!-- Invoice Title -->
		<div class="block-title">
			<div class="block-options pull-right">
				<a href="{{url('sales/create')}}" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip"
				   title="New invoice"><i class="fa fa-plus"></i></a>
				<a href="{{url('sales/edit',$record->id)}}" class="btn btn-sm btn-alt btn-default"
				   data-toggle="tooltip" title="Delete invoice"><i class="fa fa-pencil"></i></a>
				<form onsubmit="return confirm('Are you sure you want to delete?')"
					  action="{{url('sales/destroy')}}"
					  method="post"
					  style="display: inline">
					{{csrf_field()}}
					{{method_field('POST')}}
					<input type="hidden" name="id" value="{{$record->id}}">
					<button type="submit" class="btn btn-secondary cursor-pointer">
						<i class="text-danger fa fa-remove"></i>
					</button>
				</form>
				<a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i
							class="fa fa-print"></i> Print</a>
			</div>
			<h2><strong>Invoice</strong> #{{$record->invoice_number}}</h2>
		</div>
		<!-- END Invoice Title -->

		<!-- Invoice Content -->
		<!-- 2 Column grid -->
		<div class="row block-section">
			<!-- Company Info -->
			<div class="col-md-12">
				<!-- Client Info -->
				<div class="col-sm-6">
					<img src="{{ asset('backend/img/placeholders/avatars/smoker.png') }}" alt="photo" class="img-circle" style="height: 65px;width: 100px;">
					<hr>
					<h2><strong>Customer Ifo.</strong></h2>
					<address>
						<i class="fa fa-user"></i> &nbsp;{{$record->customer->customer_name}}<br>
						<i class="fa fa-envelope-o"></i> &nbsp;{{$record->customer->address}}<br>
						<i class="fa fa-phone"></i> &nbsp;{{$record->customer->contact_number}}<br>
						<i class="fa fa-envelope-o"></i> &nbsp;<a href="javascript:void(0)">{{$record->customer->email_id}}</a>
					</address>
				</div>

				<div class="col-sm-6 text-right">
					<img src="{{ asset('backend/img/placeholders/avatars/sales.png') }}" alt="photo" class="img-circle" style="height: 65px;width: 130px;">
					<hr>
					<h2><strong>Sales Info.</strong></h2>
					<address>
						{{date('Y-M-d',strtotime($record->sale_date))}}&nbsp;&nbsp;<i class="fa fa-calendar"></i> <br>
						{{$record->invoice_number}}&nbsp;&nbsp;<i class="fa fa-image"></i><br>
						{{number_format($record->invoice_price)}}&nbsp;&nbsp;<i class="fa fa-money"></i><br>
					</address>

				</div>
			</div>
		</div>
		<!-- END 2 Column grid -->

		<!-- Table -->
		<div class="table-responsive">
			<table class="table table-vcenter">
				<thead>
				<tr>
					<th></th>
					<th style="width: 60%;">Product</th>
					<th class="text-center">Quantity</th>
					<th class="text-center">Unit Price</th>
					<th class="text-right">Amount</th>
				</tr>
				</thead>
				<tbody>
				@foreach($record->salesDetails as $detail)
					<tr>
						<td class="text-center">1</td>
						<td>
							<h4>{{$detail->product->uuid}}</h4>
							<span class="label label-info"><i class="fa fa-clock-o"></i>{{$detail->product->name.'-'.$detail->product->manufacturer.'-'.$detail->product->flavour}}</span>
							<span class="label label-info">{{$detail->product->packing}}</span>
						</td>
						<td class="text-center"><strong>x <span class="badge">{{$detail->quantity}}</span></strong></td>
						<td class="text-center"><strong>$ {{number_format($detail->unit_price)}}</strong></td>
						<td class="text-right"><span class="label label-primary">$ {{number_format($detail->quantity*$detail->unit_price)}}</span></td>
					</tr>
				@endforeach
				<tr class="active">
					<td colspan="4" class="text-right"><span class="h3"><strong>TOTAL AMOUNT</strong></span></td>
					<td class="text-right"><span class="h3"><strong>$ {{number_format($record->invoice_price)}}</strong></span></td>
				</tr>
				</tbody>
			</table>
		</div>
		<!-- END Table -->

		<div class="clearfix">
		</div>
		<!-- END Invoice Content -->
	</div>
	<!-- END Invoice Block -->
</div>