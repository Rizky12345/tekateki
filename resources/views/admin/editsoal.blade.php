@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
$count_soal = 0;
$count_pilihan = 0;
$count_pilihan_json = 0;
@endphp

<form action="{{ url('admin/ujian/'.$ujian->code.'/edit/image') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="container mt-5">
		<div style="display: flex;" class="is-12 is-justify-content-right">
			<button class="button mr-3" title="" name="submit">Save</button>
		</a>
	</div>
	<br>
	@if(session('success'))
	<p>{{ session('success') }}</p>
	@endif
	<br>
	@foreach($soals as $key => $soal)
	@php
	$a = ++$count_soal;
	@endphp
	
	<div class="columns" id="soal{{ $a }}{{ $a }}{{ $a }}">
		<div class="card column is-11">
			<div class="card-content">
				{{ $soal->id }}
				<button class="button is-danger" onclick="delete_type('soal', {{ $soal->id }}, 'soal{{ $a }}{{ $a }}{{ $a }}')" type="button">Delete soal</button><br>
				<br>
				<label class="radio">
					<input name="type{{ $soal->id }}" value="pilihan" id="pilih" type="radio" onclick="typesoal({{ $soal->id }}, 'pilihan',{{ $a }}, 'addchoice{{ $a }}')" @if($soal->type == 'pilihan') checked @endif>
					Pilihan ganda
				</label>
				<br>
				<label class="radio">
					<input name="type{{ $soal->id }}" value="essay" id="pilih" type="radio" onclick="typesoal({{ $soal->id }}, 'essay',{{ $a }}, 'addchoice{{ $a }}')" @if($soal->type == 'essay') checked @endif>
					Essay
				</label>
				
				<div style="position: fixed; z-index: 9999; left: 0px; right: 0px; width: 100%; top: 0px; display: none;" id="load">
					<div style="margin:auto; display: table; background: #00000091; color:white; padding:10px 20px;">Pending</div>
				</div>
				<input type="text" class="is-hidden" name="id{{ $a }}" value="513">
				<textarea name="soal{{ $a }}" id="soal{{ $a }}" class="textarea">{{ $soal->soal }}</textarea>
				<br>
				<img src="{{ asset("storage/$soal->image") }}" alt="" id="soal_image{{ $a }}">
				<input type="text" class="is-hidden" value="{{ $soal->id }}" name="soalid{{ $a }}">
				<div class="file is-small has-name" id="file-small">
					<label class="file-label">
						<input class="file-input" onchange="changeFile(this, '.file-name-soal-{{ $key }}{{ $a }}')" type="file" name="soalfile{{ $a }}">
						<span class="file-cta">
							<span class="file-icon">
								<i class="fa fa-upload"></i>
							</span>
							<span class="file-label">
								Small file…
							</span>
						</span>
						<span class="file-name-soal-{{ $key }}{{ $a }} ml-1 mt-1">
							noting
						</span>
					</label>
				</div>
				<button class="button is-danger is-small" onclick="delete_type('gambar_soal', {{ $soal->id }}, 'soal_image{{ $a }}', 'button_img_soal_delete_{{ $a }}')" type="button" id="button_img_soal_delete_{{ $a }}">Delete gambar</button>
				<br><br>
				<div id="typepilihan{{ $a }}" @if($soal->type == "essay") class="is-hidden" @endif>
					@foreach($pilihans as $keyPilihan => $pilihan)
					@if($pilihan->soal_id == $soal->id)
					@php
					$count_pilihan = ++$count_pilihan;
					@endphp
					<div id="pilihan_select{{ $count_pilihan }}">
						{{ $pilihan->id }}
						<label class="radio">
							<input class="mt-3" name="pilih{{ $a }}" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" onclick="funcctionName({{ $a }}, {{ $soal->id }}, {{ $pilihan->id }})" 
							@foreach($kuncis as $kunci)

							@if($pilihan->soal_id == $kunci->soal_id && $kunci->pilihan_id == $pilihan->id) 
							checked
							@endif
							@endforeach
							>

						</label>


						<input type="text" class="is-hidden" value="{{ $pilihan->id }}" name="pilihanid{{ $count_pilihan }}">
						<input type="text" value="{{ $pilihan->pilihan }}" name="pilihan" id="pilihan{{ $count_pilihan }}{{ $count_pilihan }}" class="input is-normal" style="width: 90%;">
						<br>
						<img src="{{ asset("storage/$pilihan->image") }}" alt="" id="pilihan_image{{ $count_pilihan }}">
						<div class="file is-small has-name" id="file-small">
							<label class="file-label">
								<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-{{ $keyPilihan }}{{ $a }}')" type="file" name="pilihanfile{{ $count_pilihan }}">
								<span class="file-cta">
									<span class="file-icon">
										<i class="fa fa-upload"></i>
									</span>
									<span class="file-label">
										Small file…
									</span>
								</span>
								<span class="file-name-pilihan-{{ $keyPilihan }}{{ $a }} ml-1 mt-1">
									noting
								</span>
							</label>
						</div>
					</div>
					<div id="button_pilihan_{{ $count_pilihan }}">
						@if($pilihan->image != NULL)
						<button class="button is-danger is-small" type="button" onclick="delete_type('gambar_pilihan', {{ $pilihan->id }}, 'pilihan_image{{ $count_pilihan }}','button_img_pilihan_delete_{{ $count_pilihan }}')" name="button_img_pilihan_delete_{{ $count_pilihan }}">Delete gambar</button>
						@endif

						<button class="button is-danger is-small" type="button" onclick="delete_type('pilihan', {{ $pilihan->id }}, 'pilihan_select{{ $count_pilihan }}','button_pilihan_{{ $count_pilihan }}')">Delete pilihan</button>
						<br><br>
					</div>
					
					@endif
					@endforeach
				</div>
				<div id="addchoice{{ $a }}" @if($soal->type == "essay") class="is-hidden" @endif>

				</div>
				<button  type="button" id="btn-choice{{ $a }}" @if($soal->type == "essay") class="is-hidden" @else class="button" @endif>++pilihan</button>
				<br>
			</div>
		</div>
	</div><br>
	@endforeach
	<div id="addcard">
		
	</div>
</div>
<input type="text" class="is-hidden"
value="{{ $a }}" name="soalcount">
<input type="text" class="is-hidden" value="{{ $count_pilihan }}" name="pilihancount">
</form>
<button style="margin-bottom: 100px;" class="button" id="btn-soal">++Soal</button>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>


<script>
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
</script>

<script>
	function reload(){
		location.reload();
	}
</script>

<script>
</script>
@php
$p = 0;
@endphp
@foreach($soals as $soal)
@php
$b = ++$p;
@endphp
<script type="text/javascript">

	$( "#soal{{ $b }}" ).keyup(delay(function() {
		var id = {{ $soal->id }};
		var value = $( this ).val();
		$('#load').show();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: '{{ url("admin/ujian/".$ujian->code."/edit/p") }}',
			data: {
				'id': id,
				'soal': value
			},
			success: function(data) {
				$('#load').hide();
			}
		});
		console.log(value);
	},1000))
	.keyup();
</script>
@endforeach
@php
$j=0;
@endphp

@foreach($soals as $soal)
@php
$l=++$j;
@endphp

<script>
	$(document).ready(function(){
		$("#btn-choice{{ $l }}").click(function(){
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({

				url: '{{ url("admin/ujian/$ujian->code/edit/tambahpilihan") }}',
				data: {
					'pilihan': "masukkan pilihan",
					'soal_id': {{ $soal->id }}

				},
				success: function(data) {
					$('#load').hide();
				}
			});
			$("#addchoice{{ $l }}").append('<div>klik reload untuk edit<br><button class="button" type="button"onclick="reload()">Reload</button></div><br>');
		});
	});
</script>
@endforeach
<script type="text/javascript">
	function funcctionName (count,id,pilihan_id) {
		$('#load').show();
		var jawaban =  $("input[type='radio'][name='"+`pilih${count}`+"']:checked").val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/edit/kuncijawaban") }}',
			data: {
				'jawaban': jawaban,
				'soal_id': id,
				'pilihan_id': pilihan_id

			},
			success: function(data) {
				$('#load').hide();
			}
		});

	} 
</script>
<script>
	$(document).ready(function(){
		var a = {{ $a }};
		var b = 0;
		$("#btn-soal").click(function(){
			a = a+1;
			b = b+1;
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({

				url: '{{ url("admin/ujian/$ujian->code/edit/tambahsoal") }}',
				data: {
					'soal': "masukkan soal",
					'type': "pilihan",
					'ujian_id': {{ $ujian->id }}

				},
				success: function(data) {
					$('#load').hide();
				}
			});

			$("#addcard").append('<div class="columns"><div class="column card is-11"><div class="card-content"><p>Data berhasil di tambahkan, tekan reload untuk mengedit nomer</p><br><button class="button" type="button" onclick="reload()">Reload</button></div></div></div><br>');
		});
	});

</script>
@foreach($soals as $soal)
@foreach($pilihans as $pilihan)
@if($pilihan->soal_id == $soal->id)
@php
$count_json = ++$count_pilihan_json;
$asd = 'asdsad';
@endphp

<script type="text/javascript">

	$( "#pilihan{{ $count_json }}{{ $count_json }}" ).keyup(delay(function() {
		var id = {{ $pilihan->id }};
		var soal_id = {{ $soal->id }};
		var value = $( this ).val();
		$('#load').show();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: '{{ url("admin/ujian/".$ujian->code."/edit/pilihan") }}',
			data: {
				'id': id,
				'soal_id': soal_id,
				'pilihan': value
			},
			success: function(data) {
				$('#load').hide();
			}
		});
		console.log(value);
	},1000))
	.keyup();
</script>
@endif
@endforeach
@endforeach
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
<script>
	function changeFile(fileInput, filePlaceholder){
		if (fileInput.files.length > 0) {
			const fileName = document.querySelector(`#file-small ${filePlaceholder}`);
			fileName.textContent = fileInput.files[0].name;
		}
	}
</script>

<script>
	function typesoal(soal_id, type,a, addchoice){
		$('#load').show();
		if (type == 'essay') {
			$(`#typepilihan${a}`).hide();
			$(`#btn-choice${a}`).hide();
			$(`#${addchoice}`).hide();
		}else{
			$(`#typepilihan${a}`).show();
			$(`#btn-choice${a}`).show();
			$(`#${addchoice}`).show();
		}
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/".$ujian->code."/edit/type") }}',
			data:{
				'soal_id': soal_id,
				'type': type
			},
			success: function(data){
				$('#load').hide();
			}
		});

	}
</script>


<script>
	function delete_type(type,type_id,tag_id, button){
		if(type == "soal"){
			$(`#${tag_id}`).html('');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("admin/ujian/".$ujian->code."/edit/typedeletesoal") }}',
				data: {
					'soal_id': type_id
				},
				success: function(data){

				}
			});
		}
		if(type == "pilihan"){
			$(`#${tag_id}`).html('');
			$(`#${button}`).remove();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("admin/ujian/".$ujian->code."/edit/typedeletepilihan") }}',
				data: {
					'pilihan_id': type_id
				},
				success: function(data){

				}
			});
		}
		if(type == "gambar_pilihan"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("admin/ujian/".$ujian->code."/edit/destroyimage") }}',
				data: {
					'id': type_id,
					'ket': type
				},
				success: function(data){

				}
			});
		}
		if(type == "gambar_soal"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("admin/ujian/".$ujian->code."/edit/destroyimage") }}',
				data: {
					'id': type_id,
					'ket': type
				},
				success: function(data){

				}
			});
		}

	}
</script>
@endsection

