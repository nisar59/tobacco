<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Company Name </th>
		<th>Contact Name </th>
		<th>Contact Title </th>
		<th>Address </th>
		<th>City </th>
		<th>Region </th>
		<th>Postal Code </th>
		<th>Country </th>
		<th>Phone </th>
		<th>Fax </th>
		<th>Home Page </th>
		<th>Status </th>
		<th>Deleted </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->company_name }} </td>
	 	<td> {{$record->contact_name }} </td>
	 	<td> {{$record->contact_title }} </td>
	 	<td> {{$record->address }} </td>
	 	<td> {{$record->city }} </td>
	 	<td> {{$record->region }} </td>
	 	<td> {{$record->postal_code }} </td>
	 	<td> {{$record->country }} </td>
	 	<td> {{$record->phone }} </td>
	 	<td> {{$record->fax }} </td>
	 	<td> {{$record->home_page }} </td>
	 	<td> {{$record->status }} </td>
	 	<td> {{$record->deleted }} </td>
	<td><a class="btn btn-secondary" href="{{route('suppliers.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('suppliers.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('suppliers.destroy',$record->id)}}"
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