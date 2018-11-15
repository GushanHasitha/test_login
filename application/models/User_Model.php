<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    public function userRegister($username, $email, $password) {
        $this->db->trans_start();
        $this->db->query("INSERT INTO `users` (`user_name`, `email`, `password`) VALUES (?, ?, ?)", array($username, $email, $password));
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE) {
            
        }
        else {
            $output = "you are successfully registered";
        }
        return $output;
    }

    public function userLogin($username, $password) {
        //print_r($username);
        //die();
        $query = $this->db->query("SELECT * FROM `users` WHERE `user_name` = ? AND `password` = ?", array($username, $password));
        if($query->num_rows() == 1) {
            return $query->row();
        }
        else {
            return FALSE;
        }
    }

}
