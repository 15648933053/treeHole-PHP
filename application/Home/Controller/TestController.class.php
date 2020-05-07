<?php
namespace Home\Controller;

use Think\Controller;
class TestController extends BaseController {
	
    /**
     * 测试函数
     * @return [type] [description]
     */
    public function test(){
        var_dump(123);
    }

    public function insert_test(){
        //实例化数据表
        $Message = M('Message');

        //组装插入的数据
        $data = array();
        $data['user_id'] = 2;
        $data['username'] = '王五';
        $data['face_url'] = 'xxx.jpg';
        $data['content'] = '今天好开心';
        $data['totle_likes'] = 0;
        $data['send_timestamp'] = time();

        //插入时间戳
        $result = $Message->add($data);
        var_dump(($result));
        var_dump($Message->getLastSql());
    }

    public function select_test(){
        //实例化数据表
        $Message = M('Message');

        //将条件清空
        $where = array();
        //写条件
        $where['user_id'] = 1;

        //调用函数执行查询sql语句
        $a = $Message->where($where)->select();

        //打印查询结果
        dump($a);

        //只查询user_id 和username
        $a = $Message->where($where)
            ->field('user_id , username')
            ->select();

        dump($a);
        dump($Message->getLastSql());

    }

    public function find_test(){
        //实例化数据表   //select
        $Message = M("Message");
        //设置where条件
        $where = array();
        $where['id'] = 1;
        //执行查询语句
        $result = $Message->where($where)->select();
        $Message->getLastSql();
        dump($result);
        dump($Message->getLastSql());

        //实例化数据表  //find
        $Message = M("Message");
        //设置where条件
        $where = array();
        $where['id'] = 1;
        //执行查询语句
        $result = $Message->where($where)->find();
        dump($result);
        dump($Message->getLastSql());
    }

    public function save_test(){
        //实例化数据表
        $Message = M('Message');
        //设置条件
        $where = array();
        $where['id'] = 1;
        //设置修改的值
        $data = array();
        $data['totle_likes'] = 1;
        //执行sql语句进行修改
        $result = $Message->where($where)->save($data);
        dump($result);
    }

    public function delete_test(){
        //实例化数据表
        $Message = M('Message');
        //设置where条件
        $where = array();
        $where['id'] = 1;
        //执行删除语句
        $result = $Message->where($where)->delete();
        dump($result);
    }



}

