@extends('layout/head_link2')

@section('body_link')

@if($errors->any())
	<div class="notification is-danger">
 	Semua form harus di isi selain pilihan dan keterangan
</div>
@endif

<form @can('admin') action="{{ url('admin/ujian/create/process') }}" @endcan @can('sadmin') action="{{ url('s/admin/ujian/create/process') }}" @endcan method="POST">
	@csrf
	<div class="container">
		<br>
		<br>
		<h1 class="title">Buat Ujian</h1>
		<br>
		<div class="columns">
			<div class="column">
				<div class="field">
					<label class="label">Judul Ujian</label>
					<div class="control">
						<input class="input" type="text" placeholder="Judul Ujian" name="judul" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="columns">
			@can('sadmin')
			<div class="column">
				<div class="field">
					<label class="label">Kelas</label>
					<div class="select">
						<select name="kelas" id="">
							<option value="">Pilih Kelas</option>
							@foreach($kelases as $kelase)
							<option value="{{ $kelase->id }}">{{ $kelase->kelas }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			@endcan
			<div class="column">
				<div class="field">
					<label class="label">KKM</label>
					<div class="select">
						<select name="kkm" id="">
							<option value="">Pilih KKM</option>
							<option value="50">50</option>
							<option value="60">60</option>
							<option value="65">65</option>
							<option value="70">70</option>
							<option value="75">75</option>
							<option value="80">80</option>
						</select>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label">Repeat</label>
					<div class="control pt-2">
						<label class="radio">
							<input type="radio" name="repeat" value="yes">
							Yes
						</label>
						<label class="radio">
							<input type="radio" name="repeat" value="no">
							No
						</label>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label">Status</label>
					<div class="select">
						<select name="status" id="">
							<option value="lock">Pilih Status Ujian</option>
							<option value="lock">Lock</option>
							<option value="disable">Disable</option>
							<option value="enable">Enable</option>
						</select>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label">Mapel</label>
					<div class="select">
						<select name="mapel" id="">
							<option value="">Pilih Mapel Ujian</option>
							@foreach($mapels as $mapel)
							<option value="{{ $mapel->id }}">{{ $mapel->mapel }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<div class="columns">
			<div class="column">
				<div class="field">
					<label class="label">Keterangan</label>
					<div class="control">
						<textarea id="" cols="30" rows="10" class="textarea" style="resize: none; height: 115px;" placeholder="Keterangan" name="keterangan"></textarea>
					</div>
				</div>
			</div>
		</div>

		
		<div class="columns">
			<div class="column is-2">
				<div class="field">
					<label class="label">Umum?</label>
					<div class="control pt-2">
						<label class="radio">
							<input type="radio" name="umum" value="yes">
							Yes
						</label>
						<label class="radio">
							<input type="radio" name="umum" value="no">
							No
						</label>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label">Tanggal mulai</label>
					<div class="control">
						<input type="datetime-local" class="input" name="ujiandatetime">
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label">Waktu pengerjaan</label>
					<div class="control">

						<div class="select">
							<select name="time" id="">
								<option value="">Pilih waktu</option>
								<option value="15">15 menit</option>
								<option value="30">30 menit</option>
								<option value="60">60 menit</option>
								<option value="90">90 menit</option>
							</select>
						</div><br>
					</div>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column is-3">
				<div class="field">
					<label class="label">Jumlah Soal</label>
					<div class="control">
						<div class="select">
							<select name="soal" id="">
								<option value="">Pilih Soal</option>
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="15">15</option>
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="column is-5">
				<div class="field">
					<label class="label">Jumlah pilihan ganda</label>
					<div class="control">
						<div class="select">
							<select name="pilihan" id="">
								<option value="">Pilih pilihan</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						</div>
						<div style="line-height: 80%;">
							<small class="is-small">perhatian: jumlah pilihan ganda bisa di kosongkan dengan memilih pilihan paling atas</small>
						</div>
					</div>
				</div>
			</div>
		</div>
		<button class="button is-dark">Set</button>
		<br><br><br>
	</div>
</form>
@endsection