<?php


namespace Tests\Unit\Presenter;


use Illuminate\Database\Eloquent\Model;
use Webmagic\Core\Presenter\PresentableTrait;

class PresenterModel extends Model
{
    use PresentableTrait;

    protected $presenter = BasePresenter::class;
}