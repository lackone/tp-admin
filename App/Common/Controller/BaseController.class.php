<?php

namespace Common\Controller;

use Think\Controller;

/**
 * Base基类控制器
 */
class BaseController extends Controller {

    protected $noAuthCheck = array(
        'Admin/Index/index',
        'Admin/Index/welcome',
        'Admin/Index/login',
        'Admin/Index/logout',
        'Admin/Index/verify',
    );
    protected $noLogin = array(
        'Admin/Index/login',
        'Admin/Index/verify',
    );

    /**
     * 初始化方法
     */
    public function _initialize() {
        $myAuth = new \Common\Lib\MyAuth();

        $rule = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;


        //需要验证权限的方法
        if (!in_array($rule, $this->noAuthCheck)) {
            if (!$myAuth->check($rule, session('userInfo.id'))) {
                ajaxReturn('没有权限', 300);
            }
        }

        //需要验证登陆的方法
        if (!in_array($rule, $this->noLogin)) {
            if (empty(session('userInfo.id'))) {
                $this->redirect(U('Admin/Index/login'));
            }
        }
    }

}
