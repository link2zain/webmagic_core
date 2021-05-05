<?php


namespace Tests\Unit\Presenter;


use Webmagic\Core\Presenter\Presenter;

class NewPresenter extends Presenter
{
    public function name()
    {
        return 'new';
    }
}