<?php
//classe para carregar as páginas
//aqui direciona para a pasta views para carregar a página html, passando pelo loginController
class controller {

	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		require 'views/'.$viewName.'.php'; //chama e carrega aqui, por isso é possível passar o viewData com as informações de loginController
	}

	public function loadTemplate($viewName, $viewData = array()) {
		require 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData = array()) {
		extract($viewData);
		require 'views/'.$viewName.'.php';
	}

}