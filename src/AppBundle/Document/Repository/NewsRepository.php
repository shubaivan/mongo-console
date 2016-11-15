<?php

namespace AppBundle\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use FooBundle\Command\HelloCommand;
use FooBundle\Domain\News\News;
use AppBundle\Document\News as NewsDocument;

class NewsRepository extends DocumentRepository
{
    public function findNewsById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    /**
     * @param array $queryArray
     * @return array
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getConsoleQuery($queryArray)
    {
        $qb = $this->createQueryBuilder()
            ->hydrate(false);
        if (array_key_exists(HelloCommand::SELECT, $queryArray)) {
            $select = explode(',', $queryArray[HelloCommand::SELECT]);

            $qb
                ->select(
                    $select
//                    'id',
//                    'title',
//                    'description',
//                    'page',
//                    'createdAt'
                );   
        }
        
        if (array_key_exists(HelloCommand::WHERE, $queryArray)) {
            $r = explode('=', $queryArray[HelloCommand::WHERE]);

            $qb
                ->field($r[0])
                ->equals($r[1]);
        }

        if (array_key_exists(HelloCommand::LIMIT, $queryArray)) {
            $qb
                ->limit($queryArray[HelloCommand::LIMIT]);
        }

        if (array_key_exists(HelloCommand::SKIP, $queryArray)) {
            $qb
                ->skip($queryArray[HelloCommand::SKIP]);   
        }

        if (
            array_key_exists(HelloCommand::ORDER_BY_FIELD, $queryArray)
            && array_key_exists(HelloCommand::ORDER_BY, $queryArray) 
        ) {
            $qb
                ->sort(
                    $queryArray[HelloCommand::ORDER_BY_FIELD],
                    $queryArray[HelloCommand::ORDER_BY]
                );   
        }

        $query = $qb->getQuery();
        $news = $query->execute();

        $result = $news->toArray();
        
        return $result;
    }
}