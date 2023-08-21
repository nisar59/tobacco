<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Report Date </th>
		<th>Opening Stock </th>
		<th>Purchase </th>
		<th>Purchase Return </th>
		<th>Sale </th>
		<th>Sale Return </th>
		<th>Closing Stock </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->report_date }} </td>
	 	<td> {{$record->opening_stock }} </td>
	 	<td> {{$record->purchase }} </td>
	 	<td> {{$record->purchase_return }} </td>
	 	<td> {{$record->sale }} </td>
	 	<td> {{$record->sale_return }} </td>
	 	<td> {{$record->closing_stock }} </td>
	<td><a class="btn btn-secondary" href="{{route('stock_managements.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('stock_managements.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('stock_managements.destroy',$record->id)}}"
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