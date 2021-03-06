<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;
use app\common\model\CashPledge as CashPledgeModel;

class CashPledge extends ActiveController
{
    protected $modelClass = 'common\model\CashPledge';
    protected $authenticate = ['except'=>'index,read'];

    public function save()
    {
        $oderId = paramFromPost("order",true);
        $cashPledge = paramFromPost("cash_pledge",true);

        $orderModel = OrderModel::get($oderId);
        if($orderModel==null)error("该订单不存在哦！");
        $model = CashPledgeModel::get(['order_id'=>$orderModel]);
        if($model==null){
            $model = new CashPledgeModel();
            $model->user_id = $this->userId;
            $model->order_id =$oderId;
            $model->cash_pledge = $cashPledge;
            $model->save();
        }else{
            api(100,"已经交付押金了！",$model);
        }

    }
}
