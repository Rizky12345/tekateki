@extends('../layout/head_link2')

@section('body_link')
<div class="control">
	<label class="radio">
		<input type="radio" name="answer" value="satuan" onclick="asd('saya')" checked>
		Jadwal saya
	</label>
	<label class="radio">
		<input type="radio" name="answer" value="semua" onclick="asd('semua')">
		Jadwal semua
	</label>
</div>
<br>
<div style="overflow:hidden;" id="jadwal_saya">
	<div class="columns is-multiline">
		@foreach($jadwal_kelas as $jadwal)
		<div class="column is-6 p-3">
			<div class="card" @if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) style="background: #f14668;" @endif @endif>
				<div class="card-header">
					<div class="card-header-title">

						<a href="{{ url('admin/jadwal/'.$jadwal->id) }}" @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) @if($jadwal->target != "Pemberitahuan") style="color: #363636;" @endif @endif>{{ $jadwal->name }}</a>
					</div>
				</div>
				<div class="card-content">
					@if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) (tanggal sudah lewat) <br><br> @endif @endif

					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Nama jadwal</label>
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
					
					
					
					@if($jadwal->target != 'Pemberitahuan')
					<div class="field is-horizontal">
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
					
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>

<div style="overflow:hidden;" class="is-hidden" id="jadwal_semua">
	<div class="columns is-multiline">
		@foreach($jadwal_semua as $jadwal)
		<div class="column is-6">
			<div class="card" @if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) style="background: #f14668;" @endif @endif>
				<div class="card-header">
					<div class="card-header-title">
						<a href="{{ url('admin/jadwal/'.$jadwal->id) }}" @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) @if($jadwal->target != "Pemberitahuan") style="color: #363636;" @endif @endif>{{ $jadwal->name }}</a>
					</div>
				</div>
				<div class="card-content">
					@if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) (tanggal sudah lewat) <br><br> @endif @endif
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
					
					@if($jadwal->target != 'Pemberitahuan')
					<div class="field is-horizontal">
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
		</div>
		@endforeach
	</div>
</div>
<script>
	function asd(type){
		var saya = document.getElementById('jadwal_saya');
		var semua = document.getElementById('jadwal_semua');
		if (type == "semua") {
			saya.classList.add('is-hidden');
			semua.classList.remove('is-hidden');
		}
		if (type == "saya") {
			saya.classList.remove('is-hidden');
			semua.classList.add('is-hidden');
		}
	}
</script>
@endsection