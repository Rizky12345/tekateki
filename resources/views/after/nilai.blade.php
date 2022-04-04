@extends('../layout/head')

@section('body_link')
<br><br><br>
<div class="container">
	<div class="columns is-centered">
		<div class="column is-8">
			<div class="card">
				<div class="card-head">
					<div class="card-header-title">
						Nilai
					</div>
				</div>
				<div class="card-content" style="overflow-x:auto;">
					<table class="table is-fullwidth" >
						<thead>
							<tr>
								<td>No</td>
								<td>Ujian</td>
								<td>Code</td>
								<td>Nilai</td>
								<td>Detail</td>
							</tr>
						</thead>
						<tbody>
							@php
							$count = 0;
							@endphp
							@foreach($nilais as $nilai)
							<tr>
								<td>{{ ++$count }}</td>
								<td>{{ $nilai->ujian->judul }}</td>
								<td>{{ $nilai->ujian->code }}</td>
								@if($nilai->nilai == NULL)
								<td>0</td>
								@else
								<td>{{ $nilai->nilai }}</td>
								@endif
								
								<td><a href="{{ url("user/nilai/$nilai->id/".$nilai->ujian->code ) }}">lihat jawaban</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
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