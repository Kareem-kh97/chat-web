<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'dao/ChatDao.class.php';

require_once '../vendor/autoload.php';

// Flight::register('chatDao', 'ChatDao');
$chatDao = new ChatDao();

Flight::route('GET /messages', function(){ 
Flight::json(Flight::chatDao()->get_all());
});

    Flight::route('GET /messages/@id', function($id){
        Flight::json(Flight::chatDao()->get_by_id($id));
        });

Flight::route('POST /messages', function(){ // i deleted $id from the parameter
    Flight::json(Flight::chatDao()->add(Flight::request()->data->getData()));
    });

    Flight::route('PUT/messages/@id', function($id){
        $data = Flight::request()->data->getData();
        $data['id'] = $id;
    Flight::json(Flight::chatDao()->update($data));
    });

    Flight::route('DELETE/people/@id', function($id){
        Flight::chatDao()->delete($id);
        Flight::json(["message" => "deleted"]);
        });

    Flight::start();


?>