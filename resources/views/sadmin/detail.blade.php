@extends('../layout/head_link2')

@section('body_link')
@if(session('alert'))
<div class="notification {{ session('color') }}">
  {{ session('alert') }}
</div>
@endif
@can('admin')
@if($errors->first('password'))
<div class="notification is-danger">
  password harus di isi minimal 6 karakter
</div>
@endif
@endcan
@can('sadmin')
@if($errors->any())
<div class="notification is-danger">
  data selain password harus di isi, password di isi minimal 6 karakter, user_id minimal 10 karakter dan user_id tidak dapat duplikat
</div>
@endif
@endcan
<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Info user
		</div>
	</div>
	<div class="card-content">
		<form @can('admin') action="{{ url("admin/user/$user->user_id/$user->name/edit") }}" @endcan @can('sadmin') action="{{ url("s/admin/user/$user->user_id/$user->name/edit") }}" @endcan method="post">
			@csrf
			<div class="columns is-centered">
				<div class="column is-3">
					<figure class="image image is-square">
						@if($user->image == NULL)
						<img class="is-rounded" src="{{ asset('image/default.png') }}">
						@else
						<img class="is-rounded" src="{{ asset("storage/$user->image") }}">
						@endif
					</figure>
				</div>
			</div>
			<div class="columns is-multiline">
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Nama</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									@can('sadmin')
									<input class="input" type="text" placeholder="Masukkan Nama" value="{{ $user->name }}" name="name">
									@endcan
									@can('admin')
									<p class="mt-1">{{ $user->name }}</p>
									@endcan
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">User_id</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									@can('sadmin')
									<input class="input" type="text" placeholder="masukkan user_id"value="{{ $user->user_id }}" name="user_id">
									@endcan
									@can('admin')
									<p class="mt-1">{{ $user->user_id }}</p>
									@endcan
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Password</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input class="input" type="text" placeholder="masukkan password" name="password">
									<small>jika tidak mengganti password, kosongkan saja</small>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Kelas</label>
						</div>
						<div class="field-body">
							<div class="field">
								@can('sadmin')
								<div class="select">
									<select id="kelas" name="kelase">
										@foreach($kelases as $kelas)
										@if($kelas->id == Auth::user()->kelase_id)
										<option value="{{ $kelas->id }}" selected>{{ $kelas->kelas }}</option>
										@else
										<option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
										@endif
										@endforeach
									</select>
								</div>
								@endcan
								@can('admin')
								<p class="mt-1">{{ $user->kelase->kelas }}</p>
								@endcan
							</div>
						</div>
					</div>
				</div>
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Level</label>
						</div>
						<div class="field-body">
							<div class="field">
								@can('sadmin')
								<div class="select">
									<select name="level">
										<option value="user" @if($user->level == 'user') selected @endif>user</option>
										<option value="admin" @if($user->level == 'admin') selected @endif>admin</option>
										<option value="super admin" @if($user->level == 'super admin') selected @endif>super admin</option>
									</select>
								</div>
								@endcan
								@can('admin')
								<p class="mt-1">{{ $user->level }}</p>
								@endcan
							</div>
						</div>
					</div>
				</div>
				<div class="column is-12">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label"><button class="button">Edit</button></label>
						</div>
						<div class="field-body">
							<div class="field">

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</form>
</div>
@endsection