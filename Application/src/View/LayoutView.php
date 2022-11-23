<?php

namespace ApplicationView;

class LayoutView {

    private static $newPost = "Application::NewPost";
    private static $id = "Application::Id";
    private static $data = "Application::Data";
    private static $name = "Application::Name";
    private static $delete = "Application::Delete";
    private static $contentPost = "contentPost";

    private $posts;

    private $theDate; 

    public function render() {
        return '
        <div>
            <h4> Share your thoughts </h4>
                <p> '. $_SESSION['username'] .' </p>
                <p> What are you thinking of ? </p>
                    <form method="post">
                        <textarea name="'. self::$contentPost .'" rows="5" cols="100"></textarea><br>
                        <button name="'. self::$newPost . '" > Add new post</button><br>
                    </form><br>
            '. $this->posts .'
        </div>
        ';
    }

    public function wantToAddNewPost() {
        return isset($_POST[self::$newPost]);
    }

    public function getNewPost(string $name): \ApplicationModel\Post {
        $content = $_POST[self::$contentPost];
        $time = date("Y/m/d H:i:s");

        return new \ApplicationModel\Post($name, $content, $time, $id);

    }

    public function wantToDeletePost() {
        return isset($_POST[self::$delete]);
    }

    public function getPost() {
        return new \ApplicationModel\Post($_POST[self::$name], $_POST[self::$data], '', $_POST[self::$id]);
    }

    public function setPosts(array $data) : void{
        foreach($data as $post) {
            $this->posts .= '
            <form method="post">
            <input name="'. self::$id .'" value="'. $post->getPostId() .'" type="hidden">
            <h4>  '. $post->getPostUser() .'</h4>
            <p>'. htmlspecialchars($post->getPostedText()) .'</p>
            <p > '. $post->getPostedTime() .'</p>
            <button name="'. self::$delete .'">Delete</button>
            </form>
            ';
        }
    }
}