@extends('../layout/head_link2')

@section('body_link')
@php
$i = 0;
@endphp
@foreach($soals as $soal)
@php
++$i;
@endphp
<div class="card">
	<div class="card-header">
		<div class="card-header-title">
			Soal {{ $i }}
		</div>
	</div>
	<div class="card-content">
		<strong class="is-size-4">{{ $soal->soal }}</strong>
		<br>
		@foreach($pilihans as $pilihan)
		@if($pilihan->soal_id == $soal->id)
		<div class="control">
			<label class="radio">
				<input type="radio" name="answer{{ $i }}" disabled @foreach($jawabans as $jawaban) @if($jawaban->pilihan_id == $pilihan->id) checked @endif @endforeach>
				{{ $pilihan->pilihan }} @foreach($kjawabans as $kjawaban) @if($kjawaban->pilihan_id == $pilihan->id) √ @endif @endforeach
			</label>
		</div>
		@if($pilihan->image != NULL)
						<div class="columns">
							<div class="column is-6">
								<div class="card">
									<div class="card-content">
										<figure class="image is-square">
											<img src="{{ asset("storage/$pilihan->image") }}" alt="">
										</figure>
									</div>
								</div>
							</div>
						</div>
@endif
		@endif
		@endforeach
	</div>
</div>
@endforeach

@endsection