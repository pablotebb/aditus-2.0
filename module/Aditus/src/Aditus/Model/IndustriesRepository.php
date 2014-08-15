<?php

namespace Aditus\Model;

use Aditus\Model\BaseRepository;

class IndustriesRepository extends BaseRepository
{
    public function getIndustries()
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Industries i
            WHERE i.parentId IS NULL
            ORDER BY i.name ASC
        ";
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }

    public function getSuperSectors()
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Industries i
            WHERE i.parentId IS NULL
            ORDER BY i.name ASC
        ";
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }

}