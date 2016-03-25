<script type="text/javascript">
	<?php
	/**
	 * PHP is used for commenting this tuff. We don't want external user to know what thing does
	 * To use this navigation system, the page must have a top nav bar. Since the system is built exclusively for it
	 **/
	?>

	<?php
	//If the document is loaded we want to check if any hash is available in the url. and redirect user to those url
	//otherwise load the default page ?>
	$(document).ready(function () {
		var dataUrl = ((window.location.hash)? (window.location.hash).replace('#','') : defaultpage);
		loadPageGet(generatePageUrl(dataUrl));

		window.location.hash = dataUrl;

		//load click events at startup
		load_click_event();
	});

	$(window).on('hashchange', function(e){
		var dataUrl = (window.location.hash)? (window.location.hash).replace('#','') : defaultpage;
		loadPageGet(generatePageUrl(dataUrl));

	})

	function generatePageUrl(data){
		var subDir = "<?php $_SERVER['DOCUMENT_ROOT']; ?>/includes/";
		return subDir+data.replace('_','.')+'.template.php';
	}


	/* 	Execute if any secondery nav button is pressed gets the 'data-href' to change the addressbar */
	function load_click_event() {
		$('a[data-href]').on('click', function (e) {
			e.preventDefault();
			force_click_event($(this));
		});
	}


	//on click page load and hash change
	function force_click_event(elem) {
		loadPageGet(generatePageUrl(elem.attr('data-href')), (!!elem.attr('data-href')) ? elem.attr('data-href') : "");
		window.location.hash = elem.attr('data-href');
	}

	/* 	Takes 'url' parameter and loads the page into the container,
	 when a request is made the loading spinner shows and hide if the request is OK
	 or Failed */
	function loadPageGet(reqUrl, getReq) {
		$.fx.off = true; // turn off jquery animation effects
		$('#loading_icon').show(); //show loading icon'
		showOverlay(); //show overlay while loading
		$.ajax({
			url: reqUrl + "?" + getReq,
			cache: false,
			type: "GET",
		}).done(function (data) {
			$('#ajax_area').html(data); //replace the previous page data with the loaded one
			gotoTop(); //when new  page load complete go to top
		}).fail(function (jqXHR, textStatus, errorThrown) {
			showNotification("<b style=\"text-transform: uppercase;\">" + textStatus + "</b> - " + errorThrown, "error", "red_color");
		}).always(function () {
			$('#loading_icon').hide();
			hideOverlay(); //hide overlay while loading
		});
	}
	//generates Url used to get files with ajax request
	function generateUrl(data) {
		var subDir = "<?php $_SERVER['DOCUMENT_ROOT']; ?>/includes/";
		var ext = ".template.php";
		return subDir + data + ext;
	}

	//scroll page to top
	function gotoTop() {
		$.fx.off = false;
		$("html, body").delay(100).animate({scrollTop: 0}, 'fast');
		$.fx.off = true;
	}

	//overlay toogle
	function showHideOverlay() {
		if ($('#disable_overlay').length) {
			$('#disable_overlay').remove();
		} else {
			$('#main_panel').append("<div id=\"disable_overlay\" style=\"display:block;\"></div>")
		}
	}

	//overlay hide
	function hideOverlay() {
		if ($('#disable_overlay').length) {
			$('#disable_overlay').remove();
		}
	}

	//overlay visible
	function showOverlay() {
		if (!$('#disable_overlay').length) {
			$('body').append("<div id=\"disable_overlay\" style=\"display:block;\"></div>");
		}
	}

</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/system.notification.script.php'; ?>