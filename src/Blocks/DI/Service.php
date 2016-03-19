<?php

namespace Blocks\DI;

abstract class Service
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string[]
     */
    private $tags;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = (string)$id;
        $this->tags = [];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string[] $tags
     * @return $this
     */
    public function addTags(array $tags = [])
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
        return $this;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function addTag($tag)
    {
        $tag = (string)$tag;
        $this->tags[$tag] = $tag;
        return $this;
    }

    /**
     * @param $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        $tag = (string)$tag;
        return (isset($this->tags[$tag]));
    }

    /**
     * @param DIContainer $container
     * @return mixed
     */
    abstract public function get(DIContainer $container);
}
