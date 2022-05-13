@extends('../layout/head_link2')

@section('body_link')
@if(session('alert'))
<div class="notification {{ session('color') }}">
	{{ session('alert') }}
</div>
@endif
@can('admin')
@if($errors->first('image'))
<div class="notification is-danger">
	file harus gambar yang sizenya kurang dari 2MB
</div>
@endif
@if(session('info'))
<div class="notification {{ session('color') }}">
	{{ session('info') }}
</div>
@endif
@endcan
@can('sadmin')
@if($errors->any())
<div class="notification is-danger">
	data selain password dan image harus di isi, password di isi minimal 6 karakter, user_id minimal 10 karakter, image tidak boleh lebih dari 2MB dan user_id tidak dapat duplikat
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
		<form @can('admin') action="{{ url("admin/user/$user->user_id/$user->name/edit") }}" @endcan @can('sadmin') action="{{ url("s/admin/user/$user->user_id/$user->name/edit") }}" @endcan method="post" enctype="multipart/form-data">
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
									<input class="input" type="password" placeholder="masukkan password" name="password">
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
										@if($kelas->id == $user->kelase->id)
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
								@if(Auth::user()->id == $user->id)
								<input type="text" class="is-hidden" name="level" value="{{ $user->level }}">
								<div class="select">
									<select name="level" disabled>
										<option value="user" @if($user->level == 'user') selected @endif>user</option>
										<option value="admin" @if($user->level == 'admin') selected @endif>admin</option>
										<option value="super admin" @if($user->level == 'super admin') selected @endif>super admin</option>
									</select>
								</div>
								@else
								<div class="select">
									<select name="level">
										<option value="user" @if($user->level == 'user') selected @endif>user</option>
										<option value="admin" @if($user->level == 'admin') selected @endif>admin</option>
										<option value="super admin" @if($user->level == 'super admin') selected @endif>super admin</option>
									</select>
								</div>
								@endif
								
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
							<label class="label">Image</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<div id="file-js-example" class="file has-name">
										<label class="file-label">
											<input class="file-input" type="file" name="image">
											<span class="file-cta">
												<span class="file-icon">
													<i class="mdi mdi-upload"></i>
												</span>
												<span class="file-label">
													Choose a file…
												</span>
											</span>
											<span class="file-name">
												No file uploaded
											</span>
										
									</div>
									<small>jika tidak mengganti gambar, kosongkan saja</small>
								</p>
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
<script>
	const fileInput = document.querySelector('#file-js-example input[type=file]');
	fileInput.onchange = () => {
		if (fileInput.files.length > 0) {
			const fileName = document.querySelector('#file-js-example .file-name');
			fileName.textContent = fileInput.files[0].name;
		}
	}
</script>
@endsection