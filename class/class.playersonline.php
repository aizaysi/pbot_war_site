<?PHP
$timeUpdate = 5*60;
class PlayersOnline {
	
    private static function generateJson() {
        return (object)Array('time'=>time()+$GLOBALS['timeUpdate'], 'players' => PlayerDAO::getPlayersOnline());
    }
    
	public static function getInstance() {
	    $folder = dirname(__FILE__).'/../online.json';
	    $content = file_get_contents($folder);
	    $json = null;
	    if(!$content) {
	        $json = self::generateJson();
	        file_put_contents($folder, json_encode($json));
	    } else {
	        $json = json_decode($content);
	        if(time() > $json->time) {
	            $json = self::generateJson();
	            file_put_contents($folder, json_encode($json));
	        }
	    }
	    
	    return $json;
	}
}