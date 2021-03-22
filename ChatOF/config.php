<?php
require 'environment.php';

//conexão com o banco de dados
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/ChatOF/"); //define = define uma constante BASE_URL
	$config['dbname'] = 'batepapo';
	$config['host'] = '127.0.0.1:3307';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://meusite.com.br/");
	$config['dbname'] = 'estrutura_mvc';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

global $db; //acesso global para o banco de dados
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], 
			$config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}