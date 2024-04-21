<?php
session_start();
if (isset($_SESSION ['PBOT']) && isset($_SESSION ['PBOT']['account'])) {
	include '../class/Connection.php';
	include '../class/PlayerDAO.php';
	include '../class/Tools.php';	
	$nome = trim($_REQUEST ['name']);
	$msg = Tools::valideNick($nome);
	if ($msg == '') {
		$account = $_SESSION ['PBOT'] ['account'];		$vocation = $_REQUEST ['voc'];
		
		if(!in_array($vocation, array(1, 2, 3, 4))) {
			$msg = 'Vocação inexistente.';	
		}elseif (PlayerDAO::create($nome, $_REQUEST ['sex'], $vocation, $account->id)) {
			array_push($account->players, (Object)Array('name'=>$nome, 'level'=>1));
			$msg = 'Persoangem criado com sucesso!';
		} else {
			$msg = 'Erro ao tentar criar o personagem!';
		}
	}	
} else {
	$msg = 'Erro ao tentar criar o personagem!';
}

echo $msg;
?>