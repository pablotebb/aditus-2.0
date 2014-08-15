<?php

namespace Aditus\Model;

use Aditus\Model\BaseRepository;

class FeedbackRepository extends BaseRepository
{
	public function getFeedbackCounts()
	{
        // query 
        $dql = "
            SELECT f.type, COUNT(f.id) numFeedback
            FROM Aditus\Entity\Feedback f
            GROUP BY f.type
            ORDER BY f.type
        ";        
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult();

        return $result;		
	}

	public function getLatestFeedback()
	{
        // query 
        $dql = "
            SELECT f
            FROM Aditus\Entity\Feedback f            
            ORDER BY f.created DESC
        ";        
        $query = $this->_em->createQuery($dql);
        $result = $query->getResult();

        return $result;		
	}

}
?>