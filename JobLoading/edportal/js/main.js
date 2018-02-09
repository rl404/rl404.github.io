function addNewDoc(){
	$.ajax({
		type: 'POST',
		url:  'modal.php'
	})
	.done( function (responseText) {
		$('#editdoccontent').html(responseText);
	})

	$('.editmodal').modal('show');
}

function editDoc(a){
	$.ajax({
		type: 'POST',
		url:  'modal.php',
		data: { docid: a }
	})
	.done( function (responseText) {
		$('#editdoccontent').html(responseText);
	})

	$(".editmodal").modal('show');
}

function deleteDoc(a){
	$.ajax({
		type: 'POST',
		url:  'modaldelete.php',
		data: { docid: a }
	})
	.done( function (responseText) {
		$('#deletedoccontent').html(responseText);
	})

	$(".deletemodal").modal('show');
}

function submitForm(a) {
   document.getElementById(a).submit();
}

var loadFile = function(event) {
	var output = document.getElementById('output');
	output.src = URL.createObjectURL(event.target.files[0]);
};

$(document).ready(function() {
	$('#toyotalogo').click(function (event){
		$(this).transition('jiggle');
	});

	$('#supertitle').click(function (event){
		$(this).transition('jiggle');
	});

	$('#supertitle2').click(function (event){
		$(this).transition('bounce');
	});

	$('.clickanimate').click(function (event){
		$(this).transition('pulse');
	});
});

var timeout = null;

$(document).on('mousemove', function() {
	if (timeout !== null) {
		$('#screensaver').fadeOut();
		clearTimeout(timeout);
	}

	timeout = setTimeout(function() {  
		$('#screensaver').fadeIn();   
	}, 60000);
});
