<?php

namespace Aditus\Model;

use Aditus\Model\BaseRepository;

class IndicatorsRepository extends BaseRepository
{
    public function getDisplayIndicators( $user, $category=null )
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Indicators i
            WHERE i.active = 1
                AND i.display = 1
                AND (i.accountId IS NULL OR i.accountId = :accountId)
                ".(!is_null($category) ? 'AND i.category = :category' : '')."
            ORDER BY i.category ASC, i.displayOrdering ASC
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
        ));
        if( !is_null($category) ){
            $query->setParameter('category', $category);
        }
        $result = $query->getResult();

        return $result;
    }

    public function getInputIndicators( $user, $category=null )
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Indicators i
            WHERE i.active = 1
                AND i.input = 1
                AND (i.accountId IS NULL OR i.accountId = :accountId)
                ".(!is_null($category) ? 'AND i.category = :category' : '')."
            ORDER BY i.category ASC, i.ordering ASC
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
        ));
        if( !is_null($category) ){
            $query->setParameter('category', $category);
        }
        $result = $query->getResult();

        return $result;
    }

    public function getAllIndicators( $user, $category=null )
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Indicators i
            WHERE i.active = 1
                AND (i.input = 1 OR i.display = 1)
                AND (i.accountId IS NULL OR i.accountId = :accountId)
                ".(!is_null($category) ? 'AND i.category = :category' : '')."
            ORDER BY i.category ASC, i.ordering ASC
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
        ));
        if( !is_null($category) ){
            $query->setParameter('category', $category);
        }
        $result = $query->getResult();

        return $result;
    }    
}