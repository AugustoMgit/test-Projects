<?php
class Messages extends Model {

	//adiciona mensagens do banco de dados
	public function add($uid, $id_group, $msg, $msg_type = 'text') {

		$sql = "INSERT INTO messages (id_user, id_group, date_msg, msg, msg_type) VALUES (:uid, :id_group, NOW(), :msg, :msg_type)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':uid', $uid);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':msg', $msg);
		$sql->bindValue(':msg_type', $msg_type);
		$sql->execute();

	}

	//recebe as mensagens a partir do momento em que uma pessoa chega no grupo
	//last_time = só  irá pegar as mensagens depois de entrar no grupo. Para isso, é preciso saber quais mensagens irá ser pego para o usuário
	//groups = grupo em que o usuário está
	public function get($last_time, $groups) { 
		$array = array();

		$sql = "SELECT
		messages.*,
		users.username
		FROM messages 
		LEFT JOIN users ON users.id = messages.id_user
		WHERE date_msg > :date_msg AND id_group IN (".(implode(',', $groups)).")";
		echo $sql;
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':date_msg', $last_time); //envia
		$sql->execute();

		echo "oiiiiiiiiiii";
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
			
		}

		return $array;
	}

}