<?php
require_once __DIR__ . '/BaseService.class.php';
require_once __DIR__ . '/../dao/ContactDao.class.php';
require_once __DIR__ . '/../dao/UserDao.class.php';

class ContactService extends BaseService
{

  private $user_dao;

  public function __construct()
  {
    parent::__construct(new ContactDao());
    $this->user_dao = new UserDao();
  }

  public function get_user_contacts($user, $search = NULL)
  {

    Flight::json(["message" => "Hi "], 404);
    return $this->dao->get_user_contacts($user['id'], $search);
  }
}
