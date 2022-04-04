@extends('../layout/head')

@section('body_link')
<style>
	li{
		display:inline-block;
		margin-right:10px;
	}
	ul{
		width:100%;
		height:20px;
		text-align:center;
	}
	.paginate-width{
		width: 80px;
	}
	.paginate-width-small{
		width: 30px;
	}
</style>
<div class="hero-mobile is-medium-mobile" style="background:white;">
	<div class="hero-body">
		<div class="has-text-centered">
			<form action="{{ url('user/code') }}" method="post">
				@csrf
			<div><br></div>
			<h1 class="subtitle">Code Unique</h1>
			<input type="text" class="input is-rounded has-text-centered w-50" name="code">
			<br><br>
			<button class="button is-dark">Cari</button>
			<div><br></div>
			</form>
			@if(session('alert'))
			<p class="{{ session('color') }}">{{ session('alert') }}</p>
			@endif
			
		</div>
	</div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="1" d="M0,160L48,144C96,128,192,96,288,74.7C384,53,480,43,576,58.7C672,75,768,117,864,160C960,203,1056,245,1152,266.7C1248,288,1344,288,1392,288L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
<div class="container" style="background:#f1f1f1;">
	<h1 class="title">List</h1>
	<div class="columns is-multiline">
		@foreach($lists as $list)
		@if($list->status == 'enable')
		<a href="{{ url('user/accept/select/'.$list->code) }}" class="column is-6 mb-4">
			<div class="card is-mobile">
				<div class="columns is-mobile is-multiline">
					<div class="column is-2-desktop is-3-mobile ml-3">
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
							
						</div>
					</div>			
				</div>
			</div>
		</a>
		@elseif($list->status == 'disable')
		<div class="column is-6 mb-4">
		<div class="card is-mobile" style="background:#f76161; cursor: no-drop;">
				<div class="columns is-mobile is-multiline">
					<div class="column is-2-desktop is-3-mobile ml-3">
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
						</div>
					</div>			
				</div>
			</div>
			</div>
			@elseif($list->status == 'lock')
		
		@endif
		@endforeach
	</div>
</div>
<br><br>
<div class="columns is-centered " style="width:100%;">
	<div class="column has-text-centered">
		{{ $lists->links('../pagination') }}
	</div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#ffffff" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
</svg>
	<footer class="footer has-text-centered" style="background: white;">
		<div class="content ">
			<p>
				<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
				<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
			</p>
		</div>
	</footer>
@endsection
