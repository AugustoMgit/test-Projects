<?php
namespace src\handlers;

use \src\models\User;
use \src\models\HistoryCityUser;


class UserHandler{

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
            $data = User::select()->where('token', $token)->one();
            
            //se já tiver um token, se já estiver logado, então pega as informações
            if(count($data)>0){
                $infoUserLogged = new User();
                $infoUserLogged->id_user = $data['id_user'];
                $infoUserLogged->name = $data['name'];
                $infoUserLogged->second_name = $data['second_name'];
                $infoUserLogged->city = $data['city'];
                $infoUserLogged->latitude_user = $data['latitude_user'];
                $infoUserLogged->longitude_user = $data['longitude_user'];
                $infoUserLogged->apelido = $data['apelido'];
                $infoUserLogged->avatar = $data['avatar'];

                return $infoUserLogged;
            }
        }
        return false;
    }

    public static function verifyLogin($email, $passowrd){
        $userData = User::select()->where('email', $email)->one();

        if($userData){
            if($passowrd === $userData['password']){
                $token = md5(time().rand(1,54));
                User::update()->set('token', $token)->where('email', $email)->execute();

                return $token;
            }
        }
        return false;
    }

    public static function emailExists($email){
        $userEmail = User::select()->where('email', $email)->one();
        return $userEmail ? true : false;
    }

    public static function addUser($name, $email, $passowrd){

        $hashPassword = password_hash($passowrd, PASSWORD_DEFAULT);
        $token = md5(time()*80);

        User::insert([
            'name'=>$name,
            'email'=>$email, 'password'=>$hashPassword,
            'token'=>$token
        ])->execute();
 
        return $token;
    }

    public static function addCoords($id_user, $lat, $long, $newCoords){
        self::addCoordsHistory($id_user, $lat, $long);
        if($newCoords === true){
            User::insert([
                'latitude_user'=>$lat,
                'longitude_user'=>$long
            ])->where('id_user', $id_user)->execute();

        }
    }

    private static function addCoordsHistory($id_user, $lat, $long){
        HistoryCityUser::insert([
            'id_user'=>$id_user,
            'latitude_user'=>$lat,
            'longitude_user'=>$long
        ])->execute();
    }

}
