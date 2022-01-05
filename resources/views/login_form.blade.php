@extends('layout.head_link')


@section('body_link')
@if(isset(Auth::user()->name))
	<a href="user">home</a>
@endif
<div class="hero vh-100">
	<div class="hero-body is-all-centered columns">
		<div class="column is-5 has-background-black p-6 has-text-light shadow">
			<strong class="title has-text-light">login</strong>
			<p class="">Lorem ipsum dolor sit amet consectetur adipisicing, elit. Commodi doloribus illo laudantium odit repellat nisi delectus atque ea, molestiae quas veritatis blanditiis quaerat architecto voluptatem non ipsam ullam voluptas culpa eligendi vel sunt error corrupti. Quas, magni consequuntur odit, necessitatibus minus sapiente accusamus laborum veniam corrupti officiis dignissimos ipsam exercitationem.</p>
		</div>
		<div class="column is-4 p-5 border-dark shadow has-text-centered">
			<form action="login/process" method="post">
				@csrf
				<input type="text" class="input mb-3" placeholder="Email" name="email">
				<input type="text" class="input mb-3" placeholder="Password" name="password">
				<button class="button is-dark mb-3">Login</button>
			</form>
			@if(isset($message))
			<div class="notification is-danger is-light">
				{{ $message }}
			</div>
			@endif
		</div>
	</div>
</div>
@endsection
