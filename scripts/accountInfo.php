<?php 
session_start ();
if(isset($_SESSION ['PBOT']) && isset($_SESSION ['PBOT']['account'])) {
	$account = $_SESSION ['PBOT']['account'];
	echo json_encode (Array('name'=>$account->name, 'creditos'=>$account->creditos, 'lastday'=>date("j/n/Y g:i a", $account->lastday)), JSON_FORCE_OBJECT );
} else {
	echo 'false';
}
?>