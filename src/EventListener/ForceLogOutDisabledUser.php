<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ForceLogOutDisabledUser
 */
class ForceLogOutDisabledUser
{
    private $router;
    private $tokenStorage;
    private $authChecker;

    /**
     * ForcePasswordChange listener constructor
     *
     * @param RouterInterface $router
     * @param TokenStorageInterface $tokenStorage
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(
        RouterInterface $router,
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authChecker
    ) {
        $this->router       = $router;
        $this->tokenStorage = $tokenStorage;
        $this->authChecker  = $authChecker;
    }

    /**
     * @param  $event
     * @return void
     */
    public function onCheckStatus($event): void
    {
        if ($this->isUserAuthenticated()) {
            $routeName = $event->getRequest()->get('_route');
            if (strcmp($routeName, "app_logout") <> 0) {
                if (!$this->getUser()->isActive()) {
                    $response = new RedirectResponse(
                        $this->router->generate('app_logout')
                    );
                    $event->setResponse($response);
                }
            }
        }
    }
    
    /**
     * Check whether current user is authenticated
     *
     * @return boolean
     */
    protected function isUserAuthenticated(): bool
    {
        return $this->tokenStorage->getToken() && $this->authChecker->isGranted('IS_AUTHENTICATED_FULLY');
    }


    /**
     * @return string|UserInterface
     */
    protected function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
