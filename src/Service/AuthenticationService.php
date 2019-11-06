<?php


namespace JsonRpcAuthorizationBundle\Service;


use JsonRpcAuthorizationBundle\Contract\CredentialsCheckerInterface;
use JsonRpcAuthorizationBundle\Contract\CredentialsInterface;
use JsonRpcAuthorizationBundle\Contract\CredentialsReceiverInterface;
use JsonRpcAuthorizationBundle\Exception\AuthNotGrantedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class AuthenticationService extends AbstractGuardAuthenticator
{

    /**
     * @var HelperService
     */
    protected $helperService;
    /**
     * @var CredentialsReceiverInterface
     */
    protected $credentialsReceiver;
    /** @var CredentialsCheckerInterface */
    protected $credentialsChecker;

    /**
     * AuthenticationService constructor.
     * @param HelperService $helperService
     * @param CredentialsReceiverInterface $credentialsReceiver
     * @param CredentialsCheckerInterface $credentialsChecker
     */
    public function __construct(
        HelperService $helperService,
        CredentialsReceiverInterface $credentialsReceiver,
        CredentialsCheckerInterface $credentialsChecker
    ) {
        $this->helperService       = $helperService;
        $this->credentialsReceiver = $credentialsReceiver;
        $this->credentialsChecker = $credentialsChecker;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *
     * - For a form login, you might redirect to the login page
     *
     *     return new RedirectResponse('/login');
     *
     * - For an API token authentication system, you return a 401 response
     *
     *     return new JsonRpcResponse('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return void
     * @throws AuthNotGrantedException
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new AuthNotGrantedException(" authorization not granted");
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return [
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      ];
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return ['api_key' => $request->headers->get('X-API-TOKEN')];
     *
     * @param Request $request
     * @return mixed Any non-null value
     *
     */
    public function getCredentials(Request $request): CredentialsInterface
    {
        return $this->getCredentialsReceiver()->getCredentials($request);
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param CredentialsInterface $credentials
     *
     * @param UserProviderInterface $userProvider
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUserName());
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     *
     * @param UserInterface $user
     * @return bool
     *
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->getCredentialsChecker()->checkCredentialsAccess($credentials, $user);
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the JsonRpcResponse sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return void
     * @throws AuthNotGrantedException
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new AuthNotGrantedException(sprintf('access denied %s', $exception->getMessage()));
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the JsonRpcResponse sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * Does this method support remember me cookies?
     *
     * Remember me cookie will be set if *all* of the following are met:
     *  A) This method returns true
     *  B) The remember_me key under your firewall is configured
     *  C) The "remember me" functionality is activated. This is usually
     *      done by having a _remember_me checkbox in your form, but
     *      can be configured by the "always_remember_me" and "remember_me_parameter"
     *      parameters under the "remember_me" firewall key
     *  D) The onAuthenticationSuccess method returns a JsonRpcResponse object
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @return CredentialsReceiverInterface
     */
    protected function getCredentialsReceiver(): CredentialsReceiverInterface
    {
        return $this->credentialsReceiver;
    }

    /**
     * @return CredentialsCheckerInterface
     */
    public function getCredentialsChecker(): CredentialsCheckerInterface
    {
        return $this->credentialsChecker;
    }
}
