<?php

namespace Aditus\Model;

use Aditus\Model\BaseRepository;

class AccountsRepository extends BaseRepository
{
    public function getPortfolio($user)
    {
        // query 
        $dql = "
            SELECT f, c
            FROM Aditus\Entity\Funds f
                LEFT JOIN f.companies c WITH c.active = 1
            WHERE f.accountId = :accountId
                AND f.active = 1
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
        ));
        $result = $query->getResult();

        return $result;
    }

    public function getPortfolioAssessments( $user, $assessmentPeriod, $groupBy='fund', $groupResult='average', $industryId=0, $countryId=0 )
    {
        switch( $groupBy ){            
            case 'sector':
                $groups = $this->getSectorAssessments( $user, $assessmentPeriod, $industryId, $countryId );
                $results = $this->getSectorResults( $user, $groupResult, $assessmentPeriod, $industryId, $countryId );
                break;

            case 'country':
                $groups = $this->getCountryAssessments( $user, $assessmentPeriod, $industryId, $countryId );
                $results = $this->getCountryResults( $user, $groupResult, $assessmentPeriod, $industryId, $countryId );
                break;

            case 'fund':
            default:
                $groups = $this->getFundAssessments( $user, $assessmentPeriod, $industryId, $countryId );
                $results = $this->getFundResults( $user, $groupResult, $assessmentPeriod, $industryId, $countryId );
                break;

        }

        // return
        return array(
            'groups' => $groups,
            'results' => $results,
        );
    }

    protected function getFundAssessments( $user, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT f, c, a, ad, fr
            FROM Aditus\Entity\Funds f INDEX BY f.id
                LEFT JOIN f.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                LEFT JOIN c.assessments a WITH a.active = 1 
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                LEFT JOIN a.details ad INDEX BY ad.indicatorId
                LEFT JOIN f.fundReports fr WITH fr.active = 1
                    AND fr.reportingYear = :reportingYear
                    AND fr.reportingPeriod = :reportingPeriod
            WHERE f.accountId = :accountId
                AND f.active = 1
            ORDER BY f.name, c.name
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        return $result;
    }

    protected function getFundResults( $user, $type, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT f.id, ad.indicatorId, COUNT(DISTINCT ad.id) numAssessments,
                
                ".($type == 'average' ? 'AVG(ad.capturedValue)' : 'SUM(ad.capturedValue)')." result,
                i.answerType,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.capturedValue = 'yes' THEN 1 ELSE 0 END) yesCount,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.capturedValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) yesCountPercentage,

                ".($type == 'average' ? 'AVG(ad.targetValue)' : 'SUM(ad.targetValue)')." targetResult,
                ".($type == 'average' ? '((AVG(ad.targetValue) / AVG(ad.capturedValue)) - 1) * 100' : '((SUM(ad.targetValue) / SUM(ad.capturedValue)) - 1) * 100')." targetPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.targetValue = 'yes' THEN 1 ELSE 0 END) targetYesCount,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.targetValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) targetYesCountPercentage,

                ".($type == 'average' ? 'AVG(pad.capturedValue)' : 'SUM(pad.capturedValue)')." previousResult,
                ".($type == 'average' ? '((AVG(ad.capturedValue) / AVG(pad.capturedValue)) - 1) * 100' : '((SUM(ad.capturedValue) / SUM(pad.capturedValue)) - 1) * 100')." trendPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND pad.capturedValue = 'yes' THEN 1 ELSE 0 END) previousYesCount,
                SUM(CASE WHEN i.answerType = 'YN' AND pad.capturedValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) previousYesCountPercentage

            FROM Aditus\Entity\Funds f
                INNER JOIN f.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                INNER JOIN c.assessments a WITH a.active = 1
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                INNER JOIN a.details ad INDEX BY ad.indicatorId WITH (ad.capturedValue >= 0 OR ad.capturedValue = 'yes' OR ad.capturedValue = 'no')
                INNER JOIN ad.indicator i
                LEFT JOIN ad.previous pad
            WHERE f.accountId = :accountId
                AND f.active = 1
            GROUP BY f.id, ad.indicatorId
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        $averages = array();
        foreach( $result as $row ){
            $averages[$row['id']][$row['indicatorId']] = $row; 
        }

        return $averages;
    }


    protected function getSectorAssessments( $user, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT s, c, a, ad
            FROM Aditus\Entity\Industries s
                INNER JOIN s.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                INNER JOIN c.fund f 
                LEFT JOIN c.assessments a WITH a.active = 1 
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                LEFT JOIN a.details ad INDEX BY ad.indicatorId
            WHERE f.accountId = :accountId 
                AND f.active = 1
            ORDER BY s.name, c.name
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        return $result;
    }

    protected function getSectorResults( $user, $type, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT s.id, ad.indicatorId, COUNT(DISTINCT a.id) numAssessments,
                ".($type == 'average' ? 'AVG(ad.capturedValue)' : 'SUM(ad.capturedValue)')." result,
                i.answerType,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.capturedValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) yesCount,

                ".($type == 'average' ? 'AVG(ad.targetValue)' : 'SUM(ad.targetValue)')." targetResult,
                ".($type == 'average' ? '((AVG(ad.targetValue) / AVG(ad.capturedValue)) - 1) * 100' : '((SUM(ad.targetValue) / SUM(ad.capturedValue)) - 1) * 100')." targetPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.targetValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) targetYesCount,

                ".($type == 'average' ? 'AVG(pad.targetValue)' : 'SUM(pad.targetValue)')." previousResult,
                ".($type == 'average' ? '((AVG(ad.capturedValue) / AVG(pad.capturedValue)) - 1) * 100' : '((SUM(ad.capturedValue) / SUM(pad.capturedValue)) - 1) * 100')." trendPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND pad.targetValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) previousYesCount

            FROM Aditus\Entity\Industries s
                INNER JOIN s.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                INNER JOIN c.fund f

                INNER JOIN c.assessments a WITH a.active = 1
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                INNER JOIN a.details ad INDEX BY ad.indicatorId
                INNER JOIN ad.indicator i
                LEFT JOIN ad.previous pad
            WHERE f.accountId = :accountId
                AND f.active = 1
            GROUP BY s.id, ad.indicatorId
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        $averages = array();
        foreach( $result as $row ){
            $averages[$row['id']][$row['indicatorId']] = $row; 
        }

        return $averages;
    }

    protected function getCountryAssessments( $user, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT cty, c, a, ad
            FROM Aditus\Entity\Countries cty
                INNER JOIN cty.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                INNER JOIN c.fund f 
                LEFT JOIN c.assessments a WITH a.active = 1 
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                LEFT JOIN a.details ad INDEX BY ad.indicatorId
            WHERE f.accountId = :accountId 
                AND f.active = 1
            ORDER BY cty.name, c.name
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        return $result;
    }

    protected function getCountryResults( $user, $type, $assessmentPeriod, $industryId, $countryId ){
        // query 
        $dql = "
            SELECT cty.id, ad.indicatorId, COUNT(DISTINCT a.id) numAssessments,
                ".($type == 'average' ? 'AVG(ad.capturedValue)' : 'SUM(ad.capturedValue)')." result,
                i.answerType,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.capturedValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) yesCount,

                ".($type == 'average' ? 'AVG(ad.targetValue)' : 'SUM(ad.targetValue)')." targetResult,
                ".($type == 'average' ? '((AVG(ad.targetValue) / AVG(ad.capturedValue)) - 1) * 100' : '((SUM(ad.targetValue) / SUM(ad.capturedValue)) - 1) * 100')." targetPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND ad.targetValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) targetYesCount,

                ".($type == 'average' ? 'AVG(pad.targetValue)' : 'SUM(pad.targetValue)')." previousResult,
                ".($type == 'average' ? '((AVG(ad.capturedValue) / AVG(pad.capturedValue)) - 1) * 100' : '((SUM(ad.capturedValue) / SUM(pad.capturedValue)) - 1) * 100')." trendPercentage,
                SUM(CASE WHEN i.answerType = 'YN' AND pad.targetValue = 'yes' THEN 1 ELSE 0 END) / COUNT(DISTINCT a.id) previousYesCount

            FROM Aditus\Entity\Countries cty
                INNER JOIN cty.companies c WITH c.active = 1

                    ".($industryId > 0 ? " AND c.industryId = :industryId " : "")."
                    ".($countryId > 0 ? " AND c.countryId = :countryId " : "")."

                INNER JOIN c.fund f

                INNER JOIN c.assessments a WITH a.active = 1
                    AND a.reportingYear = :reportingYear
                    AND a.reportingPeriod = :reportingPeriod
                INNER JOIN a.details ad INDEX BY ad.indicatorId
                INNER JOIN ad.indicator i
                LEFT JOIN ad.previous pad
            WHERE f.accountId = :accountId
                AND f.active = 1
            GROUP BY cty.id, ad.indicatorId
        ";        
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'reportingYear' => $assessmentPeriod['reportingYear'],
            'reportingPeriod' => $assessmentPeriod['reportingPeriod'],
        ));
        if( $industryId > 0 ){
            $query->setParameter('industryId', $industryId);
        }
        if( $countryId > 0 ){
            $query->setParameter('countryId', $countryId);
        }
        $result = $query->getResult();

        $averages = array();
        foreach( $result as $row ){
            $averages[$row['id']][$row['indicatorId']] = $row; 
        }

        return $averages;
    }

    public function getAssessment($id, $user)
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

    public function getCompanyAssessmentPeriods( $user, $companyId )
    {
        // query
        $dql = "
            SELECT a.id, a.reportingYear, a.reportingPeriod
            FROM Aditus\Entity\Assessments a
                INNER JOIN a.company c
            WHERE a.active = 1
                AND a.companyId = :companyId
                AND c.accountId = :accountId
            GROUP BY a.reportingYear, a.reportingPeriod
            ORDER BY a.reportingYear DESC, a.reportingPeriod DESC
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array(
            'accountId' => $user->getAccountId(),
            'companyId' => $companyId,
        ));
        $result = $query->getResult();

        return $result;
    }    

    public function getInvestedSuperSectors( $user=false )
    {
        // query 
        $dql = "
            SELECT i
            FROM Aditus\Entity\Industries i
        ";
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult();

        return $result;
    }

}
