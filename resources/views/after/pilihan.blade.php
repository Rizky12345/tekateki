
@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="hero">
	<div class="hero-head">
		<div class="navbar pt-5">
			<div class="container">
				<div class="navbar-brand">
					<h3 class="title">Hujan</h3>
				</div>
				<div class="navbar-end">
					<p class="navbar-item" id="now"></p>
					<p class="navbar-item">asdd</p>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-body">
		<div class="card pt-5 pb-5">
			<div class="container">
				<div class="navbar">
					<div class="navbar-end">
						<div id="countdown"></div>	
					</div>
				</div>
				<h1 class="title">Soal ke 5</h1>
				@php
				$a= 0;
				@endphp
				<p>@foreach ($soals as $soal)
					@php
					$a=$soal->id;
					@endphp
					{{ $soal->soal }}
				@endforeach</p><br>
				<div class="control">
					@foreach($pilihans as $pilihan)
					<label class="radio">
						<input name="pilih" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" onclick="funcctionName()" @foreach($jawabans as $jawaban)@if($pilihan->pilihan == $jawaban->jawaban) checked @endif @endforeach>
						{{ $pilihan->pilihan }}
					</label><br>
					@endforeach
					{{-- 					@dump($jawaban) --}}
				</div>
				
			</div>
		</div>
	</div>
</div>
@php
$count = 1;
@endphp
@foreach($soalss as $s)
@php
$count++
@endphp
@endforeach
<div id="contentData"></div>
<div class="container">
	<div class="card">
		<div class="columns">
			@for($i=1; $i<$count;$i++)
			<a href="/user/accept/{{ session()->get("accept") }}?page={{ $i }}" class="column p-5 mt-3 mb-3 ml-5  card is-1 has-text-centered">
				{{ $i }}
			</a>
			@endfor
		</div>
	</div>
</div>
<div class="hero">
	<div class="hero-body">
		<div class="is-all-centered">
			<a href="{{ url('user/accept/'.session()->get("accept").'/destroy') }}"><button class="button is-dark">selesai</button></a>
		</div>
	</div>
</div>
@csrf
<footer class="footer">
	<div class="content has-text-centered">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script type="text/javascript">
	function funcctionName () {
		var jawaban =  $("input[type='radio'][name='pilih']:checked").val();
		var id = {{ $a }};

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			
			url: '{{ url("user/accept/".session()->get('accept')."/test") }}',
			data: {
				'jawaban': jawaban,
				'id': id
				
			},
			success: function(data) {
			}
		});
	} 
</script>

<script>
	let a = new Date("dec 30, 2022 20:57:00").getTime();

	let time = setInterval(function(){
		let now = new Date().getTime();
		let sisa = a-now;

		let jam = Math.floor((sisa % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		let menit = Math.floor((sisa % (1000 * 60 * 60)) / (1000 * 60));
		let detik = Math.floor((sisa % (1000 * 60)) / 1000);

		document.getElementById("countdown").innerHTML = jam+":"+menit+":"+detik;
		if (sisa < 0) {
			clearInterval(time);
			document.getElementById("countdown").innerHTML = "EXPIRED";
		}
	},1000);

</script>

@endsection
