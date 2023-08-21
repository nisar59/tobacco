<form action="{{isset($route)?$route:route('stock_managements.store')}}" method="POST" >
    {{csrf_field()}}
    <input type="hidden" name="_method" value="{{isset($method)?$method:'POST'}}"/>
    <div class="form-group">
    <label for="report_date">Report Date</label>
    <div class="input-group">
        <input type="date" class="form-control {{ $errors->has('report_date') ? ' is-invalid' : '' }}" name="report_date" id="report_date"
               value="{{old('report_date',$model->report_date)}}"
               placeholder="" required="required" >
        <div class="input-group-addon">
            <label for="report_date" class="fa fa-calendar">
            </label>
        </div>
    </div>
      @if($errors->has('report_date'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('report_date') }}</strong>
    </div>
  @endif
</div>

    <div class="form-group">
        <label for="opening_stock">Opening Stock</label>
        <input type="number" class="form-control {{ $errors->has('opening_stock') ? ' is-invalid' : '' }}" name="opening_stock" id="opening_stock" value="{{old('opening_stock',$model->opening_stock)}}" placeholder="" required="required" >
          @if($errors->has('opening_stock'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('opening_stock') }}</strong>
    </div>
  @endif 
    </div>

    <div class="form-group">
        <label for="purchase">Purchase</label>
        <input type="number" class="form-control {{ $errors->has('purchase') ? ' is-invalid' : '' }}" name="purchase" id="purchase" value="{{old('purchase',$model->purchase)}}" placeholder="" required="required" >
          @if($errors->has('purchase'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('purchase') }}</strong>
    </div>
  @endif 
    </div>

    <div class="form-group">
        <label for="purchase_return">Purchase Return</label>
        <input type="number" class="form-control {{ $errors->has('purchase_return') ? ' is-invalid' : '' }}" name="purchase_return" id="purchase_return" value="{{old('purchase_return',$model->purchase_return)}}" placeholder="" required="required" >
          @if($errors->has('purchase_return'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('purchase_return') }}</strong>
    </div>
  @endif 
    </div>

    <div class="form-group">
        <label for="sale">Sale</label>
        <input type="number" class="form-control {{ $errors->has('sale') ? ' is-invalid' : '' }}" name="sale" id="sale" value="{{old('sale',$model->sale)}}" placeholder="" required="required" >
          @if($errors->has('sale'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('sale') }}</strong>
    </div>
  @endif 
    </div>

    <div class="form-group">
        <label for="sale_return">Sale Return</label>
        <input type="number" class="form-control {{ $errors->has('sale_return') ? ' is-invalid' : '' }}" name="sale_return" id="sale_return" value="{{old('sale_return',$model->sale_return)}}" placeholder="" required="required" >
          @if($errors->has('sale_return'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('sale_return') }}</strong>
    </div>
  @endif 
    </div>

    <div class="form-group">
        <label for="closing_stock">Closing Stock</label>
        <input type="number" class="form-control {{ $errors->has('closing_stock') ? ' is-invalid' : '' }}" name="closing_stock" id="closing_stock" value="{{old('closing_stock',$model->closing_stock)}}" placeholder="" required="required" >
          @if($errors->has('closing_stock'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('closing_stock') }}</strong>
    </div>
  @endif 
    </div>


    <div class="form-group text-right ">
        <input type="reset" class="btn btn-default" value="Clear"/>
        <input type="submit" class="btn btn-primary" value="Save"/>

    </div>
</form>