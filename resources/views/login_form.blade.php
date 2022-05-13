@extends('layout.head_link')


@section('body_link')
@if(isset(Auth::user()->name))
	<a href="user">home</a>
@endif
<div class="hero vh-100">
	<div class="hero-body is-all-centered columns">
		<div class="column is-5 has-background-black p-6 has-text-light shadow is-hidden-mobile">
			<strong class="title has-text-light">login</strong>
			<p class="">Masukkan user id dan password untuk melanjutkan. Login ini bisa digunakan murid, guru dan staff TU</p>
		</div>
		<div class="column is-4 p-5 border-dark shadow has-text-centered">
			<h1 class="is-hidden-desktop" style="font-size: revert;">Login</h1>
			<form action="login/process" method="post">
				@csrf
				<input type="text" class="input mb-3" placeholder="User_id" name="user_id">
				<input type="password" class="input mb-3" placeholder="Password" name="password">
				<button class="button is-dark mb-3">Login</button>
			</form>
			@if($errors->first('user_id') == "The user id must be an integer.")
			<div class="notification is-danger is-light">
				user_id harus berupa angka
			</div>
			@else
			@if($errors->first('user_id') && $errors->first('password'))
			<div class="notification is-danger is-light">
				masukkan user_id dan password 
			</div>
			@elseif($errors->first('user_id'))
			<div class="notification is-danger is-light">
				masukkan user_id
			</div>
			@elseif($errors->first('password'))
				<div class="notification is-danger is-light">
				masukkan password
			</div>
			@endif
			@endif
			@if(session('messege'))
				<div class="notification is-danger is-light">
				user_id atau password salah
			</div>
			@endif
		</div>
	</div>
</div>
@endsection
