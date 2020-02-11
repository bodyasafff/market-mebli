@push('css_2')
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery.dataTables.min.css')}}">
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/plugins/jquery-te-1.4.0.css')}}">
    <link rel="stylesheet" href="{{asset('css/base/data-table.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/base/chosen.css')}}">
    <link rel="stylesheet" href="{{asset('css/base/form.css')}}">
@endpush
@push('js')
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('js/base/chosen.js') }}"></script>
    <script src="{{ asset('js/plugins/autosize.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.tmpl.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-te-1.4.0.min.js') }}"></script>
    <script src="{{ asset('js/base/form.js') }}"></script>

    <script>
        $('.jqte_textarea').jqte({
            fsize: false,
            color: false,
            sub: false,
            sup: false,
            outdent:false,
            indent:false,
            left:false,
            center:false,
            right:false,
            rule:false,
            formats: [
                ["p","Normal"],
                ["h1","Header 1"],
                ["h2","Header 2"],
                ["h3","Header 3"],
                ["h4","Header 4"],
                ["h5","Header 5"],
                ["h6","Header 6"],
            ]
        });
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush