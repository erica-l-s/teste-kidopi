<?php

namespace App\Service;

use App\Entity\AccessUser;
use App\Repository\AccessUserRepository;

class AccessService
{
    public function __construct(
        private AccessUserRepository $repository
    ) { }

    public function saveAccess(string $country): AccessUser
    {
        if (empty($country)) {
            throw new \InvalidArgumentException('country not found.');
        }

        $covid = (new AccessUser())
            ->setDate(new \DateTime('now'))
            ->setCountry($country)
            
        ;
        
        $this->repository->save($covid, true);

        return $covid;
    }

    public function getLastAccess(): ?AccessUser
    {   
        return $this->repository->findOneBy([], ['date' => 'DESC']);
    }
}