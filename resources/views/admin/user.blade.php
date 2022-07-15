@extends('../layout/head_link2')

@section('body_link')
<style>
	.field-label{
		flex-grow: 0;
	}
	
</style>
@if($errors->first('user_id'))
@if($errors->first('user_id') == "The user id must be an integer.")
<div class="notification is-danger">
	user_id Harus Berupa Bilangan Bulat
</div>
@endif
@endif
@if(session('success'))
<div class="notification is-success">
	{{ session('success') }}
</div>
@endif
@if(session('failed'))
<div class="notification is-danger">
	{{ session('failed') }}
</div>
@endif
@if(session('alert'))
<div class="notification is-danger">
	{{ session('alert') }}
</div>
@endif
@if($errors->first('name') || $errors->first('password') || $errors->first('nim') || $errors->first('level'))
<div class="notification is-danger">
	Semua data harus di isi dan nim harus diisi menggunakan angka
</div>
@endif
<form action="{{ url('admin/user/proccess') }}" method="POST">
	@csrf
	<div class="card">
		<div class="card-head">
			<div class="card-header-title">
				Tambah user
			</div>
		</div>
		<div class="card-content">
			<div class="columns">
				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Name</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input class="input" type="text" placeholder="Masukkan Nama" name="name" autocomplete="off" value="{{ old('name') }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Password</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input class="input" type="text" placeholder="Masukkan password" name="sandi" autocomplete="off" value="{{ old('sandi') }}">
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="columns">
				<div class="column">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Id_user</label>
						</div>
						<div class="field-body">
							<div class="field">
								<div class="control">
									<input class="input" type="text" placeholder="Masukkan Nama user_id" name="user_id" autocomplete="off" value="{{ old('user_id') }}">
									<small class="is-small"><strong>harus di isi dengan bilangan bulat</strong></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<button class="button is-primary">Tambah</button>
				</div>
			</div>
		</div>
	</div>
</form>
<br>

<br>
<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Semua user
		</div>
	</div>
	<div class="card-content" style="overflow-x:auto;">
		@if(session('adaan'))
		<table class="table is-fullwidth is-hidden" id="all_user">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Id_user</th>
					<th>Kelas</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
				@php
				$count = 0;
				@endphp
				@foreach($users as $user)
				<tr>
					<div id="modal-js-example" class="modal">
						<div class="modal-background"></div>
						<div class="modal-content">
							<div class="box is-3 has-text-centered">
								<p class="title">Hapus Ujian?</p>
								<form action="{{ url("s/admin/user/destroy") }}" method="post">
									@csrf
									<input type="text" class="is-hidden" value="{{ $user->id }}" name="id">
									<button class="button is-danger">Hapus</button>
								</form>
							</div>
						</div>
					</div>
					<td>{{ ++$count }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->user_id }}</td>
					<td>{{ $user->kelase->kelas }}</td>
					<td>{{ $user->level }}</td>
					<td class="is-actions-cell">
						<div class="buttons is-right">
							<a href="{{ url("s/admin/user/$user->user_id/$user->name") }}">
								<button class="button is-small is-primary" type="button">
									<span class="icon"><i class="mdi mdi-eye"></i></span>
								</button>
							</a>
							<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">
								<span class="icon"><i class="mdi mdi-trash-can"></i></span>
							</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		

		<table class="table is-fullwidth" id="cari_user">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Id_user</th>
					<th>Kelas</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
				@php
				$cari = 0;
				@endphp
				<div id="modal-js-example" class="modal">
					<div class="modal-background"></div>
					<div class="modal-content">
						<div class="box is-3 has-text-centered">
							<p class="title">Hapus pengguna?</p>
							<form action="{{ url("s/admin/user/destroy") }}" method="post">
								@csrf
								<input type="text" class="is-hidden" value="{{ $user->id }}" name="id">
								<button class="button is-danger">Hapus</button>
							</form>
						</div>
					</div>
				</div>
				<tr>
					<td>{{ ++$cari }}</td>
					<td>{{ $satu->name }}</td>
					<td>{{ $satu->user_id }}</td>
					<td>{{ $satu->kelase->kelas }}</td>
					<td>{{ $satu->level }}</td>
					<td class="is-actions-cell">
						<div class="buttons is-right">
							<a href="{{ url("s/admin/user/$user->id/$user->name") }}">
								<button class="button is-small is-primary" type="button">
									<span class="icon"><i class="mdi mdi-eye"></i></span>
								</button>
							</a>
							<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">
								<span class="icon"><i class="mdi mdi-trash-can"></i></span>
							</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		@else
		<table class="table is-fullwidth" id="all_user">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Id_user</th>
					<th>Kelas</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
				@php
				$count = 0;
				@endphp
				@foreach($users as $user)
				
				<tr>
					<td>{{ ++$count }}</td>
					<div id="modal-js-example{{ $count }}" class="modal">
					<div class="modal-background"></div>
					<div class="modal-content">
						<div class="box is-3 has-text-centered">
							<p class="title">Hapus Ujian?</p>
							<form action="{{ url("s/admin/user/destroy") }}" method="post">
								@csrf
								<input type="text" class="is-hidden" value="{{ $user->id }}" name="id">
								<button class="button is-danger">Hapus</button>
							</form>
						</div>
					</div>
				</div>
					<td>{{ $user->name }}</td>
					<td>{{ $user->user_id }}</td>
					<td>{{ $user->kelase->kelas }}</td>
					<td>@if($user->level == 'user') Murid @elseif($user->level == 'admin') Guru @elseif($user->level == 'super admin') Administrator @endif</td>
					<td class="is-actions-cell">
						<div class="buttons is-right">
							<a href="{{ url("s/admin/user/$user->user_id/$user->name") }}">
								<button class="button is-small is-primary" type="button">
									<span class="icon"><i class="mdi mdi-eye"></i></span>
								</button>
							</a>
							<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $count }}">
								<span class="icon"><i class="mdi mdi-trash-can"></i></span>
							</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
		@if($count>2)
		<div><a href="{{ url('admin/user/murid') }}"><strong>Selengkapnya</strong></a></div>
		@endif
	</div>
</div>
<br><br><br><br>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
	function cari(){
		var jawaban =  $("input[type='radio'][name='pilih']:checked").val();
		if (jawaban == 'semua') {
			$('#all_user').removeClass('is-hidden');
			$('#cari_user').addClass('is-hidden');
		}else{
			$('#all_user').addClass('is-hidden');
			$('#cari_user').removeClass('is-hidden');
		}
	}
</script>
<script>
	document.addEventListener('DOMContentLoaded', () => {
  // Functions to open and close a modal
  function openModal($el) {
  	$el.classList.add('is-active');
  }

  function closeModal($el) {
  	$el.classList.remove('is-active');
  }

  function closeAllModals() {
  	(document.querySelectorAll('.modal') || []).forEach(($modal) => {
  		closeModal($modal);
  	});
  }

  // Add a click event on buttons to open a specific modal
  (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
  	const modal = $trigger.dataset.target;
  	const $target = document.getElementById(modal);
  	console.log($target);

  	$trigger.addEventListener('click', () => {
  		openModal($target);
  	});
  });

  // Add a click event on various child elements to close the parent modal
  (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
  	const $target = $close.closest('.modal');

  	$close.addEventListener('click', () => {
  		closeModal($target);
  	});
  });

  // Add a keyboard event to close all modals
  document.addEventListener('keydown', (event) => {
  	const e = event || window.event;

    if (e.keyCode === 27) { // Escape key
    	closeAllModals();
    }
});
});
</script>
@endsection