<?php

class DB
{

    public function __construct() 
    {
        try {
            $this->db = new PDO(
                        'mysql:host=devkinsta_db;dbname=Simple_CMS',
                        'root',
                        '6Yrof25ml8JpUOru'
                        );
        } catch ( PDOException $error ) {
            die("Database connection failed");
        }   
    }


    public static function connect()
    {
        return new self(); // equal to new DB()
    }


    /**
     *  triggering commands via PDO
     * 
     */

    public function select( $sql, $data = [], $is_list = false )
    {
        // prepare
        $statement = $this->db->prepare( $sql );
        //execute
        $statement->execute( $data );
        //if $is_list is false it will return single record
        // but if changed to true it will return all records
        if( $is_list ) {
            return $statement->fetchAll( PDO::FETCH_OBJ );
        } else {
            return $statement->fetch( PDO::FETCH_OBJ );
        }


    }


    public function insert( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $this->db->lastInsertID();

    }


    public function update( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $statement->rowcount();
    }


    public function delete( $sql, $data = [] )
    {
        $statement = $this->db->prepare( $sql );
        $statement->execute( $data );
        return $statement->rowcount();
    }


}

