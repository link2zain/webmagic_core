<?php

namespace Webmagic\Core\Controllers\ResourceControllers;


use Illuminate\Http\Request;

interface ResourceControllerContract
{
    /**
     * Return index page
     *
     * @param Request $request
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request);

    /**
     * Return page with form for creating the entity
     *
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     */
    public function create();

    /**
     * Create entity based on request data
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request);

    /**
     * Return page for viewing the entity
     *
     * @param Request $request
     * @param         $id
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     */
    public function show($id, Request $request);

    /**
     * Return page with form filled with entity data for updating the entity
     *
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function edit($id, Request $request);

    /**
     * Update the entity with the data from the request
     *
     * @param         $id
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function update($id, Request $request);

    /**
     * Destroy entity based on the id
     *
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function destroy($id, Request $request);
}