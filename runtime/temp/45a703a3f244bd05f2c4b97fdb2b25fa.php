<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\xampp\htdocs\ota\public/../application/admin\view\house\create.html";i:1497596749;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1497577871;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>琼中OTA后台管理</title>
    <link rel="stylesheet" href="/static/css/app.css?ver=<?php echo time(); ?>">
    <link href="/static/css/component.css" rel="stylesheet">
    <link href="/DatePicker/css/datepicker.css" rel="stylesheet" />

    <script src="/static/js/jquery-3.2.1.min.js"></script>
</head>

<body>

    <div class="head" id="header">
        <div class="head_box">
            <div class="inner wrp">
                <h1 class="logo">
                    <a href="https://mp.weixin.qq.com/" title="微信公众平台"></a>
                </h1>
                <div class="account">
                    <div class="account_meta account_info account_meta_primary"> 
                        <a href="#" class="nickname">管理员</a> <span class="type_wrp"></span>
                    </div>
                    <div class="account_meta account_logout account_meta_primary"><a id="logout" href="/admin/user/logout">退出</a></div>
                </div>
            </div>
        </div>
    </div>

    <div id="body" class="body page_user">
        <div id="js_container_box" class="container_box cell_layout side_l">
            <div class="col_side">
                <div class="menu_box" id="menuBar">
                    <dl class="menu no_extra">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_function.png) no-repeat;"></i>
                            基础信息
                        </dt>
                        <dd class="menu_item "><a  href="/admin/index">首页</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_ad.png) no-repeat;"></i>
                            旅游服务
                        </dt>
                        <dd class="menu_item "><a  href="/admin/house">民宿客栈</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_statistics.png) no-repeat;"></i>
                            文化公益
                        </dt>
                        <dd class="menu_item "><a href="/admin/book_house">书屋管理</a></dd>
                        <dd class="menu_item "><a href="/admin/user/child">书童管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book">书库管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book_donate">捐书管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book_rent">租书记录</a></dd>
                        <dd class="menu_item "><a href="/admin/book_write">著书管理</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_ad.png) no-repeat;"></i>
                            智能硬件
                        </dt>
                        <dd class="menu_item "><a  href="/admin/house">智能门锁</a></dd>
                        <dd class="menu_item "><a  href="/admin/house">二维码打印机</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_management.png) no-repeat;"></i>
                            订单管理
                        </dt>
                         <dd class="menu_item"><a href="/admin/order">订单列表</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_setup.png) no-repeat;"></i>
                            数据统计
                        </dt>
                        <dd class="menu_item "><a href="#">用户统计</a></dd>
                        <dd class="menu_item "><a href="#">访问统计</a></dd>
                        <dd class="menu_item "><a href="#">交易记录</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_setup.png) no-repeat;"></i>
                            系统管理
                        </dt>
                        <dd class="menu_item "><a href="/admin/user/getList">运营管理者</a></dd>
                        <dd class="menu_item "><a href="#">数据库</a></dd>
                        <dd class="menu_item "><a href="#">系统缓存</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_developer.png) no-repeat;">    </i>
                            投诉咨询
                        </dt>
                        <dd class="menu_item "><a href="#">游客咨询</a></dd>
                        <dd class="menu_item "><a href="#">投诉建议</a></dd>
                    </dl>
                </div>
                
            </div>
            <div class="col_main">
                <div class="main_hd">
    <h2>智能民宿</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top"><a href="/admin/house" id="reloadTop">全部民宿</a></li>
            <li class="tab_nav js_top selected"><a href="javascript:;" id="blackTop">新增民宿</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">

    <form action="/admin/house/doAdd" enctype="multipart/form-data" method="post" class=" form goods_form goods_add_form">

        <ul id="progressbar">
            <li class="active">基础信息</li>
            <li>配套信息</li>
            <li>民宿详情</li>
        </ul>

        <fieldset>
            <label>基础信息</label>
            <div class="form_group">
                <label>民宿名称</label><input  name="name"  type="text" maxlength="15" />
            </div>
            <div class="form_group">
                <label>整套价格</label><input  name="price"  type="number"  />
            </div>
            <div class="form_group">
                <label>房源类型</label><input  name="house_type"/>
            </div>

            <div class="form_group">
                <label>房间数</label><input  name="room_num"   type="number"  />
            </div>

            <div class="form_group">
                <label>可住人数</label><input  name="dwell_num" type="number"  />
            </div>

            <div class="form_group">
                <label>入住时间</label><input  name="check_in_time"  type="time"  />
            </div>

            <div class="form_group">
                <label>退房时间</label><input  name="check_out_time"  type="time"  />
            </div>

            <div class="form_group">
                <label>展示图片</label>
                <div class="upload_img_box">

                    <div class="upload_img_label" ><div class="ismain">*主图</div></div>
                    <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" />
                    <div class="upload_img_label" ></div>
                    <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" id="pic_1" />
                    <div class="upload_img_label" ></div>
                    <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" id="pic_2" />
                    <div class="upload_img_label" ></div>
                    <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" id="pic_3" />
                    <div class="upload_img_label" ></div>
                    <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" id="pic_4" />
                </div>
            </div>

            <div class="form_group">

                <label>所在位置</label>

                <!--<button class="btn btn_primary">标注位置</button>-->
                <div class="dialog">
                    <div id="map"></div>
                    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=LtCHl2DYmB4pe2nQ2fjA8X1zpWwsTYNK" ></script>
                    <!--<script type="text/javascript" src="http://api.map.baidu.com/library/SearchControl/1.4/src/SearchControl.js" ></script>-->
                    <script>
                        var map = new BMap.Map("map"),MARKER={};
                        map.centerAndZoom(new BMap.Point(110.305309,20.025742), 10);
                        map.addControl(new BMap.NavigationControl());
                        // var searchControl = new BMapLib.SearchControl({
                        //     container : "searchBox" //存放控件的容器
                        //     , map     : map  //关联地图对象
                        //     , type    : 'LOCAL_SEARCH'  //检索类型
                        // });

                        map.addEventListener("click", function(e){

                            // alert("您点击的位置是"+e.point.lat+' '+e.point.lng);
                            document.getElementById('lng').value = e.point.lng
                            document.getElementById('lat').value = e.point.lat
                            if(MARKER.marker){
                                map.removeOverlay(MARKER.marker)
                            }

                            console.log(e.point.lng + ", " + e.point.lat);
                            MARKER.marker = new BMap.Marker(e.point);        // 创建标注
                            map.addOverlay(MARKER.marker);                     // 将标注添加到地图中
                        });
                    </script>
                </div>
                <input required  id="lat"  name="lat" min="0"  type="hidden"  />
                <input required  id="lng"  name="lng" min="0"  type="hidden"  />
            </div>

            <div class="current_box">
                <input type="button" name="next" class="next btn btn_primary"  value="继续" />
            </div>
        </fieldset>
        <fieldset>

            <div class="form_group">
                <label>配套设施</label>
                <div class="sku_box" style="overflow: hidden">
                    <?php if(is_array($supportFacility) || $supportFacility instanceof \think\Collection || $supportFacility instanceof \think\Paginator): $i = 0; $__LIST__ = $supportFacility;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$support): $mod = ($i % 2 );++$i;?>
                    <div class="suppor_item">
                        <input name="support[]" style="width: 20px" type="checkbox" value="<?php echo $support['id']; ?>" /><img width="40px" src="<?php echo $support['img']; ?>"><label><?php echo $support['name']; ?></label>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="current_box">
                <input type="button" name="previous" class="previous btn btn_primary " value="上一页" />
                <input type="button" name="next" class="next btn btn_primary" value="继续" />
            </div>
        </fieldset>
        <fieldset>

            <div class="goods_desc_box form_group">
                <label>详细介绍</label>
                <script class="ueditor" id="container" name="describe" type="text/plain">商品简介
            </script>
                <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
                <!-- 编辑器源码文件 -->
                <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                    var ue = UE.getEditor('container',{
                        // initialFrameWidth:800,
                        // initialFrameHeight:300
                    });
                </script>
            </div>
            <div class="current_box">
                <input type="button" name="previous" class="previous btn btn_primary  " value="上一页" />
                <input type="button" onclick="submit()" name="next" class="next btn btn_primary " value="提交" />
            </div>
        </fieldset>
        <!--<button class="submit">修改</button>-->
    </form>
</div>

<script>

    $(function() {

        $(".upload_img_label").on('click',function(e){

            var index = $(".upload_img_label").index(this);
            $('.upload_img_input').eq(index).click();
        })

        $(".upload_img_input").on("change",function(){

            var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
            if (objUrl) {

                var index = $(".upload_img_input").index(this);

                var tempStr = "<img class='thumb'  />",
                        $label = $(".upload_img_label").eq(index);

                $label.append(tempStr);
                console.log($label.find('img.thumb'));
                $label.find('img.thumb').attr('src',objUrl);

            }

        });
    });

    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    function submit(){
        // return false;
        document.form[0].submit();
    }
</script>

            </div>
        </div>
        <div class="faq">
            <ul class="links">
                <li class="links_item"><a href="http://kf.qq.com/faq/120911VrYVrA1509086vyumm.html" target="_blank">客服中心</a></li>
                <li class="links_item"><a href="https://mp.weixin.qq.com/acct/infringement?action=getmanual&amp;t=infringement/manual&amp;type=1&amp;lang=zh_CN&amp;token=204132418"
                        target="_blank">侵权投诉</a></li>
            </ul>
            <p class="tail">反馈官号weixingongzhong</p>
        </div>
    </div>


    <div class="foot" id="footer">
        <ul class="links ft">
            <li class="links_item no_extra"><a href="#" target="_blank">关于我们</a></li>
            <li class="links_item"><a href="#" target="_blank">客服中心</a></li>
            <li class="links_item"><a href="#" target="_blank">联系邮箱</a></li>
            <li class="links_item">
                <p class="copyright">Copyright © 2015-2017 海口云宿乡土网络科技有限公司. All Rights Reserved.</p>
            </li>
        </ul>
    </div>
    <script>
        window.onload = function(){

            var menuList = document.querySelectorAll('.menu_item');
            var index = Number(sessionStorage.getItem('js-active-menu'));

            if(index>-1 && index<menuList.length){
                console.log(index);
                menuList[index].className+=' selected'
            }

            for(var i=0;i<menuList.length;i++ ){

                menuList[i].addEventListener("click",function(k){

                    return function(){

                        sessionStorage.setItem('js-active-menu',k);
                        document.querySelector('.selected').className = document.querySelector('.selected').className.replace(/selected/,'');
                        this.className+=' selected';
                        console.log(sessionStorage)
                    }
                }(i))

            }

        }

    </script>
</body>

<script src="/static/js/jquery.easing.min.js" type="text/javascript"></script>
<script src="/DatePicker/js/zlDate.js"></script>
<script src="/static/js/classie.js"></script>
<script src="/static/js/modalEffects.js"></script>
<script src="/static/js/zzsc.js" type="text/javascript"></script>
</html>