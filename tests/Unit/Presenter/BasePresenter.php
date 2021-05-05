<?php


namespace Tests\Unit\Presenter;


use Webmagic\Core\Presenter\Presenter;

class BasePresenter extends Presenter
{
    public function name()
    {
        return 'base';
    }
}