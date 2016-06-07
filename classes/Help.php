<?php
/**
 * Copyright (c) AvikB, some rights reserved.
 * Copyright under Creative Commons Attribution-ShareAlike 3.0 Unported,
 *  for details visit: https://creativecommons.org/licenses/by-sa/3.0/
 *
 * @Contributors:
 * Created by AvikB for noncommercial MusicBee project.
 * Spelling mistakes and fixes from community members.
 */

/**
 * Handles Help pages and help links related stuff
 * @author : AvikB;
 */
class Help
{
	public function saveEdit()
	{
		global $connection, $db_info;

		if($_POST['setting_type'] == 'help') {
			$help_links_json = (isset($_POST['help_links'])) ? $_POST['help_links'] : null;
			$help_faq_md = $_POST['faq_md'];
			$help_faq_html = $_POST['faq_html'];

			$bindedVal = array(
				$help_links_json,
				$help_faq_md,
				$help_faq_html,
			);

			$sql = "UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'help_links';
 					UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'faq_md';
 					UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'faq_html';
 				";
		} elseif ($_POST['setting_type'] == 'api') {
			$api_md = $_POST['api_md'];
			$api_html =  $_POST['api_html'];

			$bindedVal = array(
				$api_md,
				$api_html,
			);

			$sql = "UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'api_md';
 					UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'api_html';
 				";
		} elseif ($_POST['setting_type'] == 'press') {
			$press_md = $_POST['press_md'];
			$press_html =  $_POST['press_html'];

			$bindedVal = array(
				$press_md,
				$press_html,
			);

			$sql = "UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'press_md';
 					UPDATE {$db_info['help']} SET data = ? WHERE {$db_info['help']}.variable = 'press_html';
 				";
		}


		if(databaseConnection()) {
			try {
				$statement = $connection->prepare($sql);
				$statement->execute($bindedVal);

				return true;
			} catch(Exception $e) {
				return false;
			}
		}
		return false;
	}

	public static function getHelp()
	{
		global $connection, $db_info;
		if(databaseConnection()) {
			try {
				$sql = "SELECT * FROM {$db_info['help']}";
				$statement = $connection->prepare($sql);
				$statement->execute();
				$result = array_map('reset',  $statement->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC));
				if(count($result) > 0) {
					return $result;
				} else {
					return false;
				}
			} catch(Exception $e) { }
		}
	}

}