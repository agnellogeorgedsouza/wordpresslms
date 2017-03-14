<?php
defined('ABSPATH') or die('No direct access permitted');

if (isset($_GET['action']) && $_GET['action'] != '') {
		switch ($_GET['action']) {
			case 'button':
			case 'edit': 
				if (isset($_GET["popup"]) && $_GET["popup"] == true) // bugs with save function to name something
					include_once 'button_editor_popup.php'; 
				else
					include_once 'maxbuttons-button.php';
				break;
 
			default:
				include_once 'maxbuttons-list.php';
				break;
		}

} else {
	include_once 'maxbuttons-list.php';
}

