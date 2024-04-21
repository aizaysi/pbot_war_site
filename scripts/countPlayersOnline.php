<?php
if(@include '../class/Connection.php') {
	include '../class/PlayerDAO.php';
	include '../class/Tools.php';
	include '../class/class.playersonline.php';
} else {
	include 'class/Connection.php';
	include 'class/PlayerDAO.php';
	include 'class/Tools.php';
	include 'class/class.playersonline.php';
}

echo count(PlayersOnline::getInstance()->players);
?>