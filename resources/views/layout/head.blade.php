<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
	<link rel="stylesheet" href="{{ url('bulma/css/bulma.min.css') }}">
	<link rel="stylesheet" href="{{ url('costume.css') }}">
</head>
<style>
  body{
    overflow-x: hidden;
  }
</style>
<body style="background:#f1f1f1" style="">
	<div id="app">
	<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ url('user') }}">
      <h1 class="title">Hujan</h1>
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" @click="showNav = !showNav" :class="{ 'is-active': showNav }">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu" :class="{ 'is-active': showNav }">
    <div class="navbar-start">

      <a class="navbar-item" href="{{ url('user/nilai') }}">
        Lihat nilai
      </a>
      <a class="navbar-item" href="{{ url('user/profile') }}">
        Profile
      </a>

      
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <form action="{{ url('user/logout/process') }}" method="post">
            @csrf
            <button class="button is-dark">
               <strong>Log out</strong>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>
</div>
@yield('body_link')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script>
	new Vue({
  el: '#app',
  data: {
  	showNav: false
  }
});
</script>
	<script>
		setInterval(myTimer, 1000);

		function myTimer() {
			const d = new Date();
			document.getElementById("time").innerHTML = d.toLocaleTimeString();
		}
	</script>
</body>
</html>