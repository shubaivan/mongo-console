<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class News.
 *
 * @ODM\Document(
 *      repositoryClass="AppBundle\Document\Repository\NewsRepository"
 * )
 * @ODM\HasLifecycleCallbacks()
 */
class News
{
    use Timestampable;

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\Field(type="string")
     */
    protected $title;

    /**
     * @ODM\Field(type="string")
     */
    protected $description;

    /**
     * @ODM\Field(type="int")
     */
    protected $page;

    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\NewsPaper")
     */
    protected $newsPaper;

    /**
     * Get id.
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set page.
     *
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page.
     *
     * @return int $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set newsPaper.
     *
     * @param NewsPaper $newsPaper
     *
     * @return $this
     */
    public function setNewsPaper(\AppBundle\Document\NewsPaper $newsPaper)
    {
        $this->newsPaper = $newsPaper;

        return $this;
    }

    /**
     * Get newsPaper.
     *
     * @return NewsPaper $newsPaper
     */
    public function getNewsPaper()
    {
        return $this->newsPaper;
    }
}
