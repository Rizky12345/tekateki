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
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			{{ $jadwal->name }}
		</div>
	</div>
	<div class="card-content">
		@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
		<form action="{{ url('s/admin/jadwal/'.$jadwal->id.'/edit/proccess') }}" method="post">
			@csrf
			@endif
			@if(Route::current()->uri == "s/admin/jadwal/{id}")
			<a href="{{ url("s/admin/jadwal/$jadwal->id/edit") }}"><button class="button is-info">Edit</button></a>
			@endif
			<br>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Nama jadwal</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
						<div class="control ">
							<input type="input" class="input" name="name" value="{{ $jadwal->name }}">
						</div>
						@else
						<div class="control mt-2">
							: {{ $jadwal->name }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Tanggal buat</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
						@else
						<div class="control mt-2">
							: {{ date('Y-m-d', strtotime("$jadwal->created_at")) }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Kelas</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
						<div class="control select">
							<select name="kelas" id="">
								<option value="">-- pilih kelas --</option>
								@foreach($kelases as $kelas)
								<option value="{{ $kelas->kelas }}" {{ $jadwal->kelas == $kelas->kelas ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
								@endforeach
								<option value="semua" {{ $jadwal->kelas == 'semua' ? 'selected' : '' }}>Semua kelas</option>
							</select>
						</div>
						@else
						<div class="control mt-2">
							: {{ $jadwal->kelas }}
						</div>
						@endif
					</div>
				</div>
			</div>
			
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Target</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">

						@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
						<div class="control select">
							<select name="target" id="target" onchange="asd()">
								<option value="">-- pilih target --</option>
								<option value="Pemberitahuan" {{ $jadwal->target == 'Pemberitahuan' ? 'selected' : '' }}>Pemberitahuan</option>
								<option value="Jadwal ujian UAS" {{ $jadwal->target == 'Jadwal ujian UAS' ? 'selected' : '' }}>Jadwal ujian UAS</option>
								<option value="Jadwal ujian UTS" {{ $jadwal->target == 'Jadwal ujian UTS' ? 'selected' : '' }}>Jadwal ujian UTS</option>
								<option value="Jadwal ujian ujian harian" {{ $jadwal->target == 'Jadwal ujian ujian harian' ? 'selected' : '' }}>Jadwal ujian</option>
							</select>
						</div>
						@else
						<div class="control mt-2">
							: {{ $jadwal->target }}
						</div>
						@endif

					</div>
				</div>
			</div>

			
			@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="tanggal">
				<div class="field-label is-normal">
					<label class="label">Tanggal akhir</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control ">
							<input type="date" class="input" name="tanggal" value="{{ $jadwal->tanggal }}">
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="mapel">
				<div class="field-label is-normal">
					<label class="label">Mapel</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="mapel" id="">
								<option value="">-- pilih mapel --</option>
								@foreach($mapels as $mapel)
								<option value="{{ $mapel->mapel }}" {{ $jadwal->mapel == $mapel->mapel ? 'selected' : '' }}>{{ $mapel->mapel }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="semester">
				<div class="field-label is-normal">
					<label class="label">Semester</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control select">
							<select name="semester" id="">
								<option value="">-- pilih semester --</option>
								<option value="ganjil" {{ $jadwal->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
								<option value="genap" {{ $jadwal->semester == 'genap' ? 'selected' : '' }}>Genap</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="tahun_ajaran">
				<div class="field-label is-normal">
					<label class="label">Tahun ajaran</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control">
							<input type="text" value="{{ $jadwal->tahun_ajaran }}" name="tahun_ajaran" class="input">
						</div>
					</div>
				</div>
			</div>
			@endif
			@if(Route::current()->uri == "s/admin/jadwal/{id}")
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="mapel">
				<div class="field-label is-normal">
					<label class="label">Mapel</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						
						<div class="control mt-2">
							: {{ $jadwal->mapel }}
						</div>
						
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="semester">
				<div class="field-label is-normal">
					<label class="label">Semester</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">

						<div class="control mt-2">
							: {{ $jadwal->semester }}
						</div>
						
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="tahun_ajaran">
				<div class="field-label is-normal">
					<label class="label">Tahun ajaran</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">

						<div class="control mt-2">
							: {{ $jadwal->tahun_ajaran }}
						</div>
						
					</div>
				</div>
			</div>
			<div class="field is-horizontal @if($jadwal->target == 'Pemberitahuan') is-hidden @endif" id="tanggal">
				<div class="field-label is-normal">
					<label class="label">Tanggal akhir</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control mt-2">
							: {{ $jadwal->tanggal }}
						</div>
					</div>
				</div>
			</div>
			@endif
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Catatan</label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
						<div class="control">
							<textarea class="textarea" name="catatan" cols="60">{{ $jadwal->catatan }}</textarea>
						</div>
						@else
						<div class="control mt-2">
							: {{ $jadwal->catatan }}
						</div>
						@endif
					</div>
				</div>
			</div>
			@if(Route::current()->uri == "s/admin/jadwal/{id}/edit")
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label"><button class="button is-primary">Submit</button></label>
				</div>
				<div class="field-body">
					<div class="field is-narrow">
						<div class="control mt-2">
						</div>
					</div>
				</div>
			</div>
		</form>
		@endif
	</div>
</div>
<br>
@if(Route::current()->uri == "s/admin/jadwal/{id}")
@if($jadwal->target != 'Pemberitahuan')
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Tabel {{ $jadwal->target }}
		</div>
	</div>
	<div class="card-content">
		<table class="table is-fullwidth" style="overflow-x: auto;">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Kode ujian</th>
					<th>Mapel</th>
					<th>Tanggal Buat</th>
				</tr>
			</thead>
			<tbody>
				{{-- @dd(!$sudahs->isEmpty()) --}}
				@if(!$sudahs->isEmpty())
				@foreach($sudahs as $sudah)
				<tr>
					<td>{{ ++$nomer }}</td>
					<td>{{ $sudah[0]->name }}</td>
					<td>{{ $sudah[0]->kelase->kelas }}</td>
					<td>{{ $sudah['code_ujian'] }}</td>
					<td>{{ $sudah['mapel'] }}</td>
					<td>{{ date('Y-m-d', strtotime($sudah['created_at'])) }}</td>
					
				</tr>
				@endforeach
				@endif
				{{-- @dd($sudahs2) --}}
			</tbody>
		</table>
	</div>
</div>
@endif
@endif
<script>
	function asd(){
		var target = document.getElementById("target").value;
		if (target == 'Pemberitahuan' ||  target == '') {
			document.getElementById("semester").classList.add('is-hidden');
			document.getElementById("tanggal").classList.add('is-hidden');
			document.getElementById("mapel").classList.add('is-hidden');
			document.getElementById("tahun_ajaran").classList.add('is-hidden');
		}else{
			document.getElementById("semester").classList.remove('is-hidden');
			document.getElementById("tanggal").classList.remove('is-hidden');
			document.getElementById("mapel").classList.remove('is-hidden');
			document.getElementById("tahun_ajaran").classList.remove('is-hidden');
		}
	}
</script>
<div style="height: 20vh;"></div>
@endsection