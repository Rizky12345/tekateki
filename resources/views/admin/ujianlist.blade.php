@extends('../layout/head_link2')

@section('body_link')
<div class="container">

    @php
    $a = 0;
    @endphp

    @if($ujians->isEmpty())
    <h1 class="title">Hasil Ujian</h1>
    <div class="columns">
        <div class="column ">
            <h1 class="title" style="color: hsl(0, 0%, 86%);">Ujian Kosong</h1>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-head">
            <strong class="card-header-title">Ujian monitoring</strong>
        </div>
        <div class="card-content">
            <div class="columns is-multiline is-12">
                @foreach($ujians as $ujian)
            @php
            $a = $a+1;
            @endphp
            @if($ujian->repeat == "no")
            <div class="column is-4 has-text-centered">
                @can('sadmin')
                <a href="{{ url('s/admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="subtitle" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan
                @can('admin')
                <a href="{{ url('admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="subtitle" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan
                <div id="divcanvas{{ $a }}" >
                    <canvas id="myChart{{ $a }}"></canvas>
                </div>
            </div>
            @else

            @php
            $count = 0;
            foreach($nilais as $nilai){
                if ($nilai->ujian_id == $ujian->id) {
                    ++$count;
                } 
            }
            @endphp
            <div class="column is-4 has-text-centered">

               @can('admin')
                <a href="{{ url('admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="title" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan
                @can('sadmin')
                 <a href="{{ url('s/admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="title" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan
                <h1>Jumlah yang mengerjakan</h1>
                            <br>
            <br>
            <br>
                <h1 class="title is-1">{{ $count }}</h1>
                            <br>
            <br>
            <br>
            </div>

            @endif

            @endforeach
            </div>
        </div>
    </div>
    @endif

    <br><br><br><br>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
$b = 0;
@endphp

@php
$peserta = 0;
@endphp
@foreach($users as $user)
@php
++$peserta;
@endphp
@endforeach




@foreach($ujians as $ujian)
@php
$sudah = 0;
$belum = 0;
@endphp


@foreach($users as $user)
@foreach($nilais as $nilai)
@if($ujian->id == $nilai->ujian_id && $user->id == $nilai->user_id)
@php
++$sudah;
@endphp
@endif
@endforeach
@endforeach

@php
$b = $b+1;
$belum = $peserta - $sudah;
$belum <= 0 ? $belum = 0 : $belum;
@endphp

<script>
    var ctx = document.getElementById('myChart{{ $b }}');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['sudah', 'belum'],
            datasets: [{
                label: '# of Votes',
                data: [{{ $sudah }}, {{ $belum }}],
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)'
                ],
            }]
        },

    });
</script>

@endforeach
@endsection
