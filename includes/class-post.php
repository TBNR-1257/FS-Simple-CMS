<?php

class Post
{
    public static function getAllPosts()
    {
        return DB::connect()->select(
            'SELECT * FROM posts ORDER BY id DESC',
            [],
            true
        );
    }


    public static function getPostById( $post_id )
    {
        return DB::connect()->select(
            'SELECT * FROM posts WHERE id = :id',
            [
                'id' => $post_id
            ]
        );
    }


    // add new post
    public static function add( $title, $content )
    {
        return DB::connect()->insert(
            'INSERT INTO posts (title , content , user_id ) 
            VALUES (:title, :content, :user_id )',
            [
                'title' => $title,
                'content' => $content,
                'user_id' => $_SESSION['user']['id']
            ]
        );
    }



    // update post
    public static function update( $id, $title, $content, $status )
    {
        return DB::connect()->update(
            'UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id',
            [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'status' => $status
            ]
        );
    }



    // delete post
    public static function delete( $id )
    {
        return DB::connect()->delete(
            'DELETE FROM posts where id = :id',
            [
                'id' => $id
            ]
        );
    }

}