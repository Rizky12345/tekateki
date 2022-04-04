
@extends('../layout/head_link')

@section('body_link')
<section class="section" style="padding: 1.5rem 1.5rem; padding-bottom: 0px;">
	<div class="container is-mobile is-hidden-desktop">
		<div class="is-mobile">
			<div class="columns is-mobile is-multiline">
				<div class="column is-12-mobile">
					<strong class="title">Hujan</strong>

				</div>			
			</div>
		</div>

	</div>
</section>

@if($ujian->time->date_time == NULL)
@php
$a = date("Y-m-d H:i:s", strtotime("+{$ujian->time->time} minutes", strtotime($nilai->created_at)));
@endphp 
{{-- @if ($time>$a)
	<script>
		window.location = "{{ url('user/accept/'.session()->get("accept").'/destroy') }}";
	</script>
	@endif --}}

	@else
	@php
	$a = date("Y-m-d H:i:s", strtotime("+{$ujian->time->time} minutes", strtotime($ujian->time->date_time)));
	@endphp 
{{-- @if ($time>$a) {
		<script>
		window.location = "{{ url('user/accept/'.session()->get("accept").'/destroy') }}";
	</script>
	@endif --}}
	@endif
	@php
	$y = date("Y", strtotime($a));
	$f = date("F", strtotime($a));
	$j = date("j", strtotime($a));

	$h = date("H", strtotime($a));
	$ll = date("i", strtotime($a));
	$sss = date("s", strtotime($a));
	@endphp
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<div class="hero-mobile">
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
			<div class="container">
				<div class="card p-5">

					<div class="navbar">
						<div class="navbar-end is-active">
							<div id="countdown"></div>	
						</div>
					</div>
					<h1 class="title">Soal ke @if(!isset($_GET['page'] )) 1 @else {{ $_GET['page'] }}@endif</h1>
					@php
					$a= 0;
					@endphp
					<p>@foreach ($soals as $soal)
						@php
						$a=$soal->id;
						@endphp
						{{ $soal->soal }}
						<br><br>
						<img src="{{ asset("storage/$soal->image") }}" alt=""><br>
					@endforeach</p><br>
					<div class="control">
						@if($pilihans->isEmpty())

						<textarea name="pilih" id="textareaa" class="textarea">@foreach($jawabans as $jawab){{ $jawab->jawaban }}@endforeach</textarea>
						@else
						@foreach($pilihans as $pilihan)
						<label class="radio">
							<input name="pilih" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" onclick="funcctionName({{ $pilihan->id }})" @foreach($jawabans as $jawaban)@if($pilihan->id == $jawaban->pilihan_id) checked @endif @endforeach>
							{{ $pilihan->pilihan }}

						</label>
						<br>
						@if($pilihan->image != NULL)
						<br>
						<div class="columns">
							<div class="clolumn">
								<div class="card">
									<div class="card-content">
										<img src="{{ asset("storage/$pilihan->image") }}" alt="" style="width: 300px; height: 300px;">
									</div>
								</div>
							</div>
						</div>
						
						@endif
						@endforeach
						@endif
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

	<br><br>
	<div class="container">
		<div class="">
			<div class="card columns is-mobile is-multiline is-12">
				@for($i=1; $i<$count;$i++)
				<a href="{{ url("s/admin/ujian/".$ujian->code."/tester/".session()->get('accept')."?page=$i") }}" class="column card is-1-desktop is-3-mobile has-text-centered pt-5 pb-5">
					{{ $i }}
				</a>
				@endfor
			</div>
		</div>
	</div>

	<div class="hero-mobile is-small-mobile">
		<div class="hero-body">
			<div class="is-all-centered">
		<div id="modal-js-example" class="modal">
			<div class="modal-background"></div>
			<div class="modal-content">
				<div class="box is-3 has-text-centered">
					<p class="title">Sudah selesai?</p>
					@can('admin')
<a href="{{ url("admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/destroy") }}">
						<button class="button is-danger">Selesai</button>
					</a>
					@endcan
					@can('sadmin')
					<a href="{{ url("s/admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/destroy") }}">
						<button class="button is-danger">Selesai</button>
					</a>
					@endcan
				</div>
			</div>
		</div>
				<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">Selesai</button>
				
			</div>
		</div>
	</div>
	<div id="alert" class="notification is-danger is-light is-hidden has-text-centered">
		Klik tombol <strong>sudah</strong> jika sudah menyelesaikan ujian
		<br><br>	


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
		
		@can('admin')
		<script type="text/javascript">
			function funcctionName (pilihan_id) {
				var jawaban =  $("input[type='radio'][name='pilih']:checked").val();
				var id = {{ $a }};
				var nilai_id = {{ session()->get('nilai') }};

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				});
				$.post({

					url: '{{ url("admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/post") }}',
					data: {
						'jawaban': jawaban,
						'id': id,
						'nilai_id': nilai_id,
						'pilihan_id': pilihan_id

					},
					success: function(data) {
					}
				});
			} 
		</script>
		<script type="text/javascript">
			function delay(callback, ms) {
				var timer = 0;
				return function() {
					var context = this, args = arguments;
					clearTimeout(timer);
					timer = setTimeout(function () {
						callback.apply(context, args);
					}, ms || 0);
				};
			}

			$( "#textareaa" ).keyup(delay(function() {
				var id = {{ $a }};
				var nilai_id = {{ session()->get('nilai') }};
				var value = $( this ).val();
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				});
				$.post({

					url: '{{ url("admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/testessay") }}',
					data: {
						'jawaban': value,
						'soal_id': id,
						'nilai_id': nilai_id

					},
					success: function(data) {
					}
				});
				console.log(value);
			},500))
			.keyup();
		</script>
		<script>
			let a = new Date("{{ $f }} {{ $j }}, {{ $y }} {{ $h }}:{{ $ll }}:{{ $sss }}").getTime();

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
					window.location = "{{ url('admin/ujian/'.session()->get("code").'/tester/'.session('accept').'/destroy') }}";
				}
			},1000);

		</script>
		@endcan
		@can('sadmin')
		<script type="text/javascript">
			function funcctionName (pilihan_id) {
				var jawaban =  $("input[type='radio'][name='pilih']:checked").val();
				var id = {{ $a }};
				var nilai_id = {{ session()->get('nilai') }};

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				});
				$.post({

					url: '{{ url("s/admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/post") }}',
					data: {
						'jawaban': jawaban,
						'id': id,
						'nilai_id': nilai_id,
						'pilihan_id': pilihan_id

					},
					success: function(data) {
					}
				});
			} 
		</script>
		<script type="text/javascript">
			function delay(callback, ms) {
				var timer = 0;
				return function() {
					var context = this, args = arguments;
					clearTimeout(timer);
					timer = setTimeout(function () {
						callback.apply(context, args);
					}, ms || 0);
				};
			}

			$( "#textareaa" ).keyup(delay(function() {
				var id = {{ $a }};
				var nilai_id = {{ session()->get('nilai') }};
				var value = $( this ).val();
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				});
				$.post({

					url: '{{ url("s/admin/ujian/".$ujian->code."/tester/".session()->get('accept')."/testessay") }}',
					data: {
						'jawaban': value,
						'soal_id': id,
						'nilai_id': nilai_id

					},
					success: function(data) {
					}
				});
				console.log(value);
			},500))
			.keyup();
		</script>
		<script>
			let a = new Date("{{ $f }} {{ $j }}, {{ $y }} {{ $h }}:{{ $ll }}:{{ $sss }}").getTime();

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
					window.location = "{{ url('user/accept/'.session()->get("accept").'/destroy') }}";
				}
			},1000);

		</script>
		@endcan
		<script>
			function finish(){
				$("#alert").removeClass("is-hidden");
			}
			function add(){
				$("#alert").addClass("is-hidden");
			}
		</script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
  // Functions to open and close a modal
  function openModal($el) {
  	$el.classList.add('is-active');
  }

  function closeModal($el) {
  	$el.classList.remove('is-active');
  }

  function closeAllModals() {
  	(document.querySelectorAll('.modal') || []).forEach(($modal) => {
  		closeModal($modal);
  	});
  }

  // Add a click event on buttons to open a specific modal
  (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
  	const modal = $trigger.dataset.target;
  	const $target = document.getElementById(modal);
  	console.log($target);

  	$trigger.addEventListener('click', () => {
  		openModal($target);
  	});
  });

  // Add a click event on various child elements to close the parent modal
  (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
  	const $target = $close.closest('.modal');

  	$close.addEventListener('click', () => {
  		closeModal($target);
  	});
  });

  // Add a keyboard event to close all modals
  document.addEventListener('keydown', (event) => {
  	const e = event || window.event;

    if (e.keyCode === 27) { // Escape key
    	closeAllModals();
    }
   });
 });
</script>
@endsection
