<?php
namespace src\controllers;
use \core\Controller;
use src\handlers\UserHandler;

class LoginController extends Controller {

    public function signin(){
        $this->render('signin');
    }

    public function signinLogged(){

        $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = filter_input(INPUT_POST, 'password');

        
        if($email && $password){
            $token = UserHandler::verifyLogin($email, $password);
            if($token){
                $_SESSION['token'] = $token;

                $this->redirect('/');
            }
        }else{
            $this->redirect('/login');
        }

    }

    //carrega a tela
    public function signup(){
        //$this->render('signup');
        $flash = '';
        if(!empty($_SESSION['flash'])) { //verifica se já tem algum erro, se não tem
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signup', [ //se não tiver nenhum erro, então carrega a página signup.php
            'flash' => $flash
        ]);
    }

    //transfere as informações para o banco de dados
    public function signupCheck(){
        $name = htmlspecialchars(filter_input(INPUT_POST,'name'));
        $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $passowrd = filter_input(INPUT_POST, 'password');

        
        if($name && $email && $passowrd){
            if(UserHandler::emailExists($email) === false){
                //se não existir
                $token = UserHandler::addUser($name, $email, $passowrd);
                $_SESSION['token'] = $token;
                $this->redirect('/');
            }else{
                //email já existe
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/cadastro');
            }

        }else{
            $_SESSION['flash'] = 'Digite todos os campos corretamente!';
        }
    }


}