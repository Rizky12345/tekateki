@extends('../layout/head_link2')

@section('body_link')
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Jadwal {{ $jadwal->name }}
		</div>
	</div>
	<div class="card-content">
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Jadwal</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ $jadwal->name }}
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Tanggal buat</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ date('Y-m-d', strtotime("$jadwal->created_at")) }}
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Target</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ $jadwal->target }}
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Kelas</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ $jadwal->kelas }}
					</div>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
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
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">Tanggal tenggat</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ $jadwal->tanggal }}
					</div>
				</div>
			</div>
		</div>
		@if($jadwal->target != 'Pemberitahuan')
		<div class="field is-horizontal">
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
		<div class="field is-horizontal">
			<div class="field-label is-normal">
				<label class="label">mapel</label>
			</div>
			<div class="field-body">
				<div class="field is-narrow">
					<div class="control mt-2">
						: {{ $jadwal->mapel }}
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
					<div class="control mt-2" style=" overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
						: {{ $jadwal->catatan }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@if($jadwal->target != 'Pemberitahuan')
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Yang sudah mengerjakan tugas
		</div>
	</div>
	<div class="card-content" style="overflow-x: auto;">
		<table class="table is-fullwidth">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Code Ujian</th>
					<th>Mapel</th>
					<th>Tanggal buat</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sudahs as $sudah)
				<tr>
					<td>{{ ++$nomer }}</td>
					<td>{{ $sudah[0]->name }}</td>
					<td>{{ $sudah[0]->kelase->kelas }}</td>
					<td>{{ $sudah['code_ujian'] }}</td>
					<td>{{ $sudah['mapel'] }}</td>
					<td>{{ $sudah['created_at'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endif
@endsection