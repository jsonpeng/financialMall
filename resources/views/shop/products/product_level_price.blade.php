	<?php 
	 $product_id = isset($product) ? $product->id : null;
	 $level_prices = app('commonRepo')->productLevelPriceRepo()->getAllLevelWithPrice($product_id);
	 ?>
	@foreach ($level_prices as $levelprice)
	    <div class="form-group col-xs-12 pr0-xs">
	        {!! Form::label('level_price_'.$levelprice->id, $levelprice->name.'价格:') !!}
	        {!! Form::text('level_price_'.$levelprice->id, $levelprice->level_price, ['class' => 'form-control']) !!}
	    </div>
    @endforeach