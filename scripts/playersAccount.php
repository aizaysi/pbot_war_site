<?php
session_start();
if (isset($_SESSION ['PBOT'])) {
	$account = $_SESSION ['PBOT']['account'];
	if ($account) {
		echo json_encode($account->players);
	}
}
?>