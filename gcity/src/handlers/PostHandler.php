<?php
namespace src\handlers;

use \src\models\Publish;

class PostHandler {

    public static function addPublishBD($id_user,$city, $body, $type_publish){
        $body=trim($body);

        if(!empty($id_user) && !empty($body)){
            Publish::insert([
                'id_user_public' => $id_user,
                'create_at' => date('Y-m-d H:i:s'),
                'body' => $body,
                'city' =>$city,
                'UF' => 'RS',
                'rua'=>'Nenhuma',
                'type_publish' => $type_publish,
                'latitude' => -10.25,
                'longitude'=> 52.18
            ])->execute();
        }
    }

}
