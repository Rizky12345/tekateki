@extends('../layout/head_link2')

@section('body_link')
@if(session('filter_alert'))
<div class="notification {{ session('color') }}">
	{{ session('filter_alert') }}
</div>
@endif
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Filter
		</div>
	</div>
	<div class="card-content">
		<form action="{{ url('s/admin/ujian/filter_nilai') }}" method="post">
		@csrf
		<div class="select">
			<select name="semester" id="">
				<option value="">--Filter Semester--</option>
				<option value="genap">Genap</option>
				<option value="ganjil">Ganjil</option>
			</select>
		</div>
		<div class="select">
			<select name="tahun" id="">
				<option value="">--Filter Tahun--</option>
				@foreach($tahuns as $tahun)
				<option value="{{ $tahun }}">{{ $tahun }}</option>
				@endforeach
			</select>
		</div>
		<button class="button is-info">Filter</button>
	</form>
	</div>
</div>
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Nilai ujian
		</div>
	</div>
	<div class="card-content">
		<table class="table is-fullwidth">
			<thead>
				<tr>
					<th>No</th>
					<th>User_id</th>
					<th>Nama</th>
					<th>Nama Ujian</th>
					<th>Nilai Ujian</th>
					<th>KKM Ujian</th>
					<th>Status Akhir</th>
				</tr>
			</thead>
			<tbody>
				@if(session('filters'))
				@foreach(session('filters') as $nilai)
				<tr>
					<td>{{ ++$count }}</td>
					<td>{{ $nilai->user->user_id }}</td>
					<td>{{ $nilai->user->name }}</td>
					<td>{{ $nilai->ujian->judul }}</td>
					<td>{{ $nilai->nilai }}</td>
					<td>{{ $nilai->ujian->kkm }}</td>
					<td>@if($nilai->nilai >= $nilai->ujian->kkm) lulus @else tidak lulus @endif</td>
					<td>
						<a href="{{ url("s/admin/ujian/".$nilai->ujian->code."/$nilai->user_id/".$nilai->id) }}">
							<button class="button is-small is-primary" type="button">
								<span class="icon"><i class="mdi mdi-eye"></i></span>
							</button>
						</a>
					</td>
				</tr>
				@endforeach
				@else
				@foreach($nilais as $nilai)
				<tr>
					<td>{{ ++$count }}</td>
					<td>{{ $nilai->user->user_id }}</td>
					<td>{{ $nilai->user->name }}</td>
					<td>{{ $nilai->ujian->judul }}</td>
					<td>{{ $nilai->nilai }}</td>
					<td>{{ $nilai->ujian->kkm }}</td>
					<td>@if($nilai->nilai >= $nilai->ujian->kkm) lulus @else tidak lulus @endif</td>
					<td>
						<a href="{{ url("s/admin/ujian/".$nilai->ujian->code."/$nilai->user_id/".$nilai->id) }}">
							<button class="button is-small is-primary" type="button">
								<span class="icon"><i class="mdi mdi-eye"></i></span>
							</button>
						</a>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection