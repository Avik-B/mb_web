<!DOCTYPE html>
<html>
<head>
	<title><?php echo $data['addon_title']; ?> for MusicBee</title>
	<meta name="description" content="<?php echo $meta_description; ?>">
	<!-- keyword meta tag is obsolete, google does not use it, but some
	search engine still use it, so for legacy support it is included -->
	<meta name="keywords" content="<?php echo $data['tags']; ?>, musicbee, music, player, unltimate, best, customizable, skin, free, plugin, download">

	<!--include common meta tags and stylesheets -->
	<?php include $siteRoot . 'includes/meta&styles.php'; ?>

	<!--Social network tags for facebook and twitter -->
	<meta property="og:title" content="">
	<meta property="og:image" content="<?php echo $siteUrl; ?>img/mb_big.png">
	<meta property="og:description" content="<?php echo $meta_description; ?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@MusicBeePlayer">
	<meta name="twitter:title" content="MusicBee - Music Manager and Player">
	<meta name="twitter:description" content="<?php echo $meta_description; ?>">

	<link rel="stylesheet" href="<?php echo $siteUrl; ?>styles/magnific-popup.css">
	<!-- Used for slider animation -->
	<link rel="stylesheet" href="<?php echo $siteUrl; ?>styles/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $siteUrl; ?>styles/MusicBeeAddons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $siteUrl; ?>styles/markdownView.css">
	<!--roboto is messed up when clearfont is disabled this makes sure that it looks great -->
	<?php include $siteRoot . 'includes/font.helper.php'; ?>
	<?php if (!empty($addon_type)): ?>
		<style>
			#<?php echo Slug($addon_type); ?>_active_page {
				box-shadow: inset 0px -3px 0px #FFC107;
				color: #FFC107;
				background: rgba(0, 0, 0, 0.1);
			}
		</style>
	<?php endif; ?>
</head>
<body>
	<div id="indexBackground">
		<div id="wrapper">
			<!--IMPORTANT-->
			<!-- INCLUDE MAIN MENU FOR BASIC NAVIGATION -->
			<?php
			include($mainmenu);
			?>
			<!-- BODY CONTENT -->
			<div id="main">
				<div id="main_panel">

					<!-- addon page INFO SECTION STARTS -->
					<div id="bg_image" class="general_info">
						<!-- AddOn page navigation top menu -->
						<div class="secondery_nav addon_secondery_nav" id="secondery_nav">
							<div class="secondery_nav_wrap">
								<ul class="left">
									<li><a href="<?php echo $link['addon']['home'] . "s/?q=&type=all&order=latest"; ?>" id=""><?php echo $lang['18']; ?></a></li>
									<?Php
									foreach ($main_menu['add-ons']['sub_menu'] as $key => $menu_addon) {
										echo "<li><a href=\"" . $menu_addon['href'] . " \" id=\"" . Slug($menu_addon['title']) . "_active_page\">" . $menu_addon['title'] . "</a></li>";
									}

									?>
									<div id="clear"></div>
								</ul>
								<div id="clear"></div>
							</div>
						</div>
						<div id="overlay_bg" class="general_info_color">
							<div class="general_info_wrap">
								<div class="general_info_text">
									<div class="general_info_text_wrap">
										<div class="general_info_title">
											<h2><?php echo $data['addon_title']; ?> <?php if ($data['addon_version'] != null): ?><i
												class="general_info_addon_version">v<?php echo $data['addon_version']; ?></i><?php endif; ?></h2>
											</div>
											<div class="general_info_addon_meta">
												<p><?php echo $lang['252']; ?> <?php echo $data['membername']; ?></p>
												<?php if (null != $data['update_date']): ?>
													<p><?php echo $lang['253']; ?> <?php echo $data['update_date']; ?></p>
												<?php else: ?>
													<p><?php echo $lang['254']; ?> <?php echo $data['publish_date']; ?></p>
												<?php endif; ?>
											</div>
											<div class="general_info_short_description">
												<p><?php echo $data['short_description']; ?></p>
											</div>
										</div>
									</div>
									<div class="general_info_icon_wrap">
										<div class="general_info_icon" style="background-image: url(<?php echo $data['thumbnail']; ?>);"></div>
									</div>
									<div id="clear"></div>
									<?php if (!empty(trim($data['important_note']))): ?>
										<div class="general_info_sidenote">
											<p><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp; <?php echo $data['important_note']; ?></p>
										</div>
									<?php endif; ?>

									<div class="general_info_downloadlink">
										<a href="<?php echo $data['download_links']; ?>" class="btn btn_green" target="_blank"><i class="fa fa-download"></i> <?php echo $lang['255']; ?>
											<?php if ($mbVerArray[0] != null): ?><?php echo $lang['256']; ?>
												<b><?php echo implode(", ", $mbVerArray); ?></b><?php endif; ?>
											</a>
											<?php if (!empty(trim($data['support_forum']))): ?>
												<a href="<?php echo $data['support_forum']; ?>" class="btn btn_blue">
													<i class="fa fa-support"></i><?php echo $lang['257']; ?>
												</a>
											<?php endif; ?>
											<?php if (!empty(trim($data['readme_content_html']))): ?>
												<a href="#readme" class="btn btn_grey" onclick="$('html,body').animate({scrollTop: $('#readme').offset().top});">
													<i class="fa fa-info"></i><?php echo $lang['258']; ?>
												</a>
											<?php endif; ?>
											<a id="like_count" href="javascript:void(0)" class="btn btn_red like_btn" onclick="rate('<?php echo $data['ID_ADDON']; ?>')" data-like-count="<?php echo number_format_suffix($addon_like); ?>">
												<?php echo $lang['263']; ?>
											</a>
										</div>
									</div>

								</div>
							</div>
							<!--INFO SECTION ENDS -->

							<!-- Screenshot STARTS -->
							<div class="addon_similar">
								<div class="addon_similar_wrap screenshot">
									<ul id="screenshot_all">
										<?php
										foreach ($screenshots as $key => $img) {
											if (preg_match('/^https?\:\/\/i\.imgur\.com\//', $img)) {
									$ext_pos = strrpos($img, '.'); // find position of the last dot, so where the extension starts
									$thumb = substr($img, 0, $ext_pos) . 'm' . substr($img, $ext_pos);
								} else {
									$thumb = $img;
								}
								echo '<a class="screenshot_zoom_click" href="', $img, '">
								<div class="screenshot_wrapper" style="background-image:url(' . $thumb . ')"></div>
							</a>';
						}
						?>
						<div id="clear"></div>
					</ul>
				</div>
			</div>
			<!-- SLIDER ENDS-->

			<?php if (!empty(trim($data['readme_content_html']))): ?>
				<!-- WORD FROM AUTHOR STARTS -->
				<div id="readme" class="addon_similar">
					<div class="addon_similar_wrap">
						<h2><?php echo $lang['259']; ?></h2>
					</div>
				</div>
				<div class="addon_similar readme_markdown_bg">
					<div class="addon_similar_wrap readme_markdown_wrap">
						<div id="readme_markdown" class="markdownView">
							<?php echo $data['readme_content_html']; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<!-- WORD FROM AUTHOR ENDS-->


			<!-- MORE FROM AUTHOR STARTS -->
			<div class="addon_similar more_from_author">
				<div class="addon_similar_wrap">
					<h2><?php echo $lang['260'] . $data['membername']; ?></h2>
				</div>
			</div>
			<div class="addon_similar more_from_author">
				<div class="addon_similar_wrap from_author">
				<?php 
					echo addon_result_view_generator($from_author, $addon);
				?>
				<div class="more_addon">
					<a class="blue_btn_big" href="javascript:void(0)">
						<h3><?php echo $lang['261']; ?></h3>
						<p><?php echo $lang['262']; ?> <?php echo $data['membername']; ?></p>
					</a>
				</div>

				<div class="license_attr"><p><?php echo $lang['251']; ?> <a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">cc by-sa 3.0</a></p></div>

			</div>
		</div>
		<!-- MORE FROM AUTHOR ENDS-->
	</div>
</div>
</div>
</div>
<!--IMPORTANT-->
<!-- INCLUDE THE FOOTER AT THE END -->
<?php
include($footer);
?>
<canvas id="bg_hero_blur" style="display:none"></canvas>
<script type="text/javascript" src="<?php echo $siteUrl; ?>scripts/jquery-2.1.4.min.js"></script>
<script src="<?php echo $siteUrl; ?>scripts/jquery.magnific-popup.min.js"></script>
<script src="<?php echo $siteUrl; ?>scripts/jquery.sticky.min.js"></script>
<script src="<?php echo $siteUrl; ?>scripts/highlight/highlight.pack.js"></script>
<script src="<?php echo $siteUrl; ?>scripts/StackBlur.js"></script>
<script type="text/javascript">
	function blurDo() {
		var bg_blur = document.getElementById("bg_hero_blur");
		var bg_overlapto = $('#bg_image');
		var ctx = bg_blur.getContext("2d");
		var img = new Image();
		img.setAttribute('crossOrigin', 'anonymous');
		img.src = "<?php echo $data['thumbnail']; ?>";
		img.onload = function () {
			ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, bg_blur.width, bg_blur.height);// draw image
			stackBlurCanvasRGB("bg_hero_blur", 0, 0, bg_blur.width, bg_blur.width, 40);
			$blurryData = bg_blur.toDataURL();
			$('#bg_image').attr('style', 'background-image: url("' + $blurryData + '");');
		}
	}


	$("#secondery_nav").sticky({topSpacing: 0});
	$(document).ready(function () {
		<?php if ($addon_already_liked == true): ?>
		$('#like_count').html('<?php echo $lang['268']; ?>');
		$('#like_count').addClass('red_color');
		<?php endif; ?>

		blurDo(); //activate blurry bg

		$('#screenshot_all').magnificPopup({
			delegate: 'a', // child items selector, by clicking on it popup will open
			type: 'image',
			verticalFit: true,
			removalDelay: 400,
			mainClass: 'mfp-fade',
			fixedContentPos: true,
			fixedBgPos: true,
			gallery: {enabled: true},
			callbacks: {
				open: function () {
					//The plugin has some issue with the scrollbar, this little hack should solve the issue
					$("html").css("margin", "0px")
				}
			}
		});

		/* Code blocks that do not have code type mentioned we will simply use "CODE" to display*/
		$("pre > code").not('[lang-rel]')
		.each(function () {
			$(this).attr('lang-rel', 'code');
		});

		hljs.initHighlightingOnLoad();
	});

	function rate(id) {
		hideNotification();
		$.ajax({
			url: "<?php echo $siteUrl; ?>includes/addons.tasks.php",
			cache: false,
			type: "POST",
			data: {id: "" + id + ""}
		}).done(function(data) {
			notificationCallback(data);
		}).fail(function( jqXHR, textStatus, errorThrown )  {
			showNotification("<b style=\"text-transform: uppercase;\">"+textStatus+"</b> - "+errorThrown, "error", "red_color");
		})
	}

/*
  Anonymous function declaration for rating updates
  */
 
var remove_rating = function () {
	var current_love_count = parseInt($('#like_count').attr('data-like-count'));
	var updated_love_count = current_love_count - 1;
	$('#like_count').attr('data-like-count', updated_love_count);
	$('#like_count').html('<?php echo $lang['263']; ?>');
	$('#like_count').removeClass('red_color');
}

var add_rating = function () {
	var current_love_count = parseInt($('#like_count').attr('data-like-count'));
	var updated_love_count = current_love_count + 1;
	$('#like_count').attr('data-like-count', updated_love_count);
	$('#like_count').html('<?php echo $lang['268']; ?>');
	$('#like_count').addClass('red_color');
}

</script>
<?php include_once $siteRoot.'includes/system.notification.script.php'; ?>
</body>
</html>