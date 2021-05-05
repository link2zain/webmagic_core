<?php


namespace Webmagic\Core\Entity\Exceptions;


use Throwable;

class EntityNotExtendsModelException extends \Exception
{
    public function __construct($message = 'Entity should extends \Illuminate\Database\Eloquent\Model', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}