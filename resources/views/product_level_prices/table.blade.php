<table class="table table-responsive" id="productLevelPrices-table">
    <thead>
        <tr>
            <th>Product Id</th>
        <th>Type</th>
        <th>Level Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($productLevelPrices as $productLevelPrice)
        <tr>
            <td>{!! $productLevelPrice->product_id !!}</td>
            <td>{!! $productLevelPrice->type !!}</td>
            <td>{!! $productLevelPrice->level_id !!}</td>
            <td>
                {!! Form::open(['route' => ['productLevelPrices.destroy', $productLevelPrice->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('productLevelPrices.show', [$productLevelPrice->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('productLevelPrices.edit', [$productLevelPrice->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>