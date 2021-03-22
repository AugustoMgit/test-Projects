<?php
//clase Users, que é responsável pelo acesso ao banco de dados e o direcionamento de página
class Users extends Model {

	private $uid;

	public function verifyLogin() { //verifica o login
		if(!empty($_SESSION['chathashlogin'])) { //existe uma sessão já? Armazenada no navegador com chathashlogin
			$s = $_SESSION['chathashlogin']; 

			//agora verifica se existe no banco de dados se tem uma hash.
			//Prepares an SQL statement to be executed by the PDOStatement::execute() method
			//retorna um objeto (prepare)
			$sql = "SELECT * FROM users WHERE loginhash = :hash";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":hash", $s);
			$sql->execute(); //executa o sql

			if($sql->rowCount() > 0) { //se existe um chathashlogin
				$data = $sql->fetch();//pega o dado daquela consula sql, um só
				$this->uid = $data['id'];

				return true;
			} else {
				return false;
			}
		} else { //retorna false e direciona para o login, a própria página
			return false;
		}
	}

	//acessa o usuário que está logado, se passar pela verificação de login
	public function getUid() {
		return $this->uid;
	}

	//valida o nome, apenas com números e letras, com uma expressão regular, preg_match('expressaoRegular', stringComparação)
	public function validateUsername($u) {
		if(preg_match('/^[a-z0-9]+$/', $u)) {
			return true; //se apenas tem apenas letras de A a Z e números de 0 a 9
		} else {
			return false;
		}
	}

	//verifica se o usuário já existe no banco de dados
	public function userExists($u) {

		$sql = "SELECT * FROM users WHERE username = :u";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":u", $u);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true; //se existe, então retorna true e não valida o cadastro
		} else {
			return false;
		}

	}

	//registra o usuário
	public function registerUser($username, $pass) {
		$newpass = password_hash($pass, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users (username, pass) VALUES (:u, :p)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":u", $username);
		$sql->bindValue(":p", $newpass);
		$sql->execute();
	}

	//valida o usuário cadastrado
	public function validateUser($username, $pass) {

		$sql = "SELECT * FROM users WHERE username = :username";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":username", $username);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$info = $sql->fetch();

			if(password_verify($pass, $info['pass'])) {
				//hash aleatório e único
				$loginhash = md5(rand(0,99999).time().$info['id'].$info['username']);

				$this->setLoginHash($info['id'], $loginhash);
				$_SESSION['chathashlogin'] = $loginhash;

				return true;

			} else {
				return false;
			}

		} else {
			return false;
		}

	}

	//seta um novo hash no usuário para o processo de login e cadastro
	private function setLoginHash($uid, $hash) {

		$sql = "UPDATE users SET loginhash = :hash WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":hash", $hash);
		$sql->bindValue(":id", $uid);
		$sql->execute();

	}

	public function clearLoginHash() {
		$_SESSION['chathashlogin'] = '';
	}

	public function updateGroups($groups) {
		$groupstring = '';
		if(count($groups) > 0) {
			$groupstring = '!'.implode('!', $groups).'!';
		}

		$sql = "UPDATE users SET last_update = NOW(), groups = :groups WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':groups', $groupstring);
		$sql->bindValue(':id', $this->uid);
		$sql->execute();
	}

	public function clearGroups() {
		$sql = "UPDATE users SET groups = '' WHERE last_update < DATE_ADD(NOW(), INTERVAL -2 MINUTE)";
		$this->db->query($sql);
	}

	public function getUsersInGroup($group) {
		$array = array();

		$sql = "SELECT username FROM users WHERE groups LIKE :groups";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':groups', '%!'.$group.'!%');
		$sql->execute();

		if($sql->rowCount() > 0) {
			$list = $sql->fetchAll(PDO::FETCH_ASSOC);

			foreach($list as $item) {
				$array[] = $item['username'];
			}
		}

		return $array;
	}

	public function getCurrentGroups() {
		$array = array();

		$sql = "SELECT groups FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $this->uid);
		$sql->execute();
		$sql = $sql->fetch();

		$array = explode('!', $sql['groups']);
		if(count($array) > 0) {
			array_pop($array);
			array_shift($array);

			$groups = new Groups();
			$array = $groups->getNamesByArray($array);
		}

		return $array;
	}

	public function getName() {

		$sql = "SELECT username FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id", $this->uid);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch();

			return $data['username'];
		}

		return '';
	}



}









