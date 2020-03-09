@extends('dashboard.dashboard.content')
@include('widget.form.push-resources')

@section('title_header'){{ $infoProc }}@endsection
@section('title') {{ $infoProc }} <span style="font-size: 12px"> / {{ $note }}</span> @endsection

@section('tab-bar')
    <div class="mdl-layout__tab-bar">
        @for($i = 1; $i <= $countProc; $i++)
            <a href="{{ route('dashboard.console-proc.index', [$procId, $i]) }}" class="mdl-layout__tab tab-bar-link {{ $procNum == $i ? 'is-active' : '' }}">{{ $i }}</a>
        @endfor
    </div>
@endsection

@section('content')
    <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone" style="padding:0px;">
        <div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--4-col-phone">
            @if($procNum > 1)
                <a href="{{ route('dashboard.console-proc.index', [$procId, $procNum - 1]) }}" class="mdl-button mdl-js-button mdl-button--raised"><<</a>
            @else
                <a href="#" class="mdl-button mdl-js-button mdl-button--raised"></a>
            @endif
            @if($countProc > $procNum)
                <a href="{{ route('dashboard.console-proc.index', [$procId, $procNum + 1]) }}" class="mdl-button mdl-js-button mdl-button--raised">>></a>
            @else
                <a href="#" class="mdl-button mdl-js-button mdl-button--raised"></a>
            @endif

            <br>
            <br>
            <br>
            <span>Last Update: <b>{{ $lastUpdate }}</b></span>
            <br>
            <br>
            <button class="start_proc_btn mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="startProc(this)" disabled>Start Proc</button>
            <br>
            <br>
            <div>Proc Num: <b>{{ $procNum }}</b><button class="mdl-button mdl-js-button mdl-button--accent" onclick="clearLog()">Clear Log</button></div>
            <br>
            <div>Loadavg: <b id="loadavg_count_span"></b></div>
            <br>
            <br>
            <button class="stop_btn mdl-button mdl-js-button mdl-button--raised" onclick="stopProc(this)">Stop Proc</button>
            <br>
            <br>
            <br>
            <button class="start_proc_btn mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="startAllProcess(this)" disabled>Start All Process</button>
                &nbsp;
                &nbsp;
            <button class="stop_btn mdl-button mdl-js-button mdl-button--raised" onclick="stopAllProcess(this)">Stop All Process</button>

            <table style="padding-top: 40px; width: 100%;">
                @foreach(\App\Models\Log::where('proc', 'console_proc_'.$procId.'_'.$procNum)->orderBy('id', 'desc')->limit(20)->get() as $log)
                    <tr style="background-color: #e9e9e9; font-weight: bold;">
                        <td style="border-right: 1px solid #949494; border-top: 1px solid #949494; padding: 5px; white-space: nowrap;">{{ $log->id }}</td>
                        <td style="border-right: 1px solid #949494; border-top: 1px solid #949494; padding: 5px; white-space: nowrap;">{{ $log->event }}</td>
                        <td style="border-right: 1px solid #949494; border-top: 1px solid #949494; padding: 5px; white-space: nowrap;">{{ $log->status }}</td>
                        <td style="padding: 5px; border-top: 1px solid #949494; white-space: nowrap;">{{ \Carbon\Carbon::parse($log->created_at)->format('d.m H:i') }}</td>
                        <td style="border-right: 1px solid #949494; border-top: 1px solid #949494; padding: 5px;">
                            <div style="overflow: auto; max-height: 100px;" class="hide-scroll">
                                {{  $log->description }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="mdl-cell mdl-cell--9-col mdl-cell--5-col-tablet mdl-cell--4-col-phone">
            <div style="background-color: #000; color: #fff; padding: 10px;"><span style="font-size: 12px;" id="logtail_span"></span></div>

            @if($procNum > 1)
                <a href="{{ route('dashboard.console-proc.index', [$procId, $procNum - 1]) }}" class="mdl-button mdl-js-button mdl-button--raised"><<</a>
            @else
                <a href="#" class="mdl-button mdl-js-button mdl-button--raised"></a>
            @endif
            @if($countProc > $procNum)
                <a href="{{ route('dashboard.console-proc.index', [$procId, $procNum + 1]) }}" class="mdl-button mdl-js-button mdl-button--raised">>></a>
            @else
                <a href="#" class="mdl-button mdl-js-button mdl-button--raised"></a>
            @endif
        </div>
    </div>


@endsection

@push('js')
    <script type="text/javascript">
        $(function () {
            setTimeout(function () {
                var url = location.href;
                if(url.indexOf('#menu_open') !== -1){
                    document.getElementById('app-layout').MaterialLayout.toggleDrawer();
                }
            }, 500);
            //$('.mdl-layout--fixed-drawer').removeClass('mdl-layout--fixed-drawer');
        });

        var currentFlag = null;

        function checkOffersCount() {
            $.ajax({
                url: '{{ route('dashboard.console-proc.total-result', [$procId, $procNum]) }}?key={{ config('app.ajax_key') }}',
                type: 'get',
                success: function (response) {
                    $('#loadavg_count_span').html(response.loadavg);
                    $('#memory_count_span').html(response.memory);
                    $('#logtail_span').html(response.logtail);
                    if(response.flag !== 0){
                        $('.start_proc_btn').attr('disabled', true);
                        $('.stop_btn').removeAttr('disabled');
                    }else {
                        $('.start_proc_btn').removeAttr('disabled');
                        $('.stop_btn').attr('disabled', true);
                    }
                    if(currentFlag === null){
                        currentFlag = response.flag;
                    }else if(currentFlag !== response.flag){
                        location.reload(true);
                    }

                    setTimeout(function () {
                        checkOffersCount();
                    }, 5000);
                }
            });
        }
        checkOffersCount();

        function startProc(e) {
            $(e).attr('disabled', true);
            //if (confirm("Start the process?")) {
                $.ajax({
                    url: '{{ route('dashboard.console-proc.start', [$procId, $procNum]) }}?key={{ config('app.ajax_key') }}',
                    type: 'get',
                    success: function (response) {
                        if (response === 0) {
                            alert('ERROR');
                        }
                    },
                    error: function (error) {
                        alert('ERROR');
                    }
                });
            //}
        }

        function stopProc(e) {
            $(e).attr('disabled', true);
            //if (confirm("Stop the process?")) {
                $.ajax({
                    url: '{{ route('dashboard.console-proc.stop', [$procId, $procNum]) }}?key={{ config('app.ajax_key') }}',
                    type: 'get',
                });
            //}
        }

        function clearLog() {
            //if (confirm("Stop the process?")) {
                $.ajax({
                    url: '{{ route('dashboard.console-proc.clear-log', [$procId, $procNum]) }}?key={{ config('app.ajax_key') }}',
                    type: 'get',
                });
            //}
        }

        function startAllProcess(e) {
            $(e).attr('disabled', true);
            if (confirm("Start all process?")) {
                for(var i = 1; i <= {{ $countProc }}; i++) {
                    $.ajax({
                        url: '{{ route('dashboard.console-proc.index', [$procId]) }}/' + i + '/start?key={{ config('app.ajax_key') }}',
                        type: 'get',
                    });
                }
            }
        }

        function stopAllProcess(e) {
            $(e).attr('disabled', true);
            if (confirm("Stop all process?")) {
                for(var i = 1; i <= {{ $countProc }}; i++){
                    $.ajax({
                        url: '{{ route('dashboard.console-proc.index', [$procId]) }}/'+i+'/stop?key={{ config('app.ajax_key') }}',
                        type: 'get',
                    });
                }
            }
        }
    </script>
@endpush