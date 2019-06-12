<?php

declare(strict_types=1);


namespace App\Http\Controllers;


use App\Models\Album;
use App\Models\Model;
use \Symfony\Component\HttpFoundation\Request;


class IndexController extends Controller
{

    /**
     * @var Model
     */
    private $model;

    public function __construct()
    {
        $this->model = new Album();
    }


    public function list(Request $request)
    {
        $list = $this->model->getList();

        $this->view()->assign('items', $list)->display('index.php');
    }

}