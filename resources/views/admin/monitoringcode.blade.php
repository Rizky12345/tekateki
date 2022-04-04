@extends('../layout/head_link2')

@section('body_link')
@if(session('success'))
<div class="notification is-success">
  {{ session('success') }}
</div>
@endif
@php
$essay = 0;
foreach($soals as $soal){
  if ($soal->type == "essay") {
    ++$essay;
  }
}
@endphp
@php
$nomer_nilai = 0;
foreach($nilais as $nilai){
  ++$nomer_nilai;
}
@endphp
@if($essay != 0)
<div class="card">
  <div class="card-head">
    <div class="card-header-title">Periksa Essay</div>
  </div>
  <div class="card-content">
    @can('admin')
    <a href="{{ url("admin/ujian/$ujian->code/essay") }}">Periksa</a>
    @endcan
    @can('sadmin')
    <a href="{{ url("s/admin/ujian/$ujian->code/essay") }}">Periksa</a>
    @endcan
  </div>
</div>

@endif
<div class="card">
  <div class="card-title">
    <div class="card-header-title">
      serahkan
    </div>
  </div>
  <div class="card-content">
    @if($ujian->serahkan == NULL)
    @can('admin')
    <a href="{{ url("admin/ujian/$ujian->code/serahkan") }}">Serahkan hasil ujian</a>
    @endcan
    @can('sadmin')
    <a href="{{ url("s/admin/ujian/$ujian->code/serahkan") }}">Serahkan hasil ujian</a>
    @endcan
    @else
    <p>Nilai diserahkan</p>
    @endif
  </div>
</div>

<div class="card">
  <div class="card-head">
    <strong class="card-header-title">Ujian monitoring</strong>
  </div>
  <div class="card-content">
    <div class="columns is-multiline is-10 is-flex is-vcentered">
      <div class="column is-5 has-text-centered">
        <h2 class="subtitle" style="margin-bottom:0px;">Data yang mengerjakan</h2>
        @if($ujian->repeat == "no")
        <div id="divcanvas1" >
          <canvas id="myChart1"></canvas>
        </div>
        @else
        <br>
        <h1 class="title is-1">{{ $nomer_nilai }}</h1>
        @endif
      </div>
      <div class="column is-5 has-text-centered">
        <h2 class="subtitle" style="margin-bottom:0px;">Data lulus dan tidak</h2>
        <div id="divcanvas2" >
          <canvas id="myChart2"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-head">
    <div class="card-header-title">
      Murid
    </div>
  </div>
  <div class="card-content"style="overflow-x:auto;">
    <table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Nilai</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @php
        $nomer = 0;
        @endphp
        @foreach($nilais as $nilai)
        <tr>
          <td>{{ ++$nomer }}</td>
          <td>{{ $nilai->user->name }}</td>
          <td>{{ $nilai->nilai }}</td>
          @if($nilai->nilai >= $ujian->kkm)
          <td>lulus</td>
          @else
          <td>tidak lulus</td>
          @endif
          <td class="is-actions-cell">
            <div class="buttons is-right">
              <a href="{{ url("admin/ujian/$ujian->code") }}">
                <button class="button is-small is-primary" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
              </a>
              <button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">
                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
              </button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<br><br><br><br>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
$peserta = 0;
$sudah = 0;
$belum = 0;
@endphp

@foreach($users as $user)
@php
++$peserta;
@endphp
@endforeach

@foreach($nilais as $nilai)
@if($nilai->ujian_id == $ujian->id)
@php
++$sudah;
@endphp
@endif
@endforeach
@php
$belum = $peserta - $sudah;
$belum <= 0 ? $belum = 0 : $belum;
@endphp
<script>
  var ctx = document.getElementById('myChart1');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['sudah', 'belum'],
      datasets: [{
        label: '# of Votes',
        data: ['{{ $sudah }}','{{ $belum }}'],
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)'
        ],
      }]
    },

  });
</script>
@php
$lulus = 0;
$tidak_lulus = 0;
@endphp
@foreach($nilais as $nilai)
@if($ujian->kkm <= $nilai->nilai)
  @php
  ++$lulus;
  @endphp
  @else
  @php
  ++$tidak_lulus;
  @endphp
  @endif
  @endforeach
  <script>
    var ctx = document.getElementById('myChart2');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Lulus', 'Tidak lulus'],
        datasets: [{
          label: '# of Votes',
          data: ['{{ $lulus }}','{{ $tidak_lulus }}'],
          backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)'
          ],
        }]
      },

    });
  </script>
  @endsection
