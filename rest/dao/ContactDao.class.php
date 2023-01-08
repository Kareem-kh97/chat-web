<?php
require_once __DIR__.'/BaseDao.class.php';

class ContactDao extends BaseDao{

  /**
  * constructor of dao class
  */
  public function __construct(){
    parent::__construct("contacts");
  }

  public function get_user_contacts($user_id, $search = NULL){
  //  return $this->query("SELECT * FROM notes WHERE user_id = :user_id", ['user_id' => $user_id]);
    $query = "(SELECT n.*
    FROM notes n JOIN shared_notes sn ON n.id = sn.note_id AND sn.user_id = :user_id
    ";
    $query = `SELECT u.first_name, u.last_name, u.email, u.status
    FROM users u
    JOIN contacts c ON c.user_id = u.id
    WHERE u.id IN (SELECT cs.contact_id FROM contacts cs WHERE cs.user_id = :user_id)
    `;
    // if (isset($search)){
    //   $query .= " AND n.name LIKE '%".$search."%'";
    // }

    // $query .= ")
    // UNION
    // (SELECT b.*
    // FROM notes b
    // WHERE b.user_id = :user_id";

    // if (isset($search)){
    //   $query .= " AND b.name LIKE '%".$search."%' ";
    // }

    // $query .=")";

    return $this->query($query, ['user_id' => $user_id]);
  }

  public function get_by_id($id){
    return $this->query_unique('SELECT n.*, DATE_FORMAT(n.created, "%Y-%m-%d") created FROM notes n WHERE n.id = :id', ['id' => $id]);
  }
}

?>
