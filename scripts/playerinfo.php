<?php
include '../class/Connection.php';
include '../class/Tools.php';
include '../class/PlayerDAO.php';
include '../class/class.playersonline.php';

echo json_encode(PlayerDAO::getInfoByName(trim($_REQUEST['name'])));
?>