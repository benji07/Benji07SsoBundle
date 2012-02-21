<?php

interface UserManager
{
    /**
     * Trouve un utilisateur en fonction des informations renvoyé par le sso
     *
     * @return UserInterface|null
     */
    function findUser($providerName, array $userInfos = array());

    /**
     * Crée un utilisateur en fonction des informations renvoyé par le sso
     *
     * @return UserInterface | Response
     */
    function createUser($providerName, array $userInfos = array());
}