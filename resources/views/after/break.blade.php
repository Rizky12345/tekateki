@extends('../layout/head_link')
@section('body_link')
<div class="hero is-medium">
	<div class="hero-head pt-5">
		<div class="navbar">
			<div class="container">
				<div class="navbar-brand">
					<a href="/">Hujan</a>
				</div>
				<div class="navbar-end">
					<div class="navbar-item" id="now"></div>
					<div class="navbar-item">gyjg</div>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-body">
		<div class="container has-text-centered">
			<h1 class="title">Anda sudah mengerjakan Ujian ini</h1>
			<p></p>

			<br><br>
			<p>Klik tombol ini untuk ke halaman utama</p><br>
			<a href="{{ url('user') }}" >
				<button class="button is-dark">Home</button>
			</a>
		</div>
	</div>
</div>
@endsection