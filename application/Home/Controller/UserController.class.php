<?php

namespace Home\Controller;

use Think\Controller;
class UserController extends BaseController {

    /**
     * 用户注册
     * @return [type] [description]
     */
    public function sign(){
        //校验参数是idea否存在
        if(!$_POST['username']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：username';
            $this->ajaxReturn($return_data);
        }

        if (!$_POST['phone']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：phone';
            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password';
            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password_again']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password_again';
            $this->ajaxReturn($return_data);
        }

        //检验两次密码输入是否一致
        if ($_POST['password'] != $_POST['password_again']){
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码输入不一致';
            $this->ajaxReturn($return_data);
        }

        //检验手机号是否已经被注册

        //建立user表实例对象
        $User = M('User');

        //构造where查询条件
        $where = array();
        $where['phone'] = $_POST['phone'];

        //执行查询语句
        $user = $User->where($where)->find();

        //如果查询到数据 ， 则手机号已被注册
        if ($user){
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '该手机号已被注册';
            $this->ajaxReturn($return_data);
        }else{
            //如果用户尚未注册 ， 则注册

            //构建插入的数据
            $data = array();
            $data['username'] = $_POST['username'];//用户名
            $data['phone'] = $_POST['phone'];
            //密码用md5()函数进行加密 ， 得到32为字符串
            $data['password'] = md5($_POST['password']);
            $data['face_url'] = 'xxx.jpg';

            //插入数据
            $result = $User->add($data);//add函数添加数据成功之后返回的是该数据的id

            if ($result){
                //插入数据成功
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '注册成功';
                $return_data['data']['user_id'] = $result;
                $return_data['data']['username'] = $_POST['username'];
                $return_data['data']['phone'] = $_POST['phone'];
                $return_data['data']['face_url'] = $data['face_url'];
                $this->ajaxReturn($return_data);
            }else{
                //插入数据失败
                $return_data = array();
                $return_data['error_code'] = 4;
                $return_data['msg'] = '注册失败';
                $this->ajaxReturn($return_data);
            }
        }
    }

    /**
     * 用户登录
     */
    public function login(){
        //校验参数是否存在
        if (!$_POST['phone']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：phone';
            $this->ajaxReturn($return_data);
        }

        if (!$_POST['password']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：password';
            $this->ajaxReturn($return_data);
        }

        //根据手机号查询用户

        //实例化数据表
        $User = M('User');

        //设置查询条件
        $where = array();
        $where['phone'] = $_POST['phone'];

        //执行查询条件
        $user = $User->where($where)->find();

        if ($user){
            //如果查询到用户
            if (md5($_POST['password']) != $user['password']){
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '密码不正确 ， 请重新输入';
                $this->ajaxReturn($return_data);
            }else{
                //如果密码一样
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';
                $return_data['dataValue']['user_id'] = $user['id'];
                $return_data['dataValue']['usename'] = $user['username'];
                $return_data['dataValue']['phone'] = $user['phone'];
                $return_data['dataValue']['face_url'] = $user['face_url'];

                $this->ajaxReturn($return_data);
            }
        }else{
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '不存在该手机号用户 ， 请注册';
            $this->ajaxReturn($return_data);
        }

    }

}
