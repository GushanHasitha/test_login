<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    public function userRegister($username, $email, $password) {
        //print_r($password);
        //die();
        $this->db->trans_start();
        $this->db->query("INSERT INTO `users` (`user_name`, `email`, `password`) VALUES (?, ?, ?)", array($username, $email, $password));
        $this->db->trans_complete();
        //$o = $this->db->trans_status();
        //print_r($o);
        //die();

        if($this->db->trans_status() === FALSE) {
           
            throw new Exception("database error occurred");
        }
    }

    public function userLogin($username = '', $password = '') {

        //print_r($username);
        //print_r($password);
        //die();

        if (empty($username) || empty($password)) {
            throw new Exception('username or password can\'t be empty');
        }

        $query = $this->db->query("SELECT * FROM `users` WHERE `user_name` = ?", array($username));
        $admin = $query->row();

        if(!isset($admin)) {
            throw new Exception('Invalid details');
        }

        if(!password_verify($password, $admin->password)) {
            throw new Exception('password is not correct');
        }
        
        return $admin;
    }

    public function isUniqueUsernameAJAX($username) {
        $query = $this->db->query("SELECT * FROM `users` WHERE `user_name` = ?", array($username));
        if($query->num_rows() == 1) {
            return "username already exists";
        }
        return TRUE;
    }

    public function getAllUsers() {
        $query = $this->db->query("SELECT * FROM `users`");
        return $query->result();
    }

    public function deleteUserAJAX($id = '') {
       $this->db->trans_start();
       $this->db->query("DELETE FROM `users` WHERE `id` = ?", array($id));
       $this->db->trans_complete();

       if($this->db->trans_status() === FALSE) {
           throw new Exception("database error occurred");
       }
    }

    public function updateUserAJAX($id = '', $username = '', $email = '') {
        $this->db->trans_start();
        $this->db->query("UPDATE `users` SET `user_name` = ?, `email` = ? WHERE `id` = ?", array($username, $email, $id));
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE) {
            throw new Exception("database error occurred");
        }
    }
}
