(function ($) {
	var ajaxurl = expertime_weather.ajaxurl;

	$(document).on("click", "#localisation-submit", function () {
		if (navigator.geolocation) {
			// console.log("&lat=testlat&lng=testlng&action=public_ajax_request&param=weather_localization");
			// var postdata = "&lat=testlat&lng=testlng&action=public_ajax_request&param=weather_localization";
			navigator.geolocation.getCurrentPosition(function (position) {
				var postdata = "&lat=" + position.coords.latitude + "&lng=" + position.coords.longitude + "&action=public_ajax_request&param=weather_localization";

				jQuery.post(ajaxurl, postdata, function (response) {
					var data = jQuery.parseJSON(response);

					if (data.status == 1) {
						$("#weather-display").remove();
						$("#wrapper").prepend(`<div class="row" id ="weather-display">
								<div class="col">
									<div class="jumbotron">
										<h1 class="display-4">` + data.data.city_info.name + `</h1>
										<p class="lead">` + data.data.city_info.country + `</p>
										<hr class="my-4">
										<div class="card-deck">
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_0.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_0.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_0.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_0.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_1.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_1.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_1.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_1.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_2.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_2.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_2.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_2.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_3.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_3.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_3.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_3.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_4.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_4.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_4.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_4.condition + `</strong></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>`);
					} else {
						alert(data.message);
					}
				});
			}, () => { alert("Une demande de géolocalisation ne peut avoir lieu que dans un context sécurisé") });
		} else {
			alert("La géolocalisation n'est pas supporté par votre navigateur");
		}
	});

	$(document).on("click", "#frm-adress-submit", function () {
		$("#frm-adress").validate({
			submitHandler: function () {
				var postdata = $("#frm-adress").serialize();
				postdata += "&action=public_ajax_request&param=weather_country";

				jQuery.post(ajaxurl, postdata, function (response) {
					var data = jQuery.parseJSON(response);

					if (data.status == 1) {
						$("#weather-display").remove();
						$("#wrapper").prepend(`<div class="row" id ="weather-display">
								<div class="col">
									<div class="jumbotron">
										<h1 class="display-4">` + data.data.city_info.name + `</h1>
										<p class="lead">` + data.data.city_info.country + `</p>
										<hr class="my-4">
										<div class="card-deck">
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_0.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_0.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_0.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_0.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_1.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_1.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_1.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_1.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_2.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_2.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_2.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_2.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_3.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_3.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_3.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_3.condition + `</strong></p>
												</div>
											</div>
											<div class="card border-secondary">
												<img class="card-img-top" src="`+ data.data.fcst_day_4.icon_big + `">
												<div class="card-body text-secondary">
													<h5 class="card-title">`+ data.data.fcst_day_4.day_long + `</h5>
													<p class="card-text">`+ data.data.fcst_day_4.date + `</p>
													<p class="card-text"><strong>`+ data.data.fcst_day_4.condition + `</strong></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>`);
					} else {
						alert(data.message);
					}
				});
			}
		});
	});
})(jQuery);
