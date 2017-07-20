<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Book as BookModel;
use common\model\BookHouse as BookHouseModel;
use common\model\BookModel as BookModelModel;
use common\model\Category as CategoryModel;
use common\model\Users as UsersModel;

class BookDonate extends AdminController
{

    protected $modelClass = 'common\model\BookDonate';
    protected $order = 'donate_time DESC';

    protected function prepareDataProvider()
    {
        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub
        foreach ($list as $m){
            $m->book;
        }
        return $list;
    }

    /**
     * 审核完善书本
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
     * 提交完善审核
     */
    public function audit(){

        $paras = paramFromPost();
        $validate = [
            ['intro|书籍介绍','require|max:100'],
            ['donate_id|捐赠ID','require']
        ];

        //验证
        $result = $this->validate($paras,$validate);
        if (true !== $result) {
            return $this->error($result);
        }

        //捐书
        $modelClass = $this->modelClass;
        $donateModel = $modelClass::get($paras['donate_id']);

        $model = new BookModel($_POST);
        // 过滤post数组中的非数据表字段数据
        $model->allowField(true)->save();
        if($model){

            $file = request()->file('cover_img');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//移动保存图片
                if($info==null)$this->error("文件目录没有写入权限！");
                $filePath =$info->getSaveName();
                $coverImg = "/uploads/".str_replace('\\','/',$filePath);
                $paras['cover_img'] = $coverImg;
                $model->thumb = $coverImg;
            }else{
                $paras['cover_img'] = $donateModel->cover;
                $model->thumb = $donateModel->cover;
            }
            $model->save();

            if(isset($paras['model_id'])){// 修改书模
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

                    $donateModel->book_id = $model->id;
                    $donateModel->status = 1;
                    $admin = json_decode($this->getLoginAdmin(),true);
                    $donateModel->operator = $admin['name'];
                    $rt = $donateModel->save();
                    if($rt){
                        $userModel = UsersModel::get($donateModel->user_id);
                        if($userModel){
                            $userModel->point = $userModel->point + 50;// 获得1积分
                            $userModel->save();
                        }
                        $this->success("审核通过成功！",'index');
                    }else{
                        $this->error("审核失败成功".$donateModel->getError());
                    }

                }else{
                    $model->delete();
                    $this->error("审核失败！");
                }
            }

        }else{
            $this->error("审核失败！");
        }
    }
}
