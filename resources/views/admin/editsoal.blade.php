@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
$count_soal = 0;
$count_pilihan = 0;
$count_pilihan_json = 0;
@endphp


@can('admin')
@endcan
@can('admin')
@endcan
<button id="save_button" style="position: fixed; right: 3%; z-index: 999; " class="button">Save</button>
<form @can('admin') action="{{ url('admin/ujian/'.$ujian->code.'/edit/image') }}" @endcan @can('sadmin') action="{{ url('s/admin/ujian/'.$ujian->code.'/edit/image') }}" @endcan method="post" enctype="multipart/form-data">
	@csrf
	<div class="container mt-5">
		<div style="display: flex;" class="is-12 is-justify-content-right">
			<button class="button mr-3" title="" name="submit">Simpan gambar</button>
		</a>
	</div>
	<br>
	@if($errors->any())
	<div class="notification is-danger">
		File Harus Gambar yang Sizenya Kurang dari 2MB
	</div>
	@endif
		@if(session('success'))
	<div class="notification is-success">
		Gambar Berhasil di Simpan
	</div>
	@endif
	<br>
	@foreach($soals as $key => $soal)
	@php
	$a = ++$count_soal;
	@endphp
	
	<div class="columns" id="soal{{ $a }}{{ $a }}{{ $a }}">
		<div class="card column is-12">
			<div class="card-head">
				<div class="card-header-title">
					Soal ke {{ $a }}
				</div>
			</div>
			<div class="card-content">
				<button class="button is-dark" onclick="delete_type('soal', {{ $soal->id }}, 'soal{{ $a }}{{ $a }}{{ $a }}')" type="button">Delete soal</button><br>
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
				@php
				$name_image = "soalfile$a";

				@endphp
				


				

				<input type="text" class="is-hidden" name="id{{ $a }}" value="513">
				<textarea name="soal{{ $a }}" id="soal{{ $a }}" class="textarea" onchange="changevalue('soal', {{ $soal->id }}, '{{ $ujian->code }}', 'soal{{ $a }}')">{{ $soal->soal }}</textarea>

				<br>
				<img src="{{ asset("storage/$soal->image") }}" alt="" id="soal_image{{ $a }}">
				<input type="text" class="is-hidden" value="{{ $soal->id }}" name="soalid{{ $a }}">
				<div class="file is-small has-name" id="file-small">
					<label class="file-label">
						<input class="file-input" onchange="changeFile(this, '.file-name-soal-{{ $key }}{{ $a }}')" type="file" name="soalfile{{ $a }}">
						<span class="file-cta">
							<span class="file-icon">
								<i class="mdi mdi-upload"></i>
							</span>
							<span class="file-label">
								Choose a file...
							</span>
						</span>
						<span class="file-name-soal-{{ $key }}{{ $a }} ml-1 mt-1">
							No file uploaded
						</span>
					</label>
				</div>
				@if($soal->image != NULL)
				<button class="button is-dark is-small" onclick="delete_type('gambar_soal', {{ $soal->id }}, 'soal_image{{ $a }}', 'button_img_soal_delete_{{ $a }}')" type="button" id="button_img_soal_delete_{{ $a }}">Delete gambar</button>
				@endif
				<br><br>
				<div id="typepilihan{{ $a }}" @if($soal->type == "essay") class="is-hidden" @endif>
					@foreach($pilihans as $keyPilihan => $pilihan)
					@if($pilihan->soal_id == $soal->id)
					@php
					$count_pilihan = ++$count_pilihan;
					@endphp

					<div id="pilihan_select{{ $count_pilihan }}">
						<label class="radio">
							<input class="mt-3" name="pilih{{ $a }}" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" onclick="funcctionName({{ $a }}, {{ $soal->id }}, {{ $pilihan->id }})" 
							@foreach($kuncis as $kunci)

							@if($pilihan->soal_id == $kunci->soal_id && $kunci->pilihan_id == $pilihan->id) 
							checked
							@endif
							@endforeach
							>

						</label>

						@php
						$name_image_pilihan = "pilihanfile$count_pilihan";
						@endphp
						@if($errors->first($name_image_pilihan) == "")
						@else
						<div style="position: fixed; z-index: 9999; left: 0px; bottom: 0px;" id="load{{ $count_pilihan }}" onclick="hide_message('load{{ $count_pilihan }}')">
							<div style="margin:auto; display: table; background: #00000091; color:white; padding:10px 20px;">Gambar harus dibawah 2mb</div>
						</div>
						@endif
						<input  type="text" class="is-hidden" value="{{ $pilihan->id }}" name="pilihanid{{ $count_pilihan }}">

						<input onchange="changevalue('pilihan','{{ $soal->id }}','{{ $ujian->code }}', 'pilihan{{ $count_pilihan }}{{ $count_pilihan }}','{{ $pilihan->id }}')" type="text" value="{{ $pilihan->pilihan }}" name="pilihan" id="pilihan{{ $count_pilihan }}{{ $count_pilihan }}" class="input is-normal" style="width: 90%;" autocomplete="off">
						<br>
						<img src="{{ asset("storage/$pilihan->image") }}" alt="" id="pilihan_image{{ $count_pilihan }}">
						<div class="file is-small has-name" id="file-small">
							
							<label class="file-label">
								<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-{{ $keyPilihan }}{{ $a }}')" type="file" name="pilihanfile{{ $count_pilihan }}">
								<span class="file-cta">
									<span class="file-icon">
										<i class="mdi mdi-upload"></i>
									</span>
									<span class="file-label">
										Choose a file…
									</span>
								</span>
								<span class="file-name-pilihan-{{ $keyPilihan }}{{ $a }} ml-1 mt-1">
									No file uploaded
								</span>
							</label>
						</div>
					</div>
					<div id="button_pilihan_{{ $count_pilihan }}">
						@if($pilihan->image != NULL)
						<button class="button is-dark is-small" id="button_img_pilihan_delete_{{ $count_pilihan }}" type="button" onclick="delete_type('gambar_pilihan', {{ $pilihan->id }}, 'pilihan_image{{ $count_pilihan }}','button_img_pilihan_delete_{{ $count_pilihan }}')" name="button_img_pilihan_delete_{{ $count_pilihan }}">Delete gambar</button>
						@endif

						<button class="button is-dark is-small bp{{ $a }}" type="button" onclick="delete_type('pilihan', {{ $pilihan->id }}, 'pilihan_select{{ $count_pilihan }}','button_pilihan_{{ $count_pilihan }}')" name="delete_pilihan{{ $a }}" id="delete_pilihan{{ $a }}">Delete pilihan</button>
						<br><br>
					</div>

					@endif
					@endforeach
				</div>
				<div id="addchoice{{ $a }}" @if($soal->type == "essay") class="is-hidden" @endif>
					
				</div>
				<button  type="button" onclick="tambah_pilihan({{ $soal->id }}, 'addchoice{{ $a }}', {{ $a }})" id="btn-choice{{ $a }}"  class="button @if($soal->type == "essay") is-hidden @endif">Tambah Pilihan</button>
				<br>
			</div>
		</div>
	</div><br>
	@endforeach
	<div id="addcard"></div>
</div>
<input type="text" class="is-hidden"
value="{{ $a }}" name="soalcount" id="a_count">
<input type="text" class="is-hidden" value="{{ $count_pilihan }}" name="pilihancount" id="count_pilihan">
</form>
<button style="margin-bottom: 100px;" class="button" id="btn-soal" onclick="btn_soal()">Tambah Soal</button>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>

	for (var i = 1; i <= {{ $a }}; i++) {
		let count_radio = $(`input[name="pilih${i}"]`).length;
		if(count_radio >= 4){
			$(`#btn-choice${i}`).addClass('is-hidden');
		}else{
			$(`#btn-choice${i}`).removeClass('is-hidden');
		}
		let class_count = $(`.bp${i}`);
		if(class_count.length <= 2){
			class_count.addClass('is-hidden');
		}else{
			class_count.removeClass('is-hidden');
		}
	}

window.onscroll = function() {
	console.log(window.pageYOffset);
	if(window.pageYOffset > 100){
		$("#save_button").css({"top" : "20%", "transition" : "1s"});
	}else{
		$("#save_button").css("top","");
	}
}
</script>
@can('admin')
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
	function changevalue(type, soal_id, ujian_code, value, pilihan_id){
		$('#load').show();
		if (type == "soal") {
			var asd = $(`#${value}`).val();
			
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: `edit/p`,
				data:{
					value: asd,
					soal_id: soal_id,
					ujian_code: ujian_code,
				},
				success: function(data) {
					$('#load').hide();
				}
			});
		}
		if (type == "pilihan") {
			var asd = $(`#${value}`).val();
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: `edit/pilihan`,
				data:{
					value: asd,
					soal_id: soal_id,
					ujian_code: ujian_code,
					pilihan_id: pilihan_id,
				},
				success: function(data) {
					$('#load').hide();
				}
			});
		}
	}

</script>
@if($pilihans->isEmpty());
@php
$keyPilihan = 0;
@endphp
@endif
<script>
	let count_pilihan = {{ $count_pilihan }};
	let keyPilihan = {{ $keyPilihan }};
	
	function tambah_pilihan(soal_id, id, name_id){
		$('#load').show();
		var ujian_code = "{{ $ujian->code }}";
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: 'edit/tambahpilihan',
			data: {
				'pilihan': "",
				'soal_id': soal_id

			},
			success: function(data) {
				$('#load').hide();
				count_pilihan++;
				keyPilihan++;
				$(`#${id}`).append(`<div id="pilihan_select${count_pilihan}"><label class="radio pr-1"><input class="mt-3" name="pilih${name_id}" value="${data.pilihan}" id="pilih" type="radio" onclick="funcctionName(${name_id}, ${soal_id}, ${data.id})"></label><input  type="text" class="is-hidden" value="${data.id}" name="pilihanid${count_pilihan}"><input onchange="changevalue('pilihan','${soal_id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data.id}')" type="text" value="" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off"><br><div class="file is-small has-name" id="file-small"><label class="file-label"><input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${keyPilihan}${name_id}')" type="file" name="pilihanfile${count_pilihan}"><span class="file-cta"><span class="file-icon"><i class="mdi mdi-upload"></i></span><span class="file-label">Choose a file…</span></span><span class="file-name-pilihan-${keyPilihan}${name_id} ml-1 mt-1">No file uploaded</span></label></div><button class="button is-dark is-small bp${name_id}" type="button" onclick="delete_type('pilihan', ${data.id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')">Delete pilihan</button><br><br></div>`);
				for (var i = 1; i <= $("#a_count").val(); i++) {
					let count_radio = $(`input[name="pilih${i}"]`).length;
					if(count_radio >= 4){
						$(`#btn-choice${i}`).addClass('is-hidden');
					}else{
						$(`#btn-choice${i}`).removeClass('is-hidden');
					}

					let class_count = $(`.bp${i}`);
					if(class_count.length <= 2){
						class_count.addClass('is-hidden');
					}else{
						class_count.removeClass('is-hidden');
					}
				}
				$(`#count_pilihan`).val(count_pilihan);
				console.log($(`#count_pilihan`).val());
			}

		});
	}
</script>

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
	function btn_soal(){
		var a = $("#a_count").val();
		var ujian_code = "{{ $ujian->code }}";
		var key =  {{ $a }}-1;
		
		$('#load').show();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: '{{ url("admin/ujian/$ujian->code/edit/tambahsoal") }}',
			data: {
				'soal': "",
				'type': "pilihan",
				'ujian_id': {{ $ujian->id }}

			},
			success: function(data) {
				a++;
				count_pilihan++;
				let d = $("#count_pilihan").val(count_pilihan);
				key++;
				keyPilihan++;
				$('#load').hide();
				$("#addcard").append(`<div class="columns" id="soal${a}${a}${a}">
					<div class="card column is-12">
					<div class="card-head">
					<div class="card-header-title">
					Soal ke ${a}
					</div>
					</div>
					<div class="card-content">
					<button class="button is-dark" onclick="delete_type('soal', ${data[0].id}, 'soal${a}${a}${a}')" type="button">Delete soal</button><br>
					<br>
					<label class="radio">
					<input name="type${data[0].id}" value="pilihan" id="pilih" type="radio" onclick="typesoal(${data[0].id}, 'pilihan',${a}, 'addchoice${a}')" checked>
					Pilihan ganda
					</label>
					<br>
					<label class="radio">
					<input name="type${data[0].id}" value="essay" id="pilih" type="radio" onclick="typesoal(${data[0].id}, 'essay',${a}, 'addchoice${a}')">
					Essay
					</label>

					<input type="text" class="is-hidden" name="id${a}" value="513">
					<textarea name="soal${a}" id="soal${a}" class="textarea" onchange="changevalue('soal', ${data[0].id}, '${ujian_code}', 'soal${a}')">${data[0].soal}</textarea>

					<br>
					<img src="" alt="" id="soal_image${a}">
					<input type="text" class="is-hidden" value="${data[0].id}" name="soalid${a}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-soal-${key}${a}')" type="file" name="soalfile${a}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file…
					</span>
					</span>
					<span class="file-name-soal-${key}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>

					<br><br>
					<div id="typepilihan${a}">
					<div id="pilihan_select${count_pilihan}">
					<label class="radio">
					<input class="mt-3" name="pilih${a}" value="${data[1].pilihan}" id="pilih" type="radio" onclick="funcctionName(${a}, ${data[0].id}, ${data[1].id})">

					</label>


					<input  type="text" class="is-hidden" value="${data[1].id}" name="pilihanid${count_pilihan}">

					<input onchange="changevalue('pilihan','${data[0].id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data[1].id}')" type="text" value="${data[1].pilihan}" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off">
					<br>
					<img src="" alt="" id="pilihan_image${count_pilihan}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${keyPilihan}${a}')" type="file" name="pilihanfile${count_pilihan}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file...
					</span>
					</span>
					<span class="file-name-pilihan-${keyPilihan}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>
					</div>
					<div id="button_pilihan_${count_pilihan}">
					<button class="button is-dark is-small bp${a}" type="button" onclick="delete_type('pilihan', ${data[1].id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')" name="delete_pilihan${a}" id="delete_pilihan${a}">Delete pilihan</button>
					<br><br>
					</div>


					
					<div id="pilihan_select${++count_pilihan}">
					<label class="radio">
					<input class="mt-3" name="pilih${a}" value="${data[2].pilihan}" id="pilih" type="radio" onclick="funcctionName(${a}, ${data[0].id}, ${data[2].id})">

					</label>
					<input  type="text" class="is-hidden" value="${data[2].id}" name="pilihanid${count_pilihan}">

					<input onchange="changevalue('pilihan','${data[0].id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data[2].id}')" type="text" value="${data[2].pilihan}" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off">
					<br>
					<img src="" alt="" id="pilihan_image${count_pilihan}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${++keyPilihan}${a}')" type="file" name="pilihanfile${count_pilihan}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file…
					</span>
					</span>
					<span class="file-name-pilihan-${keyPilihan}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>
					</div>
					<div id="button_pilihan_${count_pilihan}">
					<button class="button is-dark is-small bp${a}" type="button" onclick="delete_type('pilihan', ${data[2].id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')" name="delete_pilihan${a}" id="delete_pilihan${a}">Delete pilihan</button>
					<br><br>
					</div>
					</div>
					<div id="addchoice${a}">
					
					</div>
					<button  type="button" onclick="tambah_pilihan('${data[0].id}', 'addchoice${a}', ${a})" id="btn-choice${a}" class="button">Tambah Pilihan</button>
					<br>
					</div>
					</div>
					</div><br>`);
$("#a_count").val(a);
$("#count_pilihan").val(count_pilihan);
for (var i = 1; i <= $("#a_count").val(); i++) {
	let count_radio = $(`input[name="pilih${i}"]`).length;
	if(count_radio >= 4){
		$(`#btn-choice${i}`).addClass('is-hidden');
	}else{
		$(`#btn-choice${i}`).removeClass('is-hidden');
	}
	let class_count = $(`.bp${i}`);
	if(class_count.length <= 2){
		class_count.addClass('is-hidden');
	}else{
		class_count.removeClass('is-hidden');
	}
}

}
});
}
</script>
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
			$(`#typepilihan${a}`).addClass('is-hidden');
			$(`#btn-choice${a}`).addClass('is-hidden');
			$(`#${addchoice}`).addClass('is-hidden');
		}else{
			$(`#typepilihan${a}`).removeClass('is-hidden');
			$(`#btn-choice${a}`).removeClass('is-hidden');
			$(`#${addchoice}`).removeClass('is-hidden');
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
			$('#load').show();
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
					$('#load').hide();
				}
			});
		}
		if(type == "pilihan"){
			$(`#${tag_id}`).html('');
			$(`#${button}`).remove();
			$('#load').show();
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
					$('#load').hide();
					for (var i = 1; i <= $("#a_count").val(); i++) {
						let count_radio = $(`input[name="pilih${i}"]`).length;
						if(count_radio >= 4){
							$(`#btn-choice${i}`).addClass('is-hidden');
						}else{
							$(`#btn-choice${i}`).removeClass('is-hidden');
						}
						let class_count = $(`.bp${i}`);
						if(class_count.length <= 2){
							class_count.addClass('is-hidden');
						}else{
							class_count.removeClass('is-hidden');
						}
					}
				}
			});
		}
		if(type == "gambar_pilihan"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$('#load').show();
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
					$('#load').hide();
				}
			});
		}
		if(type == "gambar_soal"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$('#load').show();
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
					$('#load').hide();
				}
			});
		}

	}
</script>
<script>
	function hide_message(id){
		$(`#${id}`).hide();
	}
</script>
@endcan
@can('sadmin')
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
	function changevalue(type, soal_id, ujian_code, value, pilihan_id){
		$('#load').show();
		if (type == "soal") {
			var asd = $(`#${value}`).val();
			
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: `edit/p`,
				data:{
					value: asd,
					soal_id: soal_id,
					ujian_code: ujian_code,
				},
				success: function(data) {
					$('#load').hide();
				}
			});
		}
		if (type == "pilihan") {
			var asd = $(`#${value}`).val();
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: `edit/pilihan`,
				data:{
					value: asd,
					soal_id: soal_id,
					ujian_code: ujian_code,
					pilihan_id: pilihan_id,
				},
				success: function(data) {
					$('#load').hide();
				}
			});
		}
	}

</script>
<script>
	let count_pilihan = {{ $count_pilihan }};
	let keyPilihan = {{ $keyPilihan }};
	
	function tambah_pilihan(soal_id, id, name_id){
		$('#load').show();
		var ujian_code = "{{ $ujian->code }}";
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: 'edit/tambahpilihan',
			data: {
				'pilihan': "",
				'soal_id': soal_id

			},
			success: function(data) {
				$('#load').hide();
				count_pilihan++;
				keyPilihan++;
				$(`#${id}`).append(`<div id="pilihan_select${count_pilihan}"><label class="radio pr-1"><input class="mt-3" name="pilih${name_id}" value="${data.pilihan}" id="pilih" type="radio" onclick="funcctionName(${name_id}, ${soal_id}, ${data.id})"></label><input  type="text" class="is-hidden" value="${data.id}" name="pilihanid${count_pilihan}"><input onchange="changevalue('pilihan','${soal_id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data.id}')" type="text" value="" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off"><br><div class="file is-small has-name" id="file-small"><label class="file-label"><input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${keyPilihan}${name_id}')" type="file" name="pilihanfile${count_pilihan}"><span class="file-cta"><span class="file-icon"><i class="mdi mdi-upload"></i></span><span class="file-label">Choose a file…</span></span><span class="file-name-pilihan-${keyPilihan}${name_id} ml-1 mt-1">No file uploaded</span></label></div><button class="button is-dark is-small bp${name_id}" type="button" onclick="delete_type('pilihan', ${data.id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')">Delete pilihan</button><br><br></div>`);
				for (var i = 1; i <= $("#a_count").val(); i++) {
					let count_radio = $(`input[name="pilih${i}"]`).length;
					if(count_radio >= 4){
						$(`#btn-choice${i}`).addClass('is-hidden');
					}else{
						$(`#btn-choice${i}`).removeClass('is-hidden');
					}

					let class_count = $(`.bp${i}`);
					if(class_count.length <= 2){
						class_count.addClass('is-hidden');
					}else{
						class_count.removeClass('is-hidden');
					}
				}
				$(`#count_pilihan`).val(count_pilihan);
				console.log($(`#count_pilihan`).val());
			}

		});
	}
</script>



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
			url: '{{ url("s/admin/ujian/$ujian->code/edit/kuncijawaban") }}',
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
	function btn_soal(){
		var a = $("#a_count").val();
		var ujian_code = "{{ $ujian->code }}";
		var key =  {{ $a }}-1;
		
		$('#load').show();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({

			url: '{{ url("s/admin/ujian/$ujian->code/edit/tambahsoal") }}',
			data: {
				'soal': "masukkan soal",
				'type': "pilihan",
				'ujian_id': {{ $ujian->id }}

			},
			success: function(data) {
				a++;
				count_pilihan++;
				let d = $("#count_pilihan").val(count_pilihan);
				key++;
				keyPilihan++;
				$('#load').hide();
				$("#addcard").append(`<div class="columns" id="soal${a}${a}${a}">
					<div class="card column is-12">
					<div class="card-head">
					<div class="card-header-title">
					Soal ke ${a}
					</div>
					</div>
					<div class="card-content">
					<button class="button is-dark" onclick="delete_type('soal', ${data[0].id}, 'soal${a}${a}${a}')" type="button">Delete soal</button><br>
					<br>
					<label class="radio">
					<input name="type${data[0].id}" value="pilihan" id="pilih" type="radio" onclick="typesoal(${data[0].id}, 'pilihan',${a}, 'addchoice${a}')" checked>
					Pilihan ganda
					</label>
					<br>
					<label class="radio">
					<input name="type${data[0].id}" value="essay" id="pilih" type="radio" onclick="typesoal(${data[0].id}, 'essay',${a}, 'addchoice${a}')">
					Essay
					</label>

					<input type="text" class="is-hidden" name="id${a}" value="513">
					<textarea name="soal${a}" id="soal${a}" class="textarea" onchange="changevalue('soal', ${data[0].id}, '${ujian_code}', 'soal${a}')">${data[0].soal}</textarea>

					<br>
					<img src="" alt="" id="soal_image${a}">
					<input type="text" class="is-hidden" value="${data[0].id}" name="soalid${a}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-soal-${key}${a}')" type="file" name="soalfile${a}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file…
					</span>
					</span>
					<span class="file-name-soal-${key}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>

					<br><br>
					<div id="typepilihan${a}">
					<div id="pilihan_select${count_pilihan}">
					<label class="radio">
					<input class="mt-3" name="pilih${a}" value="${data[1].pilihan}" id="pilih" type="radio" onclick="funcctionName(${a}, ${data[0].id}, ${data[1].id})">

					</label>


					<input  type="text" class="is-hidden" value="${data[1].id}" name="pilihanid${count_pilihan}">

					<input onchange="changevalue('pilihan','${data[0].id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data[1].id}')" type="text" value="${data[1].pilihan}" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off">
					<br>
					<img src="" alt="" id="pilihan_image${count_pilihan}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${keyPilihan}${a}')" type="file" name="pilihanfile${count_pilihan}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file…
					</span>
					</span>
					<span class="file-name-pilihan-${keyPilihan}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>
					</div>
					<div id="button_pilihan_${count_pilihan}">
					<button class="button is-dark is-small bp${a}" type="button" onclick="delete_type('pilihan', ${data[1].id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')" name="delete_pilihan${a}" id="delete_pilihan${a}">Delete pilihan</button>
					<br><br>
					</div>


					
					<div id="pilihan_select${++count_pilihan}">
					<label class="radio">
					<input class="mt-3" name="pilih${a}" value="${data[2].pilihan}" id="pilih" type="radio" onclick="funcctionName(${a}, ${data[0].id}, ${data[2].id})">

					</label>
					<input  type="text" class="is-hidden" value="${data[2].id}" name="pilihanid${count_pilihan}">

					<input onchange="changevalue('pilihan','${data[0].id}','${ujian_code}', 'pilihan${count_pilihan}${count_pilihan}','${data[2].id}')" type="text" value="${data[2].pilihan}" name="pilihan" id="pilihan${count_pilihan}${count_pilihan}" class="input is-normal" style="width: 90%;" autocomplete="off">
					<br>
					<img src="" alt="" id="pilihan_image${count_pilihan}">
					<div class="file is-small has-name" id="file-small">
					<label class="file-label">
					<input class="file-input" onchange="changeFile(this, '.file-name-pilihan-${++keyPilihan}${a}')" type="file" name="pilihanfile${count_pilihan}">
					<span class="file-cta">
					<span class="file-icon">
					<i class="mdi mdi-upload"></i>
					</span>
					<span class="file-label">
					Choose a file…
					</span>
					</span>
					<span class="file-name-pilihan-${keyPilihan}${a} ml-1 mt-1">
					No file uploaded
					</span>
					</label>
					</div>
					</div>
					<div id="button_pilihan_${count_pilihan}">
					<button class="button is-dark is-small bp${a}" type="button" onclick="delete_type('pilihan', ${data[2].id}, 'pilihan_select${count_pilihan}','button_pilihan_${count_pilihan}')" name="delete_pilihan${a}" id="delete_pilihan${a}">Delete pilihan</button>
					<br><br>
					</div>
					</div>
					<div id="addchoice${a}">
					
					</div>
					<button  type="button" onclick="tambah_pilihan('${data[0].id}', 'addchoice${a}', ${a})" id="btn-choice${a}" class="button">Tambah Pilihan</button>
					<br>
					</div>
					</div>
					</div><br>`);
$("#a_count").val(a);
$("#count_pilihan").val(count_pilihan);
for (var i = 1; i <= $("#a_count").val(); i++) {
	let count_radio = $(`input[name="pilih${i}"]`).length;
	if(count_radio >= 4){
		$(`#btn-choice${i}`).addClass('is-hidden');
	}else{
		$(`#btn-choice${i}`).removeClass('is-hidden');
	}
	let class_count = $(`.bp${i}`);
	if(class_count.length <= 2){
		class_count.addClass('is-hidden');
	}else{
		class_count.removeClass('is-hidden');
	}
}

}
});
}
</script>
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
			$(`#typepilihan${a}`).addClass('is-hidden');
			$(`#btn-choice${a}`).addClass('is-hidden');
			$(`#${addchoice}`).addClass('is-hidden');
		}else{
			$(`#typepilihan${a}`).removeClass('is-hidden');
			$(`#btn-choice${a}`).removeClass('is-hidden');
			$(`#${addchoice}`).removeClass('is-hidden');
		}
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/".$ujian->code."/edit/type") }}',
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
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("s/admin/ujian/".$ujian->code."/edit/typedeletesoal") }}',
				data: {
					'soal_id': type_id
				},
				success: function(data){
					$('#load').hide();
				}
			});
		}
		if(type == "pilihan"){
			$(`#${tag_id}`).html('');
			$(`#${button}`).remove();
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("s/admin/ujian/".$ujian->code."/edit/typedeletepilihan") }}',
				data: {
					'pilihan_id': type_id
				},
				success: function(data){
					$('#load').hide();
					for (var i = 1; i <= $("#a_count").val(); i++) {
						let count_radio = $(`input[name="pilih${i}"]`).length;
						if(count_radio >= 4){
							$(`#btn-choice${i}`).addClass('is-hidden');
						}else{
							$(`#btn-choice${i}`).removeClass('is-hidden');
						}
						let class_count = $(`.bp${i}`);
						if(class_count.length <= 2){
							class_count.addClass('is-hidden');
						}else{
							class_count.removeClass('is-hidden');
						}
					}
				}
			});
		}
		if(type == "gambar_pilihan"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("s/admin/ujian/".$ujian->code."/edit/destroyimage") }}',
				data: {
					'id': type_id,
					'ket': type
				},
				success: function(data){
					$('#load').hide();
				}
			});
		}
		if(type == "gambar_soal"){
			$(`#${tag_id}`).attr('src', '');
			$(`#${button}`).remove();
			$('#load').show();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			});
			$.post({
				url: '{{ url("s/admin/ujian/".$ujian->code."/edit/destroyimage") }}',
				data: {
					'id': type_id,
					'ket': type
				},
				success: function(data){
					$('#load').hide();
				}
			});
		}

	}
</script>
<script>
	function hide_message(id){
		$(`#${id}`).hide();
	}
</script>
@endcan
@endsection

