<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// php has two files definition file and execution fiel, and this one is a definition file
// where we going to define this class, and the execution once are for scripts executing such as insert, delete..
//this class is to givee me a signal to say that there is a different between this file and the index.php
//index.php can be executed while chatDao.class cannot be executed
//this class is ment to be imported
// 2nd this is that we need to import this class into index.php and use it there
class ChatDao
{
    // we need to access the $conn object we need to ceate it as a private attribute so we can use it in methods

    //in $conn we store PDO connection
    private $conn;
    public function __construct()
    {
        $servername = "localhost";
        $username = "chat";
        $password = "chat";
        $schema = "chat";
        // here we connecting to the db
        $this->conn = new PDO("mysql:host=$servername;dbname=$schema", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected successfully";
    }

    //in this method we can access the connection
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM messages");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_by_id($id){
        $stmt = $this->conn->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return @reset($result); //@ THIS RAISE A WARNING IF RESULT IS EMPTY
    }

    public function add($text)
    {
        $stmt = $this->conn->prepare("INSERT INTO messages(text) VALUES ('textMeee')");
        $result = $stmt->execute(['text'=>$text]);
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM messages WHERE id=:id");// $ instead of :
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function update($id, $text){
        $stmt = $this->conn->prepare("UPDATE people SET text=:text, WHERE id =:id");
        $stmt->execute(['text'=>$text, 'id'=>$id]);
    }
}
?>