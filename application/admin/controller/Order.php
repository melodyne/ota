<?php
namespace app\admin\controller;

use app\common\controller\AdminController;
use think\Request;

class Order extends AdminController
{

    protected $modelClass = 'app\common\model\HotelOrder';
    protected $order = 'create_time DESC';
    protected $with = 'user';

    protected $beforeActionList = [
        'preposition'  =>  ['only'=>'index,create,save,edit,update,delete'],
    ];

    /**
     * 前置操作
     */
    protected function  preposition(){
        $type = paramFromGet('type');
        if($type!=null){
            $this->condition = ['status'=>$type];
        }
        $this->setAssign(['type'=>$type]);
    }


    protected function findModel($id)
    {
        $model = parent::findModel($id);
        $model ->user;
        return $model;
    }

    protected function prepareDataProvider()
    {
        $list =  parent::prepareDataProvider();
        foreach ($list as $m){

            if($m->status>=1){
                if($m->leave_time<time()){
                    $m->status = 4; // 消费完成 待评价
                    $m->save();
                }else{
                    if($m->arrive_time<time()){
                        $m->status = 2;// 正在消费
                        $m->save();
                    }
                }
            }
        }
        return $list;
    }

}
