<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Book as BookModel;
use common\model\BookHouse as BookHouseModel;
use common\model\BookModel as BookModelModel;
use common\model\Category as CategoryModel;

class Book extends AdminController
{

    protected $modelClass = 'common\model\Book';
    protected $order = 'create_time DESC';

    protected function prepareDataProvider()
    {
        $type = paramFromGet('type');
        if($type!=null){
            $this->condition = ['status'=>$type];
        }
        $this->setAssign(['type'=>$type]);
        return parent::prepareDataProvider(); // TODO: Change the autogenerated stub
    }

    /**
     * 添加书本界面
     * @return string
     */
    public function create()
    {
        $bookHouseList = BookHouseModel::all();
        $bookCategory = CategoryModel::all(['resource_type'=>2]);

        $this->assign('bookHouseList',$bookHouseList);
        $this->assign('bookCategory',$bookCategory);
        return parent::create(); // TODO: Change the autogenerated stub
    }

    /**
     * 增书本
     * @return string
     */
    public function save()
    {

        $validate = [
            ['intro|书籍介绍','require|max:100'],
        ];

        //验证
        $result = $this->validate($_POST,$validate);

        if (true !== $result) {
            return $this->error($result);
        }

        $modelClass = $this->modelClass;
        $model = new $modelClass($_POST);
        // 过滤post数组中的非数据表字段数据
        $model->allowField(true)->save();
        if($model){

            $file = request()->file('cover_img');
            if($file==null)$this->error("没有上传书籍的封面图！");
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//移动保存图片
            if($info==null)$this->error("文件目录没有写入权限！");
            $filePath =$info->getSaveName();
            $coverImg = "/uploads/".str_replace('\\','/',$filePath);

            $model->thumb = $coverImg;
            $model->save();

            $paras = $_POST;
            $paras['cover_img'] = $coverImg;

            if(isset($_POST['model_id'])){// 修改书模
                $bmModel = new BookModelModel();
                $bmModel->allowField(true)->save($paras,['id' => $_POST['model_id']]);
                if($bmModel){
                    $this->success("新增成功！",'index');
                }else{
                    $model->delete();
                    $this->error("新增失败！");
                }
            }else{//新增书模
                $bmModel = new BookModelModel($paras);
                $bmModel->allowField(true)->save();
                if($bmModel){
                    $model->model_id = $bmModel->id;
                    $model->create_time = time();
                    $model->save();
                    $this->success("新增成功！",'index');
                }else{
                    $model->delete();
                    $this->error("新增失败！");
                }
            }

        }else{
            $this->error("新增失败！");
        }


    }

    /**
     * 编辑书本
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $bookHouseList = BookHouseModel::all();
        $bookCategory = CategoryModel::all(['resource_type'=>2]);

        $this->assign('bookHouseList',$bookHouseList);
        $this->assign('bookCategory',$bookCategory);
        return parent::edit($id); // TODO: Change the autogenerated stub
    }

    /**
     * 确认保存修
     */

    public function update($id)
    {
        $params = paramFromPost();

        $file = request()->file('cover_img');
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//移动保存图片
            if($info==null)$this->error("文件目录没有写入权限！");
            $filePath =$info->getSaveName();
            $coverImg = "/uploads/".str_replace('\\','/',$filePath);
            $params['cover_img']= $coverImg;
            $params['thumb']=$coverImg;
        }

        $model = new BookModel();
        $model->allowField(true)->save($params,['id' => $id]);
        $model = BookModel::get($id);

        if(isset($model->model_id)){
            $bmModel = new BookModelModel();
            $rt = $bmModel->allowField(true)->save($params,['id' => $model->model_id]);
            if($rt){
                $this->success("修改成功！",'index');
            }
        }


        $this->error("修改失败");

    }

    /**
     * 生成指定网址的二维码
     * @param string $url 二维码中所代表的网址
     * @param string $label 标签参数
     */
    public function qrcode($id)
    {
        $m = BookModel::get($id);
        //$url="https://qz.icloudinn.com/admin/book";
        $url=$m->id;
        $qrCode = new \Endroid\QrCode\QrCode();//创建生成二维码对象
        $qrCode->setText($url)
            ->setSize(150)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabel($m->id)      //标签
            ->setLabelFontSize(10)  //标签中字体的大小
            ->setImageType(\Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);
        header("Content-type: image/png");
        $qrCode->render();
        die;
    }
    //使用方法
    //在模板文件中使用<img src="{:url('index/qrcode/create_qrcode')}">


    public function findModel($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::get($id);
        if($model){
           $model->model;
        }else{
            error('该书本不存在！');
        }
        return $model;
    }

}
