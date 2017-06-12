<?php

namespace SONFin\Auth;


use Jasny\Auth;
use Jasny\Auth\Sessions;
use SONFin\Repository\RepositoryInterface;


class JasnyAuth extends Auth
{
    use Sessions;

    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Fetch a user by ID
     * 
     * @param  int $id
     * @return Jasny\Auth\User
     */
    public function fetchUserById($id)
    {
        return $this->repository->find($id, false);
    }

    /**
     * Fetch a user by username
     * 
     * @param  string $username
     * @return Jasny\Auth\User
     */
    public function fetchUserByUsername($username)
    {
        return $this->repository->findByField('email', $username)[0];
    }
}
