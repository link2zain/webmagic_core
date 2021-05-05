<?php

namespace Webmagic\Core\Entity;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface EntityRepoInterface
{
    /**
     * Get all entities
     *
     * @param null $perPage
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getAll($perPage = null);

    /**
     * Get all active entities
     *
     * @param null $perPage
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getAllActive($perPage = null);

    /**
     * Get entity by ID
     *
     * @param $id
     *
     * @return Model|null
     */
    public function getByID($id);

    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data);

    /**
     * Update entity by ID
     *
     * @param       $id
     * @param array $data
     *
     * @return int
     */
    public function update($id, array $data);

    /**
     * Destroy entity by ID
     *
     * @param integer|array $id
     *
     * @return mixed
     */
    public function destroy($id);

    /**
     * Destroy all entities
     *
     * @return void
     */
    public function destroyAll();

    /**
     * Use for quick generate list of items for dropdown elements
     *
     * @param string $value
     * @param string $key
     *
     * @return array
     */
    public function getForSelect($value = 'id', $key = 'id'): array;
}