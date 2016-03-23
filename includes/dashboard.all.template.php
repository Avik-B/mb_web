<?php
/**
 * Copyright (c) AvikB, some rights reserved.
 * Copyright under Creative Commons Attribution-ShareAlike 3.0 Unported,
 *  for details visit: https://creativecommons.org/licenses/by-sa/3.0/
 *
 * @Contributors:
 * Created by AvikB for noncommercial MusicBee project.
 * Spelling mistakes and fixes from phred and other community memebers.
 */

$no_guests = true; //kick off the guests
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

include $siteRoot . 'classes/Dashboard.php';
$dashboard = new Dashboard();


/**
 * Get all addon list submitted by this user
 * @var array $addondata
 */
$addondata['all_addons_byuser'] = $dashboard->getAllAddonByMember ($_SESSION['memberinfo']['memberid']);


/**
 * Calculate the total page required if it shows x number of items per page
 * @var int $page_total
 */
$page_total = ceil (count ($addondata['all_addons_byuser']) / $dashboard_all_view_range);

/**
 * Offset start and end value for pagination
 * @var int $offset_start
 */
$offset_start = (isset($_POST['page_num'])) ? (($_POST['page_num'] - 1) * $dashboard_all_view_range) : "0";

$current_pagenum = (isset($_POST['page_num'])) ?($_POST['page_num']) : "1";

/**
 * Slice the addon list to show x number of items
 * @var array $addondata
 */
$addondata['all_addons_byuser'] = ($addondata['all_addons_byuser'] != null) ? array_slice ($addondata['all_addons_byuser'],
                                                                                           $offset_start,
                                                                                           $dashboard_all_view_range) : null;
function dashboard_result_pagination_generator($page_total, $current_pagenum) {
	if ($page_total > 0) {
		$pagination_view = '<ul class="pagination">';
		for ($i = 1; $i < $page_total + 1; $i++) {
			if($current_pagenum == $i) {
				$pagination_view .= '<li><button class="btn btn_blue active" onclick="loadAddonPage(' . $i . ')">' . $i . '</button></li>';
			} else {
				$pagination_view .= '<li><button class="btn btn_blue" onclick="loadAddonPage(' . $i . ')">' . $i . '</button></li>';
			}
		}
		$pagination_view .= '</ul>';
	} else {
		$pagination_view = "";
	}

	return $pagination_view;
}


?>
<div
	class="main_content_wrapper col_1_2">
	<div class="sub_content_wrapper">
		<div class="box_content">
			<span
				class="show_info info_darkgrey custom">
				<h3>
					<i class="fa fa-filter"></i>&nbsp;&nbsp;
					Filter & Search your
					add-ons</h3>
			</span>

		</div>
	</div>
	<div class="sub_content_wrapper"
	     id="addon_records">
		<div class="box_content">
				<span
					class="show_info custom">
					<h3>
						<i class="fa fa-th"></i>&nbsp;&nbsp;
						Your published
						add-ons</h3>
				</span>
			<?php if (!empty($addondata['all_addons_byuser'])): ?>

				<table class="record">
					<thead>
					<tr>
						<td>
							<?php echo $lang['229']; ?>
						</td>
						<td>
							<?php echo $lang['230']; ?>
						</td>
						<td>
							<?php echo $lang['231']; ?>
						</td>
						<td>

						</td>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($addondata['all_addons_byuser'] as $key => $addon): ?>
						<tr id="<?php echo $addon['ID_ADDON']; ?>_record">
							<td>
								<a href="<?php echo $link['addon']['home'] . $addon['ID_ADDON'] . "/" . Format::Slug ($addon['addon_title']); ?>"
								   target="_blank"
								   title="View this addon"><?php echo $addon['addon_title']; ?></a>
							</td>
							<td>
								<?php echo Format::UnslugTxt ($addon['addon_type']); ?>
							</td>
							<td>
								<?php echo Validation::getStatus ($addon['status']); ?>
							</td>
							<td class="action_input">

								<form
									id="<?php echo $addon['ID_ADDON']; ?>"
									action="../includes/dashboard.tasks.php"
									method="post"
									data-autosubmit>
									<button
										id="<?php echo $addon['ID_ADDON']; ?>"
										class="btn btn_red"
										title="<?php echo $lang['233']; ?>"
										onclick="deleteRecord(<?php echo $addon['ID_ADDON']; ?>);">
										<i class="fa fa-trash"></i>
									</button>
									<input
										type="hidden"
										name="record_id"
										value="<?php echo $addon['ID_ADDON']; ?>"/>
									<input
										type="hidden"
										name="modify_type"
										value="delete"/>
								</form>
								<button
									class="btn btn_blue"
									type="submit"
									onclick="loadEditView(<?php echo $addon['ID_ADDON']; ?>);"><?php echo $lang['234']; ?></button>

							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>

				</table>
			<?php else: ?>
				<p class="message"><?php echo $lang['dashboard_err_3']; ?></p>
			<?php endif; ?>
		</div>
		<div class="box_content">
			<?php echo dashboard_result_pagination_generator ($page_total,
			                                                  $current_pagenum); ?>
		</div>
	</div>
</div>

<div class="space medium"></div>

<div id="editView"
     class="modalBox1 iw-modalBox fadeIn animated"></div>
<script type="text/javascript">

	//get page(1,2,3..) addon list via ajax
	function loadAddonPage(page_num) {
		$('#loading_icon').show(); //show loading icon'
		showOverlay(); //show overlay while loading
		$.ajax({
			url: '../includes/dashboard.all.template.php',
			cache: false,
			type: "POST",
			data: {page_num: "" + page_num + ""}
		}).done(function (data) {
			var sourcedata = $('#addon_records > *', $(data));
			$('#addon_records').html(sourcedata).fadeIn();
		}).fail(function (jqXHR, textStatus, errorThrown) {
			showNotification("<b style=\"text-transform: uppercase;\">" + textStatus + "</b> - " + errorThrown, "error", "red_color");
		}).always(function () {
			$('#loading_icon').hide(); //show loading icon'
			hideOverlay(); //show overlay while loading
		});
	}
//
//	function showEditModal(id) {
//		$('.modalBox1').modalBox({
//			left: '0',
//			top: '0',
//			width: '100%',
//			height: '100%',
//			keyClose: true,
//			iconClose: true,
//			bodyClose: true,
//			onOpen: function () {
//				$('#editView').html("<div class=\"sk-circle\"> <div class=\"sk-circle1 sk-child\"></div> <div class=\"sk-circle2 sk-child\"></div> <div class=\"sk-circle3 sk-child\"></div> <div class=\"sk-circle4 sk-child\"></div> <div class=\"sk-circle5 sk-child\"></div> <div class=\"sk-circle6 sk-child\"></div> <div class=\"sk-circle7 sk-child\"></div> <div class=\"sk-circle8 sk-child\"></div> <div class=\"sk-circle9 sk-child\"></div> <div class=\"sk-circle10 sk-child\"></div> <div class=\"sk-circle11 sk-child\"></div> <div class=\"sk-circle12 sk-child\"></div> </div>"); //show loading signal maybe!
//				loadEditView(id); //do some ajax request for the file
//			},
//			onClose: function () {
//				$('#editView').html(""); //delete the html we got from ajax req
//			}
//		});
//	}

	function loadEditView(id) {
		$('#loading_icon').show(); //show loading icon'
		showOverlay(); //show overlay while loading
		$.ajax({
			url: '<?php $_SERVER['DOCUMENT_ROOT']; ?>/includes/dashboard.submit.template.php?view=update&id=' + id,
			cache: false,
			type: "POST",
		}).done(function (data) {
			if ($('#ajax_area').children().length > 0) {
				$('#ajax_area').html(data);
				hideNotification();
			}
		}).fail(function (jqXHR, textStatus, errorThrown) {
			showNotification("<b style=\"text-transform: uppercase;\">" + textStatus + "</b> - " + errorThrown, "error", "red_color");
		}).always(function () {
			$('#loading_icon').hide(); //show loading icon'
			hideOverlay(); //show overlay while loading
		});
	}

	var delete_record_id = "0";

	function deleteRecord(id) {
		var modify_confirm = confirm("<?php echo $lang['232']; ?>");
		if (modify_confirm == true) {
			hideNotification();
			$('#loading_icon').show();
			//store the record id so that we can remove the table from html
			delete_record_id = id;
			$('form[data-autosubmit][id='+id+']').autosubmit();
		} else {
			this.event.preventDefault(); //stop the actual form submission
		}
	}

	(function ($) {
		$.fn.autosubmit = function () {
			console.log("yy");
			//noinspection JSUnresolvedFunction
			this.submit(function (event) {
				event.preventDefault();
				event.stopImmediatePropagation(); //This will stop the form submit twice
				var form = $(this);
				//noinspection JSUnresolvedFunction
				$.ajax({
					type: form.attr('method'),
					url: form.attr('action'),
					data: form.serialize()
				}).done(function (data) {
					notificationCallback(data);
				}).fail(function (jqXHR, textStatus, errorThrown) {
					showNotification("<b style=\"text-transform: uppercase;\">" + textStatus + "</b> - " + errorThrown, "error", "red_color");
				}).always(function () {
					$('#loading_icon').hide();
				});
			});
		}
		return false;
	})(jQuery)


	var remove_addon_record = function () {
		$('#' + delete_record_id + "_record").html("<td><p><?php echo $lang['dashboard_msg_1']; ?></p></td><td></td><td></td><td></td>");
		$('#' + delete_record_id + "_record").addClass('record_removed');
	}


</script>