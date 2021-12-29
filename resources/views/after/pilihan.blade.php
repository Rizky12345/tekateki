
@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="hero">
	<div class="hero-head">
		<div class="navbar pt-5">
			<div class="container">
				<div class="navbar-brand">
					<h3 class="title">Hujan</h3>
				</div>
				<div class="navbar-end">
					<p class="navbar-item" id="now"></p>
					<p class="navbar-item">asdd</p>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-body">
		<div class="card pt-5 pb-5">
			<div class="container">
				<div class="navbar">
					<div class="navbar-end">
						<div id="countdown"></div>	
					</div>
				</div>
				<h1 class="title">Soal ke 5</h1>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, suscipit mollitia porro, cumque eum dignissimos. Illo praesentium asperiores rem tenetur, explicabo magni officia laudantium non natus, hic sint, perspiciatis eligendi vitae repudiandae quos sed voluptate mollitia exercitationem nesciunt modi. Vel qui commodi libero ipsa consequuntur, omnis tempora? Ipsam vitae, provident?</p><br>
				<div class="control">
					<label class="radio">
						<input name="pilih" value="pinguin" id="pilih" type="radio" onclick="funcctionName()">
						Pinguin
					</label><br>
					<label class="radio">
						<input name="pilih" id="pilih" value="Gajah" type="radio" onclick="funcctionName()">
						Gajah
					</label><br>
					<label class="radio">
						<input name="pilih" id="pilih" value="kuda" type="radio" onclick="funcctionName()">
						Kuda
					</label><br>
				</div>
				<a href="{{ session()->get("accept") }}/destroy"><button class="button is-dark">selesai</button></a>
			</div>
		</div>
	</div>
</div>
<div id="contentData"></div>
<div class="container">
	<div class="card">
		<div class="columns">
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>		
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
			<div class="column p-5 mt-3 mb-3 ml-5 card is-1 has-text-centered">1</div>
		</div>
	</div>
</div>
@csrf

<footer class="footer">
	<div class="content has-text-centered">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript">
	function funcctionName () {
		var jawaban =  $("input[type='radio'][name='pilih']:checked").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		jQuery.ajax({
			
			url: '{{ url("user/list/accept/simpanajax") }}',
			type: 'POST',
			data: {
				'jawaban': jawaban
			},
			success: function(data) {
			}
		});
       } 
   </script>

   <script src="../../../js/cd.js"></script>

   @endsection
