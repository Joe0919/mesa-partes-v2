<?php

class ErrorController extends Controllers
{
    public function __construct()
    {
        parent::__construct('');
    }

    public function notFound()
    {
        $this->views->getView("error", "index");
    }
}

$notFound = new ErrorController();
$notFound->notFound();
