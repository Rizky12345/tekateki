@extends('../layout/head_link2')

@section('body_link')
<div class="container mt-5">
	<h1 class="title">{{ $ujian->judul }}({{ $ujian->code }})</h1>
	<br>
	<p>Walaupun ini tester sistem akan menggap ini seperti ujian seperti biasa dengan tujuan agar guru dapat mendapat sensasi dari soal yang sudah di buat</p>
	<br>

	<p>Pelajaran: {{ $ujian->mapel->mapel }}</p>
	<p>Pembuat: {{ $ujian->user->name }}</p>
	@if($ujian->time->date_time != NULL)
	<p>Tanggal dimulai: 
		@php
		echo date("j F Y", strtotime($ujian->time->date_time));
		@endphp
	</p>
	<p>Waktu Pengerjaan: 
		@php
		echo date("H:i:s", strtotime($ujian->time->date_time));
		echo " - ";
		echo date("H:i:s", strtotime("+{$ujian->time->time} minutes", strtotime($ujian->time->date_time)));
		@endphp
	</p>
	<p>Status pengerjaan: 
		@php
		if (date("Y-m-d H:i:s", strtotime($ujian->time->date_time)) > date("Y-m-d H:i:s", strtotime($time))) {
			$status = "Ujian Belum dimulai";
		}elseif(date("Y-m-d H:i:s", strtotime("+{$ujian->time->time} minutes", strtotime($ujian->time->date_time))) <= date("Y-m-d H:i:s", strtotime($time))){
			$status = "Ujian Belakhir";
		}elseif (date("Y-m-d H:i:s", strtotime($ujian->time->date_time)) <= date("Y-m-d H:i:s", strtotime($time))) {
			$status = "Ujian di mulai";
		}
		@endphp
		<strong>{{ $status }}</strong>
	</p>
	@else
	<p>Waktu Pengerjaan: 
		@php
		echo $ujian->time->time." Menit";
		@endphp
	</p>
	@endif
	<p>Repeat: {{ $ujian->repeat }}</p>
	<p>Keterangan: untuk mahasiswa informatika UMMI</p>
	<br><br>
	<strong>Dengan klik tombol ini anda menyetujui untuk mengerjakan ujian ini <br>	hingga selesai</strong><br><br>
	@php

	@endphp
	@if($ujian->repeat == "no")
	@if($nilai->isEmpty())
	@if($ujian->time->date_time != NULL)
	@if($status == "Ujian Belum dimulai" || $status ==  "Ujian Belakhir")
	<button class="button is-dark" disabled>Accept</button>
	@else
	<a href="{{ url("admin/ujian/$ujian->code/tester/accept") }}" >
		<button class="button is-dark">Accept</button>
	</a>
	@endif
	@else
	<a href="{{ url("admin/ujian/$ujian->code/tester/accept") }}" >
		<button class="button is-dark">Accept</button>
	</a>
	@endif
	@else
	<button class="button is-dark" disabled>Accept</button>
	<p class="has-text-danger">Kamu sudah menyelesaikan Ujian ini</p>
	@endif
	@else
	<a href="{{ url("admin/ujian/$ujian->code/tester/accept") }}" >
		<button class="button is-dark">Accept</button>
	</a>
	@endif


</div>
@endsection