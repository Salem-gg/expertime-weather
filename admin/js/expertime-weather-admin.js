(function ($) {
	var ajaxurl = expertime_weather.ajaxurl;

	$(document).on("click", "#frm-endpoint-submit", function () {
		$("#frm-endpoint").validate({
			submitHandler: function () {
				var postdata = $("#frm-endpoint").serialize();
				postdata += "&action=admin_ajax_request&param=update_endpoint";

				jQuery.post(ajaxurl, postdata, function (response) {
					console.log(response.substring(0, response.length - 1));
					var data = jQuery.parseJSON(response.substring(0, response.length - 1));
					
					if (data.status == 1) {
						alert(data.message);
						setTimeout(function() {
							location.reload();
						}, 1000);
					}
				});
			}

		});
	});
})(jQuery);
