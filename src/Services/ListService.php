<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ListService
 */
class ListService extends AbstractController
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
     * @return object[]
     */
    public function getUsers()
    {
        return $this->entityManager->getRepository(User::class)->findBy([], ['username' => 'ASC']);
    }

    /**
     * @param User $user
     */
    public function disableUser(User $user)
    {
        $user->setActive(false);
        $this->entityManager->flush();
    }
}
