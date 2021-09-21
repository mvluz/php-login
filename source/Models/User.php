<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

class User extends DataLayer
{
    public function __construct()
    {        
        parent::__construct("tbusers",[
            "userFirstName",
            "userLastName",
            "userEmail",
            "userPassword"
        ]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (
            !$this->validateEmail()
            || !$this->validatePassword()
            || !parent::save() // save on database if ok
        ) {
            return false;
        }
        return true;        
    }

    /**
     * @return bool
     */
    public function validateEmail(): bool
    {
        if(
            empty($this->userEmail) 
            || !filter_var($this->userEmail, FILTER_VALIDATE_EMAIL)
        ) {
            $this->fail = new Exception("Informe um e-mail válido (aqui)");
            return false;
        }

        // verify for insert or update
        $userByEmail = null;
        if($this->id){
            $userByEmail = $this->find("userEmail = :email", "email={$this->userEmail}")->count();
        }else{
            $userByEmail = $this->find("userEmail = :email AND id != :id", "email={$this->userEmail}&id={$this->id}")->count();
        }

        if($userByEmail){
            $this->fail = new Exception("O e-mail informado já está em uso");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validatePassword(): bool
    {
        if(empty($this->userPassword) || strlen($this->userPassword < 5)){
            $this->fail = new Exception("Informe uma senha com pelo menos 5 caracteres");
            return false;
        }

        if(password_get_info($this->userPassword)["algo"]){
            return true;
        }

        $this->userPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);
        return true;
    }

}