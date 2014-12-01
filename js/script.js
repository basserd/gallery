var template = 
'<div class="preview">'+
	'<span class="imageHolder">'+
	'<img />'+
	'<div class="progressHolder">'+
	'	<div class="progress"></div>'+
	'</div>'+
'</div>'; 

function createImage(file){
	var preview = $(template),
		image = $('img', preview);

	var reader = new FileReader();

	image.width = 100;
	image.height = 100;

	reader.onload = function(e){
		image.attr('src', e.target.result);
	};

	reader.readAsDataURL(file);

	message.hide();
	preview.appendTo(dropbox);

	$.data(file, preview);
}