<?php
include '../class/Connection.php';
include '../class/PlayerDAO.php';

echo json_encode(PlayerDAO::getPlayersByRank($_REQUEST['vocation'], $_REQUEST['rank'], $_REQUEST['page']));
?>