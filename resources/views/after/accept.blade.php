@extends('../layout/head')
@section('body_link')
<div class="is-hidden-desktop">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,0L60,37.3C120,75,240,149,360,160C480,171,600,117,720,128C840,139,960,213,1080,218.7C1200,224,1320,160,1380,128L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z" ></path></svg>
</div>
<div class="hero is-medium is-hidden-mobile">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title">Code: {{ $ujian->code }}</h1>
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
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
			@else
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
			@else
			<button class="button is-dark" disabled>Accept</button>
			<p class="has-text-danger">Kamu sudah menyelesaikan Ujian ini</p>
			@endif
			@else
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
		</div>
	</div>
</div>
<div class="hero-mobile is-small is-hidden-desktop">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title">Code: {{ $ujian->code }}</h1>
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
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
			@else
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
			@else
			<button class="button is-dark" disabled>Accept</button>
			<p class="has-text-danger">Kamu sudah menyelesaikan Ujian ini</p>
			@endif
			@else
			<a href="{{ url('user/accept/choice/'.$ujian->code) }}" >
				<button class="button is-dark">Accept</button>
			</a>
			@endif
		</div>
	</div>
</div>
<div class="is-hidden-desktop">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,96L30,96C60,96,120,96,180,85.3C240,75,300,53,360,85.3C420,117,480,203,540,245.3C600,288,660,288,720,277.3C780,267,840,245,900,213.3C960,181,1020,139,1080,138.7C1140,139,1200,181,1260,208C1320,235,1380,245,1410,250.7L1440,256L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path></svg>
</div>
@endsection
@section('foot_link')

<footer class="footer is-hidden-desktop" style="background:#fff;">
	<div class="content has-text-centered">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
<footer class="footer is-hidden-mobile">
	<div class="content has-text-centered">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
@endsection