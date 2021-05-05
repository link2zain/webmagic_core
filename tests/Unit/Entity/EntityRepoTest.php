<?php


use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;
use Tests\TestCase;
use Tests\Unit\Entity\Entity;
use Tests\Unit\Entity\EntityRepo;

class EntityRepoTest extends TestCase
{
    /** @var  EntityRepo */
    protected $repo;

    public function setUp()
    {
        parent::setUp();

        $this->repo = new EntityRepo();
        $this->repo->setEntity(Entity::class);
    }

    public function testModelNotDefinedException()
    {
        $repo = new EntityRepo();

        $this->expectException(ModelNotDefinedException::class);
        $repo->getAll();
    }

    public function testNotModelClassDefinedException()
    {
        $repo = new EntityRepo();

        $repo->setEntity(\Tests\Unit\Entity\EntityNotModel::class);
        $this->expectException(EntityNotExtendsModelException::class);
        $repo->getAll();
    }

    public function testGetAll()
    {
        $entities_collection = $this->repo->getAll();

        $this->assertTrue($entities_collection instanceof \Illuminate\Database\Eloquent\Collection);
        $this->assertCount(0, $entities_collection);

        Entity::create([]);
        Entity::create([]);
        Entity::create([]);

        $entities_collection = $this->repo->getAll();

        $this->assertTrue($entities_collection instanceof \Illuminate\Database\Eloquent\Collection);
        $this->assertCount(3, $entities_collection);
    }

    public function testGetAllActive()
    {
        $entities_collection = $this->repo->getAll();

        $this->assertTrue($entities_collection instanceof \Illuminate\Database\Eloquent\Collection);
        $this->assertCount(0, $entities_collection);

        Entity::create([]);
        Entity::create([]);
        Entity::create([]);

        $entities_collection = $this->repo->getAll();

        $this->assertTrue($entities_collection instanceof \Illuminate\Database\Eloquent\Collection);
        $this->assertCount(3, $entities_collection);
    }

    public function testGetByID()
    {
        $entity_name = 'test_entity';
        Entity::create([]);
        $new_entity = Entity::create([
            'name' => $entity_name
        ]);

        $entity = $this->repo->getByID($new_entity->id);

        $this->assertTrue(is_subclass_of($entity, \Illuminate\Database\Eloquent\Model::class));
        $this->assertEquals($entity_name, $entity->name);
    }

    public function testGetForSelect()
    {
        $test_array = [
            1 => 'name_1',
            2 => 'name_2',
            3 => 'name_3'
        ];

        foreach ($test_array as $key => $data) {
            Entity::create([
                'name' => $data,
                'description' => "data_$key"
            ]);
        }

        //If we use default params
        $array_for_id_only = [1, 2, 3];
        $result_array = $this->repo->getForSelect();
        $this->assertTrue(is_array($result_array));
        $this->assertEquals($array_for_id_only, $result_array);

        //If we set only first param
        $array_for_name_only = ['name_1', 'name_2', 'name_3'];
        $result_array = $this->repo->getForSelect('name');
        $this->assertTrue(is_array($result_array));
        $this->assertEquals($array_for_name_only, $result_array);

        //If we set both params
        $array_for_both_params = [
            'name_1' => 'data_1',
            'name_2' => 'data_2',
            'name_3' => 'data_3',
        ];
        $result_array = $this->repo->getForSelect('description', 'name');
        $this->assertTrue(is_array($result_array));
        $this->assertEquals($array_for_both_params, $result_array);
    }

    public function testCreate()
    {
        $entity_name = 'test_entity';
        $new_entity = $this->repo->create([
            'name' => $entity_name
        ]);

        $this->assertTrue(is_subclass_of($new_entity, \Illuminate\Database\Eloquent\Model::class));
        $this->assertEquals($entity_name, $new_entity->name);
    }

    public function testUpdate()
    {
        $test_data = [
            'old' => [
                'name' => 'test_name',
                'description' => 'test_description'
            ],
            'new' => [
                'name' => 'changed_name',
                'description' => 'changed_description'
            ]
        ];

        $test_entity = Entity::create($test_data['old']);
        $this->repo->update($test_entity->id, $test_data['new']);

        //Check if it is not equal to old entity
        $updated_entity = Entity::find($test_entity->id);

        //Check if it is equal to new entity
        $this->assertEquals($updated_entity->name, $test_data['new']['name']);
        $this->assertEquals($updated_entity->description, $test_data['new']['description']);
    }

    public function testDestroy()
    {
        $first_entity = Entity::create([
            'name' => 'test_name',
            'description' => 'test_description'
        ]);

        $test_entity = Entity::create([
            'name' => 'test_name1',
            'description' => 'test_description1'
        ]);

        $third_entity = Entity::create([
            'name' => 'test_name2',
            'description' => 'test_description2'
        ]);

        $forth_entity = Entity::create([
            'name' => 'test_name3',
            'description' => 'test_description3'
        ]);

        $this->repo->destroy($test_entity->id);

        //Test delete with one id
        $destroyed_entity = Entity::find($test_entity->id);
        $this->assertNull($destroyed_entity);
        $third_entity = Entity::find($third_entity->id);
        $this->assertNotNull($third_entity);

        //Test delete with array
        $this->repo->destroy([$first_entity->id, $forth_entity->id]);

        $destroyed_entity = Entity::find($first_entity->id);
        $this->assertNull($destroyed_entity);
        $destroyed_entity = Entity::find($forth_entity->id);
        $this->assertNull($destroyed_entity);
        $third_entity = Entity::find($third_entity->id);
        $this->assertNotNull($third_entity);
    }

    public function testDestroyAll()
    {
        Entity::create([
            'name' => 'test_name',
            'description' => 'test_description'
        ]);

        Entity::create([
            'name' => 'test_name1',
            'description' => 'test_description1'
        ]);

        //Test that all entities was deleted
        $entities_exists = Entity::all();
        $this->assertCount(2, $entities_exists);

        $this->repo->destroyAll();
        $no_entities = Entity::all();
        $this->assertCount(0, $no_entities);
    }

}