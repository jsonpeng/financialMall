@extends('shop.layouts.app')


@section('content')

<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-email">
                <li class="{{ Request::is('shop/settings/setting*') ? 'active' : '' }}">
                    <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>网站设置</span></a>
                </li>
            {{--     <li class="{{ Request::is('shop/settings/system') ? 'active' : '' }}">
                    <a href="{!! route('settings.system') !!}"><i class="fa fa-edit"></i><span>系统功能</span></a>
                </li> --}}
                @if( Config::get('web.FUNC_THEME') || Config::get('web.FUNC_COLOR'))
                <li class="{{ Request::is('shop/settings/themeSetting*') ? 'active' : '' }}">
                    <a href="{!! route('settings.themeSetting') !!}"><i class="fa fa-edit"></i><span>主题设置</span></a>
                </li>
                @endif
            </ul>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="container">
                <section class="content pdall0-xs pt10-xs" style="padding: 0;">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">网站设置</a>
                            </li>

                            <li>
                                <a href="#tab_2" data-toggle="tab">购物设置</a>
                            </li>

                            <li>
                                <a href="#tab_12" data-toggle="tab">商城订单分佣设置</a>
                            </li>

                            <li>
                                <a href="#tab_11" data-toggle="tab">购买会员设置</a>
                            </li>

                            <li>
                                <a href="#tab_3" data-toggle="tab">{{ getSettingValueByKeyCache('credits_alias') }}设置</a>
                            </li>

                            <li>
                            <a href="#tab_5" data-toggle="tab">支付设置</a>
                            </li>
                            <li>
                            <a href="#tab_6" data-toggle="tab">短信设置</a>
                            </li> 
                             <li>
                            <a href="#tab_7" data-toggle="tab">显示图片设置</a>
                            </li>
                            <!--li>
                         
                      {{--       <li>
                            <a href="#tab_4" data-toggle="tab">显示设置</a>
                            </li> --}}
                            <!--li>
                                <a href="#tab_5" data-toggle="tab">短信设置</a>
                            </li-->
                          {{--   <li>
                                <a href="#tab_7" data-toggle="tab">小票打印设置</a>
                            </li> --}}
                            <li>
                                <a href="#tab_8" data-toggle="tab">其他设置</a>
                            </li>
                            <li>
                                <a href="#tab_9" data-toggle="tab">游戏设置</a>
                            </li>
                            <li>
                                <a href="#tab_10" data-toggle="tab">APP下载地址设置</a>
                            </li>
                        </ul>
                        <div class="tab-content">

                               <div class="tab-pane" id="tab_11">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form11">
                                            <div class="form-group">
                                                <label for="buy_member_dis_code" class="col-sm-3 control-label">购买会员优惠代码</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="buy_member_dis_code" maxlength="60" placeholder="购买会员优惠代码" value="{{ getSettingValueByKey('buy_member_dis_code') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="buy_member_dis_price" class="col-sm-3 control-label">购买会员优惠价格</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="buy_member_dis_price" maxlength="60" placeholder="购买会员优惠价格" value="{{ getSettingValueByKey('buy_member_dis_price') }}"></div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(11)">保存</button>
                                    </div>
                                 
                                </div>
                            </div>

                            <div class="tab-pane active" id="tab_1">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form1">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">名称<span class="bitian">(必填)</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" maxlength="60" placeholder="网站名称" value="{{ getSettingValueByKey('name') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="logo" class="col-sm-3 control-label">网站LOGO</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image1" name="logo" placeholder="网站LOGO" value="{{ getSettingValueByKey('logo') }}">
                                                    <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('logo')) {{ getSettingValueByKey('logo') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div>

                                            @if(funcOpen('FUNC_SEO'))
                                            <div class="form-group">
                                                <label for="seo_title" class="col-sm-3 control-label">网站标题</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="seo_title" maxlength="60" placeholder="网站标题" value="{{ getSettingValueByKey('seo_title') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="seo_des" class="col-sm-3 control-label">网站描述</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="seo_des" maxlength="60" placeholder="网站描述" value="{{ getSettingValueByKey('seo_des') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="seo_keywords" class="col-sm-3 control-label">网站关键字</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="seo_keywords" maxlength="60" placeholder="网站关键字" value="{{ getSettingValueByKey('seo_keywords') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="icp" class="col-sm-3 control-label">ICP备案信息</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="icp" maxlength="60" placeholder="ICP备案信息" value="{{ getSettingValueByKey('icp') }}">
                                                    <p class="help-block">网站备案号，将显示在前台底部欢迎信息等位置</p>
                                                </div>
                                            </div>
                                            @endif

                                      {{--       <div class="form-group">
                                                <label for="service_tel" class="col-sm-3 control-label">客服电话</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="service_tel" maxlength="60" placeholder="客服电话" value="{{ getSettingValueByKey('service_tel') }}"></div>
                                            </div> --}}

                                            <div class="form-group">
                                                <label for="big_data_query_menu_option" class="col-sm-3 control-label">大数据查询链接地址</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="big_data_query_menu_option" maxlength="60" placeholder="大数据查询链接地址" value="{{ getSettingValueByKey('big_data_query_menu_option') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kedou_query_menu_option" class="col-sm-3 control-label">蝌蚪查询链接地址</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="kedou_query_menu_option" maxlength="60" placeholder="蝌蚪查询链接地址" value="{{ getSettingValueByKey('kedou_query_menu_option') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="online_kefu_menu_option" class="col-sm-3 control-label">在线客服链接地址</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="online_kefu_menu_option" maxlength="60" placeholder="在线客服链接地址" value="{{ getSettingValueByKey('online_kefu_menu_option') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="dk_shop_menu_option" class="col-sm-3 control-label">贷款超市链接地址</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="dk_shop_menu_option" maxlength="60" placeholder="贷款超市链接地址" value="{{ getSettingValueByKey('dk_shop_menu_option') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kefu_tel_menu_option" class="col-sm-3 control-label">客服电话</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="kefu_tel_menu_option" maxlength="60" placeholder="客服电话" value="{{ getSettingValueByKey('kefu_tel_menu_option') }}"></div>
                                            </div>


                                     {{--        <div class="form-group">
                                                <label for="weixin" class="col-sm-3 control-label">微信公众号</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image2" name="weixin" placeholder="微信公众号二维码" value="{{ getSettingValueByKey('weixin') }}">
                                               <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image2')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('weixin')) {{ getSettingValueByKey('weixin') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="form-group">
                                                <label for="share_ruanwen_menu_option" class="col-sm-3 control-label">分享软文</label>
                                                <div class="col-sm-9">
                                                        <textarea  class="form-control intro" name="share_ruanwen_menu_option" placeholder="购买协议">{{ getSettingValueByKey('share_ruanwen_menu_option') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="shop_agreee_before_img_menu_option" class="col-sm-3 control-label">购买会员前图片介绍</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image31" name="shop_agreee_before_img_menu_option" placeholder="购买会员前图片介绍" value="{{ getSettingValueByKey('shop_agreee_before_img_menu_option') }}">
                                               <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image31')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('shop_agreee_before_img_menu_option')) {{ getSettingValueByKey('shop_agreee_before_img_menu_option') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div>

                                          

                                            <div class="form-group">
                                                <label for="shop_agreement_menu_option" class="col-sm-3 control-label">购买协议</label>
                                                <div class="col-sm-9">
                                                        <textarea  class="form-control intro" name="shop_agreement_menu_option" placeholder="购买协议">{{ getSettingValueByKey('shop_agreement_menu_option') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="shop_sound_link_menu_option" class="col-sm-3 control-label">购买前音频链接</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="shop_sound_link_menu_option" maxlength="60" placeholder="购买前音频链接" value="{{ getSettingValueByKey('shop_sound_link_menu_option') }}"></div>
                                            </div>




                           
                                            @if(funcOpen('FUNC_MEMBER_LEVEL'))
                                            <div class="form-group">
                                                <label for="user_level_switch" class="col-sm-3 control-label">开启用户等级</label>
                                                <div class="col-sm-9">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="user_level_switch" value="开启" @if( '开启' == getSettingValueByKey('user_level_switch') )checked="" @endif>开启</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="user_level_switch" value="不开启" @if( '不开启' == getSettingValueByKey('user_level_switch') || '' == getSettingValueByKey('user_level_switch') )checked="" @endif>不开启</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if(funcOpen('FUNC_BIND_MOBILE'))
                                            <div class="form-group">
                                                <label for="account_bind" class="col-sm-3 control-label">第三方登录是否必须绑定账号</label>
                                                <div class="col-sm-9">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="account_bind" value="是" @if( '是' == getSettingValueByKey('account_bind') )checked="" @endif>是</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="account_bind" value="否" @if( '否' == getSettingValueByKey('account_bind') )checked="" @endif>否</label>
                                                    </div>
                                                    <p class="help-block">否: 第三方账号首次登录时会自动创建账号, 不需要额外绑定账号</p>
                                                    <p class="help-block">
                                                        是:(推荐)第三方账号首次登录时必须先绑定一个注册账号, 否则无法购买商品(优点:可以避免微商城, PC端产生多账户问题)
                                                    </p>
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(1)">保存</button>
                                    </div>
                                 
                                </div>
                            </div>

                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form2">
                                             <div class="form-group">
                                                <label for="category_level" class="col-sm-3 control-label">商品分类等级</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="category_level"  placeholder="商品分类等级" value="{{ getSettingValueByKey('category_level') }}">
                                                    <p class="help-block">设置商品的分类等级，值为0-3，设置为0则不对商品分类。 设置商品分类是为了便于商品管理和展示</p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inventory_default" class="col-sm-3 control-label">默认库存</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="inventory_default"  maxlength="10" placeholder="默认库存" value="{{ getSettingValueByKey('inventory_default') }}">
                                                    <p class="help-block">设置商品的默认库存，上传商品的时候可以单独设置商品的库存，如果不设置将使用默认库存，-1表示无限量库存</p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inventory_warn" class="col-sm-3 control-label">库存预警数</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="inventory_warn" maxlength="10" placeholder="库存预警数" value="{{ getSettingValueByKey('inventory_warn') }}">
                                                <p class="help-block">库存小于预警数值，将会提醒用户</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="freight_free_limit" class="col-sm-3 control-label">全场满多少免运费(0表示不免运费)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="freight_free_limit" maxlength="10" placeholder="全场满多少免运费 0不免运费" value="{{ getSettingValueByKey('freight_free_limit') }}">
                                                        <span class="input-group-addon">元</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="auto_complete" class="col-sm-3 control-label">自动确认收货时间</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="auto_complete" maxlength="10" placeholder="" value="{{ getSettingValueByKey('auto_complete') }}">
                                                        <span class="input-group-addon">天</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(funcOpen('FUNC_AFTERSALE'))
                                            <div class="form-group">
                                                <label for="after_sale_time" class="col-sm-3 control-label">多少天内可申请售后</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="after_sale_time" maxlength="10" placeholder="" value="{{ getSettingValueByKey('after_sale_time') }}">
                                                        <span class="input-group-addon">天</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="form-group">
                                                <label for="inventory_consume" class="col-sm-3 control-label">减库存的时机</label>
                                                <div class="col-sm-9">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="inventory_consume" value="下单成功" @if( '下单成功' == getSettingValueByKey('inventory_consume') )checked="" @endif>下单成功</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="inventory_consume" value="支付成功" @if( '支付成功' == getSettingValueByKey('inventory_consume') )checked="" @endif>支付成功</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="after_sale_time" class="col-sm-3 control-label">订单支付超时时间(0表示永不过期)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="order_expire_time" maxlength="10" placeholder="" value="{{ getSettingValueByKey('order_expire_time') }}">
                                                        <span class="input-group-addon">小时</span>
                                                    </div>
                                                </div>
                                            </div>


                                            @if (funcOpen('FUNC_CASH_WITHDRWA'))
                                                <p class="help-block">提现设置</p>
                                                <div class="form-group">
                                                    <label for="withdraw_limit" class="col-sm-3 control-label">满多少才能提现</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="withdraw_limit" placeholder="满多少才能提现" value="{{ getSettingValueByKey('withdraw_limit') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="withdraw_min" class="col-sm-3 control-label">最少提现额度</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="withdraw_min" placeholder="最少提现额度" value="{{ getSettingValueByKey('withdraw_min') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="withdraw_bili" class="col-sm-3 control-label">提现手续费比例(占提现支付金额)</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="withdraw_bili" maxlength="3" placeholder="" value="{{ getSettingValueByKey('withdraw_bili') }}">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="withdraw_bili_info" class="col-sm-3 control-label">提现比例提示</label>
                                                    <div class="col-sm-9">
                                                      
                                                        <textarea type="text" class="form-control" name="withdraw_bili_info" placeholder="如:需支付提现金额*%的手续费" rows="2">{{ getSettingValueByKey('withdraw_bili_info') }}</textarea>
                                                    
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="after_sale_time" class="col-sm-3 control-label">单日最多提现多少次</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="withdraw_day_max_num" maxlength="10" placeholder="" value="{{ getSettingValueByKey('withdraw_day_max_num') }}">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(2)">保存</button>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form3">
                                            <div class="form-group">
                                                <label for="credits_alias" class="col-sm-3 control-label">积分别名</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="credits_alias" maxlength="10" placeholder="积分别名" value="{{ getSettingValueByKey('credits_alias') }}"></div>
                                            </div>



                                        {{--     <div class="form-group">
                                                <label for="CARD_NUM" class="col-sm-3 control-label">生成{{ getSettingValueByKey('credits_alias') }}卡统一位数:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="CARD_NUM" maxlength="10" placeholder="请输入统一位数,不输入默认为8位,小于4位按4位生成" value="{{ getSettingValueByKey('CARD_NUM') }}"></div>
                                            </div> --}}
                                            
                                            <div class="form-group">
                                                <label for="register_credits" class="col-sm-3 control-label">注册赠送{{ getSettingValueByKeyCache('credits_alias') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="register_credits" maxlength="10" placeholder="赠送数值" value="{{ getSettingValueByKey('register_credits') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="invite_credits" class="col-sm-3 control-label">邀请人获赠{{ getSettingValueByKeyCache('credits_alias') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="invite_credits" maxlength="10" placeholder="" value="{{ getSettingValueByKey('invite_credits') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="consume_credits" class="col-sm-3 control-label">购物送{{ getSettingValueByKeyCache('credits_alias') }}比例(占商品总金额)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="consume_credits" maxlength="3" placeholder="" value="{{ getSettingValueByKey('consume_credits') }}">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="credits_rate" class="col-sm-3 control-label">1元能兑换多少{{ getSettingValueByKeyCache('credits_alias') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="credits_rate" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_rate') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="credits_switch" class="col-sm-3 control-label">{{ getSettingValueByKeyCache('credits_alias') }}可抵扣订单金额</label>
                                                <div class="col-sm-9">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="credits_switch" value="是" @if( '是' == getSettingValueByKey('credits_switch') )checked="" @endif>是</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="credits_switch" value="否" @if( '否' == getSettingValueByKey('credits_switch') )checked="" @endif>否</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="credits_min" class="col-sm-3 control-label">最低多少{{ getSettingValueByKeyCache('credits_alias') }}才能使用</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="credits_min" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_min') }}"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="credits_max" class="col-sm-3 control-label">{{ getSettingValueByKeyCache('credits_alias') }}抵扣订单金额上限(比例)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="credits_max"  maxlength="3" placeholder="" value="{{ getSettingValueByKey('credits_max') }}">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group">
                                                <label for="send_credits_bili" class="col-sm-3 control-label">转赠{{ getSettingValueByKeyCache('credits_alias') }}转赠人额外支付比例(转赠数量)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="send_credits_bili" maxlength="3" placeholder="" value="{{ getSettingValueByKey('send_credits_bili') }}">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="send_credits_min_num" class="col-sm-3 control-label">单次转赠最低服务费</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="send_credits_min_num" maxlength="3" placeholder="" value="{{ getSettingValueByKey('send_credits_min_num') }}">
                                                        <span class="input-group-addon">{{ getSettingValueByKeyCache('credits_alias') }}</span>
                                                    </div>
                                                </div>
                                            </div>




                                             <div class="form-group">
                                                <label for="send_credits_info" class="col-sm-3 control-label">转赠{{ getSettingValueByKeyCache('credits_alias') }}提示</label>
                                                <div class="col-sm-9">
                                                  
                                                        <textarea type="text" class="form-control" name="send_credits_info" placeholder="如:需支付转赠金额的*%的呗壳,请保证呗壳金额充足" rows="2">{{ getSettingValueByKey('send_credits_info') }}</textarea>
                                                
                                                </div>
                                            </div> --}}



                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(3)">保存</button>
                                    </div>
                                </div>
                            </div>
                            

                              <div class="tab-pane" id="tab_12">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form12">

                                            <div class="form-group">
                                                <label for="leader1_shop_order_rate" class="col-sm-3 control-label">一级推荐人分佣比率(占订单总金额)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="leader1_shop_order_rate"  maxlength="3" placeholder="一级推荐人分佣比率(占订单总金额)" value="{{ getSettingValueByKey('leader1_shop_order_rate') }}">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="leader2_shop_order_rate" class="col-sm-3 control-label">二级推荐人分佣比率(占订单总金额)</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="leader2_shop_order_rate"  maxlength="3" placeholder="二级推荐人分佣比率(占订单总金额)" value="{{ getSettingValueByKey('leader2_shop_order_rate') }}">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(12)">保存</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_4">
                                
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form4">

                                            <div class="form-group">
                                                <label for="logo" class="col-sm-3 control-label">新品推荐</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image_new" name="image_new" placeholder="新品推荐" value="{{ getSettingValueByKey('image_new') }}">
                                                    <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image_new')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('image_new')) {{ getSettingValueByKey('image_new') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                    <p class="help-block">部分主题有效，新品推荐封面图片，大小300x300像素</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="logo" class="col-sm-3 control-label">优惠活动</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image_prmop" name="image_prmop" placeholder="优惠活动" value="{{ getSettingValueByKey('image_prmop') }}">
                                                    <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image_prmop')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('image_prmop')) {{ getSettingValueByKey('image_prmop') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                    <p class="help-block">部分主题有效，优惠封面图片，大小300x145像素</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="logo" class="col-sm-3 control-label">销量榜</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image_sales_count" name="image_sales_count" placeholder="销量榜" value="{{ getSettingValueByKey('image_sales_count') }}">
                                                    <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image_sales_count')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('image_sales_count')) {{ getSettingValueByKey('image_sales_count') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                    <p class="help-block">部分主题有效，销量榜封面图片，大小300x145像素</p>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(4)">保存</button>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="tab-pane" id="tab_5">
                                <div class="box box-info form">
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form5">
                                 
                                            <div class="form-group">
                                                <label for="alipay_app_id" class="col-sm-3 control-label">支付宝支付[APP_ID]</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="alipay_app_id"   maxlength="60" placeholder="APP_ID" value="{{ getSettingValueByKey('alipay_app_id') }}"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="alipay_public_key" class="col-sm-3 control-label">支付宝支付公钥[PUBLIC_KEY]</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" name="alipay_public_key"  rows="3" placeholder="PUBLIC_KEY">{{ getSettingValueByKey('alipay_public_key') }}</textarea></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="alipay_private_key" class="col-sm-3 control-label">支付宝支付私钥[PRIVATE_KEY]</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" name="alipay_private_key" rows="5"  placeholder="PRIVATE_KEY" >{{ getSettingValueByKey('alipay_private_key') }}</textarea></div>
                                            </div>
                            
                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(5)">保存</button>
                                    </div>
                                </div>
                            </div> 
                        
                            <div class="tab-pane" id="tab_6">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form6">
                                            <div class="form-group">
                                                <label for="feie_sn" class="col-sm-3 control-label">Access Key ID</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="access_key_id" maxlength="60" placeholder="Access Key ID" value="{{ getSettingValueByKey('access_key_id') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="feie_user" class="col-sm-3 control-label">Access Key Secret</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="access_key_secret" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('access_key_secret') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="feie_ukey" class="col-sm-3 control-label">注册签名</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="sms_sign" maxlength="60" placeholder="注册签名" value="{{ getSettingValueByKey('sms_sign') }}"></div>
                                            </div>
                                              <div class="form-group">
                                                <label for="feie_ukey" class="col-sm-3 control-label">短信模板编号</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="sms_tem" maxlength="60" placeholder="短信模板编号" value="{{ getSettingValueByKey('sms_tem') }}"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(6)">保存</button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_7">
                                        <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form7">
                                 
                                            <div class="form-group">
                                                <label for="share_money_menu_option" class="col-sm-3 control-label">分享赚钱图片</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image71" name="share_money_menu_option" placeholder="分享赚钱图片" value="{{ getSettingValueByKey('share_money_menu_option') }}">
                                               <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image71')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('share_money_menu_option')) {{ getSettingValueByKey('share_money_menu_option') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="tuiguang_money_menu_option" class="col-sm-3 control-label">推广赚钱图片</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image72" name="tuiguang_money_menu_option" placeholder="推广赚钱图片" value="{{ getSettingValueByKey('tuiguang_money_menu_option') }}">
                                               <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image72')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('tuiguang_money_menu_option')) {{ getSettingValueByKey('tuiguang_money_menu_option') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="live_img_menu_option" class="col-sm-3 control-label">直播封面图片</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="image73" name="live_img_menu_option" placeholder="直播封面图片" value="{{ getSettingValueByKey('live_img_menu_option') }}">
                                               <div class="input-append">
                                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image73')">选择图片</a>
                                                        <img src="@if(getSettingValueByKey('live_img_menu_option')) {{ getSettingValueByKey('live_img_menu_option') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                                    </div>
                                                </div>
                                            </div>
                           
                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(7)">保存</button>
                                    </div>
                                 
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_8">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form8">
                                            <div class="form-group">
                                                <label for="feie_sn" class="col-sm-3 control-label">每页显示记录数量</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="records_per_page" value="{{ getSettingValueByKey('records_per_page') }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="feie_sn" class="col-sm-3 control-label">订单提醒邮箱</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email" value="{{ getSettingValueByKey('email') }}"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(8)">保存</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="tab_9">
                            <div class="form">
                                <!-- form start -->
                                <div class="box-body">
                                    <form class="form-horizontal" id="form9">

                                        <div class="form-group">
                                            <label for="hongbao_coin" class="col-sm-3 control-label">每次消耗金币数量<span class="bitian">(积分)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_coin" maxlength="60" placeholder="每次消耗金币数量" value="{{ valueOfKey('hongbao_coin') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_1" class="col-sm-3 control-label">奖项1名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_1_name" maxlength="60" placeholder="奖项1名称" value="{{ valueOfKey('hongbao_1_name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_1" class="col-sm-3 control-label">奖项1中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_1" maxlength="60" placeholder="奖项1中奖比例" value="{{ valueOfKey('hongbao_1') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_2" class="col-sm-3 control-label">奖项2名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_2_name" maxlength="60" placeholder="奖项2名称" value="{{ valueOfKey('hongbao_2_name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_2" class="col-sm-3 control-label">奖项2中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_2" maxlength="60" placeholder="奖项2中奖比例" value="{{ valueOfKey('hongbao_2') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_2" class="col-sm-3 control-label">奖项3名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_3_name" maxlength="60" placeholder="奖项3名称" value="{{ valueOfKey('hongbao_3_name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_3" class="col-sm-3 control-label">奖项3中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_3" maxlength="60" placeholder="奖项3中奖比例" value="{{ valueOfKey('hongbao_3') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_2" class="col-sm-3 control-label">奖项4名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_4_name" maxlength="60" placeholder="奖项4名称" value="{{ valueOfKey('hongbao_4_name') }}">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="hongbao_4" class="col-sm-3 control-label">奖项4中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_4" maxlength="60" placeholder="奖项4中奖比例" value="{{ valueOfKey('hongbao_4') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="hongbao_5" class="col-sm-3 control-label">奖项5名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_5_name" maxlength="60" placeholder="奖项5名称" value="{{ valueOfKey('hongbao_5_name') }}">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="hongbao_5" class="col-sm-3 control-label">奖项5中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_5" maxlength="60" placeholder="奖项5中奖比例" value="{{ valueOfKey('hongbao_5') }}">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="hongbao_2" class="col-sm-3 control-label">奖项6名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hongbao_6_name" maxlength="60" placeholder="奖项6名称" value="{{ valueOfKey('hongbao_6_name') }}">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="hongbao_6" class="col-sm-3 control-label">奖项6中奖比例<span class="bitian">(%)</span></label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="hongbao_6" maxlength="60" placeholder="奖项6中奖比例" value="{{ valueOfKey('hongbao_6') }}">
                                            </div>
                                        </div>


                                    </form>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(9)">保存</button>
                                </div>
                                <!-- /.box-footer --> 
                            </div>
                            </div>

                            <div class="tab-pane" id="tab_10">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form10">
                                           

                                            <div class="form-group">
                                                <label for="android_link" class="col-sm-3 control-label">安卓下载链接</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="android_link" maxlength="120" placeholder="安卓下载链接" value="{{ getSettingValueByKey('android_link') }}"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="android_link" class="col-sm-3 control-label">IOS下载链接</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="ios_link" maxlength="120" placeholder="IOS下载链接" value="{{ getSettingValueByKey('ios_link') }}"></div>
                                            </div>




                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(10)">保存</button>
                                    </div>
                                 
                                </div>
                            </div>

                    {{--         <div class="tab-pane" id="tab_9">
                                <div class="box box-info form">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <form class="form-horizontal" id="form9">
                                            <div class="form-group">
                                                <label for="freight_first_weight" class="col-sm-3 control-label">每页显示信息条目</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="records_per_page" maxlength="10" placeholder="" value="{{ getSettingValueByKey('records_per_page') }}"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(9)">保存</button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>




@endsection

@include('shop.partials.imagemodel')

@section('scripts')
<script>
        function saveForm(index){
            tinyMCE.triggerSave();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/shop/settings/setting",
                type:"POST",
                data:$("#form"+index).serialize(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            });
            
        }
    </script>
@endsection