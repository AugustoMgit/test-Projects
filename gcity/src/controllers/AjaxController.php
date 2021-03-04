<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class AjaxController extends Controller {

    private $loggedUser;

    /*public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false) { //se ele não está logado, retorna um erro
            header("Content-Type: application/json");
            echo json_encode(['error' => 'Usuário não logado']); //array com as informações de erro, quando der like e não estiver logado 
            exit;
        }
    }*/

    public function setCoords(){
        $array = ['error' => ''];

        $id_user = $this->loggedUser->id_user;
        $lat = filter_input(INPUT_POST, 'lat');
        $long = filter_input(INPUT_POST, 'long');
        $newCoordReq = filter_input(INPUT_POST,'newCoordReq');

        

        $array['newCoordReq'] = $newCoordReq;
        
        if($id_user && $lat && $long){
            $newCoordReq == 1 ? $newCoords=true : $newCoords=false;
            UserHandler::addCoords($id_user, $lat, $long, $newCoords);
            
            $array['id_user'] =$id_user;
            $array['lat'] = $lat;
            $array['long'] = $long;
        }else{
            $array['error'] = 'Dados invalidos';
        }

        header("Content-Type: application/json");
        echo json_encode($array);//retorna o array com uma resposta
        exit;
    }

    public function addPublish(){

        $id_user = $this->loggedUser->id_user;
        $body = filter_input(INPUT_POST, 'body');
        $city = filter_input(INPUT_POST, 'city');
        $type_publish = filter_input(INPUT_POST, 'type_publish');

        
        if($body){
            PostHandler::addPublishBD($id_user, $body, $city, $type_publish);
        }
        //$this->redirect('/');

  

    }

}