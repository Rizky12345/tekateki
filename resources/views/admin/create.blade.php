@extends('layout/head_link2')

@section('body_link')
<form action="{{ url('admin/ujian/create/process') }}" method="POST">
	@csrf
	<div class="container">
		<br>
		<br>
		<h1 class="title">Buat Ujian</h1>
		<br>
		<div class="columns">
			<div class="column is-10">
				<div class="field">
					<label class="label">Judul Ujian</label>
					<div class="control">
						<input class="input" type="text" placeholder="Judul Ujian" name="judul" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column is-5">
				<div class="field">
					<label class="label">Jumlah Soal</label>
					<div class="control">
						<input class="input" type="text" placeholder="Jumlah Soal" name="soal" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="column is-5">
				<div class="field">
					<label class="label">Jumlah pilihan ganda</label>
					<div class="control">
						<input class="input" type="text" placeholder="Jumlah pilihan ganda" name="pilihan" autocomplete="off">
						<div style="line-height: 80%;">
							<small class="is-small">perhatian: jumlah pilihan ganda bisa di kosongkan atau di tambahkan saat di edit</small>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column is-10">
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
			<div class="column is-2">
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
			<div class="column is-3">
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
			<div class="column is-3">
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
			<div class="column is-4">
				<div class="field">
					<label class="label">Tanggal mulai</label>
					<div class="control">
						<input type="datetime-local" class="input" name="ujiandatetime">
					</div>
				</div>
			</div>
			<div class="column is-4">
				<div class="field">
					<label class="label">Waktu pengerjaan</label>
					<div class="control">
						<input type="number" class="input" placeholder="Waktu pengerjaan" name="time" autocomplete="off">
						<small class="is-small">satuan hitungan menit</small>
					</div>
				</div>
			</div>
		</div>
		<button class="button is-dark">Set</button>
		<br><br><br>
	</div>
</form>
@endsection