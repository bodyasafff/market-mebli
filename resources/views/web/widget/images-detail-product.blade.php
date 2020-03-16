<div class="product-select-img">
    @for($j = 0;$j < count($product->data_product->images);$j++)
        <div>
            <img src="{{!empty($product->data_product->images[$j])? url('') . '/storage/'.$product->data_product->images[$j] : asset('images/base/upload-image-default.png') }}">
        </div>
    @endfor
</div>
<div class="product-main-img">
    <img src="{{url('').'/storage/'.$product->image}}">
</div>