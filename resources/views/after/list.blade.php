@extends('../layout/head')

@section('head_list')

<div class="container">
	<h1 class="title">List</h1>
	<div class="columns is-multiline">
		@foreach($lists as $list)
		<a href="list/accept" class="column is-6 pl-2 mb-4">
			<div class="card columns">
				<div class="column is-2">
					<figure class="image">
						<img src="../image/pp.jpg" alt="" class="is-rounded is-50x50">
					</figure>
				</div>
				<div class="column">
					<strong>{{ $list->judul }}</strong><br>
					<div class="columns">
						<div class="column is-6"><small>{{ $list->user->name }}</small></div>
						<div class="column"><small>{{ $list->mapel->mapel }}</small></div>
						<div class="column"><strong>rating: 

							
							@if(in_array($list->id, $ratings))
							@dd($ratings)
							@endif
							
						</strong></div>
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
</div>
@endsection
