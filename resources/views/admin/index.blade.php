@extends('../layout/head_link2')

@section('body_link')
@php
$nomer_nilai = 0;
foreach($ujians as $ujian){
    ++$nomer_nilai;
}
@endphp
<div class="container">
    <div class="tile is-ancestor">
      <div class="tile is-parent">
        <div class="card tile is-child">
          <div class="card-content">
            <div class="level is-mobile">
              <div class="level-item">
                <div class="is-widget-label"><h3 class="subtitle is-spaced">
                  Siswa
              </h3>
              <h1 class="title">
                @can('sadmin')
                @php
                $count = 0;
                @endphp
                @foreach($user_all as $user)
                @php
                $count++;
                @endphp
                @endforeach
                {{ $count }}
                @endcan
                @can('admin')
                @php
                $count2 = 0;
                @endphp
                @foreach($users as $user)
                @php
                $count2++;
                @endphp
                @endforeach
                {{ $count2 }}
                @endcan
            </h1>
        </div>
    </div>
    <div class="level-item has-widget-icon">
        <div class="is-widget-icon">
            <span class="icon has-text-primary is-large"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="tile is-parent">
    <div class="card tile is-child">
      <div class="card-content">
        <div class="level is-mobile">
          <div class="level-item">
            <div class="is-widget-label"><h3 class="subtitle is-spaced">
              Ujian
          </h3>
          <h1 class="title">
            @php
            $ujian_all_user = 0;
            @endphp
            @foreach($ujian_all as $all)
            @php
            $ujian_all_user++;
            @endphp
            @endforeach
            {{ $ujian_all_user }}
        </h1>
    </div>
</div>
<div class="level-item has-widget-icon">
    <div class="is-widget-icon"><span class="icon has-text-info is-large"><i
        class="mdi mdi-clipboard-outline mdi-48px"></i></span>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
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
        <div class="columns is-multiline is-10 is-flex is-vcentered">
            @foreach($ujians as $ujian)
            @php
            $a = $a+1;
            @endphp

            <div class="column is-4 has-text-centered">
                @can('admin')
                <a href="{{ url('admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="subtitle" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan
                @can('sadmin')
                <a href="{{ url('s/admin/ujian/ujianmonitoring/'.$ujian->code) }}"><h2 class="subtitle" style="margin-bottom:0px;">{{ $ujian->judul }}</h2></a>
                @endcan


                <div id="divcanvas{{ $a }}" >
                    <canvas id="myChart{{ $a }}"></canvas>
                </div>
            </div>
            

           @endforeach

       </div>
   </div>
</div>
@endif

<div class="columns">

    <div class="column">
        <div class="card">
            <div class="card-head">
                <strong class="card-header-title">Data Siswa</strong>
            </div>
            <div class="card-content has-text-centered">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jumlah mengikuti Ujian</th>
                            <th>Jumlah Mengerjakan Ujian</th>
                        </tr>
                    </thead>            
                    @php
                    $count_user = 0;
                    
                    @endphp

{{--                     @foreach($users as $user)
                    @foreach($nilais as $nilai)
                    @if($nilai->user_id == $user->id)
                    @php
                    ++$count_nilai;
                    @endphp
                    @endif
                    @endforeach
                    @endforeach --}}
                    


                    <tbody>
                        @foreach($users as $user)
                        @php
                        $count_nilai = collect([]);
                        $count_nilais = 0;
                        @endphp
                        <tr>
                            <td>{{ ++$count_user }}</td>
                            <td>{{ $user->name }}</td>
                            @foreach($nilais as $nilai)
                            @if($nilai->user_id == $user->id)
                            @php
                            $count_nilai->push($nilai);
                            @endphp
                            @endif
                            @endforeach
                            @php
                            $hitungan = $count_nilai->unique('user_id');
                            @endphp
                            <td>{{ count($hitungan) }}</td>
                            @foreach($nilais as $nilai)
                            @if($nilai->user_id == $user->id)
                            @php
                            ++$count_nilais;
                            @endphp
                            @endif
                            @endforeach
                            <td>{{ $count_nilais }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div> 
</div>
<br><br><br><br>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
$b = 0;
@endphp
{{-- @foreach($ujians as $ujian)
@php
$peserta = 0;
$lulus = 0;
$tidak_lulus = 0;
@endphp
@foreach($nilais as $nilai)
@if($nilai->ujian_id == $ujian->id)
@php
$peserta++;
@endphp
@if($nilai->nilai >= $ujian->kkm)
@php
$lulus++;
@endphp
@endif
@if($nilai->nilai < $ujian->kkm)
@php
$tidak_lulus++;
@endphp
@endif
@endif
@endforeach --}}





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
$arr = collect([]);
@endphp


@foreach($users as $user)
@foreach($nilais as $nilai)
@if($ujian->id == $nilai->ujian_id && $nilai->user_id == $user->id)
@php
$arr->push($nilai);
@endphp
@endif
@endforeach
@endforeach


@php
$b = $b+1;
$sudah = $arr->unique('user_id');
$sudah = count($sudah);
$belum = $peserta - $sudah;
$belum <= 0 ? $belum = 0 : $belum;
@endphp


@if($b == 1)
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
@elseif($b == 2)
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
                'rgb(255, 205, 86)',
                '#4bc0c0'
                ],
            }]
        },

    });
</script>
@else
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
                '#ff9f40',
                'rgb(255, 99, 132)'
                ],
            }]
        },

    });
</script>
@endif
@endforeach
@endsection
