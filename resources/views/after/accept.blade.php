@extends('../layout/head_link2')
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
			<h1 class="title">Code: {{ $ujian->code }}</h1>
			<p>Pelajaran: {{ $ujian->mapel->mapel }}</p>
			<p>Pembuat: {{ $ujian->user->name }}</p>
			<p>Keterangan: untuk mahasiswa informatika UMMI</p>
			<br><br>
			<strong>Dengan klik tombol ini anda menyetujui untuk mengerjakan ujian ini <br>	hingga selesai</strong><br><br>
<a href="{{ url('user/accept/choice/'.$ujian->code) }}">
				<button class="button is-dark">Accept</button>
</a>
		</div>
	</div>
</div>
<p class="navbar-item">asdd</p>
@endsection