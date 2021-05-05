<?php


namespace Webmagic\Core\ResourceUrls;


interface ResourceUrlsAbleContract
{
    /**
     * Return instance of ResourceUrlsGeneratorContract
     * for generation resource urls
     *
     * @return ResourceUrlsGeneratorContract
     */
    public function resourceUrls(): ResourceUrlsGeneratorContract;
}