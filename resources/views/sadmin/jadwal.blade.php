@extends('../layout/head_link2')

@section('body_link')
@if(session('success'))
	<div class="notification is-success">
		{{ session('success') }}
	</div>
@endif
<style>
	.demo-1{
		overflow: hidden;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
	}
</style>
<div class="columns is-multiline">
	@foreach($jadwals as $jadwal)
	<div class="column is-6 p-3">
		<div class="card" @if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) style="background: #f14668;" @endif @endif>

			<div class="card-header">
				<div class="card-header-title">
					@if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) @if($jadwal->target != "Pemberitahuan") <a href="{{ url('s/admin/jadwal/'.$jadwal->id) }}" style="color: #363636;">{{ $jadwal->name }}</a> @endif
					@else
					<a href="{{ url('s/admin/jadwal/'.$jadwal->id) }}">{{ $jadwal->name }}</a>
					@endif
					
				</div>
			</div>
			<div class="card-content" style="color: #363636;">
				@if($jadwal->target != "Pemberitahuan") @if(date('Y-m-d',strtotime($jadwal->tanggal)) < date('Y-m-d',strtotime($time))) (tanggal sudah tenggat) <br><br> @endif @endif
				
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
				</div><div class="field is-horizontal">
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
				<div id="modal-js-example" class="modal">
						<div class="modal-background"></div>
						<div class="modal-content">
							<div class="box is-3 has-text-centered">
								<p class="title">Hapus Jadwal?</p>
								<form action="{{ url("s/admin/jadwal/destroy/$jadwal->id") }}" method="post">
									@csrf
									<input type="text" class="is-hidden" value="{{ $jadwal->id }}" name="id">
									<button class="button is-danger">Hapus</button>
								</form>
							</div>
						</div>
					</div>
				<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example">
					<span class="icon"><i class="mdi mdi-trash-can"></i></span>
				</button>
			</div>
		</div>
	</div>
	@endforeach
</div>

<div style="height: 20vh;"></div>
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