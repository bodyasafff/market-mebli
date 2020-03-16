
@extends('layouts.web.layout')
@section('content')
    <div class="container-fluid" style="margin-top: 50px">
        <div class="row justify-content-md-center">
            <input type="hidden" name="chekedArray" id="chekedArray" value="">
            <div class="col-2">

                @include('web.widget.categories',[
                'items' => \App\Models\ProductCategory::select('id','name_ua')->get(),
                'name' => 'name_ua'
                ])

                @include('web.widget.chekbox-filters',[
                'items' => $model->property_categories,
                'name' => 'name_ua',
                'id' => 'properties'
                ])
            </div>

            <div class="col-10">
                @include('web.widget.table',[
                'nameCard' => 'name_ua',
                'rows' => $products,
                'image' => 'image',
                'theadsTranslite' => ['id','назва'] ])
            </div>
        </div>
    </div>

@endsection
