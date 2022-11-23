<?php

namespace ApplicationModel;

class Database {
    private $connection;
    private $dBInformation;

    private static $Localhost = "localhost";
    private static $Server = "SERVER_NAME";
    
    public function __construct() {

        $serverToRead = $_SERVER[self::$Server];

        // Check if we are using localhost or the production server to know what information to use to login to DB.
        if($serverToRead == self::$Localhost){
            $this->dBInformation = new \LocalSettings();
        } else {
            $this->dBInformation = new \ProductionSettings();
        }

        // Connects to the database using information from the variables inside either of the one above.
        $this->connection = new \mysqli($this->dBInformation->dbServername,
                                 $this->dBInformation->dbUserName, 
                                 $this->dBInformation->dbPassword, 
                                 $this->dBInformation->dbName
                                );
        $this->connection->query("CREATE TABLE IF NOT EXISTS `posts`
        (`id` INT(11) not null PRIMARY KEY AUTO_INCREMENT,
         `username` VARCHAR(100) NOT NULL,
         `content` VARCHAR(1000) NOT NULL,
         `postedDate` DATETIME NOT NULL
        )");
    }

    public function sendNewPostToDB(\ApplicationModel\Post $post, string $name) {

        $content = $post->getPostedText();
        $time = $post->getPostedTime();

        $sql = "INSERT INTO posts (username , content, postedDate) VALUES ('$name', '$content', '$time')";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('sss', $user, $content, $time);
        $stmt->execute();
    }

    public function deletePost($username, \ApplicationModel\Post $postToDelete) : bool{
        if(!$this->controllIfUserCreatedPost($username, $postToDelete->getPostID())) {
            return false;
        }
        $sql = "DELETE FROM posts WHERE id =?;";

        $id = $postToDelete->getPostID();
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        return true;

    }

    // If user doesn't own post he cant delete it.
    public function controllIfUserCreatedPost(string $name, $id) {
        $stmt = $this->connection->prepare("SELECT username FROM posts WHERE id=?");

        $stmt->bind_param('s', $id);
        $stmt->bind_result($usernameOfThePost);

        $stmt->execute();
        $stmt->fetch();

        return $name == $usernameOfThePost;
    }

    public function showPostedContent() {
        $sql = "SELECT * FROM posts ORDER BY id DESC;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        $postsFromDB = array();
        while($row = $res->fetch_assoc()) {
            $postsFromDB[] =
            new \ApplicationModel\Post(
                $row['username'],
                $row['content'],
                $row['postedDate'],
                $row['id']
            );
        }
        return $postsFromDB;
    }
}