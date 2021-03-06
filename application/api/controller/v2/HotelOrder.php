<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 18:05
 */

namespace app\api\controller\v2;

use common\controller\ActiveController;
use common\model\Hotel as HouseModel;
use common\model\HotelRoom as RoomModel;
use common\model\HotelOrder as HotelOrderModel;
use common\model\HotelReservation;
use common\model\Users as UsersModel;
use think\Request;


class HotelOrder extends ActiveController
{
    protected $modelClass = 'common\model\HotelOrder';
    protected $authenticate = ['only'=>'save'];
    protected $order = "create_time desc";

    protected $rule = [
        'hotel_id'   => 'require|number|max:25',
        'room_id'    => 'number|max:25',
        'point'      => 'number|between:0,10000',
        'arrive_time'=> 'require|number|length:10',
        'leave_time' => 'require|number|length:10|>:arrive_time',

    ];

    protected function findModel($id)
    {
        $m = HotelOrderModel::get(['user_id'=>$this->userId,'hotel_order_id'=>$id]);
        if($m){
            return $m;
        }else{
            error('你没有该订单哦！');
        }
    }

    protected function prepareDataProvider()
    {
        $this->condition['user_id'] = $this->userId;
        $list = parent::prepareDataProvider();
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

    /**
     * 预订下单
     */
    public function save(){

        $params = Request::instance()->param();
        $this->validate($params,$this->rule);
        $params['user_id']=$this->userId;

        $hotel = HouseModel::get($params['hotel_id']);
        if($hotel==null)error("对不起，该民宿不存在！");

        $params['hotel_name'] = $hotel->name;
        $params['hotel_img'] = $hotel->img[0]['url'];// 民宿主图
        $params['total_money'] = $params['pay_money']+$params['deduction_money'];//总价

        if(isset($params['room_id'])){
            $room = RoomModel::get(['id'=>$params['room_id'],'hotel_id'=>$params['hotel_id']]);
            if($room){
                $this->reservation($params['hotel_id'],$params['arrive_time'],$params['leave_time'],$params['room_id']);//单间、写入民宿预订时间
            }else{
                error("该民宿不存在".$params['room_id']."ID房间！");
            }

        }else {
            $this->reservation($params['hotel_id'],$params['arrive_time'],$params['leave_time']);//整套、写入民宿预订时间
        }

        $model = new HotelOrderModel($params);
        $rt = $model->allowField(true)->save();

        if($rt){
            $userModel = UsersModel::get($this->userId);
            if($userModel){
                if($params['deduction_money']){
                    $userModel->point = $userModel->point- ($params['deduction_money']*50);// 50个积分可以抵扣1元钱
                    $userModel->save();
                }
            }
            success($model);
        }else{
            error("下单失败哦！");
        }
    }

    /**
     * 用户取消订单
     */
    public function cancel($id){
        $order = $this->findModel($id);
        if($order->status==0||$order->status==1){
            $order->status = -1;
            if($order->save()){
                api(100,"取消成功！");
            }else{
                error("取消失败！");
            }
        }else{
            if($order->status==-1){
                error("该订单状态为：".$order->status.",已经取消,请勿重复操作！");
            }else{
                error("该订单状态为：".$order->status.",不满足取消条件！");
            }
        }
    }

    /**
     * 退房
     */
    public function checkOut($id){
        $drder = $this->findModel($id);
        if($drder->status !=2) error("只有正在消费中的订单，才能退房,状态码：".$drder->status);
        $drder->status = 3 ;//待退房
        if($drder->save()){
            api(100,"退房成功！");
        }else{
            error("退房失败！".$drder->getError());
        }

    }

    /**
     * 民宿预订
     */
    protected function reservation($hotelId,$checkInDate,$checkOutDate,$roomId = null){

        //入住
        $y1 = (int)date("Y",$checkInDate);
        $m1 = (int)date("m",$checkInDate);
        $d1 = (int)date("d",$checkInDate);

        //退房
        $y2 = (int)date("Y",$checkOutDate);
        $m2 = (int)date("m",$checkOutDate);
        $d2 = (int)date("d",$checkOutDate);

        $max = date('t', $checkInDate);//该月天数

        //预订时间算法
        $list = [];
        if($y1==$y2){
            if($m1==$m2){
                for ($i=$d1; $i <$d2; $i++) {
                    $list[]['date']=$y1."-".$m1."-".$i;
                }

            }else{
                for ($i=$d1; $i <=$max; $i++) {
                    $list[]['date']=$y1."-".$m1."-".$i;
                }
                for ($i=1; $i <$d2; $i++) {
                    $list[]['date']=$y1."-".$m2."-".$i;
                }
            }
        }else{
            for ($i=$d1; $i <=$max; $i++) {
                $list[]['date']=$y1."-".$m1."-".$i;
            }
            for ($i=1; $i <$d2; $i++) {
                $list[]['date']=$y2."-".$m2."-".$i;
            }
        }

        foreach ($list as $k=>$v){
            if($roomId){
                $model = HotelReservation::get(['hotel_id'=>$hotelId,'room_id'=>$roomId,'date'=>$v['date']]);//单间情况
                $list[$k]['hotel_id']=$hotelId;
                $list[$k]['room_id']=$roomId;
            }else{
                $model = HotelReservation::get(['hotel_id'=>$hotelId,'date'=>$v['date']]);//整套情况
                $list[$k]['hotel_id']=$hotelId;
            }
            if($model)error("该民宿在".$v['date']."日期已经被预定！");

        }

        $model = new HotelReservation();
        $model->saveAll($list);

    }
}