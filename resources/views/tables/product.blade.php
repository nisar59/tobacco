<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Uuid </th>
		<th>Product Name </th>
		<th>Manufacturer </th>
		<th>Flavour </th>
		<th>Category Id </th>
		<th>Quantity Per Unit </th>
		<th>Unit Price </th>
		<th>Units Instock </th>
		<th>Reorder Level </th>
		<th>Status </th>
		<th>Deleted </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->uuid }} </td>
	 	<td> {{$record->product_name }} </td>
	 	<td> {{$record->manufacturer }} </td>
	 	<td> {{$record->flavour }} </td>
	 	<td> {{$record->category_id }} </td>
	 	<td> {{$record->pack_per_unit }} </td>
	 	<td> {{$record->unit_price }} </td>
	 	<td> {{$record->units_instock }} </td>
	 	<td> {{$record->reorder_level }} </td>
	 	<td> {{$record->status }} </td>
	 	<td> {{$record->deleted }} </td>
	<td><a class="btn btn-secondary" href="{{route('products.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('products.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('products.destroy',$record->id)}}"
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