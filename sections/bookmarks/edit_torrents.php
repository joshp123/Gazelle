<?php
// ugly UserID code that should be turned into a function . . .
if(!empty($_GET['userid'])) {
	if(!check_perms('users_override_paranoia')) {
		error(403);
	}
	$UserID = $_GET['userid'];
	if(!is_number($UserID)) { error(404); }
	$DB->query("SELECT Username FROM users_main WHERE ID='$UserID'");
	list($Username) = $DB->next_record();
} else {
	$UserID = $LoggedUser['ID'];
}

// Finally we start

//Require the table class
// require_once SERVER_ROOT . '/classes/class_mass_user_torrents_table_view.php';

View::show_header('Organize Bookmarks', 'browse,jquery,jquery-ui,jquery.tablesorter,sort');

$EditType = isset($_GET['type']) ? $_GET['type'] : 'torrents';

list($K, $GroupIDs, $CollageDataList, $TorrentList) = Users::bookmark_data($UserID);

$TT = new MASS_USER_TORRENTS_TABLE_VIEW($TorrentList, $CollageDataList, $EditType, 'Organize Torrent Bookmarks');
$TT->render_all();

View::show_footer();