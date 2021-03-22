<?php
class ajaxController extends controller {

	private $user;

	public function __construct() {
		$this->user = new Users();

		//quando não estiver logado retorna um status 0
		if(!$this->user->verifyLogin()) {
			$array = array(
				'status' => '0'
			);

			echo json_encode($array);
			exit;
		}
	}

	public function index() {}

	//pega todos os grupos e retorna em ordem alfabética
	public function get_groups() {
		$array = array('status' => '1');
		$groups = new Groups(); //Groups.php

		$array['list'] = $groups->getList();

		echo json_encode($array);
		exit;
	}

	public function add_group() {
		$array = array('status' => '1', 'error' => '0');
		$groups = new Groups();

		if(!empty($_POST['name'])) {
			$name = $_POST['name'];

			$groups->add($name);
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Falta o NOME do grupo.';
		}

		echo json_encode($array);
		exit;
	}

	public function add_message() {
		$array = array('status' => '1', 'error' => '0');
		$messages = new Messages();
		if(!empty($_POST['msg']) && !empty($_POST['id_group'])) {
			$msg = $_POST['msg'];
			$id_group = $_POST['id_group'];
			$uid = $this->user->getUid();

			$messages->add($uid, $id_group, $msg, 'text');
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Mensagem vazia';
		}

		echo json_encode($array);
		exit;
	}

	public function add_photo() {
		$array = array('status' => '1', 'error' => '0');
		$messages = new Messages();

		if(!empty($_POST['id_group'])) {
			$id_group = $_POST['id_group'];
			$uid = $this->user->getUid();

			$allowed = array('image/jpeg', 'image/jpg', 'image/png');
			if(!empty($_FILES['img']['tmp_name'])) {
				if(in_array($_FILES['img']['type'], $allowed)) {
					$newname = md5(time().rand(0,9999));
					if($_FILES['img']['type'] == 'image/png') {
						$newname .= '.png';
					} else {
						$newname .= '.jpg';
					}

					move_uploaded_file($_FILES['img']['tmp_name'], 'media/images/'.$newname);
					$messages->add($uid, $id_group, $newname, 'img');
				} else {
					$array['error'] = '1';
					$array['errorMsg'] = 'Arquivo inválido';
				}
			}else {
				$array['error'] = '1';
				$array['errorMsg'] = 'Arquivo em branco';
			}
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Grupo inválido';
		}

		echo json_encode($array);
		exit;
	}

	public function get_userlist() {
		$array = array('status' => '1', 'users' => array());

		$groups = array();
		if(!empty($_GET['groups']) && is_array($_GET['groups'])) {
			$groups = $_GET['groups'];
		}

		foreach($groups as $group) {
			$array['users'][$group] = $this->user->getUsersInGroup($group);
		}

		echo json_encode($array);
		exit;
	}

	//sistema de Long Pooling
	public function get_messages() {
		$array = array('status' => '1', 'msgs' => array(), 'last_time' => date('Y-m-d H:i:s'));
		$messages = new Messages();
		//tempo limite de 60s da requisição de pegar as mensagens
		//se der 60s ele sai e não faz mais requisição
		set_time_limit(5); //uma forma de proteção

		$ult_msg = date('Y-m-d H:i:s'); //data atual ->indica que acabei de entrar no grupo
		if(!empty($_GET['last_time'])) { //se lá no banco não tiver preenchido, então pega a data de hoje e seta pra saber quando recbeu a última mensagem e atualizar
			$ult_msg = $_GET['last_time'];
			
		}

		//se o usuário não tem grupo e é um array, então coloca o grupo
		$groups = array();
		if(!empty($_GET['groups']) && is_array($_GET['groups'])) {
			$groups = $_GET['groups'];
		}

		$this->user->updateGroups( $groups );
		$this->user->clearGroups();

		//enquanto não tiver nova mensagem, ele fica no loop infinito a cada 2 segundos
		while(true) {

			session_write_close();//atualiza o cabeçalho a cada requisição, pois é preciso atualizar o cabeçalho
				//de cada requisição, pois caso contrário, a página sempre ficará carreagndo(pendding) e não 
				//carregará mais nada, ficará em apenas uma requisição	 
				//isso permite carregar qualquer outra coisa no site ao mesmo tempo
				 
			//envia para o banco de dados as informações da mensagem
			$msgs = $messages->get($ult_msg, $groups);
			print(count($msgs));
			//se tiver novas mensagens
			if(count($msgs) > 0) {
				$array['msgs'] = $msgs;
				$array['last_time'] = date('Y-m-d H:i:s');
				print_r($array);
				break;
			//se não tiver uma mensagem nova, a cada 2 egundos ficará pegando uma nova mensagem
			} else {
				sleep(2);
				continue;
			}
		}

		echo json_encode($array);
		exit;
	}


}














