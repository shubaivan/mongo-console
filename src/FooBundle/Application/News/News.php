<?php

namespace FooBundle\Application\News;

use FooBundle\Domain\News\NewsInterface as NewsInterfaceDomain;

class News implements NewsInterface
{
    /**
     * @var NewsInterfaceDomain
     */
    private $newsInterfaceDomain;

    /**
     * News constructor.
     *
     * @param NewsInterfaceDomain $newsInterfaceDomain
     */
    public function __construct(
        NewsInterfaceDomain $newsInterfaceDomain
    ) {
        $this->newsInterfaceDomain = $newsInterfaceDomain;
    }

    /**
     * {@inheritdoc.
     */
    public function getDocument($queryArray)
    {
        $response = $this->getNewsInterfaceDomain()->getConsoleQuery($queryArray);
        $return = '';
        foreach ($response as $key => $value) {
            $id = (array) $value['_id'];
            $response[$key]['_id'] = $id['$id'];
            if (isset($response[$key]['createdAt'])) {
                $mongoDate = $response[$key]['createdAt'];
                /* @var \MongoDate $mongoDate */
                $response[$key]['createdAt'] = $mongoDate->toDateTime()->format('Y-m-d');
            }

            if (isset($response[$key]['updatedAt'])) {
                $mongoDate = $response[$key]['updatedAt'];
                /* @var \MongoDate $mongoDate */
                $response[$key]['updatedAt'] = $mongoDate->toDateTime()->format('Y-m-d');
            }
            $output = implode(', ', array_map(
                function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                $response[$key],
                array_keys($response[$key])
            ));
            $return .= $output."\n";
        }

        return $return;
    }

    /**
     * @return NewsInterfaceDomain
     */
    private function getNewsInterfaceDomain()
    {
        return $this->newsInterfaceDomain;
    }
}
