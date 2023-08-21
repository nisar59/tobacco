<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-9">
                <a href="{{route('stock_managements.show',$record->id)}}"> {{$record->id}}</a>
            </div>
            <div class="col-sm-3 text-right">
                <div class="btn-group">
                    <a class="btn btn-secondary" href="{{route('stock_managements.edit',$record->id)}}">
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
</form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block">
        <table class="table table-bordered table-striped">
            <tbody>
            		<tr>
			<th>Report Date</th>
			<td>{{$record->report_date}}</td>
		</tr>
		<tr>
			<th>Opening Stock</th>
			<td>{{$record->opening_stock}}</td>
		</tr>
		<tr>
			<th>Purchase</th>
			<td>{{$record->purchase}}</td>
		</tr>
		<tr>
			<th>Purchase Return</th>
			<td>{{$record->purchase_return}}</td>
		</tr>
		<tr>
			<th>Sale</th>
			<td>{{$record->sale}}</td>
		</tr>
		<tr>
			<th>Sale Return</th>
			<td>{{$record->sale_return}}</td>
		</tr>
		<tr>
			<th>Closing Stock</th>
			<td>{{$record->closing_stock}}</td>
		</tr>

            </tbody>
        </table>
    </div>
</div>
