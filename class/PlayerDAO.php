<?php

class PlayerDAO
{

    public static function create($name, $sex, $vocation, $accountId)
    {
        $connection = Connection::getInstance();
        
        /*
         * $towns = Array(2, 4, 5, 6, 7, 8);
         * $stmt = $connection->prepare('SELECT town_id FROM (SELECT town_id, count(*) as min FROM players WHERE town_id in ('.join(',', $towns).') GROUP BY town_id) as temp ORDER BY min LIMIT 1;');
         * $stmt->execute();
         *
         * $town_id = $stmt->fetch(PDO::FETCH_ASSOC)['town_id'];
         *
         * if ($town_id == null) {
         * $town_id = $towns[0];
         * }
         */
        
        $startCap = 400;
        $startHealth = 150;
        
        $town_id = 4;
        $level = 8;
        $points = 5;
        $mana = 0;
        $health = 0;
        $cap = 0;
        if ($vocation == 1 || $vocation == 2) {
            $mana = 30;
            $health = 5;
            $cap = 10;
        } elseif ($vocation == 3) {
            $mana = 15;
            $health = 10;
            $cap = 20;
        } elseif ($vocation == 4) {
            $mana = 5;
            $health = 15;
            $cap = 25;
        }
        
        $mana *= $level;
        $cap = $startCap + ($cap * $level);
        $health = $startHealth + ($health * $level);
        $points *= $level;
        
        $stmt = $connection->prepare('
			INSERT INTO `players`
				(`name`, `account_id`, `vocation`, `level`, `sex`, `town_id`, `cap`, `health`, `healthmax`, `mana`, `manamax`, `points`, `conditions`, `looktype`, `lookbody`, `lookfeet`, `lookhead`, `looklegs`)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 69, 76, 78, 58)');
        
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $accountId);
        $stmt->bindValue(3, $vocation);
        $stmt->bindValue(4, $level);
        $stmt->bindValue(5, $sex);
        $stmt->bindValue(6, $town_id);
        $stmt->bindValue(7, $cap);
        $stmt->bindValue(8, $health);
        $stmt->bindValue(9, $health);
        $stmt->bindValue(10, $mana);
        $stmt->bindValue(11, $mana);
        $stmt->bindValue(12, $points);
        $stmt->bindValue(13, '');
        $stmt->bindValue(14, ($sex == 0 ? 136 : 128));
        
        return $stmt->execute();
    }

    public static function registeredName($name)
    {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare('SELECT id FROM players WHERE name LIKE ?');
        $stmt->bindParam(1, $name);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    private static $QUANTIDADE_RANK = 5;

    private static $TOWN_ROOK = 9;

    public static function getPlayersByRank($vocation, $rank, $page)
    {
        $list = Array();
        
        $connection = Connection::getInstance();
        $inicio = (self::$QUANTIDADE_RANK * (int) $page) - self::$QUANTIDADE_RANK;
        switch ($rank) {
            case 'level':
            case 'maglevel':
            case 'skill_fist':
            case 'skill_club':
            case 'skill_sword':
            case 'skill_axe':
            case 'skill_dist':
            case 'skill_shielding':
            case 'frags':
                break;
            
            default:
                return $list;
        }
        
        $whereVocation = '';
        $vocation = (int) $vocation;
        if ($vocation > 0) {
            $whereVocation = ' AND vocation IN (';
            if ($vocation == 1) {
                $whereVocation .= '1, 5, 9';
            } else if ($vocation == 2) {
                $whereVocation .= '2, 6, 10';
            } else if ($vocation == 3) {
                $whereVocation .= '3, 7, 11';
            } else if ($vocation == 4) {
                $whereVocation .= '4, 8, 12';
            }
            $whereVocation .= ')';
        }
        
        $subSelect = $rank;
        
        if ($rank == 'frags') {
            $subSelect = '(SELECT count(player_id) FROM player_deaths WHERE is_player = 1 AND killed_by = name OR mostdamage_is_player = 1 AND mostdamage_by = name) as frags';
        }        
        
        $stmt = $connection->prepare('SELECT name, ' . $subSelect . ' FROM players WHERE group_id = 1 ' . $whereVocation . ' ORDER BY ' . $rank . ' DESC LIMIT ' . $inicio . ', ' . self::$QUANTIDADE_RANK);
        $stmt->execute();
        
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($list, (object) Array(
                'name' => $result['name'],
                'rank' => $result[$rank]
            ));
        }
        
        return $list;
    }

    public static function getCountPlayersOnline()
    {
        $connection = Connection::getInstance();
        
        $stmt = $connection->prepare('SELECT count(*) as qnt FROM players_online');
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC)['qnt'];
    }

    public static function getPlayersOnline()
    {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare('SELECT name, vocation, level FROM players p JOIN players_online po ON p.id = player_id WHERE group_id = 1');
        $stmt->execute();
        
        $list = Array();
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($list, (object) Array(
                'name' => $result['name'],
                'vocation' => Tools::getVocationNameById($result['vocation']),
                'level' => $result['level']
            ));
        }
        
        return $list;
    }

    public static function getInfoByName($name)
    {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare('
            SELECT id, name, vocation, level, sex, town_id, lastlogin, 
                (SELECT premdays FROM accounts WHERE id = account_id) as premdays,
                (SELECT name FROM guilds as g JOIN guild_membership as gm ON g.id = gm.guild_id WHERE player_id = p.id) as guildName
            FROM players as p WHERE name LIKE ? AND group_id = 1
        ');
        $stmt->bindParam(1, $name);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result) {
            $result->vocation = Tools::getVocationNameById($result->vocation);
            $result->sex = $result->sex == 0 ? 'Feminino' : 'Masculino';
            $result->town = Tools::getTownName($result->town_id);
            $result->accountStatus = $result->premdays > 0 ? 'Premium' : 'Free';
            $result->lastlogin = date("d-m-Y H:i:s", $result->lastlogin);
            unset($result->town_id);
            
            $result->deaths = array();
            
            $stmt = $connection->prepare('
                SELECT `time`, level, killed_by, is_player, mostdamage_by, mostdamage_is_player FROM player_deaths WHERE player_id = ? ORDER BY `time` DESC LIMIT 5
            ');
            $stmt->bindParam(1, $result->id);
            $stmt->execute();
            
            while ($death = $stmt->fetch(PDO::FETCH_OBJ)) {
                array_push($result->deaths, $death);
                $death->time = date("d-m-Y H:i:s", $death->time);
            }
            
            unset($result->id);
        }
        
        return $result;
    }
}
?>