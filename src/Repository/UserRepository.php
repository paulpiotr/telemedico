<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container = null)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param int $id
     * @return User|array
     */
    public function findOneUserById(?int $id)
    {
        try {
            return $this->findOneBy([
                'id' => $id
            ]);
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage(),
                'trace_as_string' => $e->getTraceAsString(),
            ];
        }
    }

    /**
     * @param string $email
     * @return User|array
     */
    public function findOneUserByEmail(?string $email)
    {
        try {
            return $this->findOneBy([
                'email' => $email
            ]);
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage(),
                'trace_as_string' => $e->getTraceAsString(),
            ];
        }
    }

    /**
     * @param User $user
     * @return User|array
     */
    public function insert(?User $user)
    {
        try {
            $user->setCreated(new \DateTime());
            $em = $this->getEntityManager();
            $em->persist($user);
            $em->flush();
            return $user;
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage(),
                'trace_as_string' => $e->getTraceAsString(),
            ];
        }
    }

    /**
     * @param User $user
     * @return User|array
     */
    public function delete(?User $user)
    {
        try {
            $em = $this->getEntityManager();
            $em->remove($user);
            return $em->flush();
        } catch (\Exception $e) {
            return [
                'status' => 500,
                'message' => $e->getMessage(),
                'trace_as_string' => $e->getTraceAsString(),
            ];
        }
    }

}
