@extends('../layout/head_link2')

@section('body_link')
@if(session('filter_alert'))
<div class="notification {{ session('color') }}">
	{{ session('filter_alert') }}
</div>
@endif
@if(session('success'))
<div class="notification is-success">
	{{ session('success') }}
</div>
@endif
<section >
	@can('admin')
	<a href="{{ url('admin/ujian/create') }}">
		<button class="button is-primary">Buat Ujian</button>
	</a>
	@endcan
	@can('sadmin')
	<a href="{{ url('s/admin/ujian/create') }}">
		<button class="button is-primary">Buat Ujian</button>
	</a>
	@endcan
	<br>
	<br>
@can('sadmin')
	<form action="{{ url('s/admin/ujian/filter') }}" method="post">
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
	@endcan
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
		<div class="card-content" style="overflow-x:auto;">
			<table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Ujian</th>
						<th>Pembuat</th>
						<th>Code</th>
						@can('sadmin') <th>Kelas</th> @endcan
						<th>Status</th>
						<th>Semester</th>
						<th>Type</th>
						<th>Tahun ajaran</th>
						<th>Tanggal Buat</th>
					</tr>
				</thead>
				<tbody>
					@php
					$nomer=0;
					@endphp
					@can('admin')
					@if(session('filters'))
					@foreach(session('filters') as $ujian)
					<tr>
						<td>{{ ++$nomer }}</td>
						<div id="modal-js-example{{ $nomer }}" class="modal">
							<div class="modal-background"></div>
							<div class="modal-content">
								<div class="box is-3 has-text-centered">
									<p class="title">Hapus Ujian?</p>
									<form action="{{ url("admin/ujian/$ujian->code/destroy") }}" method="post">
										@csrf
										<input type="text" class="is-hidden" value="{{ $ujian->id }}" name="id">
										<button class="button is-danger">Hapus</button>
									</form>
								</div>
							</div>
						</div>
						<td>{{ $ujian->judul }}</td>
						<td>{{ $ujian->user->name }}</td>
						<td>{{ $ujian->code }}</td>
						@can('sadmin') <td>{{ $ujian->Kelase->kelas }}</td> @endcan
						<td>{{ $ujian->status }}</td>
						<td>{{ $ujian->semester }}</td>
						<td>{{ $ujian->type }}</td>
						<td>{{ $ujian->tahun_ajaran }}</td>
						<td>{{ date('Y-m-d', strtotime($ujian->created_at)) }}</td>
						<td class="is-actions-cell">
							<div class="buttons is-right">
								<a href="{{ url("admin/ujian/$ujian->code") }}">
									<button class="button is-small is-primary" type="button">
										<span class="icon"><i class="mdi mdi-eye"></i></span>
									</button>
								</a>
								<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $nomer }}">
									<span class="icon"><i class="mdi mdi-trash-can"></i></span>
								</button>
							</div>
						</td>
					</tr>
					@endforeach
					@else
					@foreach($ujians as $ujian)
					<tr>
						<td>{{ ++$nomer }}</td>
						<div id="modal-js-example{{ $nomer }}" class="modal">
							<div class="modal-background"></div>
							<div class="modal-content">
								<div class="box is-3 has-text-centered">
									<p class="title">Hapus Ujian?</p>
									<form action="{{ url("admin/ujian/$ujian->code/destroy") }}" method="post">
										@csrf
										<input type="text" class="is-hidden" value="{{ $ujian->id }}" name="id">
										<button class="button is-danger">Hapus</button>
									</form>
								</div>
							</div>
						</div>
						<td>{{ $ujian->judul }}</td>
						<td>{{ $ujian->user->name }}</td>
						<td>{{ $ujian->code }}</td>
						@can('sadmin') <td>{{ $ujian->Kelase->kelas }}</td> @endcan
						<td>{{ $ujian->status }}</td>
						<td>{{ $ujian->semester }}</td>
						<td>{{ $ujian->type }}</td>
						<td>{{ $ujian->tahun_ajaran }}</td>
						<td>{{ date('Y-m-d', strtotime($ujian->created_at)) }}</td>
						<td class="is-actions-cell">
							<div class="buttons is-right">
								<a href="{{ url("admin/ujian/$ujian->code") }}">
									<button class="button is-small is-primary" type="button">
										<span class="icon"><i class="mdi mdi-eye"></i></span>
									</button>
								</a>
								<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $nomer }}">
									<span class="icon"><i class="mdi mdi-trash-can"></i></span>
								</button>
							</div>
						</td>
					</tr>
					@endforeach
					@endif
					@endcan
					
					@can('sadmin')
					@if(session('filters'))
					@foreach(session('filters') as $ujian)
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
						<td>{{ $ujian->user->name }}</td>
						<td>{{ $ujian->code }}</td>
						@can('sadmin') <td>{{ $ujian->Kelase->kelas }}</td> @endcan
						<td>{{ $ujian->status }}</td>
						<td>{{ $ujian->semester }}</td>
						<td>{{ $ujian->type }}</td>
						<td>{{ $ujian->tahun_ajaran }}</td>
						<td>{{ date('Y-m-d', strtotime($ujian->created_at)) }}</td>
						<td class="is-actions-cell">
							<div class="buttons is-right">
								<a href="{{ url("s/admin/ujian/$ujian->code") }}">
									<button class="button is-small is-primary" type="button">
										<span class="icon"><i class="mdi mdi-eye"></i></span>
									</button>
								</a>
								<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $nomer }}">
									<span class="icon">
										<i class="mdi mdi-trash-can"></i>
									</span>
								</button>
							</div>
						</td>
					</tr>
					@endforeach
					@else
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
						<td>{{ $ujian->user->name }}</td>
						<td>{{ $ujian->code }}</td>
						@can('sadmin') <td>{{ $ujian->Kelase->kelas }}</td> @endcan
						<td>{{ $ujian->status }}</td>
						<td>{{ $ujian->semester }}</td>
						<td>{{ $ujian->type }}</td>
						<td>{{ $ujian->tahun_ajaran }}</td>
						<td>{{ date('Y-m-d', strtotime($ujian->created_at)) }}</td>
						<td class="is-actions-cell">
							<div class="buttons is-right">
								<a href="{{ url("s/admin/ujian/$ujian->code") }}">
									<button class="button is-small is-primary" type="button">
										<span class="icon"><i class="mdi mdi-eye"></i></span>
									</button>
								</a>
								<button class="button is-small is-dark js-modal-trigger" data-target="modal-js-example{{ $nomer }}">
									<span class="icon">
										<i class="mdi mdi-trash-can"></i>
									</span>
								</button>
							</div>
						</td>
					</tr>
					@endforeach
					@endif
					@endcan
					
				</tbody>
			</table>
		</div>
	</div>
    @if(!session('filters'))
    {{ $ujians->render() }}
    @endif
	<div style="height:20vh;"></div>
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