<?php
class Connection
{
    
    private static $host = '45.35.154.184';
    private static $password = '@pbgame.3154';
    private static $dbName = 'pbot';
    private static $user = 'root';
    
    /*private static $host = '127.0.0.1';
    private static $password = '';
    private static $dbName = 'uot';
    private static $user = 'root';*/

    public static function getInstance($forum = false)
    {
        if ($forum) {
            $host = '184.107.54.145';
            $dbname = 'autopert_pbforum';
            $user = 'autopert_pbforum';
            $pass = 'fOrump.bO12@';
        } else {
            $host = self::$host;
            $dbname = self::$dbName;
            $user = self::$user;
            $pass = self::$password;
        }
        
        try {
            return new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
        } catch (PDOException $e) {
            echo ('Não foi possivel estabelecer uma conexão.');
            return;
        }
    }
}
?>