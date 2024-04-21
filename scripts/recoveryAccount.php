<?php
include '../class/Connection.php';
include '../class/AccountDAO.php';
include '../class/Tools.php';
include '../class/class.phpmailer.php';
include '../class/class.smtp.php';

$msg = '<span translate="yes">';
if (! Tools::verifyCaptcha()) {
    $msg .= 'Verificação de robor é necessária.';
} else {
    $email = trim($_REQUEST['email']);
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg .= 'Formato do email invalido!';
    } elseif (AccountDAO::recovery($email)) {
        $msg .= 'Foi enviado um e-mail com informações para prosseguir com o procedimento.';
    } else {
        $msg .= 'Ocorreu algum erro, verique se o email está correto e tente novamente.';
    }
}
$msg .= '</span>';

echo $msg;
?>