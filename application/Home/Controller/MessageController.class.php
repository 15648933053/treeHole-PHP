<?php
namespace Home\Controller;
use Think\Controller;

class MessageController extends BaseController{


    /**
     * 发布新树洞
     */
    public function publish_new_message(){
        //校验参数是否存在
        if (!$_POST['user_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：user_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['content']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：content';

            $this->ajaxReturn($return_data);
        }

        //实例化表User
        $User = M('User');

        //设置where条件
        $where = array();
        $where['id'] = $_POST['user_id'];

        $result = $User->where($where)->find();
        if (!$result){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '用户不存在';

            $this->ajaxReturn($return_data);
        }else{
            //实例化表
            $Message = M('Message');
            //设置要插入的数据
            $data = array();
            $data['user_id'] = $_POST['user_id']; //用户id
            $data['username'] = $result['username'];//用户名
            $data['face_url'] = $result['face_url'];//头像地址
            $data['content'] = $_POST['content'];//树洞消息
            $data['totle_likes'] = 0;//点赞数
            $data['send_timestamp'] = time();//时间戳

            //插入数据
            $result = $Message->add($data);

            //如果插入数据成功
            if ($result){
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '发布成功';

                $this->ajaxReturn($return_data);
            }else{
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '发布失败';

                $this->ajaxReturn($return_data);
            }
        }
    }

    /**
     * 获取所有树洞消息
     */
    public function get_all_messages(){
        //实例化数据表
        $Message = M('Message');

        //设置查询条件

        //按照时间倒叙获取所有树洞
        $all_messages = $Message->order('id desc')->select();

//        dump($all_messages);
        //将所有的时间戳转换为2020-5-5 11:22:33
        foreach ($all_messages as $key => $message){
            $all_messages[$key]['send_timestamp'] = date('Y-m-d H:i:s' , $all_messages[$key]['send_timestamp']);
        }

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '数据获取成功';
        $return_data['data'] = $all_messages;

        $this->ajaxReturn($return_data);
//        dump($all_messages);
    }

    /**
     * 获取指定用户树洞接口
     */
    public function get_one_user_all_messages(){
        if (!$_POST['user_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：user_id';

            $this->ajaxReturn($return_data);
        }

        //实例化数据表
        $Message = M('Message');

        //设置where条件
        $where = array();
        $where['user_id'] = $_POST['user_id'];

        //执行查询
        $result = $Message->where($where)->select();
        if (!$result){
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '查询失败';

            $this->ajaxReturn($return_data);
        }else{
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '查询成功';
            $return_data['data'] = $result;

            $this->ajaxReturn($return_data);
        }
    }

    /**
     * 点赞接口
     */
    public function do_like(){
        //校验参数
        if (!$_POST['message_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：message_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['user_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：user_id';

            $this->ajaxReturn($return_data);
        }

        //实例化数据表
        $Message = M('Message');

        //查询条件
        $where = array();
        $where['id'] = $_POST['message_id'];
        $where['user_id'] = $_POST['user_id'];

        //执行查询
        $message = $Message->where($where)->find();
//        dump($Message->getLastSql());

        if (!$message){
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '指定树洞不存在';

            $this->ajaxReturn($return_data);
        }else{
            //构造要保存的数据
            $data = array();
            $data['totle_likes'] = $message['totle_likes'] + 1;

            //构造保存的条件
            $where = array();
            $where['id'] = $_POST['message_id'];
            $where['user_id'] = $_POST['user_id'];

            //执行修改
            $result = $Message->where($where)->save($data);

            if (!$result){
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '点赞失败';

                $this->ajaxReturn($return_data);
            }else{
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '点赞成功';
                $return_data['data']['user_id'] = $_POST['user_id'];
                $return_data['data']['message_id'] = $_POST['message_id'];
                $return_data['data']['totle_likes'] = $data['totle_likes'];

                $this->ajaxReturn($return_data);
            }

        }


    }

    /**
     * 删除指定树洞接口
     */
    public function delete_message(){
        //校验参数
        if (!$_POST['message_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：message_id';

            $this->ajaxReturn($return_data);
        }

        if (!$_POST['user_id']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：user_id';

            $this->ajaxReturn($return_data);
        }

        //实例化数据表
        $Message = M('Message');

        //写条件
        $where = array();
        $where['user_id'] = $_POST['user_id'];
        $where['id'] = $_POST['message_id'];

        //调用查询接口
        $result = $Message->where($where)->delete();

        if (!$result){
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '指定树洞不存在';

            $this->ajaxReturn($return_data);
        }else{
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '删除成功';
            $return_data['data']['message_id'] = $_POST['message_id'];

            $this->ajaxReturn($return_data);
        }


    }

}