
<div class="col-6">
<img class="img-thumbnail img-fluid" src="{{url('').'/storage/'.$product->image}}" style="max-width: 100%; height: auto;">
    <div class="row justify-content-md-center">
        @for($j = 0;$j < App\Models\DataProduct::IMAGES_COUNT;$j++)
            <div class="col-6">
               <img src="{{!empty($product->data_product->images[$j])? url('').'/storage/'.$product->data_product->images[$j] : asset('images/base/upload-image-default.png') }}" style="max-width: 100%;height: auto;">
            </div>
         @endfor
    </div>
</div>