<?php

/**
 * This file is part of the Symfony framework.
 *
 * (c) Matthieu Bontemps <matthieu@knplabs.com>
 * (c) Thibault Duplessis <thibault.duplessis@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bundle\DoctrineUserBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Bundle\DoctrineUserBundle\DAO\UserRepositoryInterface;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @see UserRepositoryInterface::createUser
     */
    public function createUser($username, $password, $isActive = true, $isSuperAdmin = false)
    {
        $user = new User();

        $user->setUsername($username);
        $user->setPassword($password);
        $user->setIsActive($isActive);
        $user->setIsSuperAdmin($isSuperAdmin);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @see UserRepositoryInterface::findOneByUsernameAndPassword
     */
    public function findOneByUsernameAndPassword($username, $password)
    {
        $user = $this->findOneByUsername($username);
        
        if($user && $user->checkPassword($password))
        {
            return $user;
        }
    }

    /**
     * @see UserRepositoryInterface::findOneByUsername
     */
    public function findOneByUsername($username)
    {
        return $this->findOneBy(array('username' => $username));
    }

}
