@extends('../layout/head_link2')

@section('body_link')
@if($errors->any())
<div class="notification is-danger">
Form harus di isi
</div>
@endif
@if(session('success'))
<div class="notification is-success">
{{ session('success') }}
</div>
@endif
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Tambah Mapel
		</div>
	</div>
	<div class="card-content">
		<form action="{{ url('s/admin/mapel/tambah') }}" method="post">
			@csrf
			<div class="columns ">
				<div class="column is-4">
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label for="" class="label">Masukkan Mapel</label>
						</div>
						<div class="control">
							<input type="text" class="input" name="mapel"> 
						</div>
					</div>
				</div>
				<div class="column">
					<div class="field is-horizontal">
						<div class="control">
							<button class="button is-primary">SET</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<br>
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Mapel
		</div>
	</div>
	<div class="card-content">
		<table class="table is-fullwidth is-striped
">
			<thead>
				<tr>
					<th>No</th>
					<th>Mapel</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($mapels as $mapel)
				<tr>
					<div id="modal-js-example" class="modal">
						<div class="modal-background"></div>
						<div class="modal-content">
							<div class="box is-3 has-text-centered">
								<p class="title">Hapus mapel?</p>
								<form action="{{ url("s/admin/mapel/destroy") }}" method="post">
									@csrf
									<input type="text" class="is-hidden" value="{{ $mapel->id }}" name="id">
									<button class="button is-danger">Hapus</button>
								</form>
							</div>
						</div>
					</div>
					<td>{{ ++$nomer }}</td>
					<td>{{ $mapel->mapel }}</td>
					<td class="is-actions-cell">
						<div class="buttons is-right">
							<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">
								<span class="icon"><i class="mdi mdi-trash-can"></i></span>
							</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
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