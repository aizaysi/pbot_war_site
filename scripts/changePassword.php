<?php
session_start ();

include '../class/Connection.php';
include '../class/AccountDAO.php';
include '../class/Tools.php';

$res = ( object ) Array ();
$res->result = false;
$res->msg = '<span translate="yes">';
if (! Tools::verifyCaptcha ()) {
	$res->msg .= 'Verificação de robor é necessária.';
} else {
	$account = $_SESSION ['PBOT'] ['account'];
	$oldPassword = trim ( $_REQUEST ['oldPassword'] );
	
	if ($account->password != sha1 ( $oldPassword )) {
		$res->msg .= 'A última senha não se corresponde.';
	} else {
		$password = trim ( $_REQUEST ['password'] );
		
		if (! preg_match ( "#([a-zA-Za-z0-9\d\._\#\$\@]){8,29}$#i", $password )) {
			$res->msg .= 'A senha tem q ter pelo menos 8 caracteres e usar apenas letras, números e caracteres como: _, ., #, $, @';
		} elseif (AccountDAO::changePassword ( $account, $password )) {
			$res->result = true;
			$res->msg .= 'Senha alterada com sucesso.';
		} else {
			$res->msg .= 'Error ao tentar alterar a senha.';
		}
	}
}
$res->msg .= '</span>';

echo json_encode ( $res, JSON_FORCE_OBJECT );
?>