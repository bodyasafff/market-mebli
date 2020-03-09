
<div class="container-fluid">
    <div class="row justify-content-md-center">
        @if(!empty($rows))
        @foreach($rows as $row)

        <div class="card col-3" >
            <a href="{{ route('web.product.index', [$row->id]) }}">
            <img class="card-img-top" src="{{ $row->{$image} ? url('').'/storage/'.$row->{$image} : asset('images/base/upload-image-default.png')}}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{$row->{$nameCard}  }}</h5>
            </div>
            </a>
        </div>

        @endforeach
        @endif
    </div>
</div>

