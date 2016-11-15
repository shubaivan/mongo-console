<?php

namespace FooBundle\Application\NewsPaper;

use FooBundle\Command\HelloCommand;
use FooBundle\Domain\News\NewsInterface as NewsInterfaceDomain;
use FooBundle\Domain\NewsPaper\NewsPaper as NewsPaperDomain;

class NewsPaper implements NewsPaperInterface
{
    /**
     * @var NewsPaperDomain
     */
    private $newsPaperDomain;

    /**
     * News constructor.
     *
     * @param NewsPaperDomain $newsPaperDomain
     */
    public function __construct(
        NewsPaperDomain $newsPaperDomain
    ) {
        $this->newsPaperDomain = $newsPaperDomain;
    }

    /**
     * {@inheritdoc.
     */
    public function getDocument($queryArray)
    {
        $response = $this->getNewsPaperDomain()
            ->getConsoleQuery($queryArray);
        $return = '';
        foreach ($response as $key => $value) {
            $id = (array) $value['_id'];
            $response[$key]['_id'] = $id['$id'];
            if (isset($response[$key]['createdAt'])) {
                $mongoDate = $response[$key]['createdAt'];
                /** @var \MongoDate $mongoDate */
                $response[$key]['createdAt'] = $mongoDate->toDateTime()->format('Y-m-d');
            }

            if (isset($response[$key]['updatedAt'])) {
                $mongoDate = $response[$key]['updatedAt'];
                /** @var \MongoDate $mongoDate */
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
     * @return NewsPaperDomain
     */
    private function getNewsPaperDomain()
    {
        return $this->newsPaperDomain;
    }
}
