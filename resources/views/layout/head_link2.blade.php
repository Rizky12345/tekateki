<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@php
	$co = count($title);
	$co--;
	@endphp
	<title>{{ $title[$co] }}</title>

	<!-- Bulma is included -->
	<link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
	<link rel="stylesheet" href="{{ asset('costume2.css') }}">

	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="{{ asset("css/googleapis.css") }}" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="app">
		<nav id="navbar-main" class="navbar is-fixed-top">
			<div class="navbar-brand">
				<a class="navbar-item is-hidden-desktop jb-aside-mobile-toggle">
					<span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
				</a>
			</div>
			<div class="navbar-brand is-right">
				<a class="navbar-item is-hidden-desktop jb-navbar-menu-toggle" data-target="navbar-menu">
					<span class="icon"><i class="mdi mdi-dots-vertical"></i></span>
				</a>
			</div>
			<div class="navbar-menu fadeIn animated faster" id="navbar-menu">
				<div class="navbar-end">
					<div class="navbar-item has-dropdown has-dropdown-with-icons has-divider has-user-avatar is-hoverable">
						@php
						$idddd = Auth::user()->user_id;
						$namee = Auth::user()->name;
						@endphp
@can('sadmin')
<a class="navbar-link is-arrowless" href="{{ url("s/admin/user/$idddd/$namee") }}">
							<div class="is-user-avatar">
								<img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe">
							</div>
							<div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
						</a>
@endcan
@can('admin')
<a class="navbar-link is-arrowless" href="{{ url("admin/user/$idddd/$namee") }}">
							<div class="is-user-avatar">
								<img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe">
							</div>
							<div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
						</a>
@endcan
						</div>
					</div>
					@can('admin')
					<form action="{{ url('admin/logout') }}" method="post">
						@csrf
						<button class="navbar-item logout-hover pt-4 pb-4">
							<span class="icon"><i class="mdi mdi-logout"></i></span>
							<span>logout</span>
						</button>
					</form>
					@endcan
					@can('sadmin')
					<form action="{{ url('s/admin/logout') }}" method="post">
						@csrf
						<button class="navbar-item logout-hover pt-4 pb-4">
							<span class="icon"><i class="mdi mdi-logout"></i></span>
							<span>logout</span>
						</button>
					</form>
					@endcan
				</a>
			</div>
		</div>
	</nav>
	<aside class="aside is-placed-left is-expanded">
		<div class="aside-tools">
			<div class="aside-tools-label">
				<span><b>Admin</b> One HTML</span>
			</div>
		</div>
		<div class="menu is-menu-main">
			<p class="menu-label">General</p>
			<ul class="menu-list">
				<li>
					@can('admin')
					<a href="{{ url('admin') }}" class="is-active router-link-active has-icon">
						<span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
						<span class="menu-item-label">Dashboard</span>
					</a>
					@endcan
					@can('sadmin')
					<a href="{{ url('s/admin') }}" class="is-active router-link-active has-icon">
						<span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
						<span class="menu-item-label">Dashboard</span>
					</a>
					@endcan
				</li>
			</ul>
			<p class="menu-label">Examples</p>
			<ul class="menu-list">
				@can('admin')
				<li>
					<a href="{{ url('admin/ujian') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-table"></i></span>
						<span class="menu-item-label">Ujian list</span>
					</a>
				</li>
				<li>
					<a href="{{ url('admin/ujian/ujianmonitoring') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-monitor"></i></span>
						<span class="menu-item-label">Monitoring</span>
					</a>
				</li>
				@endcan
				@can('sadmin')
				<li>
					<a href="{{ url('s/admin/ujian') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-table"></i></span>
						<span class="menu-item-label">Ujian list</span>
					</a>
				</li>
				<li>
					<a href="{{ url('s/admin/ujian/ujianmonitoring') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-monitor"></i></span>
						<span class="menu-item-label">Monitoring</span>
					</a>
				</li>
				<li>
					<a class="has-icon has-dropdown-icon">
						<span class="icon"><i class="mdi mdi-account-circle"></i></span>
						<span class="menu-item-label">Pengaturan User</span>
						<div class="dropdown-icon">
							<span class="icon"><i class="mdi mdi-plus"></i></span>
						</div>
					</a>
					<ul>
						<li>
							<a href="{{ url('s/admin/user') }}">
								<span>Tambah user</span>
							</a>
						</li>
						<li>
							<a href="{{ url('s/admin/user/alluser') }}">
								<span>Semua user</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="{{ url('s/admin/ujian/all') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-table"></i></span>
						<span class="menu-item-label">Ujian list all</span>
					</a>
				</li>
				<li>
					<a href="{{ url('s/admin/ujian/ujianmonitoring/all') }}" class="has-icon">
						<span class="icon"><i class="mdi mdi-monitor"></i></span>
						<span class="menu-item-label">Monitoring all</span>
					</a>
				</li>
				@endcan

			</ul>
		</div>
	</aside>
	<section class="section is-title-bar">
		<div class="level">
			<div class="level-left">
				<div class="level-item">
					<ul>
						@php
						$count = count($title);
						@endphp

						@for ($i = 0; $i < $count; $i++)
						<li>{{ $title[$i] }}</li>
						@endfor
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="hero is-hero-bar">
		<div class="hero-body">
			<div class="level">
				<div class="level-left">
					<div class="level-item"><h1 class="title">
						@if(isset($ujian))
						@php
						$count--;
						@endphp
						@if($ujian->code == $title[$count])
						{{ $ujian->judul }}({{ $title[$count] }})
						@else
						{{ $title[$count] }}
						@endif
						@else
						@php
						$count--;
						@endphp
						{{ $title[$count] }}
						@endif
					</h1></div>
				</div>
				<div class="level-right" style="display: none;">
					<div class="level-item"></div>
				</div>
			</div>
		</div>
	</section>

	<section class="section">
		@yield('body_link')
	</section>

</div>
<!-- Scripts below are for demo only -->
<script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
</body>
</html>
