@if(!empty($items))
    <div>

    </div>


@foreach($items as $item)
    <label>{{ $item->{$name} }}</label>
    @foreach($item->{$id} as $i)
        <div>
            <input type="checkbox" class="{{$i->id}}" onclick="checking()">
            <label>{{ $i->{$name} }}</label>
        </div>

    @endforeach
@endforeach
@endif
<script>
    {{--var weights = JSON.parse('{!! $weights !!}');--}}
    {{--var weightsRealese = [];--}}
    {{--var property_categories = JSON.parse('{!! $model->property_categories !!}');--}}



    {{--@for($i = 0; $i<count($model->property_categories);$i++)--}}
    {{--    property_categories['{!! $i !!}']['properties'] =  JSON.parse('{!! $model->property_categories[$i]->properties !!}')--}}
    {{--@endfor--}}

    {{--for(let i = 0;i<weights.length;i++){--}}
    {{--    for(let j = 0;j<property_categories.length;j++){--}}
    {{--        if(weights[i].id == property_categories[j].weight_id){--}}
    {{--            var flag = false;--}}
    {{--            for(let q = 0;q< weightsRealese.length;q++){--}}
    {{--                if(weightsRealese[q].id == weights[i].id){--}}
    {{--                    flag = true;--}}
    {{--                    weightsRealese[q]['property_categories'] = property_categories[j];--}}
    {{--                    break;--}}
    {{--                }--}}
    {{--            }--}}
    {{--            if(flag == false){--}}
    {{--                weightsRealese.push(weights[i]);--}}
    {{--                weightsRealese[weightsRealese.length-1]['property_categories'] = property_categories[j];--}}
    {{--            }--}}
    {{--        }--}}
    {{--    }--}}
    {{--}--}}

    {{--console.log(weightsRealese);--}}
    // console.log(weights);
    // console.log(property_categories);


    // for(let i = 0;i<weights.length;i++)
    // {
    //     if(weights[i] ==)
    // }
    // weights.sort(function (a,b) {
    //          return a.value - b.value;
    //      });

    @if(!empty($idChekBoxes))
    function fillCheked(){
        var chekedIds = '{{$idChekBoxes}}'.split(',');
        $("input:checkbox").each(function(){
            for(let i = 0;i < chekedIds.length;i++) {
                if(chekedIds[i] == $(this).attr('class')){
                    $(this).attr('checked','checked');
                }
            }
        });
    }
    fillCheked();
    @endif

    function checking() {
        checkedIds = [];
        var temp;
        $("input:checkbox:checked").each(function(){
            checkedIds.push($(this).attr('class'));
        });
        temp = '';
        for(let i = 0;i < checkedIds.length;i++) {
            temp += i == 0 ? checkedIds[i] : ','+checkedIds[i];
        }
        temp?location.href = '/category/{{$model->id}}/'+temp+'/index-sort':location.href = '/category/{{$model->id}}';
    }
</script>