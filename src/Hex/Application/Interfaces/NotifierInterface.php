<?php

namespace Hex\Application\Interfaces;

interface NotifierInterface
{
    public function notify(Message $message);
}
