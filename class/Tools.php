<?php
class Tools {
	public static function verifyCaptcha() {
		$recaptcha = isset($_REQUEST['g-recaptcha-response']) ? $_REQUEST['g-recaptcha-response'] : null;
		if($recaptcha) {
			$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdY3icTAAAAAEMoKR0WG-JU5wCX5gLsTPYjOKh1&response=".$recaptcha);
			$captcha_success=json_decode($verify);
			return $captcha_success->success;				
		}
		return false;
	}
	
	public static function sendEmail($destEmail, $destName, $assunto, $content, $altContent = NULL) {
		$mail = new PHPMailer();
				
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = "mail.pbot.com.br"; // Endereço do servidor SMTP
		$mail->SMTPAuth = true; // Autenticação
		$mail->Username = 'forum@pbot.com.br'; // Usuário do servidor SMTP
		$mail->Password = 'dF213@23.1'; // Senha da caixa postal utilizada		
		
		$mail->From = "support@pbot.com.br";
		$mail->FromName = "PBOT Support";
		
		$mail->AddAddress($destEmail, $destName);
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
		
		$mail->Subject  = $assunto; // Assunto da mensagem
		
		$content .= '<br/><br/>Att,<br/>Equipe PBOT - www.pbot.com.br';
		
		$mail->Body = $content;
		
		
		if($altContent) {
			$mail->AltBody = $altContent;
		}
		
		$enviado = $mail->Send();
		
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		
		return $enviado;
	}
	
	public static function onlyLetterAndNumber($value) {
		return preg_match ( '/^[\w]+$/', $value );
	}
	
	public static function valideNick($nickname){
		switch (true)
		{
			
			case empty ( $nickname ) :
				
				return 'Por favor, Coloque um Nick';
			
			case (strlen ( $nickname ) < 3 || strlen ( $nickname ) > 20) :
				
				return 'O nome contem menos que 3 letras ou mais que 20 letras.';
			
			case (! preg_match ( '/^[a-zA-Z][a-zA-Z ]*$/', $nickname )) :
				
				return 'O nome contem caracteristicas ilegais, use apenas A-Z, a-z e espaço!';
			
			case preg_match ( '/\bgm\b/i', $nickname ) :
				
				return 'Não utilize nome com GM!';
			
			case preg_match ( '/\bgamemaster\b/i', $nickname ) :
				
				return 'Não utilize nome com GameMaster!';
			
			case preg_match ( '/\bgame master\b/i', $nickname ) :
				
				return 'Não utilize nome com Game Master!';
			
			case preg_match ( '/\bpbot\b/i', $nickname ) :
				
				return 'Não utilize nome com pbot!';
			
			case preg_match ( '/\bgod\b/i', $nickname ) :
				
				return 'Não utilize nome com GOD!';
			
			case preg_match ( '/\btutor\b/i', $nickname ) :
				
				return 'Não utilize nome com Tutor!';
			
			case preg_match ( '/\btutora\b/i', $nickname ) :
				
				return 'Não utilize nome com Tutora!';
			
			case preg_match ( '/\badm\b/i', $nickname ) :
				
				return 'Não utilize nome com Adm!';
			
			case preg_match ( '/\badmin\b/i', $nickname ) :
				
				return 'Não utilize nome com Admin!';
			
			/*
			 * case self::getMonsterName($nickname):
			 *
			 * return 'Não utilize nome de monstro!';
			 */
			
			case PlayerDAO::registeredName ( $nickname ) :				
				return 'Esse nome ja existe!';
		}
		
		return '';
	}
	public static function getNumberAccount()
	{
		$accounts = array ();
		
		foreach ( Sql::query ( "select `id` from `accounts`" )->fetch_row () as $account )
			
			$accounts [] = $account;
		
		$min = 100000;
		
		$max = 9999999;
		
		$random = rand ( $min, $max );
		
		$account = $random;
		
		do {
			
			$account ++;
			
			if ($account > $max)
				
				$account = $min;
			
			if ($account == $random)
				
				Tools::messageBox ( 'Impossivel de criar uma conta, contacte ao administrador.' );
		} while ( in_array ( $number, $accounts ) );
		
		return $account;
	}
	
	public static function generatePassword($size) {
		$password = '';
		
		do {
			
			switch (rand ( 0, 31 )) 

			{
				
				case 0 :
					$password .= '1';
					break;
				
				case 1 :
					$password .= '2';
					break;
				
				case 2 :
					$password .= '3';
					break;
				
				case 3 :
					$password .= '4';
					break;
				
				case 4 :
					$password .= '5';
					break;
				
				case 5 :
					$password .= '6';
					break;
				
				case 6 :
					$password .= '7';
					break;
				
				case 7 :
					$password .= '8';
					break;
				
				case 8 :
					$password .= '9';
					break;
				
				case 9 :
					$password .= 'a';
					break;
				
				case 10 :
					$password .= 'b';
					break;
				
				case 11 :
					$password .= 'c';
					break;
				
				case 12 :
					$password .= 'd';
					break;
				
				case 13 :
					$password .= 'e';
					break;
				
				case 14 :
					$password .= 'f';
					break;
				
				case 15 :
					$password .= 'g';
					break;
				
				case 16 :
					$password .= 'h';
					break;
				
				case 17 :
					$password .= 'i';
					break;
				
				case 18 :
					$password .= 'j';
					break;
				
				case 19 :
					$password .= 'l';
					break;
				
				case 20 :
					$password .= 'm';
					break;
				
				case 21 :
					$password .= 'n';
					break;
				
				case 22 :
					$password .= 'o';
					break;
				
				case 23 :
					$password .= 'p';
					break;
				
				case 24 :
					$password .= 'q';
					break;
				
				case 25 :
					$password .= 'r';
					break;
				
				case 26 :
					$password .= 's';
					break;
				
				case 27 :
					$password .= 't';
					break;
				
				case 28 :
					$password .= 'u';
					break;
				
				case 29 :
					$password .= 'v';
					break;
				
				case 30 :
					$password .= 'x';
					break;
				
				case 31 :
					$password .= 'z';
					break;
			}
		} while ( strlen ( $password ) < $size );
		
		return $password;
	}
	
	public static function getMonsterName($name)
	{
		$file_monster = '';
		
		$f = @fopen ( $file_monster, 'r' );
		
		if ($f) {
			
			$contents = fread ( $f, filesize ( $file_monster ) );
			
			fclose ( $f );
			
			$tags = explode ( '<', $contents );
			
			foreach ( $tags as $tag ) {
				
				if (substr ( $tag, 0, 7 ) == 'monster') {
					
					$temp = stristr ( $tag, ' name="' );
					
					$temp2 = explode ( '"', $temp );
					
					$monster = $temp2 [1];
				}
				
				if (strtoupper ( $monster ) == strtoupper ( $name ))
					
					return 1;
			}
		}
		
		return 0;
	}
	
	public static function getTownName($id)
	{
	    switch ($id) {
	        case 2: return 'Egeu';
	        case 3: return 'Horpus';
	        case 4: return 'Artemisias';
	        case 5: return 'Styge';
	        case 6: return 'Nissea';
	        case 7: return 'Valentia';
	        case 8: return 'Kypros';
	        case 9: return 'Florensia';
	    }
	    
	    return 'Desconhecida';
	}	
	
	public static function getHouseName($id) 

	{
		$file_house = '';
		
		$f = @fopen ( $file_house, 'r' );
		
		if ($f) {
			
			$contents = fread ( $f, filesize ( $file_house ) );
			
			fclose ( $f );
			
			$tags = explode ( '<', $contents );
			
			foreach ( $tags as $tag ) {
				
				if (substr ( $tag, 0, 5 ) == 'house') {
					
					$temp = stristr ( $tag, ' name="' );
					
					$temp2 = explode ( '"', $temp );
					
					$name = $temp2 [1];
				}
				
				if (substr ( $tag, 0, 5 ) == 'house') {
					
					$temp = stristr ( $tag, ' houseid="' );
					
					$temp2 = explode ( '"', $temp );
					
					$houseid = $temp2 [1];
				}
				
				if ($houseid == $id)
					
					return $name;
			}
		}
		
		return null;
	}
	public static function getHouseTownId($id) 

	{
		$file_house = '';
		
		$f = @fopen ( $file_house, 'r' );
		
		if ($f) {
			
			$contents = fread ( $f, filesize ( $file_house ) );
			
			fclose ( $f );
			
			$tags = explode ( '<', $contents );
			
			foreach ( $tags as $tag ) {
				
				if (substr ( $tag, 0, 5 ) == 'house') {
					
					$temp = stristr ( $tag, ' townid="' );
					
					$temp2 = explode ( '"', $temp );
					
					$townid = $temp2 [1];
				}
				
				if (substr ( $tag, 0, 5 ) == 'house') {
					
					$temp = stristr ( $tag, ' houseid="' );
					
					$temp2 = explode ( '"', $temp );
					
					$houseid = $temp2 [1];
				}
				
				if ($houseid == $id)
					
					return $townid;
			}
		}
		
		return 0;
	}
	public static function reasonid($id) 

	{
		switch (( int ) $id) 

		{
			
			case 0 :
				
				return "Offensive Name";
			
			case 1 :
				
				return "Invalid Name Format";
			
			case 2 :
				
				return "Unsuitable Name";
			
			case 3 :
				
				return "Name Inciting Rule Violation";
			
			case 4 :
				
				return "Offensive Statement";
			
			case 5 :
				
				return "Spamming";
			
			case 6 :
				
				return "Illegal Advertising";
			
			case 7 :
				
				return "Off-Topic Public Statement";
			
			case 8 :
				
				return "Non-English Public Statement";
			
			case 9 :
				
				return "Inciting Rule Violation";
			
			case 10 :
				
				return "Bug Abuse";
			
			case 11 :
				
				return "Game Weakness Abuse";
			
			case 12 :
				
				return "Using Unofficial Software to Play";
			
			case 13 :
				
				return "Hacking";
			
			case 14 :
				
				return "Multi-Clienting";
			
			case 15 :
				
				return "Account Trading or Sharing";
			
			case 16 :
				
				return "Threatening Gamemaster";
			
			case 17 :
				
				return "Pretending to Have Influence on Rule Enforcement";
			
			case 18 :
				
				return "False Report to Gamemaster";
			
			case 19 :
				
				return "Destructive Behaviour";
			
			default :
				return "Unknown Reason";
		}
	}
	
	public static function getVocationNameById($id) {
	    switch ($id) {
	        case 1:
	            return 'Sorcerer';
	        case 2:
	            return 'Druid';
	        case 3:
	            return 'Paladin';
	        case 4:
	            return 'Knight';
	        case 5:
	            return 'Master Sorcerer';
	        case 6:
	            return 'Elder Druid';
	        case 7:
	            return 'Royal Paladin';
	        case 8:
	            return 'Elite Knight';
	        case 9:
	            return 'Hell Wizard';
	        case 10:
	            return 'High Saintess';
	        case 11:
	            return 'Force Archer';
	        case 12:
	            return 'Titan Blader';
	    }
	    
	    return 'None';
	}
}

?>