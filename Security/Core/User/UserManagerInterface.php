<?php

namespace Benji07\SsoBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserManager
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
interface UserManager
{
    /**
     * Trouve un utilisateur en fonction des informations renvoyé par le sso
     *
     * @param string $providerName the provider name
     * @param array  $userInfos    user informations
     *
     * @return UserInterface|null
     */
    function findUser($providerName, array $userInfos = array());

    /**
     * Crée un utilisateur en fonction des informations renvoyé par le sso
     *
     * @param string $providerName the provider name
     * @param array  $userInfos    user informations
     *
     * @return UserInterface | Response
     */
    function createUser($providerName, array $userInfos = array());
}