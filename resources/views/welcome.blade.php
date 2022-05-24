<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ url('bulma/css/bulma.min.css') }}">
	<link rel="stylesheet" href="{{ url('costume.css') }}">
	<title>{{ $title }}</title>
</head>
<style>
	html, body{
		overflow-x: hidden !important;
		margin: 0px;
	}
</style>
<body style="overflow-x: hidden;">
	<div style=" overflow: hidden;">

		<div style="height: 120vh; width: 100%; background:#000000a6; position:absolute;" class="has-text-centered">
			<div class="columns is-flex is-vcentered" style="height:120vh; width: 100%; margin: 0px;">
				<div class="column">
					<h1 class="title has-text-white" style="text-shadow: 2px 2px 2px #0000006b;">
						Ujian Siswa <br> SD CBM Cipanengah Sukabumi</h1>
						<br>
						<figure class="image is-128x128" style="display: block;margin-left: auto;margin-right: auto;">
							<img src="{{ asset('image/cbm.png') }}">
						</figure>
						<br>
						<p class="has-text-white is-small">Login untuk melanjutkan:</p><br>
						<a href="{{ route('login') }}">
						<button class="button is-rounded is-medium is-link" style="width:200px;">Login</button></a>
					</div>
				</div>
			</div>

			<img src="{{ asset('image/4.jpg') }}" alt="" style="height: 120vh; width:100%;">

		</div>
	</div>
<div class="is-hidden-desktop">
	<br><br>
</div>
	<div class="container">
		<div class="columns is-flex is-vcentered has-text-centered-mobile" style="height:60vh;">
			<div class="column">
				<h1 class="title"><strong>Pemberitahuan</strong></h1>
				<p>Ada beberapa yang harus dilakukan sebelum belajar dan mengerjakan ujian:</p>
				<br><br>
				<ol>
					<li>Berdoa, terutama doa orang tua</li>
					<li>Belajar, yang paling bagus belajar di spertiga malam</li>
					<li>Jauhi hal yang di larang, terutama yang dilarang agama</li>
					<li>Paksakan, Paksakanlah di setiap kebaikan</li>
					<li>Tolong agama Allah, hidupkanlah sunnah sunnah dalam agama, dan Allah akan menolongmu</li>
				</ol>
				<br><br>
				<p>Semoga Allah memudahkan pekerjaanmu</p>
			</div>
		</div>
	</div>
	<footer class="footer has-text-centered" style="background: white;">
		<div class="content ">
			<p>
				<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
				<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
			</p>
		</div>
	</footer>
</body>
</html>