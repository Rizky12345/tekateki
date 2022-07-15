@extends('../layout/head_link2')

@section('body_link')
@if($errors->any())
<div class="notification is-danger">
	Data gagal di simpan
</div>
@endif
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
<form action="{{ url('s/admin/jadwal/create/proccess') }}" method="post" autocomplete="off">
	@csrf
	<div class="card">
		<div class="card-header">
			<div class="card-header-title">
				Buat jadwal
			</div>
		</div>
		<div class="card-content">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Nama jadwal</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input type="input" class="input" name="name" value="{{ old('name') }}">
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Kelas</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="kelas" id="">
								<option value="">-- pilih kelas --</option>
								@foreach($kelases as $kelas)
								<option value="{{ $kelas->kelas }}" {{ old('kelas') == $kelas->kelas ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
								@endforeach
								<option value="semua" {{ old('kelas') == 'semua' ? 'selected' : '' }}>Semua kelas</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Target</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="target" id="target" onchange="asd()">
								<option value="">-- pilih target --</option>
								<option value="Pemberitahuan" {{ old('target') == 'Pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
								<option value="Jadwal ujian UAS" {{ old('target') == 'Jadwal ujian UAS' ? 'selected' : '' }}>Jadwal ujian UAS</option>
								<option value="Jadwal ujian UTS" {{ old('target') == 'Jadwal ujian UTS' ? 'selected' : '' }}>Jadwal ujian UTS</option>
								<option value="Jadwal ujian ujian harian" {{ old('target') == 'Jadwal ujian ujian harian' ? 'selected' : '' }}>Jadwal ujian ujian harian</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal is-hidden"  id="semester">
				<div class="field-label is-normal">
					<Label class="label">Semester</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="semester" id="">
								<option value="">-- pilih Semester --</option>
								<option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
								<option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal is-hidden" id="tahun_ajaran">
				<div class="field-label is-normal">
					<Label class="label">Tahun ajaran</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input type="text" class="input" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}">
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal is-hidden" id="tanggal">
				<div class="field-label is-normal">
					<Label class="label">Tanggal akhir</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input type="date" class="input" name="tanggal">
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal is-hidden"  id="mapel">
				<div class="field-label is-normal">
					<Label class="label">Mapel</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="mapel">
								<option value="">-- pilih mapel --</option>
								@foreach($mapels as $mapel)
								<option value="{{ $mapel->mapel }}" {{ old('mapel') == $mapel->mapel ? 'selected' : '' }}>{{ $mapel->mapel }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Catatan</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<textarea class="textarea" name="catatan" cols="60" >{{ old('catatan') }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<button class="button is-info">Submit</button>
		</div>
	</div>
</form>
<script>
	function asd(){
		var target = document.getElementById("target").value;
		if (target == 'Pemberitahuan' ||  target == '') {
			document.getElementById("mapel").classList.add('is-hidden');
			document.getElementById("semester").classList.add('is-hidden');
			document.getElementById("tanggal").classList.add('is-hidden');
			document.getElementById("tahun_ajaran").classList.add('is-hidden');
		}else{
			document.getElementById("mapel").classList.remove('is-hidden');
			document.getElementById("semester").classList.remove('is-hidden');
			document.getElementById("tanggal").classList.remove('is-hidden');
			document.getElementById("tahun_ajaran").classList.remove('is-hidden');
		}
	}
</script>
{{-- <script>
	var arr = [
	[2,1,3],
	[1,4,3],
	[2,4,3]
	];
	var hasil = [];
	var hitung = [];
	var arr2 = [];
	var arr3 = [];
	for(var i = 0; i<arr.length; i++){
		for(var x = 0; x<arr[i].length-1; x++){
			var proses = arr[i][2]-arr[i][x];
			if (proses<0) {
				proses = Math.abs(proses);
			}
			hasil.push(proses);
		}
		arr2.push(hasil);
		hasil=[];

		if (arr2[i][0] < arr2[i][1]) {
			arr3.push('indexA');
		}
		if (arr2[i][0] > arr2[i][1]) {
			arr3.push('indexB');
		}
		if (arr2[i][0] == arr2[i][1]) {
			arr3.push('indexC');
		}
	}
	for (var z = 0; z < arr3.length; z++) {
		console.log(arr3[z]);
	}
</script> --}}
<div style="height: 20vh;"></div>
@endsection