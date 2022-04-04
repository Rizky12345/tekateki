@extends('../layout/head')

@section('body_link')
<br><br><br>
<div class="container">
	<div class="columns is-centered is-multiline">
		@foreach($soals as $soal)
		<div class="column is-9">
			<div class="card">
				<div class="card-content">
					<h1 class="subtitle">
						{{ $soal->soal }}
					</h1>
					<br>
					@if($soal->type == 'essay')
					@foreach($jawabans as $jawaban)
					@if($soal->id == $jawaban->soal_id)
					{{ $jawaban->jawaban }}({{ $jawaban->point }})
					@endif
					@endforeach
					@else
					@foreach($pilihans as $pilihan)
					@if($soal->id == $pilihan->soal_id)
						<div class="columns">
							<div class="column is-1 has-text-centered">
								@foreach($kjawabans as $kjawaban) @if($pilihan->id == $kjawaban->pilihan_id) √ @endif @endforeach
							</div>
							<div class="column is-11">
								<label class="radio">
							<input name="pilih" value="" id="pilih" type="radio" @foreach($jawabans as $jawaban) @if($jawaban->pilihan_id == $pilihan->id) checked @endif @endforeach disabled>
							{{ $pilihan->pilihan }}
						</label>
							</div>
						</div>
						@endif
					@endforeach
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
	<path fill="#ffffff" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,250.7C1248,256,1344,288,1392,304L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
</svg>
<footer class="footer has-text-centered" style="background: white;">
	<div class="content ">
		<p>
			<strong>kerja praktik</strong> From <a href="https://jgthms.com">SD NEGERI CBM Cipanengah</a>. The source code is licensed. App Status
			<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">DEMO</a>.
		</p>
	</div>
</footer>
@endsection