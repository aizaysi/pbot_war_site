<?php
include '../class/Connection.php';
include '../class/bbcode.php';
include '../class/ForumDAO.php';

echo json_encode(ForumDAO::getTopicos(2), JSON_UNESCAPED_UNICODE);
?>