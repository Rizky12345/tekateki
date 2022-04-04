@extends('../layout/head')

@section('body_link')
<br><br><br>
<div class="container">
	<div class="columns is-centered">
		<div class="column is-8">
			<div class="card">
				<div class="card-head">
					<div class="card-header-title">
						Profile
					</div>
				</div>

				<div class="card-content">
					@if(session('alert'))
				<div class="notification {{ session('color') }}">
					{{ session('alert') }}
				</div>
				@endif
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">Name</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control mt-2">
									{{ Auth::user()->name }}
								</p>
							</div>
						</div>
					</div>
					<div class="field is-horizontal">
						<div class="field-label is-normal">
							<label class="label">User_id</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control mt-2">
									{{ Auth::user()->user_id }}
								</p>
							</div>
						</div>
					</div>
					<form action="{{ url('user/profile/ubah') }}" method="post">
						@csrf
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">Password</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
										<input type="password" name="password" class="input">
									</p>
								</div>
							</div>
						</div>
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">
									<button class="button">Save</button>
								</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control">
									</p>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
	<path fill="#ffffff" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
</svg>
<footer class="footer has-text-centered" style="background: white;">
	<div class="content ">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>
		</p>
	</div>
</footer>
@endsection