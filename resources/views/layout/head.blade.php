<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<link rel="stylesheet" href="{{ url('bulma/css/bulma.min.css') }}">
	<link rel="stylesheet" href="{{ url('costume.css') }}">
</head>
<body>
	<nav class="hero is-hidden-mobile">
		<div class="hero-head">
			<div class="navbar">
				<div class="container pt-2">
					<div class="navbar-brand">
						<div class="nav-item">
							<div class="title">asd</div>
						</div>	
					</div>
					<div class="navbar-menu">
						<div class="navbar-end">
							<div class="navbar-item" id="time">{{ date('h:i') }}</div>
							<div class="navbar-item">{{ Auth::user()->name }}</div>
							<div class="navbar-item">
								<form action="/user/logout/process" method="post">
									@csrf
									<button>logout</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@yield('head_link')
	</nav>
	<section class="section" style="padding: 1.5rem 1.5rem;">
		<div class="container is-mobile is-hidden-desktop">
			<div class="is-mobile">
				<div class="columns is-mobile is-multiline">
					<div class="column is-12-mobile">
						<strong class="title">Hujan</strong>
						<br><br><br>
						<div class="columns is-mobile is-multiline has-text-centered">
							<div class="column is-4-mobile">
								<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#363636"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 5.69l5 4.5V18h-2v-6H9v6H7v-7.81l5-4.5M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
							</div>
							<div class="column is-4-mobile">
								<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#363636"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
							</div>
							<div class="column is-4-mobile">
								<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#363636"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
							</div>
						</div>
					</div>			
				</div>
			</div>

			<br><br>
		</div>
	</section>
	<div class="is-hidden-desktop">
		@yield('head_link')
	</div>
	<div style="background:#f1f1f1" class="is-hidden-desktop">
		
		@yield('body_link')
	</div>
	<div class="is-hidden-mobile">
		@yield('body_link')
	</div>
	@yield('foot_link')

	<script>
		setInterval(myTimer, 1000);

		function myTimer() {
			const d = new Date();
			document.getElementById("time").innerHTML = d.toLocaleTimeString();
		}
	</script>
</body>
</html>