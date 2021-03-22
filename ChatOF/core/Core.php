<?php
//é um mecanismo para dar o ponto de partida para dar o início do MVC
class Core { //new Core()

	//run = iniciar -> rodar
	//1- pega a url que está sendo enviada pelo arquivo index.php
	public function run() {

		$url = '/';
		if(isset($_GET['url'])) {//se foi enviado alugma coisa, então a url = url/noticia/...
			$url .= $_GET['url'];
		}

		$params = array();

		if(!empty($url) && $url != '/') { //se algo foi enviado e for diferente da /, então faz algo
			$url = explode('/', $url); //divide pela barra o que está no link
			array_shift($url); //remove o primeiro registro do array, pois nessa ocasião, é inútil
			//echo $url;

			$currentController = $url[0].'Controller'; //homeController, galeriaController...
			array_shift($url);

			if(isset($url[0]) && !empty($url[0])) {//se o primeiro valor da url estiver preenchido e for difrente da /
				$currentAction = $url[0];
				array_shift($url);
			} else { //senão, vai para o index;
				$currentAction = 'index';
			}

			if(count($url) > 0) {
				$params = $url;
			}

		} else { //se não enviou nada, então vai para os controllers padrão de login, homeController
			$currentController = 'homeController'; //qual é o controller
			$currentAction = 'index'; //qual é a função do controller
		}

		if(!file_exists('controllers/'.$currentController.'.php') || !method_exists($currentController, $currentAction)) {
			$currentController = 'notfoundController';
			$currentAction = 'index';
		}

		$c = new $currentController();

		call_user_func_array(array($c, $currentAction), $params);
		
	}

}