<?php


namespace Webmagic\Core\Entity\Exceptions;


use Throwable;

class ModelNotDefinedException extends \Exception
{
    public function __construct($message = 'Eloquent model class should be defined first', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}