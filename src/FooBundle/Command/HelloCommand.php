<?php
namespace FooBundle\Command;

use FooBundle\Application\News\News;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends ContainerAwareCommand
{
    const SELECT = 'SELECT';
    const FROM = 'FROM';
    const WHERE = 'WHERE';
    const ORDER_BY_FIELD = 'ORDER_BY_FIELD';
    const ORDER_BY = 'ORDER_BY';
    const SKIP = 'SKIP';
    const LIMIT = 'LIMIT';

    protected function configure()
    {
        $this
            ->setName('foo:hello')
            ->addArgument(self::SELECT, InputArgument::OPTIONAL, 'add select fileds')
            ->addArgument(self::FROM, InputArgument::OPTIONAL, 'add from table')
            ->addArgument(self::WHERE, InputArgument::OPTIONAL, 'add where conditions')
            ->addArgument(self::ORDER_BY_FIELD, InputArgument::OPTIONAL, 'group by filed ')
            ->addArgument(self::ORDER_BY, InputArgument::OPTIONAL, 'group by')
            ->addArgument(self::SKIP, InputArgument::OPTIONAL, 'add skip')
            ->addArgument(self::LIMIT, InputArgument::OPTIONAL, 'add limit')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $array = [];
        $array[self::SELECT] = $input->getArgument(self::SELECT);
        $array[self::FROM] = $input->getArgument(self::FROM);
        $array[self::WHERE] = $input->getArgument(self::WHERE);
        $array[self::ORDER_BY_FIELD] = $input->getArgument(self::ORDER_BY_FIELD);
        $array[self::ORDER_BY] = $input->getArgument(self::ORDER_BY);
        $array[self::SKIP] = $input->getArgument(self::SKIP);
        $array[self::LIMIT] = $input->getArgument(self::LIMIT);

        $queryArray = array_filter($array, function($value) { 
            return $value !== null && $value != "null"; 
        });
        
        $text = $this->getNewsApplication()->getDocumnet($queryArray);
        $output->writeln($text);
    }

    /**
     * @return News
     */
    private function getNewsApplication()
    {
        return $this->getContainer()->get('app.application.news');
    }
}