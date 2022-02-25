@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="position: fixed; z-index: 9999; left: 0px; right: 0px; width: 100%; top: 0px; display: none;" id="load">
	<div style="margin:auto; display: table; background: #00000091; color:white; padding:10px 20px;">Pending</div>
</div>
@php
$i = 0;
@endphp
<div class="container mt-5">
	<div style="display: flex;" class="is-12 is-justify-content-right">
		<a href="{{ url('admin/ujian/'.$ujian->code.'/edit') }}">
			<button class="button mr-3">Edit</button>
		</a>
		<button class="button mr-3 is-success">Add++</button>
	</div>
	<br>
	<br>
	<p>Tanggal mulai: @if($ujian->time->date_time == NULL) - @else {{ $ujian->time->date_time }} @endif</p>
	<p>Waktu pengerjaan: {{ $ujian->time->time }}</p>
	<p>Repeat: {{ $ujian->repeat }}</p>
	@php
	$date = date('Y-m-d', strtotime($ujian->time->date_time));
	$time = date('H:i:s', strtotime($ujian->time->date_time));
	@endphp
@error('timeupdate')
    <div class="">gagal</div>
@enderror
	<br>
	@if(session('success'))
	<div class="">{{ session('success') }}</div>
	@endif
	<form action="{{ url("admin/ujian/".$ujian->code."/timeujian") }}" method="post">
		@csrf
		<input type="datetime-local" value="{{ $date }}T{{ $time }}" id="time_ujian" name="timeujian">
		<input type="number" name="timeupdate" value="{{ $ujian->time->time }}">
		<button>set</button>
	</form>
	<br>
	<br>
	<br>
	@foreach($soals as $soal)
	<div class="columns">
		<div class="card column is-11">
			<div class="card-content">
				<h1 class="title">{{ ++$i }}</h1>
				<p>{{ $soal->soal }}</p>
				@foreach($pilihans as $pilihan)
				@if($pilihan->soal_id == $soal->id)
				<label class="radio">
					<input name="pilih" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" disabled>
					{{ $pilihan->pilihan }}
				</label><br>
				@endif
				@endforeach
			</div>
		</div>
	</div><br>
	@endforeach
</div>
@endsection