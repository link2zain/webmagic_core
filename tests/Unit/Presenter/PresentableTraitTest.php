<?php


namespace Tests\Unit\Presenter;


use Tests\TestCase;

class PresentableTraitTest extends TestCase
{
    public function testRegularPresent()
    {
        $entity = app()->make(PresenterModel::class);

        //test that we have regular presenter
        $this->assertEquals('base', $entity->present()->name);

    }

    public function testOverridePresenter()
    {
        //bind new presenter
        app()->bind(BasePresenter::class, NewPresenter::class);
        $entity = app()->make(PresenterModel::class);

        //test that we have new presenter
        $this->assertEquals('new', $entity->present()->name);
    }
}