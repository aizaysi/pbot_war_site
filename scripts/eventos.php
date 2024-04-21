<?php
include '../class/Connection.php';
include '../class/bbcode.php';
include '../class/ForumDAO.php';

echo json_encode(ForumDAO::getTopicos(3, true), JSON_UNESCAPED_UNICODE);
?>