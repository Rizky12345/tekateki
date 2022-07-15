@extends('../layout/head_link2')

@section('body_link')
@can('sadmin')
@foreach($kelases as $kelas)
@if( (int)$kelas->kelas != 6 )
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Kelas {{ $kelas->kelas }}
		</div>
	</div>
	<div class="card-content">
		<div class="title">
			Kelas {{ $kelas->kelas }} <br><br>
			<a href="{{ url('s/admin/naik_kelas/'.$kelas->id) }}">
				<button class="button is-info">
					<span class="mdi mdi mdi-chevron-double-up"> Naik kelas</span>
				</button>
			</a>
		</div>
	</div>
</div>
@else
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Kelas {{ $kelas->kelas }}
		</div>
	</div>
	<div class="card-content">
		<div class="title">
			Kelas {{ $kelas->kelas }} <br><br>
			<a href="{{ url('s/admin/naik_kelas/'.$kelas->id) }}">
				<button class="button is-info">
					LULUS
				</button>
			</a>
		</div>
	</div>
</div>
@endif
@endforeach
@endcan
@endsection