@extends('../layout/head_link2')

@section('body_link')
@if(session('success'))
<div class="notification is-success">
	{{ session('success') }}
</div>
@endif
@if(session('gagal'))
<div class="notification is-danger">
	{{ session('gagal') }}
</div>
@endif
@if(session('ujian'))
<div class="notification is-danger">
	{{ session('ujian') }}
</div>
@endif
@if($errors->any())
<div class="notification is-danger">
	Lengkapi semua data
</div>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="position: fixed; z-index: 9999; left: 0px; right: 0px; width: 100%; top: 0px; display: none;" id="load">
	<div style="margin:auto; display: table; background: #00000091; color:white; padding:10px 20px;">Pending</div>
</div>
@php
$i = 0;
@endphp
<div class="container mt-5">
	<div class="columns">
		<div class="column">
			@can('admin')
			<a href="{{ url('admin/ujian/'.$ujian->code.'/edit') }}">
				<button class="button mr-3 is-primay">Edit soal</button>
			</a>
			<a href="{{ url('admin/ujian/'.$ujian->code.'/docs') }}">
				<button class="button mr-3 is-info">Docs</button>
			</a>
			@endcan
			@can('sadmin')
			<a href="{{ url('s/admin/ujian/'.$ujian->code.'/edit') }}">
				<button class="button mr-3 is-primay">Edit soal</button>
			</a>
			<a href="{{ url('s/admin/ujian/'.$ujian->code.'/docs') }}">
				<button class="button mr-3 is-info">Docs</button>
			</a>
			@endcan
			@can('admin')
			<a href="{{ url("admin/ujian/$ujian->code/tester") }}">
				<button class="button is-dark">Tester</button>
			</a>
			@endcan
			@can('sadmin')
			<a href="{{ url("s/admin/ujian/$ujian->code/tester") }}">
				<button class="button is-dark">Tester</button>
			</a>
			@endcan
		</div>
	</div>
	<form @can('admin') action="{{ url("admin/ujian/".$ujian->code."/timeujian") }}" @endcan action="{{ url("s/admin/ujian/".$ujian->code."/timeujian") }}" @can('sadmin') @endcan method="post">
		@csrf
		<div class="card">
			<div class="card-title">
				<div class="card-header-title">
					Edit Ujian
				</div>
			</div>
			<div class="card-content">
				<div class="columns is-multiline">
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Judul Ujian</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<input class="input" type="text" placeholder="Masukkan judul ujian" value="{{ $ujian->judul }}" name="judul">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Tahun ajaran</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<input class="input" type="text" placeholder="Masukkan judul ujian" value="{{ $ujian->tahun_ajaran }}" name="tahun_ajaran">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Mapel</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<div class="select">
											<select name="mapel" id="mapel">
												<option value="">--Pilih Mapel--</option>
												@foreach($mapels as $mapel)
												<option value="{{ $mapel->id }}" {{ $ujian->mapel_id == $mapel->id ? 'selected' : '' }}>{{ $mapel->mapel }}</option>
												@endforeach
											</select>
										</div>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Semester</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<div class="select">
											<select name="semester" id="">
												<option value="" {{ $ujian->semester == null ? 'selected' : '' }}>Pilih Semester</option>
												<option value="ganjil" {{ $ujian->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
												<option value="genap" {{ $ujian->semester == 'genap' ? 'selected' : '' }}>Genap</option>
											</select>
										</div>
									</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">KKM</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<div class="select" onclick="kkm()">
											<select name="kkm" id="kkm" onclick="kkm()">
												<option value="50" @if($ujian->kkm == 50) selected @endif>50</option>
												<option value="60" @if($ujian->kkm == 60) selected @endif>60</option>
												<option value="65" @if($ujian->kkm == 65) selected @endif>65</option>
												<option value="70" @if($ujian->kkm == 70) selected @endif>70</option>
												<option value="75" @if($ujian->kkm == 75) selected @endif>75</option>
												<option value="80" @if($ujian->kkm == 80) selected @endif>80</option>
											</select>
										</div>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Type Ujian</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<div class="select">
											<select name="type" id="" >
												<option value="" {{ $ujian->type == "" ? 'selected' : '' }}>Pilih type</option>
												<option value="uas" {{ $ujian->type == "uas" ? 'selected' : '' }}>UAS</option>
												<option value="uts" {{ $ujian->type == "uts" ? 'selected' : '' }}>UTS</option>
												<option value="ulangan harian" {{ $ujian->type == "ulangan harian" ? 'selected' : '' }}>Ulangan Harian</option>
												<option value="latihan" {{ $ujian->type == "latihan" ? 'selected' : '' }}>Latihan</option>
											</select>
										</div>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Waktu Mulai</label>
							</div>
							<div class="field-body">
								<div class="field">
									@php
									$date = date('Y-m-d', strtotime($ujian->time->date_time));
									$time = date('H:i:s', strtotime($ujian->time->date_time));
									@endphp
									<p class="control pt-2">
										@if($ujian->time->date_time ==  null)
										<input type="datetime-local" class="input" value="" name="timeujian">
										@else
										<input type="datetime-local" class="input" value="{{ $date }}T{{ $time }}" name="timeujian">
										@endif
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Waku Ujian</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<div class="select">
											<select name="timeupdate">
												<option value="15" @if($ujian->time->time == 15) selected @endif>15</option>
												<option value="30" @if($ujian->time->time == 30) selected @endif>30</option>
												<option value="60" @if($ujian->time->time == 60) selected @endif>60</option>
												<option value="90" @if($ujian->time->time == 90) selected @endif>90</option>
											</select>
										</div>
									</div>
								</p>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Kelas</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control pt-2">
										<div class="select">
											<select id="kelas" onclick="qweqwe()">
												@foreach($kelases as $kelas)
												@if($kelas->id == $ujian->kelase_id)
												<option value="{{ $kelas->id }}" selected>{{ $kelas->kelas }}</option>
												@else
												<option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
												@endif
												@endforeach
											</select>
										</div>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Status Ujian</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control pt-2">
										<label class="radio">
											<input name="pilih" value="enable" id="pilih" type="radio" onclick="funcctionName('{{ $ujian->id }}')" @if($ujian->status == "enable") checked @endif>
											enable
										</label>
										<label class="radio">

											<input name="pilih" value="disable" id="pilih" type="radio" onclick="funcctionName('{{ $ujian->id }}')" @if($ujian->status == "disable") checked @endif>
											Disable
										</label>
										<label class="radio">
											<input name="pilih" value="lock" id="pilih" type="radio" onclick="funcctionName('{{ $ujian->id }}')" @if($ujian->status == "lock") checked @endif>
											Lock
										</label>
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-12">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label"><button class="button is-primary">set</button></label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control pt-2">

									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@error('timeupdate')
<div class="">gagal</div>
@enderror

<br>

@foreach($soals as $soal)
<div class="columns">
	<div class="card column is-12">
		<div class="card-content">
			<h1 class="title">{{ ++$i }}</h1>
			<p class="subtitle">{{ $soal->soal }}</p>
			@if($soal->image)
			<img src="{{ asset("storage/$soal->image") }}" alt="">
			<br>
			<br>
			<br>
			@endif
			{{-- @dump($soal->type = "pilihan") --}}
			@if($soal->type == "pilihan")
			@foreach($pilihans as $pilihan)
			@if($pilihan->soal_id == $soal->id)
			<label class="radio">
				
				<input name="" value="{{ $pilihan->pilihan }}" id="pilih" type="radio" disabled @if($kuncis->contains($pilihan->id)) checked @endif >
				{{ $pilihan->pilihan }}

			</label><br>
			@if($pilihan->image)
			<img src="{{ asset("storage/$pilihan->image") }}" alt=""><br>
			@endif
			@endif
			@endforeach
			@endif
		</div>
	</div>
</div><br>
@endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
@can('admin')
<script>
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
	function funcctionName (id) {
		var value =  $("input[type='radio'][name='"+`pilih`+"']:checked").val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/status") }}',
			data: {
				'ujian_id': id,
				'value': value,
			},
			success: function(data) {
				
			}
		});

	} 
	function qweqwe () {
		var value =  $('#kelas').find(":selected").text()

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/kelas") }}',
			data: {
				'value': value,
			},
			success: function(data) {
				
			}
		});
	} 
	function kkm() {
		var value =  $('#kkm').find(":selected").text()

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/$ujian->code/kkm") }}',
			data: {
				'value': value,
			},
			success: function(data) {
				
			}
		});
	} 
	
</script>
@endcan
@can('sadmin')
<script>
	
	function kkm() {
		var value =  $('#kkm').find(":selected").text()

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/$ujian->code/kkm") }}',
			data: {
				'value': value,
			},
			success: function(data) {
				
			}
		});
	} 
	function judul(){
		var judul = $('#judul').val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/$ujian->code/judul") }}',
			data: {
				'judul': judul,
			},
			success: function(data) {

			}
		});
	}
	function funcctionName (id) {
		var value =  $("input[type='radio'][name='"+`pilih`+"']:checked").val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/$ujian->code/status") }}',
			data: {
				'ujian_id': id,
				'value': value,
			},
			success: function(data) {
				
			}
		});

	} 
	function qweqwe () {
		var value =  $('#kelas').find(":selected").text();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/$ujian->code/kelas") }}',
			data: {
				'value': value,
			},
			success: function(data) {
				
			}
		});

	} 
	
</script>
@endcan


@endsection