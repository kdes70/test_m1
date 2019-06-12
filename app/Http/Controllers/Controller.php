<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Core\Template;
use Illuminate\Routing\Controller as BaseController;
use ReflectionClass;

class Controller extends BaseController
{
    protected $_view;

    /**
     * @return Template
     * @throws \ReflectionException
     */
    public function view()
    {
        if (!isset($this->_view)) {
            $reflection = new ReflectionClass($this);
            $this->_view = Template::create($this)
                ->setBasePath(  "../app/Views/");
        }

        return $this->_view;
    }

}