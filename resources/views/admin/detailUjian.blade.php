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
	
<div class="columns">
	<div class="column is-1 mt-2">
		<strong class="">Ujian: </strong>
	</div>
	<div class="column is-5">
		<input type="text" value="{{ $ujian->judul }}" onchange="judul()" id="judul" class="input">
	</div>
</div>
	
	<p>Tanggal mulai: @if($ujian->time->date_time == NULL) - @else {{ $ujian->time->date_time }} @endif</p>
	<p>Waktu pengerjaan: {{ $ujian->time->time }}</p>
	<div class="columns" style="margin-bottom:0px;">
		<div class="column is-1">
			<p>Repeat:</p>
		</div>
		<div class="column">
			<p id="repeat">{{ $ujian->repeat }}</p>
		</div>
	</div>
	<div class="columns" >
		<div class="column is-1">
			<p class="mt-2">kelas:</p>
		</div>
		<div class="column ">
			<div class="select">
			<select id="kelas">
				@foreach($kelases as $kelas)
				@if($kelas->id == $ujian->kelase_id)
				<option value="{{ $kelas->id }}" selected>{{ $kelas->kelas }}</option>
				@else
				<option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
				@endif
				@endforeach
			</select>
			</div>
		</div>
	</div>
	@php
	$date = date('Y-m-d', strtotime($ujian->time->date_time));
	$time = date('H:i:s', strtotime($ujian->time->date_time));
	@endphp
	@error('timeupdate')
	<div class="">gagal</div>
	@enderror
	
	@if(session('success'))
	<div class="">{{ session('success') }}</div>
	@endif
	<button class="button" type="button" onclick="ubahrepeat('{{ $ujian->id }}','{{ $ujian->repeat }}')">Ubah Repeat</button><br><br>
	<form action="{{ url("admin/ujian/".$ujian->code."/timeujian") }}" method="post">
		@csrf
		
		<div class="columns">
			@if($ujian->time->date_time == NULL)
			<div class="column is-3">
				<input type="datetime-local" id="time_ujian" name="timeujian" class="input">
			</div>
			@else
			<div class="column is-3">
				<input type="datetime-local" value="{{ $date }}T{{ $time }}" id="time_ujian" name="timeujian" class="input">
			</div>
			@endif

			<div class="column is-2">
				<input type="number" name="timeupdate" value="{{ $ujian->time->time }}" class="input">
			</div>
			<div class="column">
				<button class="button">set</button>
			</div>
		</div>

		
	</form>
	<br>
	<a href="{{ url("admin/ujian/$ujian->code/tester") }}">
		<button class="button">Tester</button>
	</a>
	<br>
	<br>
	<br>
	@foreach($soals as $soal)
	<div class="columns">
		<div class="card column is-12">
			<div class="card-content">
				<h1 class="title">{{ ++$i }}</h1>
				<p>{{ $soal->soal }}</p>
				@if($soal->image)
				<img src="{{ asset("storage/$soal->image") }}" alt="">
				<br>
				<br>
				<br>
				@endif

				@foreach($pilihans as $pilihan)
				@if($pilihan->soal_id == $soal->id)
				<label class="radio">
					<input name="pilih" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" disabled>
					{{ $pilihan->pilihan }}

				</label><br>
				@if($pilihan->image)
				<img src="{{ asset("storage/$pilihan->image") }}" alt=""><br>
				@endif
				@endif
				@endforeach
			</div>
		</div>
	</div><br>
	@endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
console.log($('#kelas').find(":selected").text());
	function ubahrepeat(ujian,revers){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/repeat") }}',
			data: {
				'ujian_id': ujian,
			},
			success: function(data) {

			}
		});
		if($('#repeat').html() == 'yes'){
			$('#repeat').html('no');
		}
		else if ($('#repeat').html() == 'no') {
			$('#repeat').html('yes');
		}
	}
	function judul(){
		var judul = $('#judul').val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/judul") }}',
			data: {
				'judul': judul,
			},
			success: function(data) {

			}
		});
	}
	
</script>
@endsection