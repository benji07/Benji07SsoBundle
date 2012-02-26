<?php

namespace Benji07\SsoBundle\Security\Http\EntryPoint;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Http\HttpUtils,
    Symfony\Component\HttpFoundation\Request;

use Benji07\SsoBundle\Providers\Factory;

/**
 * Sso EntryPoint
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SsoEntryPoint implements AuthenticationEntryPointInterface
{

    protected $httpUtils;

    protected $ssoProviders;

    protected $checkPath;

    protected $loginPath;

    /**
     * __construct
     *
     * @param HttpUtils $httpUtils    httpUtils
     * @param Factory   $ssoProviders ssoProviders
     * @param string    $checkPath    checkPath
     * @param string    $loginPath    loginPath
     */
    public function __construct(HttpUtils $httpUtils, Factory $ssoProviders, $checkPath, $loginPath)
    {
        $this->httpUtils = $httpUtils;
        $this->ssoProviders = $ssoProviders;
        $this->checkPath = $checkPath;
        $this->loginPath = $loginPath;
    }

    /**
     * Starts the authentication scheme.
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if (!$this->httpUtils->checkRequestPath($request, $this->checkPath)) {
            if ($this->httpUtils->checkRequestPath($request, $this->loginPath)) {
                $request->getSession()->remove('_security.target_path');
            }

            $providerName = $request->query->get('provider');

            if ($providerName) {

                $request->getSession()->set('sso_provider', $providerName);

                $provider = $this->ssoProviders->get($providerName);

                $checkPathUrl = $this->httpUtils->createRequest($request, $this->checkPath)->getUri();

                $redirectUrl = $provider->handleRequest($request, $checkPathUrl);

                return $this->httpUtils->createRedirectResponse($request, $redirectUrl);
            }
        }

        throw $authException;
    }
}