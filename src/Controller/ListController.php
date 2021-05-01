<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListController
 */
class ListController extends AbstractController
{
    private $entityManager;

    /**
     * ListController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['username' => 'ASC']);

        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('list/index.html.twig', [
            'pagination' => $pagination,
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
        $user->setActive(false);
        $this->entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
