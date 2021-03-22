<?php
class homeController extends controller {

	private $user;

	public function __construct() {
		$this->user = new Users(); //instancia o Users, responsável pelo usuário

		if(!$this->user->verifyLogin()) { //verifica login. Se deu problema, volta para o login e retorna para a vaiável user
			header("Location: ".BASE_URL."login");//redireciona site.com/login
			exit;
		}
	}

	public function index() {
		$data = array(
			'name' => $this->user->getName(),
			'current_groups' => $this->user->getCurrentGroups()
		);

		$this->loadTemplate('home', $data);

	}

}