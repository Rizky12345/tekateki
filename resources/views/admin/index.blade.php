@extends('../layout/head_link2')

@section('body_link')
<div class="container">
    <div id="divcanvas" style="height: 300px; width: 300px;">
  <canvas id="myChart"></canvas>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="myChart" width="400" height="400"></canvas>
<script>
const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'grey', 'cyan'],
         datasets: [{
            label: '# of Votes',
            data: [99, 19, 3, 5, 2, 3],
            backgroundColor: [
                'red',
                'blue',
                'yellow',
                'green',
                'grey',
                'cyan'
            ],
        }]
    },
    
});
</script>
@endsection