<?php
namespace src\controllers;
use \core\Controller;
use src\handlers\UserHandler;
use src\handlers\PostHandler;

class PublishController extends Controller {

    private $infoUser; //armazena as informações do usuário

    public function __construct(){
        //1º Checar se o usuário já tem login, uma sessão, um token, um cookie
        $this->infoUser = UserHandler::checkLogin();
        if($this->infoUser === false) {// se retornar false, então vai ser direcionado para a página de login
            $this->redirect('/login'); 
        }
        $this->render('/');
    }

    public function addPublish(){

        $id_user = $this->loggedUser->id_user;
        $body = filter_input(INPUT_POST, 'body');
        $city =filter_input(INPUT_POST, 'city');
        $type_publish = filter_input(INPUT_POST, 'type_publish');

        
        if($body){
            PostHandler::addPublishBD($id_user, $body, $city, $type_publish);
        }
        //$this->redirect('/');

    }
}