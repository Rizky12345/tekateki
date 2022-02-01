@extends('../layout/head')

@section('head_link')
<div class="hero-body is-hidden-mobile">
	<svg class="absolute is-hidden-mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
		<path fill="#273036" fill-opacity="0.7" d="M0,224L6.2,192C12.3,160,25,96,37,112C49.2,128,62,224,74,240C86.2,256,98,192,111,138.7C123.1,85,135,43,148,32C160,21,172,43,185,74.7C196.9,107,209,149,222,165.3C233.8,181,246,171,258,176C270.8,181,283,203,295,186.7C307.7,171,320,117,332,112C344.6,107,357,149,369,181.3C381.5,213,394,235,406,218.7C418.5,203,431,149,443,160C455.4,171,468,245,480,234.7C492.3,224,505,128,517,90.7C529.2,53,542,75,554,117.3C566.2,160,578,224,591,240C603.1,256,615,224,628,197.3C640,171,652,149,665,165.3C676.9,181,689,235,702,250.7C713.8,267,726,245,738,208C750.8,171,763,117,775,117.3C787.7,117,800,171,812,176C824.6,181,837,139,849,133.3C861.5,128,874,160,886,181.3C898.5,203,911,213,923,208C935.4,203,948,181,960,181.3C972.3,181,985,203,997,229.3C1009.2,256,1022,288,1034,272C1046.2,256,1058,192,1071,144C1083.1,96,1095,64,1108,48C1120,32,1132,32,1145,32C1156.9,32,1169,32,1182,74.7C1193.8,117,1206,203,1218,229.3C1230.8,256,1243,224,1255,197.3C1267.7,171,1280,149,1292,170.7C1304.6,192,1317,256,1329,240C1341.5,224,1354,128,1366,117.3C1378.5,107,1391,181,1403,202.7C1415.4,224,1428,192,1434,176L1440,160L1440,320L1433.8,320C1427.7,320,1415,320,1403,320C1390.8,320,1378,320,1366,320C1353.8,320,1342,320,1329,320C1316.9,320,1305,320,1292,320C1280,320,1268,320,1255,320C1243.1,320,1231,320,1218,320C1206.2,320,1194,320,1182,320C1169.2,320,1157,320,1145,320C1132.3,320,1120,320,1108,320C1095.4,320,1083,320,1071,320C1058.5,320,1046,320,1034,320C1021.5,320,1009,320,997,320C984.6,320,972,320,960,320C947.7,320,935,320,923,320C910.8,320,898,320,886,320C873.8,320,862,320,849,320C836.9,320,825,320,812,320C800,320,788,320,775,320C763.1,320,751,320,738,320C726.2,320,714,320,702,320C689.2,320,677,320,665,320C652.3,320,640,320,628,320C615.4,320,603,320,591,320C578.5,320,566,320,554,320C541.5,320,529,320,517,320C504.6,320,492,320,480,320C467.7,320,455,320,443,320C430.8,320,418,320,406,320C393.8,320,382,320,369,320C356.9,320,345,320,332,320C320,320,308,320,295,320C283.1,320,271,320,258,320C246.2,320,234,320,222,320C209.2,320,197,320,185,320C172.3,320,160,320,148,320C135.4,320,123,320,111,320C98.5,320,86,320,74,320C61.5,320,49,320,37,320C24.6,320,12,320,6,320L0,320Z"></path>
	</svg>


	<div class="container has-text-centered">
		<div class="subtitle">Code Unique</div>
		<form action="create" action="post">
			<input type="text" class="input is-rounded has-text-centered w-50">

			<br><br>
			<button class="button is-dark">Submit</button>
		</form>

		<br><br><br>
		<div class="small has-text-danger">"Code tidak di temukan"</div>
	</div>
</div>

<section class="hero-mobile is-hidden-desktop">
	<div class="hero-body">
		<div class="container has-text-centered">
			<div class="subtitle ">Code Unique</div>
			<form action="create" action="post">
				<input type="text" class="input is-rounded has-text-centered w-50">

				<br><br>
				<button class="button is-dark">Submit</button>
			</form>

			<br>
			<div class="small has-text-danger">"Code tidak di temukan"</div>
		</div>
	</div>
</section>

@endsection
@section('body_link')
<div class="container is-hidden-mobile">
	<h1 class="title">List</h1>
	<div class="columns is-multiline">
		@foreach($lists as $list)
		<a href="{{ url('user/accept/select/'.$list->code) }}" class="column is-6 pl-2 mb-4">
			<div class="card columns">
				<div class="column is-2">
					<figure class="image">
						<img src="../image/pp.jpg" alt="" class="is-rounded is-50x50">
					</figure>
				</div>
				<div class="column">
					<strong>{{ $list->judul }}</strong><br>
					<div class="columns">
						<div class="column is-5"><small>{{ $list->user->name }}</small></div>
						<div class="column"><small>{{ $list->mapel->mapel }}</small></div>
						<div class="column"><strong>rating: 
							@php
							$a = 0;
							$b = 0;
							@endphp
							@foreach($ratings as $rating)
							@if($rating->ujian_id == $list->id)
							@php
							$a = $a+$rating->rating;
							$b++;
							@endphp
							@endif
							@endforeach
							
							{{ number_format((float)$a/$b, 1, '.', '') }}
						</strong></div>
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>
<div class="is-hidden-desktop">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,0L60,37.3C120,75,240,149,360,160C480,171,600,117,720,128C840,139,960,213,1080,218.7C1200,224,1320,160,1380,128L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z" ></path></svg>
</div>
<section class="section">
	<div class="container is-mobile is-hidden-desktop">
		@foreach($lists as $list)
		<a href="{{ url('user/accept/select/'.$list->code) }}" class="column is-6 pl-2 mb-4">
			<div class="card is-mobile">
				<div class="columns is-mobile is-multiline">
					<div class="column is-3-mobile ml-3">
						<figure class="image">
							<img src="../image/pp.jpg" alt="" class="is-rounded is-50x50">
						</figure>
					</div>
					<div class="column is-8-mobile">
						<strong>{{ $list->judul }}</strong>
						<div class="columns is-mobile is-multiline">
							<div class="column is-5-mobile">
								{{ $list->user->name }}
							</div>
							<div class="column is-5-mobile">
								{{ $list->mapel->mapel }}
							</div>
							<div class="column is-9-mobile">
								<strong>rating: 
									@php
									$a = 0;
									$b = 0;
									@endphp
									@foreach($ratings as $rating)
									@if($rating->ujian_id == $list->id)
									@php
									$a = $a+$rating->rating;
									$b++;
									@endphp
									@endif
									@endforeach

									{{ number_format((float)$a/$b, 1, '.', '') }}
								</strong>
							</div>
						</div>
					</div>			
				</div>
			</div>
		</a>
		<br>
		@endforeach
	</div>
</section>
@endsection
@section('foot_link')
	<footer class="footer is-hidden-mobile">
		<div class="content has-text-centered">
			<p>
				<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
				<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
			</p>
		</div>
	</footer>
	<footer class="footer is-hidden-desktop" style="background: #f1f1f1;">
	<div class="content has-text-centered">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
@endsection
