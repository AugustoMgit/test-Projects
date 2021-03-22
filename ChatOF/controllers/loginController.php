<?php
//aqui é feito o "back-end" antes de carregar os views, que tem as páginas html.
class loginController extends controller {

	public function index() { 
		$data = array(
			'msg' => ''
		);

		if(!empty($_GET['error'])) {
			if($_GET['error'] == '1') {
				$data['msg'] = 'Usuário e/ou senha inválidos!';
			}
		}

		$this->loadView('login', $data);
	}

	//entrar no sistema de chat
	public function signin() {

		if(!empty($_POST['username'])) {
			$username = strtolower($_POST['username']);
			$pass = $_POST['pass'];

			$users = new Users();
			if($users->validateUser($username, $pass)) {
				header("Location: ".BASE_URL);
				exit;
			} else {
				header("Location: ".BASE_URL.'login?error=1');//vai para o index, alí de cima
				exit;
			}
		} else {
			header("Location: ".BASE_URL.'login');
			exit;
		}

	}

	//tela de cadastro
	public function signup() {
		//array de respostas para a tela de cadastro de html
		$data = array(
			'msg' => ''
		);

		if(!empty($_POST['username'])) {
			//pega os dados recebidos do input da tela de cadastro
			$username = strtolower($_POST['username']);
			$pass = $_POST['pass'];

			//verifica se tem no banco de dados
			$users = new Users();

			//validações antes de cadastrar
			if($users->validateUsername($username)) {
				if(!$users->userExists($username)) {//verifica se existe. Se ele não existe
					$users->registerUser($username, $pass);

					header("Location: ".BASE_URL."login");
					exit;
				} else {
					$data['msg'] = 'Usuário já existente!';
				}
			} else { //essa mensagem vai para o login.php
				$data['msg'] = 'Usuário não válido (Digite apenas letras e números).';
			}
		}

		$this->loadView('signup', $data); //chama a função loadView para carregar a página html de signup
	}

	public function logout() {
		$users = new Users();
		$users->clearLoginHash();

		header("Location: ".BASE_URL.'login');
	}

}
















