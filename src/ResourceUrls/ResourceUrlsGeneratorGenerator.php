<?php


namespace Webmagic\Core\ResourceUrls;


use Illuminate\Database\Eloquent\Model;

class ResourceUrlsGeneratorGenerator implements ResourceUrlsGeneratorContract
{
    /** @var string Routes first part */
    protected $routeGroup;

    /** @var Model */
    protected $resource;

    /**
     * EntityResourceUrlsGenerator constructor.
     *
     * @param string $routeGroup
     * @param Model  $resource
     */
    public function __construct(Model $resource, string $routeGroup = '')
    {
        $this->routeGroup = $routeGroup;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function listUrl(): string
    {
        return route($this->prepareRoute('index'));
    }


    /**
     * @return string
     */
    public function createUrl(): string
    {
        return route($this->prepareRoute('create'));
    }

    /**
     * @return string
     */
    public function editUrl(): string
    {
        return route($this->prepareRoute('edit'), $this->resource);
    }

    /**
     * @return string
     */
    public function showUrl(): string
    {
        return route($this->prepareRoute('show'), $this->resource);
    }

    /**
     * @return string
     */
    public function storeUrl(): string
    {
        return route($this->prepareRoute('store'));
    }

    /**
     * @return string
     */
    public function updateUrl(): string
    {
        return route($this->prepareRoute('update'), $this->resource);
    }

    /**
     * @return string
     */
    public function destroyUrl(): string
    {
        return route($this->prepareRoute('destroy'), $this->resource);
    }

    /**
     * @return string
     */
    public function listUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('index'));
    }

    /**
     * @return string
     */
    public function createUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('create'));
    }

    /**
     * @return string
     */
    public function editUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('edit'));
    }

    /**
     * @return string
     */
    public function showUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('show'));
    }

    /**
     * @return string
     */
    public function storeUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('store'));
    }

    /**
     * @return string
     */
    public function updateUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('update'));
    }

    /**
     * @return string
     */
    public function destroyUrlMethod(): string
    {
        return $this->getMethod($this->prepareRoute('destroy'));
    }

    /**
     * Prepare route based on route group and rout
     *
     * @param string $route
     *
     * @return string
     */
    protected function prepareRoute(string $route): string
    {
        return $this->getRouteGroup().$route;
    }

    /**
     * Return method for  route by name
     *
     * @param string $routeName
     *
     * @return string
     */
    public function getMethod(string $routeName): string
    {
        return array_first(app('router')->getRoutes()->getByName($routeName)->methods());
    }

    /**
     * @return string
     */
    public function getRouteGroup(): string
    {
        return str_finish($this->routeGroup, '.');
    }

    /**
     * @param string $routeGroup
     */
    public function setRouteGroup(string $routeGroup): void
    {
        $this->routeGroup = $routeGroup;
    }

    /**
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->resource;
    }

    /**
     * @param Model $resource
     *
     * @return ResourceUrlsGeneratorGenerator
     */
    public function setEntity(Model $resource): ResourceUrlsGeneratorGenerator
    {
        $this->resource = $resource;

        return $this;
    }
}