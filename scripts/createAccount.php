<?php
	include '../class/Connection.php';
	include '../class/AccountDAO.php';
	include '../class/Tools.php';	
	$login = trim($_REQUEST ['login']);
	$password = trim($_REQUEST ['password']);
	$email = trim($_REQUEST ['email']);

	$res = (Object)Array();
	$res->result = false;	
	$res->msg = '<span translate="yes">';
	if(!Tools::verifyCaptcha()) {
		$res->msg .= 'Verificação de robor é necessária.';
	}elseif(!isset($_REQUEST['aceitoTermos'])) {
		$res->msg .= 'É preciso aceitar os termos e regras do PBOT.';
	}elseif(!Tools::onlyLetterAndNumber($login)) {
		$res->msg .= 'O nome da conta só pode conter letras e números!';
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$res->msg .= 'O email é invalido!';
	}elseif(!preg_match("#([a-zA-Za-z0-9\d\._\#\$\@]){8,29}$#i", $password)) {
		$res->msg .= 'A senha tem q ter pelo menos 8 caracteres e usar apenas letras, números e caracteres como: _, ., #, $, @';
	}elseif(AccountDAO::usedAccountName($login)) {
		$res->msg .= 'Esse nome para conta já esta sendo utilizado!';
	}elseif(AccountDAO::usedEmail($email)) {
		$res->msg .= 'Esse email já está sendo utilizado!';
	}elseif($res->result = AccountDAO::register($login, sha1($password), $email)) {
		$res->msg .= 'Conta registrada com sucesso!</span><br/><span style="color: red;" translate="yes">A criação de personagem é através do cliente.';
	} else {
		$res->msg .= 'Erro ao registrar conta!';
	}	
	$res->msg .= '</span>';
	echo json_encode($res, JSON_FORCE_OBJECT);
?>

