@extends('../layout/head_link2')

@section('body_link')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
$soal_id = 0;
@endphp
<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Soal
		</div>
	</div>

	<div class="card-content">
		@foreach($soals as $soal)
		@php
		$soal_id = $soal->id;
		@endphp
		<p class="title">{{ $soal->soal }}</p>
		@endforeach
	</div>
</div>
{{ $soals->links('../plihan_p') }}

<div class="card">
	<div class="card-head">
		<div class="card-header-title">
			Jawaban
		</div>
	</div>

	<div class="card-content">
		@php
		$name = 0;
		@endphp
		@foreach($jawabans as $jawaban)
		@if($jawaban->soal_id == $soal_id)
		@php
		$name = $name+1;
		@endphp
		<div>
			<p class="subtitle">jawaban dari <strong>{{ $jawaban->user->name }}</strong></p>
			<p class="title">{{ $jawaban->jawaban }}</p>
			<label class="radio">
				<input name="type{{ $name }}" value="0" id="pilih" type="radio" onclick="jawaban('type{{ $name }}','{{ $jawaban->id }}')" @if($jawaban->point == 0) checked @endif>
				Salah
			</label>
			<label class="radio">
				<input name="type{{ $name }}" value="0.5" id="pilih" type="radio" onclick="jawaban('type{{ $name }}','{{ $jawaban->id }}')" @if($jawaban->point == 0.5) checked @endif>
				Setengah
			</label>
			<label class="radio">
				<input name="type{{ $name }}" value="1" id="pilih" type="radio" onclick="jawaban('type{{ $name }}','{{ $jawaban->id }}')" @if($jawaban->point == 1) checked @endif>
				Benar
			</label>
		</div>
		<br><br>
		@endif
		@endforeach

	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
@can('admin')
<script>
	function jawaban(tagid, jawaban_id){
var value =  $("input[type='radio'][name="+tagid+"]:checked").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("admin/ujian/".$ujian->code."/essay/point") }}',
			data: {
				'jawaban_id': jawaban_id,
				'value': value
			},
			success: function(data){

			}
		});
	}
</script>
@endcan
@can('sadmin')
<script>
	function jawaban(tagid, jawaban_id){
var value =  $("input[type='radio'][name="+tagid+"]:checked").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		});
		$.post({
			url: '{{ url("s/admin/ujian/".$ujian->code."/essay/point") }}',
			data: {
				'jawaban_id': jawaban_id,
				'value': value
			},
			success: function(data){

			}
		});
	}
</script>
@endcan

@endsection

