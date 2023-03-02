function show_alert(title, content, icon, timer) {
	
	const setting = { 
		title: title,
		html: content,
		icon: type,
		showConfirmButton : true
	}
	
	if (timer) {
		setting.timer = timer
		setting.showConfirmButton = false
	}
	Swal.fire( setting )
}

function generate_alert(type, message) {
	return '<div class="alert alert-dismissible alert-'+type+'" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	
}