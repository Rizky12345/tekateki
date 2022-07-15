@extends('layout/head_link2')

@section('body_link')

@if($errors->any())
<div class="notification is-danger">
	Semua form harus di isi selain pilihan dan keterangan
</div>
@endif
@if(session('gagal'))
<div class="notification is-danger">
	{{session('gagal')}}
</div>
@endif
{{-- @dd(session('validate')['kkm']) --}}
<form @can('admin') action="{{ url('admin/ujian/create/process') }}" @endcan @can('sadmin') action="{{ url('s/admin/ujian/create/process') }}" @endcan method="POST">
	@csrf
	<div class="card">
		<div class="card-header">
			<div class="card-header-title">
				
			</div>
		</div>
		<div class="card-content">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Nama ujian</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input class="input" type="text" placeholder="Judul Ujian" name="judul" autocomplete="off" value="{{ session('validate') ? session('validate')['judul'] : old('judul') }}">
						</div>
					</div>
				</div>
			</div>
			@can('sadmin')
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Kelas</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="kelas" id="">
									<option value="" >Pilih Kelas</option>
									@foreach($kelases as $kelase)
									<option value="{{ $kelase->id }}" {{ session('validate')['kelas'] == $kelase->id ? 'selected' : (old('kelas') == $kelase->id ? 'selected' : '') }}>{{ $kelase->kelas }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endcan
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">KKM</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="kkm" id="" value="{{ old('kkm') }}">
									<option value="">Pilih KKM</option>
									<option value="50" @if(session('validate') != null && session('validate')['kkm'] == "50") selected @elseif(old('kkm') == 50) selected @endif>50</option>
									<option value="60" @if(session('validate') != null && session('validate')['kkm'] == "60") selected @elseif(old('kkm') == 60) selected @endif>60</option>
									<option value="65" @if(session('validate') != null && session('validate')['kkm'] == "65") selected @elseif(old('kkm') == 65) selected @endif>65</option>
									<option value="70" @if(session('validate') != null && session('validate')['kkm'] == "70") selected @elseif(old('kkm') == 70) selected @endif>70</option>
									<option value="75" @if(session('validate') != null && session('validate')['kkm'] == "75") selected @elseif(old('kkm') == 75) selected @endif>75</option>
									<option value="80" @if(session('validate') != null && session('validate')['kkm'] == "80") selected @elseif(old('kkm') == 80) selected @endif>80</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Semester</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="semester" id="">
									<option value="" @if(session('validate') != null && session('validate')['semester'] == "") selected @elseif(old('semester') == "") selected @endif>Pilih Semester</option>
									<option value="ganjil" @if(session('validate') != null && session('validate')['semester'] == "ganjil") selected @elseif(old('semester') == "ganjil") selected @endif>Ganjil</option>
									<option value="genap" @if(session('validate') != null && session('validate')['semester'] == "genap") selected @elseif(old('semester') == "genap") selected @endif>Genap</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Type ujian</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="type" id="">
									<option value="" @if(session('validate') != null && session('validate')['type'] == "") selected @elseif(old('type') == "") selected @endif>Pilih type</option>
									<option value="uas" @if(session('validate') != null && session('validate')['type'] == "uas") selected @elseif(old('type') == "uas") selected @endif>UAS</option>
									<option value="uts" @if(session('validate') != null && session('validate')['type'] == "uts") selected @elseif(old('type') == "uts") selected @endif>UTS</option>
									<option value="ulangan harian" @if(session('validate') != null && session('validate')['type'] == "ulangan harian") selected @elseif(old('type') == "ulangan harian") selected @endif>Ulangan Harian</option>
									<option value="latihan" @if(session('validate') != null && session('validate')['type'] == "latihan") selected @elseif(old('type') == "latihan") selected @endif>Latihan</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Mapel</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="mapel" id="">
									<option value="" @if(session('validate') != null && session('validate')['mapel'] == "") selected @elseif(old('mapel') == "") selected @endif>Pilih Mapel Ujian</option>
									@foreach($mapels as $mapel)
									<option value="{{ $mapel->id }}" @if(session('validate') != null && session('validate')['mapel'] == $mapel->id) selected @elseif(old('mapel') == $mapel->id) selected @endif>{{ $mapel->mapel }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Tahun ajaran</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input class="input" type="text" placeholder="tahun ajara" name="tahun_ajaran" autocomplete="off" value="{{ session('validate') ? session('validate')['tahun_ajaran'] : old('tahun_ajaran') }}">
							<small>Contoh penulisan: 2022/2023</small>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Status</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="status" id="">
									<option value="" @if(session('validate') != null && session('validate')['status'] == "") selected @elseif(old('status') == "") selected @endif>Pilih Status Ujian</option>
									<option value="lock" @if(session('validate') != null && session('validate')['status'] == "lock") selected @elseif(old('status') == "lock") selected @endif>Lock</option>
									<option value="disable" @if(session('validate') != null && session('validate')['status'] == "disable") selected @elseif(old('status') == "disable") selected @endif>Disable</option>
									<option value="enable" @if(session('validate') != null && session('validate')['status'] == "enable") selected @elseif(old('status') == "enable") selected @endif>Enable</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Tanggal mulai</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input type="datetime-local" class="input" name="ujiandatetime" >
							<small><li>Tanggal dan waktu ujian di buka untuk siswa</li></small>
							<small><li>Form ini tidak wajib di isi</li></small>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Waktu pengerjaan</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="time" id="">
									<option value="" @if(session('validate') != null && session('validate')['time'] == "") selected @elseif(old('time') == "") selected @endif>Pilih waktu</option>
									<option value="15" @if(session('validate') != null && session('validate')['time'] == "15") selected @elseif(old('time') == 15) selected @endif>15 menit</option>
									<option value="30" @if(session('validate') != null && session('validate')['time'] == "30") selected @elseif(old('time') == 30) selected @endif>30 menit</option>
									<option value="60" @if(session('validate') != null && session('validate')['time'] == "60") selected @elseif(old('time') == 60) selected @endif>60 menit</option>
									<option value="90" @if(session('validate') != null && session('validate')['time'] == "90") selected @elseif(old('time') == 90) selected @endif>90 menit</option>
								</select>
							</div><br>
							<small>Waktu pengerjaan ujian</small>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Jumlah soal</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<div class="select">
								<select name="soal" id="">
									<option value="" @if(session('validate') != null && session('validate')['soal'] == "") selected @elseif(old('soal') == "") selected @endif>Pilih Soal</option>
									<option value="5" @if(session('validate') != null && session('validate')['soal'] == "5") selected @elseif(old('soal') == "5") selected @endif>5</option>
									<option value="10" @if(session('validate') != null && session('validate')['soal'] == "10") selected @elseif(old('soal') == "10") selected @endif>10</option>
									<option value="15" @if(session('validate') != null && session('validate')['soal'] == "15") selected @elseif(old('soal') == "15") selected @endif>15</option>
									<option value="20" @if(session('validate') != null && session('validate')['soal'] == "20") selected @elseif(old('soal') == "20") selected @endif>20</option>
									<option value="30" @if(session('validate') != null && session('validate')['soal'] == "30") selected @elseif(old('soal') == "30") selected @endif>30</option>
									<option value="40" @if(session('validate') != null && session('validate')['soal'] == "40") selected @elseif(old('soal') == "40") selected @endif>40</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label">Keterangan</Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<textarea id="" cols="30" rows="10" class="textarea" style="resize: none; height: 115px;" placeholder="Keterangan" name="keterangan">{{ session('validate') ? session('validate')['keterangan'] : old('keterangan') }}</textarea>
							<small>Form ini tidak wajib di isi</small>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<Label class="label"><button class="button is-primary">Buat ujian</button></Label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br><br><br>
</div>
</form>
@endsection