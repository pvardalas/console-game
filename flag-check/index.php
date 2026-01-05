<?php
    ini_set("display_errors", "On");
    require_once("../../wp-load.php");
    $encid_ = $_GET['c'];
    $encoded_custom_id_1 = str_replace("-", "=", $encid_);
    $encoded_custom_id_2 = str_replace(".", "+", $encoded_custom_id_1);
    $encoded_custom_id_3 = str_replace("_", "/", $encoded_custom_id_2);
    $custom_id = base64_decode($encoded_custom_id_3);
    $users = get_users(array(
        'meta_key' => 'custom_id',
        'meta_value' => $custom_id
    ));
    if (strcasecmp('XMLHttpRequest', $_SERVER['HTTP_X_REQUESTED_WITH']) === 0)
    {
	forEach($users as $user) {
	    $user->set_role('premium');
	}
    }
    else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
        exit;
    }
?>
