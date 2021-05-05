<?php


namespace Webmagic\Core\Presenter;


use Laracasts\Presenter\Exceptions\PresenterException;
use Laracasts\Presenter\PresentableTrait as BasePresentableTrait;

trait PresentableTrait
{
    use BasePresentableTrait;

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (!$this->presenter or !class_exists($this->presenter)) {
            throw new PresenterException('Please set the $presenter property to your presenter path.');
        }

        if (!$this->presenterInstance) {
            $this->presenterInstance = app()->makeWith($this->presenter, ['entity' => $this]);
        }

        return $this->presenterInstance;
    }


}