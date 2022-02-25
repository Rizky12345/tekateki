@extends('../layout/head_link2')

@section('body_link')
<style>
	.card-content p{
		line-height: 0.5;
	}
</style>
<div class="container">
	<br>
	<div class="columns is-multiline is-12">
		@foreach($ujians as $ujian)
		<a href="{{ url('admin/ujian/'.$ujian->code) }}" class="column card is-3 m-3">
			<div class="">
				<div class="card-content">
					<strong class="">{{ $ujian->judul }}</strong>
					<br><br>
					<p>Kelas: {{ $ujian->kelas }}</p>
					<p>Code: {{ $ujian->code }}</p>	
					<p>Jenis Ujian: Umum</p>
				</div>
				
			</div>
		</a>
		@endforeach
	</div>
</div>
@endsection