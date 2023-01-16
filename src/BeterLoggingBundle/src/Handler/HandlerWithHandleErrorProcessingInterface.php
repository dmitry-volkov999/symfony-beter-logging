<?php

namespace App\BeterLoggingBundle\src\Handler;

interface HandlerWithHandleErrorProcessingInterface
{
    public function setHandleExceptionHandler(?callable $callback): self;
    public function setMaxHandleErrorsBeforeDisabling(int $maxAmountOfHandleErrors): self;
}
