@extends('../layout/head_link2')

@section('body_link')
@if(session('success'))
<div class="notification is-success">
	{{ session('success') }}
</div>
@endif
<section >
	<a href="{{ url('s/admin/ujian/create') }}">
		<button class="button">Buat Ujian</button>
	</a>
	<br>
	<br>


	@if($ujians->isEmpty())
	<div class="columns">
		<div class="column">
			<h1 class="title">Kosong</h1>
		</div>
	</div>
	@else

			<div class="card">
			<div class="card-head">
				<div class="card-header-title">
					Daftar Ujian
				</div>
			</div>
			<div class="card-content">
				<table class="table is-fullwidth">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Ujian</th>
					<th>Code</th>
					<th>Status</th>
					<th>Repeat</th>
				</tr>
			</thead>
			<tbody>
				@php
					$nomer=0;
					@endphp
				@foreach($ujians as $ujian)
				
				<tr>
					<td>{{ ++$nomer }}</td>
					<div id="modal-js-example{{ $nomer }}" class="modal">
						<div class="modal-background"></div>
						<div class="modal-content">
							<div class="box is-3 has-text-centered">
								<p class="title">Hapus Ujian?</p>
<form action="{{ url("s/admin/ujian/$ujian->code/destroy") }}" method="post">
								@csrf
								<input type="text" class="is-hidden" value="{{ $ujian->id }}" name="id">
									<button class="button is-danger">Hapus</button>
								</form>
							</div>
						</div>
					</div>
					<td>{{ $ujian->judul }}</td>
					<td>{{ $ujian->code }}</td>
					<td>{{ $ujian->status }}</td>
					<td>{{ $ujian->repeat }}</td>
					<td class="is-actions-cell">
						<div class="buttons is-right">
							<a href="{{ url("s/admin/ujian/$ujian->code") }}">
								<button class="button is-small is-primary" type="button">
									<span class="icon"><i class="mdi mdi-eye"></i></span>
								</button>
							</a>

								<button class="button is-small is-dark jb-modal" data-target="modal-js-example{{ $nomer }}">
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
		
		
		

	@endif
</section>
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