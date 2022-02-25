<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="{{ url('bulma/css/bulma.min.css') }}">
	<link rel="stylesheet" href="{{ url('costume.css') }}">
	<link rel="stylesheet" href="{{ url('fontawesome/css/font-awesome.min.css') }}">
	<title>{{ $title }}</title>
</head>
<body>
	<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
  	@can('admin')
    <a class="navbar-item" href="{{ url('admin') }}">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>
@endcan
  	@can('sadmin')
    <a class="navbar-item" href="{{ url('s/admin') }}">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>
@endcan
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item">
        Home
      </a>

      <a class="navbar-item">
        Documentation
      </a>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">
            About
          </a>
          <a class="navbar-item">
            Jobs
          </a>
          <a class="navbar-item">
            Contact
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            Report an issue
          </a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary">
            <strong>Sign up</strong>
          </a>
          @can('admin')
								<form action="{{ url('admin/logout') }}" method="post">
									@csrf
									<button class="button is-light">logout</button>
								</form>
@endcan
          @can('sadmin')
								<form action="{{ url('s/admin/logout') }}" method="post">
									@csrf
									<button class="button is-light">logout</button>
								</form>
@endcan
        </div>
      </div>
    </div>
  </div>
</nav>
	<div class="is-widescreen">
		<div class="columns">
			<aside class="menu">

				<p class="menu-label">
					Administration
				</p>
				<ul class="menu-list ">
					<li><a href="{{ url('admin/ujian') }}">Team Settings</a></li>
					<script>
						let a = false;
					</script>
					<li onclick="drop(a)">
						<a class="is-active ">Manage Team</a>
						<ul id="false" class="is-hidden">
							<li><a>Members</a></li>
							<li><a>Plugins</a></li>
							<li><a>Add a member</a></li>
							<li><a>Members</a></li>
							<li><a>Plugins</a></li>
							<li><a>Add a member</a></li>
							<li><a>Members</a></li>
							<li><a>Plugins</a></li>
							<li><a>Add a member</a></li>
							<li><a>Members</a></li>
							<li><a>Plugins</a></li>
							<li><a>Add a member</a></li>
							<li><a>Members</a></li>
							<li><a>Plugins</a></li>
							<li><a>Add a member</a></li>
						</ul>
					</li>
					<li><a>Invitations</a></li>
				</ul>
			</aside>
			<div class="column content">
				@yield('body_link')

			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script>
		function drop(bool){
			if (bool == false) {
				$('#false').removeClass('is-hidden').addClass('is-show');
				a = true;
			}
			if(bool == true){
				$('#false').addClass("is-hidden").removeClass('is-show');
				a =  false;
			}
		}
	</script>
</body>
</html>