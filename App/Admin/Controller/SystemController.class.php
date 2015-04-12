<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model as MODEL;

/**
 *
 * @authors yangweijie (yangweijiester@gmail.com)
 * @date    2013-09-30 09:17:32
 * @version $Id$
 */
class SystemController extends Controller {

    public function index() {
        is_login() || $this->redirect('System/login');
        $this->display();
    }

    public function login() {
        cookie('think_language_save', null);
        if (is_login()) {
            $this->redirect('System/index');
        } else {
            $this->display();
        }
    }

    /* 登录验证 */

    public function check() {
        //接收数据
        $loginName = trim(I('post.loginName'));
        $loginPwd = trim(I('post.loginPwd'));

        //数据验证
        if (empty($loginName)) {
            $this->ajaxReturn('', '请填写登录名', 0);
        } elseif (empty($loginName)) {
            $this->ajaxReturn('', '请填写密码', 0);
        }
        if (C('ADMIN.LOGIN_NAME') == $loginName) {
            if (md5($loginPwd) == C('ADMIN.PWD')) {
                $user = array(
                    'admin_id' => 1,
                    'admin_name' => $loginName,
                    'login_time' => NOW_TIME, //上次登录时间
                );
                //设置登录SESSION
                session(C('USER_AUTH_KEY'), $user);
                session(C('USER_AUTH_SIGN_KEY'), user_auth_sign($user));
                $this->success('登录成功', U('System/index'));
            } else {
                $this->error('密码错误');
            }
        } else {
            $this->error('该管理员不存在');
        }
    }

    //注销登录
    public function logout() {
        session(C('USER_AUTH_KEY'), null);
        session(C('USER_AUTH_SIGN_KEY'), null);
        $this->success('登出成功', U('System/login'));
    }

    //清除缓存
    function cleancache(){
        $dirname = RUNTIME_PATH;

        //清文件缓存
        $dirs = array($dirname);
        //清理缓存
        foreach ($dirs as $value) {
            rmdirr($value);
        }
        @mkdir($dirname, 0777, true);
        S('DB_CONFIG_DATA', NULL);

        $this->success('删除缓存成功');
    }
}
