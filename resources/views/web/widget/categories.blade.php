
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
        display: block;
        text-decoration: none;
        outline: none;
    }
    .a-category:hover{
        background: #d7b2ba;
        color: black;
    }
    .a-category label{
        padding: 5px 20px;
        margin-bottom: 0;
    }

    .label-category{
        cursor: pointer;
    }
</style>