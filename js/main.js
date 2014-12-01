function expandProfileImg(){
	var overlay = document.createElement("div");
	overlay.setAttribute("id","overlay");
	overlay.setAttribute("class", "overlay");
	
	
	var centerdiv = document.createElement("div");
	centerdiv.setAttribute("id", "centerdiv");
	centerdiv.setAttribute("class", "centerdiv");

	overlay.appendChild(centerdiv);
	document.body.appendChild(overlay);

	var img = document.createElement("img");
	img.setAttribute("id","img");
	img.src = this.getAttribute("data-larger");
	img.setAttribute("class","overlayimg");
	img.setAttribute("style","width: auto;");

	img.onclick=restore;
	overlay.onclick=restore;

	centerdiv.appendChild(img);
}

function restore() {
	overlay.removeChild(document.getElementById("centerdiv"));
	document.body.removeChild(document.getElementById("overlay"));
	document.body.removeChild(document.getElementById("img"));
}

window.onload=function() {
	var imgs = document.getElementById("profile-pic");
	imgs.onclick=expandProfileImg;
	imgs.onkeydown=expandProfileImg;
}