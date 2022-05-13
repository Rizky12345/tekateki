@extends('../layout/head_link2')

@section('body_link')
@if(session('success'))
<div class="notification is-success">
	{{ session('success') }}
</div>
@endif
<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Cari user
		</div>
	</div>
	<div class="card-content">
		<form action="{{ url('s/admin/user/cari') }}" method="post">
			@csrf
			<div class="columns">
				<div class="column">
					<label class="radio">
						<input name="type" value="id" id="semua" type="radio" onclick="choice('id')" checked>
						Id_user
					</label>
				</div>
				<div class="column">
					<label class="radio">
						<input name="type" value="kelas" id="semua" type="radio" onclick="choice('kelas')">
						kelas
					</label>
				</div>
				<div class="column">
					<label class="radio">
						<input name="type" value="level" id="semua" type="radio" onclick="choice('level')">
						level
					</label>
				</div>
			</div>
			<div class="field has-addons">
				<div class="control" id="id">
					<input class="input" type="text" placeholder="Cari user" name="id">
				</div>
				<div class="control is-hidden" id="kelas">
					<div class="select">
						<select name="kelas" id="">
							@foreach($kelases as $kelase)
							<option value="{{ $kelase->id }}">{{ $kelase->kelas }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="control is-hidden" id="level">
					<div class="select">
						<select name="level" id="">
							<option value="user">User</option>
							<option value="admin">Admin</option>
							<option value="super admin">Super admin</option>
						</select>
					</div>
				</div>
				<div class="control">
					<button class="button is-info">Cari</button>
				</div>
			</div>
		</form>
		@if(session('adaan'))
		@if(session('adaan')->isEmpty())
		<label class="radio">
			<input name="pilih" value="semua" id="semua" type="radio" onclick="cari('semua_pengguna','kosong')">
			lihat semua user
		</label>
		<label class="radio">
			<input name="pilih" value="satuan" id="satu" type="radio" onclick="cari('kosong','semua_pengguna')" @if(session('adaan')) checked @endif>
			lihat user yang di cari
		</label>
		@else
		<label class="radio">
			<input name="pilih" value="semua" id="semua" type="radio" onclick="cari('all_user','cari_user')">
			lihat semua user
		</label>
		<label class="radio">
			<input name="pilih" value="satuan" id="satu" type="radio" onclick="cari('cari_user','all_user')" @if(session('adaan')) checked @endif>
			lihat user yang di cari
		</label>
		@endif
		@endif
	</div>
</div>

<br>
<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Semua user
		</div>
	</div>
	<div class="card-content">


		@if(session('adaan'))
		@if(session('adaan')->isEmpty())
		<div class="columns" id="kosong">
			<div class="column has-text-centered">
				<h1 class="title"><strong>Pencarian tidak di temukan</strong></h1>
			</div>
			
		</div>
		<div class="columns is-hidden" id="semua_pengguna">
			<div class="column" style="overflow-x:auto;">
				<table class="table is-fullwidth" >
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
						<a href="">
							<tr>
								<td>{{ ++$count }}</td>
								<div id="modal-js-example{{ $count }}{{ $count }}{{ $count }}{{ $count }}{{ $count }}" class="modal">
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
								<td>{{ $user->level }}</td>
								<td class="is-actions-cell">
									<div class="buttons is-right">
										<a href="{{ url("s/admin/user/$user->user_id/$user->name") }}">
											<button class="button is-small is-primary" type="button">
												<span class="icon"><i class="mdi mdi-eye"></i></span>
											</button>
										</a>
										<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $count }}{{ $count }}{{ $count }}{{ $count }}{{ $count }}">
											<span class="icon"><i class="mdi mdi-trash-can"></i></span>
										</button>
									</div>
								</td>
							</tr>
						</a>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@else
		<div style="overflow-x:auto;">
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
							<td>{{ ++$count }}</td>
							<div id="modal-js-example{{ $count }}{{ $count }}{{ $count }}{{ $count }}" class="modal">
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
									<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $count }}{{ $count }}{{ $count }}{{ $count }}">
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
					$count_adaan = 0;
					@endphp

					@foreach(session('adaan') as $pengguna)
						<tr>
							<td>{{ ++$cari }}</td>
							<div id="modal-js-example{{ $cari }}{{ $cari }}{{ $cari }}" class="modal">
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
							<td>{{ $pengguna->name }}</td>
							<td>{{ $pengguna->user_id }}</td>
							<td>{{ $pengguna->kelase->kelas }}</td>
							<td>{{ $pengguna->level }}</td>
							<td class="is-actions-cell">
								<div class="buttons is-right">
									<a href="{{ url("s/admin/user/$pengguna->user_id/$pengguna->name") }}">
										<button class="button is-small is-primary" type="button">
											<span class="icon"><i class="mdi mdi-eye"></i></span>
										</button>
									</a>
									<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $cari }}{{ $cari }}{{ $cari }}">
										<span class="icon"><i class="mdi mdi-trash-can"></i></span>
									</button>
								</div>
							</td>
						</tr>
					@endforeach

				</tbody>
			</table>
		</div>
		@endif
		@else
		<div id="all_user" style="overflow-x:auto;">
			<table class="table is-fullwidth" id="all">
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
							<div id="modal-js-example{{ $count }}{{ $count }}" class="modal">
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
									<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $count }}{{ $count }}">
										<span class="icon"><i class="mdi mdi-trash-can"></i></span>
									</button>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
	</div>
</div>
<br><br><br><br>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
@if(session('adaan'))
@if(session('adaan')->isEmpty())
<script>
	function cari(value, value2){
		if(value == "kosong"){
			$(`#${value}`).removeClass('is-hidden');
			$(`#${value2}`).addClass('is-hidden');
		}
		if(value == "semua_pengguna"){
			$(`#${value}`).removeClass('is-hidden');
			$(`#${value2}`).addClass('is-hidden');
		}
	}
	
</script>
@else
<script>
	function cari(value, value2){
		if(value == "cari_user"){
			$(`#${value}`).removeClass('is-hidden');
			$(`#${value2}`).addClass('is-hidden');
		}
		if(value == "all_user"){
			$(`#${value}`).removeClass('is-hidden');
			$(`#${value2}`).addClass('is-hidden');
		}
	}
	
</script>
@endif
@endif
<script>
	function choice(value){
		if (value == 'id') {
			$('#id').removeClass('is-hidden');
			$('#kelas').addClass('is-hidden');
			$('#level').addClass('is-hidden');
		}
		if (value == 'kelas') {
			$('#id').addClass('is-hidden');
			$('#kelas').removeClass('is-hidden');
			$('#level').addClass('is-hidden');
		}
		if (value == 'level') {
			$('#id').addClass('is-hidden');
			$('#kelas').addClass('is-hidden');
			$('#level').removeClass('is-hidden');
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