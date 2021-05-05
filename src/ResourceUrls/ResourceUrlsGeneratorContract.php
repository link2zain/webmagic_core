<?php


namespace Webmagic\Core\ResourceUrls;

interface ResourceUrlsGeneratorContract
{
    /**
     * @return string
     */
    public function listUrl(): string;

    /**
     * @return string
     */
    public function listUrlMethod(): string;

    /**
     * @return string
     */
    public function createUrl(): string;

    /**
     * @return string
     */
    public function createUrlMethod(): string;

    /**
     * @return string
     */
    public function editUrl(): string;

    /**
     * @return string
     */
    public function editUrlMethod(): string;

    /**
     * @return string
     */
    public function showUrl(): string;

    /**
     * @return string
     */
    public function showUrlMethod(): string;

    /**
     * @return string
     */
    public function storeUrl(): string;

    /**
     * @return string
     */
    public function storeUrlMethod(): string;

    /**
     * @return string
     */
    public function updateUrl(): string;

    /**
     * @return string
     */
    public function updateUrlMethod(): string;

    /**
     * @return string
     */
    public function destroyUrl(): string;

    /**
     * @return string
     */
    public function destroyUrlMethod(): string;
}