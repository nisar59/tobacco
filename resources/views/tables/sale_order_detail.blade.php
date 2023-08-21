<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Sale Order Id </th>
		<th>Product Id </th>
		<th>Unit Price </th>
		<th>Quantity </th>
		<th>Discount </th>
		<th>Deleted </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->sale_order_id }} </td>
	 	<td> {{$record->product_id }} </td>
	 	<td> {{$record->unit_price }} </td>
	 	<td> {{$record->quantity }} </td>
	 	<td> {{$record->discount }} </td>
	 	<td> {{$record->deleted }} </td>
	<td><a class="btn btn-secondary" href="{{route('sale_order_details.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('sale_order_details.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('sale_order_details.destroy',$record->id)}}"
      method="post"
      style="display: inline">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button type="submit" class="btn btn-secondary cursor-pointer">
        <i class="text-danger fa fa-remove"></i>
    </button>
</form></td></tr>

    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">
            {{{$records->render()}}}
        </td>
    </tr>
    </tfoot>
</table>