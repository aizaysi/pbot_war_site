<?php
	include '../class/Connection.php';
	include '../class/AccountDAO.php';
	include '../class/Tools.php';
	
	$key = $_REQUEST ['key'];
	
	if (isset ( $_REQUEST ['password'] )) {
		$password = trim ( $_REQUEST ['password'] );
		
		$res = ( object ) Array ();
		$res->result = false;
		
		$res->msg = '<span translate="yes">';
		if (! preg_match ( "#([a-zA-Za-z0-9\d\._\#\$\@]){8,29}$#i", $password )) {
			$res->msg .= 'A senha tem q ter pelo menos 8 caracteres e usar apenas letras, números e caracteres como: _, ., #, $, @';
		} elseif (AccountDAO::setPassword ( $key, $password )) {
			$res->result = true;
			$res->msg .= 'Senha alterada com sucesso.';
		} else {
			$res->msg .= 'Error ao tentar alterar a senha.';
		}
		$res->msg .= '</span>';
		
		echo json_encode ( $res, JSON_FORCE_OBJECT );
	} elseif (! AccountDAO::recoveryKeyExist ( $key )) {
		echo 'Invalid key.';
	}
?>