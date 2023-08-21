<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Customer Id </th>
		<th>User Id </th>
		<th>Sale Date </th>
		<th>Status </th>
		<th>Deleted </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->customer_id }} </td>
	 	<td> {{$record->user_id }} </td>
	 	<td> {{$record->sale_date }} </td>
	 	<td> {{$record->status }} </td>
	 	<td> {{$record->deleted }} </td>
	<td><a class="btn btn-secondary" href="{{route('sale_orders.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('sale_orders.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('sale_orders.destroy',$record->id)}}"
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