@extends('../layout/head_link2')

@section('body_link')
<section >
	<a href="{{ url('admin/ujian/create') }}">
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

	<div class="columns is-multiline is-12">
		@foreach($ujians as $ujian)
		<a href="{{ url('admin/ujian/'.$ujian->code) }}">
			<div class="column is-12">
				<div class="card">
					<div class="card-content">
						<strong class="title is-5">{{ $ujian->judul }}</strong><br>
						{{ $ujian->code }}
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>

	@endif
</section>
@endsection