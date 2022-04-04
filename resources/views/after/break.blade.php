@extends('../layout/head')
@section('body_link')
<div class="hero is-medium">
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title">Anda sudah mengerjakan Ujian ini</h1>
			<p></p>

			<br><br>
			<p>Klik tombol ini untuk ke halaman utama</p><br>
			@can('user')
			<a href="{{ url('user') }}" >
				<button class="button is-dark">Home</button>
			</a>
			@endcan
			@can('admin')
			<a href="{{ url('admin') }}" >
				<button class="button is-dark">Home</button>
			</a>
			@endcan
			@can('sadmin')
			<a href="{{ url('s/admin') }}" >
				<button class="button is-dark">Home</button>
			</a>
			@endcan
		</div>
	</div>
</div>
@endsection