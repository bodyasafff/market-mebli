
@if(!empty($items))
    @foreach($items as $item)
            <a class="a-category" href="{{ route('web.product-category.index', [$item->id]) }}">
            <label class="col-12 label-category">
                {{ $item->{$name} }}
            </label>
            </a>
    @endforeach
@endif


<style>
    .a-category{
        color: black;
    }
    .label-category{
        cursor: pointer;
        border: solid black 1px;
    }
</style>