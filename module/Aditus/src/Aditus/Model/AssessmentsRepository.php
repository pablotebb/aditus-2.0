<?php

namespace Aditus\Model;

use Aditus\Model\BaseRepository;

class AssessmentsRepository extends BaseRepository
{
    public function addDetails( $assessmentId )
    {
        // query 
        $dql = "
            SELECT a, ad, c
            FROM Aditus\Entity\Assessments a
                LEFT JOIN a.details ad INDEX BY ad.indicatorId
                INNER JOIN a.company c
            WHERE a.id = :assessmentId
                AND c.accountId = :accountId
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'assessmentId' => $id,
            'accountId' => $user->getAccountId(),
        ));
        $result = $query->getResult();

        return $result[0];        
    }

    public function getAssessmentPeriods( $user )
    {
        // query
        $dql = "
            SELECT a.reportingYear, a.reportingPeriod
            FROM Aditus\Entity\Assessments a
                INNER JOIN a.company c
            WHERE a.active = 1
                AND c.accountId = :accountId
            GROUP BY a.reportingYear, a.reportingPeriod
            ORDER BY a.reportingYear DESC, a.reportingPeriod DESC
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
        ));
        $result = $query->getResult();

        if( !is_array($result) || empty($result) ){
            $result = array(
                array(
                    'reportingYear' => (date('Y') - 1),
                    'reportingPeriod' => 'YEAR',
                )
            );
        }
        return $result;
    }
}
