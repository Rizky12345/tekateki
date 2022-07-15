@extends('../layout/head_link2')

@section('body_link')
@if(session('failed'))
<div class="notification is-danger">
  {{ session('failed') }}
</div>
@endif
@if(session('success'))
<div class="notification is-success">
  {{ session('success') }}
</div>
@endif
<form @can('sadmin') action="{{ url('s/admin/naik_kelas/'.$kelas->id.'/upgrade') }}" @endcan @can('admin') action="{{ url('admin/naik_kelas/upgrade') }}" @endcan method="post">
	@csrf
	@if( (int)$kelas->kelas == 6)
	<button class="button is-primary">LULUS</button>
	@else
	<button class="button is-primary">Naik Kelas</button>
	@endif
	<a href="{{ url('s/admin/naik_kelas/'.$kelas->id.'/excel') }}">
		<button type="button" class="button is-info">Excel</button>
	</a>
	<br><br>
	<div class="columns">
		<div class="column is-4">
			<input type="password" name="password" class="input" placeholder="Masukkan Password">
		</div>
	</div>
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Kelas {{ $kelas->kelas }}
		</div>
	</div>
	<div class="card-content" style="overflow-x: auto;">
		<table class="table is-fullwidth">
			<thead>
				<tr>
					<th>No</th>
					<th>
						<label class="checkbox">
							<input type="checkbox" id="check">
						</label>
					</th>
					<th>user_id</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{ ++$count }}</td>
					<td>
						<label class="checkbox">
							<input type="checkbox" name="checkbox{{ $count }}" value="{{ $user->id }}">
						</label>
					</td>
					<td>{{ $user->user_id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->kelase->kelas }}</td>
					<td>{{ $user->level == "user" ? "Murid" : '' }}
						{{ $user->level == "admin" ? "Guru" : '' }}
						{{ $user->level == "super admin" ? "Administrator" : '' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<input type="text" class="is-hidden" value="{{ $count }}" name="max_count">
</form>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script>
	$('#check').click(function(){
		if (this.checked) {
			$(':checkbox').each(function(){
				this.checked = true;
			});
		}else{
			$(':checked').each(function(){
				this.checked = false;
			});
		}
	});
</script>
@endsection