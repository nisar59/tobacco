<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-9">
                <a href="{{route('products.show',$record->id)}}"> {{$record->id}}</a>
            </div>
            <div class="col-sm-3 text-right">
                <div class="btn-group">
                    <a class="btn btn-secondary" href="{{route('products.edit',$record->id)}}">
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
</form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block">
        <table class="table table-bordered table-striped">
            <tbody>
            		<tr>
			<th>Uuid</th>
			<td>{{$record->uuid}}</td>
		</tr>
		<tr>
			<th>Bar Code</th>
			<td>{{$record->bar_code}}</td>
		</tr>
		<tr>
			<th>Name</th>
			<td>{{$record->name}}</td>
		</tr>
		<tr>
			<th>Manufacturer</th>
			<td>{{$record->manufacturer}}</td>
		</tr>
		<tr>
			<th>Flavour</th>
			<td>{{$record->flavour}}</td>
		</tr>
		<tr>
			<th>Packing</th>
			<td>{{$record->packing}}</td>
		</tr>
		<tr>
			<th>Unit Price</th>
			<td>{{$record->unit_price}}</td>
		</tr>
		<tr>
			<th>Stock In Hand</th>
			<td>{{$record->stock_in_hand}}</td>
		</tr>
		<tr>
			<th>Min Stock Level</th>
			<td>{{$record->min_stock_level}}</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>{{$record->status}}</td>
		</tr>
		<tr>
			<th>Deleted</th>
			<td>{{$record->deleted}}</td>
		</tr>

            </tbody>
        </table>
    </div>
</div>
