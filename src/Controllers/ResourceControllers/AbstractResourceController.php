<?php


namespace Webmagic\Core\Controllers\ResourceControllers;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Webmagic\Core\Controllers\AjaxRedirectTrait;
use Webmagic\Core\Entity\EntityRepoInterface;
use Webmagic\Dashboard\Contracts\Renderable;

abstract class AbstractResourceController implements ResourceControllerContract
{
    use AjaxRedirectTrait;

    /** @var EntityRepoInterface */
    protected $entityRepository;

    /** @var Model */
    protected $entity;

    /**
     * Return index page
     *
     * @param Request $request
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $repo = $this->getEntityRepository();
        $items = $repo->getAll($request->get('perPage', 15));

        $listPage = $this->prepareListPage($items, $request);

        return $listPage;
    }

    /**
     * Return page with form for creating the entity
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $page = $this->prepareCreateFormPage();

        return $page;
    }

    /**
     * Create entity based on request data
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateRequestData($request);

        $repo = $this->getEntityRepository();

        $repo->create($validatedData);

        // Return redirect if required
        if($request->has('redirect')){
            return $this->redirect($request->get('redirect'));
        }
    }

    /**
     * Return page for viewing the entity
     *
     * @param Request $request
     * @param null    $id
     *
     * @return string | \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function show($id, Request $request)
    {
        $item = $this->getItem($id);

        $pageForShow = $this->preparePageForShow($item, $request, $id);

        return $pageForShow;
    }

    /**
     * Return page with form filled with entity data for updating the entity
     *
     * @param Request $request
     * @param null    $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function edit($id, Request $request)
    {
        $item = $this->getItem($id);

        $page = $this->prepareEditFormPage($item, $request);

        return $page;
    }

    /**
     * Update the entity with the data from the request
     *
     * @param null    $id
     *
     * @param Request $request
     *
     * @return
     * @throws \Exception
     */
    public function update($id, Request $request)
    {
        $request['id'] = $id;
        $validatedData = $this->validateRequestData($request);

        $repo = $this->getEntityRepository();

        $repo->update($id, $validatedData);

        // Return redirect if required
        if($request->has('redirect')){
            return $this->redirect($request->get('redirect'));
        }
    }

    /**
     * Destroy entity based on the id
     *
     * @param Request $request
     * @param null    $id
     *
     * @throws \Exception
     */
    public function destroy($id, Request $request)
    {
        $item = $this->getItem($id);

        $repo = $this->getEntityRepository();

        $repo->destroy($item['id']);
    }

    /**
     * Get item based in ID
     *
     * @param $id
     *
     * @return Model|null
     * @throws \Exception
     */
    protected function getItem($id)
    {
        $repo = $this->getEntityRepository();

        if ($item = $repo->getByID($id)) {
            return $item;
        }

        abort(404);
    }


    /**
     * @return EntityRepoInterface
     * @throws \Exception
     */
    protected function getEntityRepository(): EntityRepoInterface
    {
        if (isset($this->entityRepository) && $this->entityRepository instanceof EntityRepoInterface) {
            return $this->entityRepository;
        }

        if (isset($this->entityRepository) && is_subclass_of($this->entityRepository, EntityRepoInterface::class)) {
            return new $this->entityRepository;
        }

        $repo = new DefaultEntityRepo();
        $repo->setEntity($this->getEntity());

        $this->entityRepository = $repo;

        return $repo;
    }

    /**
     * Return the Model for CRUD
     *
     * @return Model
     * @throws \Exception
     */
    protected function getEntity(): Model
    {
        if (isset($this->entity) && is_subclass_of($this->entity, Model::class)) {
            return new $this->entity;
        }

        throw new \Exception('Please, define the Model in ' . get_class($this));
    }

    /**
     * Prepare page with entities list
     *
     * @param Collection|LengthAwarePaginator|array $items
     * @param Request              $request
     *
     * @return string|Renderable
     */
    abstract protected function prepareListPage($items, Request $request);

    /**
     * Prepare page for create the entity
     *
     *
     * @return mixed
     */
    abstract protected function prepareCreateFormPage();

    /**
     * Prepare page for create or edit
     *
     * @param Model|null $item
     *
     * @param Request    $request
     *
     * @return mixed
     */
    abstract protected function prepareEditFormPage(Model $item, Request $request);


    /**
     * Prepare page for show entity
     *
     * @param         $item
     * @param Request $request
     *
     * @return Renderable
     */
    abstract protected function preparePageForShow(Model $item, Request $request);

    /**
     * Validate request
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    abstract protected function validateRequestData(Request $request): array;
}