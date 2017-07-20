<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Admin as AdminModel;
use common\model\BookHouse as BookHouseModel;

class BookRent extends AdminController
{

    protected $modelClass = 'common\model\BookRent';
    protected $order = 'rent_time DESC';

    protected function prepareDataProvider()
    {
        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub
        foreach ($list as $m){
            $m->book;
            if($m->book){
                $m->book->model;
            }
        }
        return $list;
    }

}
