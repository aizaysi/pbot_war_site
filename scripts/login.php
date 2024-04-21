<?php
session_start ();

if (isset ( $_REQUEST ['destroy'] )) {
	unset ( $_SESSION ['PBOT']['account']);
} elseif (! isset ( $_SESSION ['PBOT']['ACCOUNT'] )) {
	include '../class/Connection.php';
	include '../class/AccountDAO.php';
	include '../class/Tools.php';
	
	$requestFromWebsite = isset ( $_REQUEST ['website'] );
	if ($requestFromWebsite && ! Tools::verifyCaptcha ()) {
		echo '<span translate="yes">Verificação de robor é necessária.</span>';
	} else {
		$account = AccountDAO::login ( $_REQUEST ['name'], $requestFromWebsite ? sha1($_REQUEST ['password']) : $_REQUEST ['password']);
		if ($account) {	
			if(!$requestFromWebsite) {
				$account->players = AccountDAO::getPlayers ( $account->id );
				$account->countPlayers = count ( $account->players );
			
				echo json_encode ( $account, JSON_FORCE_OBJECT );
			}
			
			$_SESSION ['PBOT'] ['account'] = $account;
		}elseif($requestFromWebsite) {
			echo '<span translate="yes">Login ou senha incorreto.</span>';
		}
	}
}
?>