<?php
//$dbms = 'mysql';
//$dbhost = 'localhost';
//$dbport = '';
//$dbname = 'hkvsto2_forums';
//$dbuser = 'hkvsto2_forum2';
//$dbpasswd = 'eworld';


include "config.php";
include "ewmysql8.php";

$conn = ADONewConnection('mysqlt');
$conn->Connect($dbhost, $dbuser, $dbpasswd, $dbname);

if (@$_POST["user"] <> "") {
	$user = $_POST["user"];
	$conn->Exceute("DELETE FROM phpbb_posts WHERE post_username = '$user'");
	$conn->Exceute("DELETE FROM phpbb_topics WHERE topic_first_poster_name = '$user'");
	$conn->Exceute("UPDATE phpbb_forums SET forum_last_poster_name = '', forum_last_post_subject = '' WHERE forum_last_poster_name = '$user'");

}
?>
<form action="" method="post">
username <input type="text" name="user">

<input type="submit" name="submit" value="Clean">

</form>