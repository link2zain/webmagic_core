<?php

namespace Webmagic\Core\Entity;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

abstract class EntityRepo implements EntityRepoInterface
{
    /** @var  Model */
    protected $entity;

    /**
     * Get all entities
     *
     * @param null $perPage
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAll($perPage = null)
    {
        $query = $this->query();

        return $this->realGetMany($query, $perPage);
    }

    /**
     * Get all active entities
     *
     * @param null $perPage
     *
     * @return LengthAwarePaginator|Collection
     * @throws Exception
     */
    public function getAllActive($perPage = null)
    {
        $query = $this->query();
        $query = $this->addActiveFilter($query);

        return $this->realGetMany($query, $perPage);
    }

    /**
     * Add filtering for active entities
     * Condition can be added if you need
     *
     * @param Builder $query
     *
     * @return Builder
     */
    protected function addActiveFilter(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Get entity by ID
     *
     * @param $id
     *
     * @return Model|null
     * @throws Exception
     */
    public function getByID($id)
    {
        $query = $this->query();
        $query->where('id', $id);

        return $this->realGetOne($query);
    }

    /**
     * Get from DB and prepare array with ID as key and name as value
     *
     * @param string $value
     * @param string $key
     *
     * @return array
     * @throws Exception
     */
    public function getForSelect($value = 'id', $key = 'id'): array
    {
        $query = $this->query();

        if (!$entities = $query->pluck($value, $key)) {
            return $entities->toArray();
        }

        return $entities->toArray();
    }

    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return Model
     * @throws Exception
     */
    public function create(array $data)
    {
        $query = $this->query();

        return $query->create($data);

    }

    /**
     * Update entity by ID
     *
     * @param       $id
     * @param array $data
     *
     * @return int
     * @throws Exception
     */
    public function update($id, array $data)
    {
        $query = $this->query();

        return $query->find($id)->update($data);
    }

    /**
     * Destroy entity by ID
     *
     * @param $id
     *
     * @return int
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function destroy($id)
    {
        $entity = $this->entity();

        return $entity::destroy($id);
    }

    /**
     * Destroy all entities
     *
     * @return void
     * @throws Exception
     */
    public function destroyAll()
    {
        $query = $this->query();

        $query->truncate();
    }

    /**
     * Get one entity based on query
     *
     * @param Builder $query
     *
     * @return Model|null
     */
    protected function realGetOne(Builder $query)
    {
        return $query->first();
    }

    /**
     *  Get all entities based on query
     *
     * @param Builder $query
     *
     * @param null    $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Collection
     */
    protected function realGetMany(Builder $query, $perPage = null)
    {
        $query = $this->addOrdering($query);

        if(is_null($perPage)){
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    /**
     * Add default ordering
     *
     * @param Builder $query
     *
     * @return Builder
     */
    protected function addOrdering(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Use for prepare query base on defined entity
     *
     * @return Builder
     * @throws Exception
     */
    protected function query(): Builder
    {
        $entity = $this->entity();

        return ($entity)::query();
    }

    /**
     * Check if entity set and return it
     *
     * @return Model
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    protected function entity()
    {
        if(!isset($this->entity)){
            throw new ModelNotDefinedException();
        }

        if(!is_subclass_of($this->entity, Model::class)){
            throw new EntityNotExtendsModelException();
        }

        return $this->entity;
    }

    /**
     * Set the repository entity
     *
     * @param $entityClass
     *
     * @return Model
     * @throws Exception
     */
    public function setEntity($entityClass)
    {
        if($entityClass instanceof Model || is_subclass_of($entityClass,Model::class)){
            return $this->entity = $entityClass;
        }

        throw new Exception("$entityClass is not extended " . Model::class);
    }
}