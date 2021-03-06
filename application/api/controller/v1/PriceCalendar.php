<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;
use app\common\model\Hotel as HouseModel;
use app\common\model\HotelRoom as RoomModel;
use app\common\model\HotelPriceCalendar as PriceCalendarModel;
use app\common\model\HotelReservation;

class PriceCalendar extends ActiveController
{

    protected $modelClass = 'app\common\model\HotelPriceCalendar';
    protected $authenticate = ['except'=>'index,read,save'];

    /**
     * 价格日历
     */
    public function index(){
        $hotelId = paramFromGet('hotel_id',true);
        $houseModel = HouseModel::get($hotelId);
        if(!$houseModel){
            error("没有该ID的民宿！");
        }
        $roomId = paramFromGet('room_id');
        if($roomId!=null){
            $roomModel = RoomModel::get($roomId);
            if(!$roomModel){
                error("该民宿没有此房间！");
            }
            $reservation = HotelReservation::all(['hotel_id'=>$hotelId,'room_id'=>$roomId]);
            $list = PriceCalendarModel::all(['hotel_id'=>$hotelId,'room_id'=>$roomId,'type'=>0]);//单间
        }else{
            $reservation = HotelReservation::all(['hotel_id'=>$hotelId]);
            $list = PriceCalendarModel::all(['hotel_id'=>$hotelId,'type'=>1]);//整套
        }
        $alreadyReservation = [];
        foreach ($reservation as $value){
            $alreadyReservation[] = $value['date'];
        }
        success(['already_reservation'=>$alreadyReservation,'price_calendar'=>$list]);
    }

    /**
     * 新增和修改价格日历
     */
    public function save()
    {
        $day = paramFromPost('day',true);
        $houseId = paramFromPost('hotel_id',true);
        $roomId = paramFromPost('room_id');
        $price = paramFromPost('price',true);
        if($roomId!=null){
            $roomModel = RoomModel::get($roomId);
            if(!$roomModel){
                error("该民宿没有此房间！");
            }
            $m = PriceCalendarModel::get(['hotel_id'=>$houseId,'room_id'=>$roomId,'day'=>$day,'type'=>0]);
        }else{
            $m = PriceCalendarModel::get(['hotel_id'=>$houseId,'day'=>$day,'type'=>1]);
        }

        if($m){//有则修改
            $m->price = $price;
            $rt = $m->save();
            if($rt){
                api(100,"该天的价格已修改！",$m);
            }else{
                error("与原价格一致！");
            }

        }else{//无则新增
            $m = new PriceCalendarModel(paramFromPost());
            $rt = $m->allowField(true)->save();
            if($roomId == null){
                $m->type = 1;
                $m->save();
            }
            if($rt){
                api(100,"新增".$day."日的价格！",$m);
            }else{
                error("新增价格日历失败！".$m->getError());
            }
        }
    }

    /**
     * 详情
     * @param $id
     */
    public function read($id){
        $modelClass = $this->modelClass;

        $m = $modelClass::get($id);
        if($m){
            $m->img;
            $m->room;
            $m->support;
            $m->comment;
            success($m);
        }else{
            error("没有该ID的民宿哦！");
        }
    }


}
