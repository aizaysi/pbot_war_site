<?php

class AccountDAO {
	
	public static function login($name, $password) {		
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('SELECT * FROM accounts WHERE name = ? and password = ?');
		
		$stmt->bindParam(1, $name);
		
		$stmt->bindParam(2, $password);
		
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		
		return $result;
	
	}
	
	public static function register($name, $password, $email) {		
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('INSERT INTO accounts(name, password, email, creation) VALUES(?, ?, ?, ?)');
		
		$stmt->bindValue(1, $name);
		
		$stmt->bindValue(2, $password);
		
		$stmt->bindValue(3, $email);
		
		$stmt->bindValue(4, time());
		
		return $stmt->execute();	
	}
	
	public static function usedAccountName($value) {		
		return self::used('name', $value);
	}
	
	public static function usedEmail($value) {
		return self::used('email', $value);
	
	}
	
	private static function used($name, $value) {
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('SELECT `id` FROM `accounts` WHERE `' . $name . '` LIKE ?');
		
		$stmt->bindParam(1, $value);
		
		$stmt->execute();
		
		return $stmt->rowCount() > 0;
	
	}
	
	public static function getCountPlayers($accountId) {		
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('SELECT COUNT(id) as qnt FROM players WHERE account_id = ?');
		
		$stmt->bindParam(1, $accountId);
		
		$stmt->execute();
		
		return $stmt->fetch(PDO::FETCH_OBJ)['qnt'];	
	}
	
	public static function getPlayers($accountId) {
		$connection = Connection::getInstance();
	
		$stmt = $connection->prepare('SELECT name, level FROM players WHERE account_id = ? ORDER BY name');
	
		$stmt->bindParam(1, $accountId);
	
		$stmt->execute();
	
		$list = Array();
	
		while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
			array_push($list, $result);
		}
	
		return $list;
	}
	
	public static function recovery($email) {
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('SELECT id, name FROM accounts WHERE email = ?');
		$stmt->bindParam(1, $email);
		
		$stmt->execute();
				
		if($stmt->rowCount()) {
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			$id = $result->id;
			$login = $result->name;
			
			$recoveryKey = sha1($id+Tools::generatePassword(4));
			
			$sended = Tools::sendEmail($email, $login, 'Recuperação de senha', 'Olá '.$login.',<br/><br/> acesse esse <a href="http://'.$_SERVER['SERVER_NAME'].'/account.html?key='.$recoveryKey.'">link</a> para seguir com o procedimento.');
			
			if($sended) {
				$stmt = $connection->prepare('UPDATE accounts SET recoverykey = ? WHERE id = ?');
					
				$stmt->bindValue(1, $recoveryKey);
				$stmt->bindValue(2, $id);
					
				return $stmt->execute();
			}
		}
			
		return false;
	}
	
	public static function setPassword($key, $password) {
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('UPDATE accounts SET recoverykey = null, password = ? WHERE recoverykey = ?');
			
		$stmt->bindValue(1, sha1($password));
		$stmt->bindValue(2, $key);
			
		return $stmt->execute();
	}
	
	public static function changePassword($account, $password) {
		$connection = Connection::getInstance();
	
		$stmt = $connection->prepare('UPDATE accounts SET password = ? WHERE id = ?');
		
		$password = sha1($password);
		
		$stmt->bindValue(1, $password);
		$stmt->bindValue(2, $account->id);
		
		if($stmt->execute()) {
			$account->password = $password;
			return true;
		}
		
		return false;
	}
	
	public static function recoveryKeyExist($key) {
		$connection = Connection::getInstance();
		
		$stmt = $connection->prepare('SELECT id FROM accounts WHERE recoverykey = ?');
		$stmt->bindParam(1, $key);
		
		return $stmt->execute() && $stmt->rowCount();
	}
}

?>