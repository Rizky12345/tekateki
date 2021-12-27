let a = new Date("dec 19, 2021 14:57:00").getTime();

let time = setInterval(function(){
	let now = new Date().getTime();
	let sisa = a-now;

	let menit = Math.floor((sisa % (1000 * 60 * 60)) / (1000 * 60));
	let detik = Math.floor((sisa % (1000 * 60)) / 1000);

	document.getElementById("countdown").innerHTML = menit+":"+detik;
	if (sisa < 0) {
		clearInterval(time);
		document.getElementById("countdown").innerHTML = "EXPIRED";
	}
},1000);
