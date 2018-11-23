function confirmModal (options) {
	var deferredObject = $.Deferred();
	var defaults = {
		modalSize: 'modal-sm', //modal-sm, modal-lg
		yesButtonText: 'Yes',
		noButtonText: 'No',
		headerText: 'Attention',
		messageText: 'Message',

	}
	$.extend(defaults, options);
  
	var _show = function(){
		var headClass = "navbar-default";
		switch (defaults.alertType) {
		
			case "info":
				headClass = "alert-info";
				break;
        }
		$('BODY').append(
			'<div id="ezAlerts" class="modal fade">' +
			    '<div class="modal-dialog" class="' + defaults.modalSize + '">' +
			        '<div class="modal-content">' +
			            '<div id="ezAlerts-header" class="modal-header ' + headClass + '">' +
			                '<button id="close-button" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
			                '<h4 id="ezAlerts-title" class="modal-title">Modal title</h4>' +
			            '</div>' +
			            '<div id="ezAlerts-body" class="modal-body">' +
			                '<div id="ezAlerts-message" ></div>' +
			            '</div>' +
			            '<div id="ezAlerts-footer" class="modal-footer">' +
			            '</div>' +
			        '</div>' +
			    '</div>' +
			'</div>'
		);
    
		$('#ezAlerts-title').text(defaults.headerText);
		$('#ezAlerts-message').html(defaults.messageText);

		var keyb = "false", backd = "static";
		var calbackParam = "";
		switch (defaults.type) {
			case 'confirm':
				var btnhtml = '<button id="ezok-btn" class="btn btn-primary">' + defaults.yesButtonText + '</button>';
				if (defaults.noButtonText && defaults.noButtonText.length > 0) {
					btnhtml += '<button id="ezclose-btn" class="btn btn-default">' + defaults.noButtonText + '</button>';
				}
				$('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
						if (e.target.id === 'ezok-btn') {
							calbackParam = true;
							$('#ezAlerts').modal('hide');
						} else if (e.target.id === 'ezclose-btn') {
							calbackParam = false;
							$('#ezAlerts').modal('hide');
						}
					});
			break;
		}
   
		$('#ezAlerts').modal({ 
          show: false, 
          backdrop: backd, 
          keyboard: keyb 
        }).on('hidden.bs.modal', function (e) {
			$('#ezAlerts').remove();
			deferredObject.resolve(calbackParam);
		}).on('shown.bs.modal', function (e) {
			if ($('#prompt').length > 0) {
				$('#prompt').focus();
			}
		}).modal('show');
	}
    
  _show();  
  return deferredObject.promise();    
}