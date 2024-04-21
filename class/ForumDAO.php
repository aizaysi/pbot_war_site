<?php
class ForumDAO {
	public static function getTopicos($forumId, $agrupar = false) {
		$list = Array();
		
		$connection = Connection::getInstance(true);
		
		$sql = 'SELECT forum_id, topic_id, post_subject, post_text, post_time FROM phpbb_posts WHERE forum_id = '.$forumId;
		if($agrupar) {
			$sql .= ' GROUP BY topic_id DESC';
		} else {
			$sql .= ' ORDER BY post_time DESC';
		}
		
		$sql .= ' LIMIT 10';
		
		$stmt = $connection->prepare($sql);		
		
		$stmt->execute();
		
		while($result = $stmt->fetch(PDO::FETCH_OBJ)) {			
			$result->post_subject = utf8_encode($result->post_subject);
			$result->post_text = utf8_encode(nl2br(bbcode::remove($result->post_text)));
			$result->post_time = date("j F , Y, g:i a", $result->post_time);
			array_push($list, $result);
		}
		
		return $list;
	}
}
?>