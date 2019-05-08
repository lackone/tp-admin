<?php

namespace Admin\Controller;

use Common\Controller\BaseController;

/**
 * 后台首页
 */
class IndexController extends BaseController {

    /**
     * 后台首页
     */
    public function index() {
        $myAuth = new \Common\Lib\MyAuth();
        $ruleList = $myAuth->getUserRules(session('userInfo.id'));

        if (!empty($ruleList)) {
            //获取权限中类型为链接
            $tmp = array();
            foreach ($ruleList as $item) {
                if ($item['type'] == 0) {
                    $item['url'] = U($item['name']);
                    $tmp[] = $item;
                }
            }
            $ruleList = $tmp;
        }
        
        $ruleList = genTree($ruleList);

        $this->assign('ruleList', $ruleList);
        $this->display();
    }

    /**
     * 欢迎页面
     */
    public function welcome() {
        $this->display();
    }

    /**
     * 登陆
     */
    public function login() {
        if (IS_POST) {
            $name = I('post.name', '');
            $password = I('post.password', '');
            $verify = I('post.verify', '');

            if (empty($name)) {
                $this->error('用户名不能为空');
            }
            if (empty($password)) {
                $this->error('密码不能为空');
            }
            if (empty($verify)) {
                $this->error('验证码不能为空');
            }
            if (!checkVerify($verify, 'login')) {
                $this->error('验证码错误');
            }
            $users = M('Users');

            $existName = $users->where("name='{$name}'")->find();
            if (empty($existName)) {
                $this->error('该用户名不存在');
            }
            $password = md5($password);
            $existUser = $users->where("name='{$name}' AND password='{$password}'")->find();
            if (empty($existUser)) {
                $this->error('密码错误');
            }
            if (!$existUser['status']) {
                $this->error('禁止登陆');
            }
            $users->where("id={$existUser['id']}")->save(array('last_login_time' => time(), 'last_login_ip' => get_client_ip()));
            session('userInfo', $existUser);
            $this->redirect(U('Admin/Index/index'));
        } else {
            $this->display();
        }
    }

    /**
     * 退出
     */
    public function logout() {
        session(null);
        $this->redirect(U('Admin/Index/login'));
    }

    /**
     * 验证码
     */
    public function verify() {
        showVerify('login');
    }

}
