<?php
namespace src\controllers;
use \core\Controller;
use src\handlers\UserHandler;

class HomeController extends Controller {

    private $infoUser; //armazena as informações do usuário

    public function __construct(){
        //1º Checar se o usuário já tem login, uma sessão, um token, um cookie
        $this->infoUser = UserHandler::checkLogin();
        if($this->infoUser === false) {// se retornar false, então vai ser direcionado para a página de login
            $this->redirect('/login'); 
        }
        $this->render('/');
    }

    public function index() {

        
        $this->render('home', ['dataUser' => $this->infoUser ]);
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}