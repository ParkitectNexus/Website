<?php
namespace PN\Users\Repositories;

use PN\Users\User;

interface UserRepositoryInterface
{

    /**
     * validates user credential
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function validateCredentials($email, $password);
    
     /**
     * find by social
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @return User
     */
    public function findBySocial($id, $name, $email);
    
    /**
     * Finds user by api key
     *
     * @param string $apiKey
     * @return User
     */
    public function findByApiKey(string $apiKey) : User;

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User
     */
    public function findByUsername(string $username);

    /**
     * Finds user by steam id
     *
     * @param string $steamId
     * @return User
     */
    public function findBySteamId(string $steamId);

    /**
     * Finds user by token
     * 
     * @param $token
     * @return mixed
     */
    public function findByConfirmToken($token);
}
