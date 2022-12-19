<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once("rest/dao/ChatDao.class.php"); // in here we imported that class to use its methods here

$dao = new ChatDao();

$results = $dao->get_all();

print_r($results);

// so we can see that the chaDao.class.php was ment to be imported not executed
// and we create an instance of it and create a erquest


?>