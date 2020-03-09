
<div class="col-6">
    <div class="row justify-content-md-center">
        <div class="col-8">
            <h1>{{$product->name_ua}}</h1>
        </div>
        <div class="col-8 price-label">
            <h2>Ціна: {{$product->price?$product->price : 'не вказана'}}</h2>
        </div>
        <div class="col-8 description-label">
            <h3>{{$product->data_product->description_ua}}</h3>
        </div>
    <div class="col-8 div-properties">
        @foreach($properties as $group)
            <h1>{!! $group['name'] !!}</h1>
            @foreach($group as $propety_category)
                @if(isset($propety_category['name']))
                    <h2>{!! $propety_category['name'] !!}</h2>
                    @foreach($propety_category as $property)
                        @if(isset($property['name_ua']))
                        <h4>{!! $property['name_ua'] !!}</h4>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endforeach
    </div>
    </div>
<script>
{{--    @foreach($properties as $group)--}}

{{--            @foreach($group as $propety_category)--}}
{{--               @if(isset($propety_category['name']))--}}
{{--                @foreach($propety_category as $property)--}}
{{--                   @if(isset($property['name_ua']))--}}
{{--                    console.log('{!! $property->name_ua !!}')--}}
{{--                   @endif--}}

{{--                @endforeach--}}
{{--              @endif--}}
{{--            @endforeach--}}
{{--    @endforeach--}}
</script>


</div>

<style>
    .price-label{
        margin-top: 25px;
    }
    .description-label{
        margin-top: 50px;
    }
    .div-properties{
        margin-top: 50px;
    }
</style>