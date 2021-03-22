<?php
//a partir do index.php, desse arquivo, é o arquivo inicial que dará a rota e carregamento de tudo
session_start();

//arquivo de configurações. A principal é a conexão com a do banco de dados, fazendo a conexão
require 'config.php';

//percorre todas as classes que foram criadas
spl_autoload_register(function($class){

	if(file_exists('controllers/'.$class.'.php')) {
		require 'controllers/'.$class.'.php';
	}
	else if(file_exists('models/'.$class.'.php')) {
		require 'models/'.$class.'.php';
	}
	else if(file_exists('core/'.$class.'.php')) {
		require 'core/'.$class.'.php';
	}

});

$core = new Core();
$core->run();