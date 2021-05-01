<?php

namespace App\Controller;

use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ListService;

/**
 * Class ListController
 */
class ListController extends AbstractController
{
    private $listService;

    /**
     * ListController constructor.
     *
     * @param ListService $listService
     */
    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    /**
     * @Route("/", name="list")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function indexAction(Request $request, PaginatorInterface $paginator): Response
    {
        return $this->render('list/index.html.twig', [
            'pagination' => $paginator->paginate(
                $this->listService->getUsers(),
                $request->query->getInt('page', 1),
                10
            ),
        ]);
    }

    /**
     * @Route("/disable-user/{user}", name="disable_user")
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function disableAction(Request $request, User $user)
    {
        $this->listService->disableUser($user);

        return $this->redirect($request->headers->get('referer'));
    }
}
