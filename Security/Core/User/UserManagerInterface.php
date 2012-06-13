<?php

namespace Benji07\SsoBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserManager
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
interface UserManagerInterface
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

    /**
     * Lie un utilisateur a un provider
     *
     * @param  UserInterface $user         the user
     * @param  string        $providerName the provider name
     * @param  array         $userInfos    user informations
     */
    function linkUser(UserInterface $user, $providerName, $userInfos);

    /**
     * Supprime le lien a un provider
     *
     * @param  UserInterface $user         the user
     * @param  string        $providerName the provider name
     */
    function unlinkUser(UserInterface $user, $providerName);
}
