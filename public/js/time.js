setInterval(time, 1000);

function time(){
	let now = new Date();
	document.getElementById("now").innerHTML = now.toLocaleTimeString();
}