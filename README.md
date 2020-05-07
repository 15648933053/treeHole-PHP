# treeHole-PHP

树洞接口文档说明

返回数据格式：json数据

用户注册接口：    http://59.110.237.22/Home/User/sign
	必传参数：
		username：用户名
		phone：手机号
		password：密码
		password_again：重复密码	
	返回数据：
		参数不足：{
			"error_code":1,
			"msg":参数不足：username
			}

		参数不足：{
			"error_code":1,
			"msg":参数不足：phone
			}
		参数不足：{
			"error_code":1,
			"msg":参数不足：password
			}
		参数不足：{
			"error_code":1,
			"msg":参数不足：password_again
			}

		两次密码不一致：
			{
			error_code：2
			msg：两次密码不一致
			}
		手机号已被注册：
			{
			error_code：3
			msg：手机号已被注册
			}
		注册成功：
			{
			error_code:0
			msg:注册成功
			data:{
				user_id:1
				usename：张三
				phone：15141414432
				face_url：asf.jpg		
			       }	
			
			}


用户登录接口：  http://59.110.237.22/Home/User/login

	必传参数：
		phone：手机号
		password：密码

	返回数据：
		参数不足：{
			"error_code":1,
			"msg":参数不足：phone
			}

		参数不足：{
			"error_code":1,
			"msg":参数不足：password
			}
		不存在该账号：
			{
			"error_code":2,
			"msg":不存在该账号 ， 请注册
			}
		密码错误：
			{
			"error_code":3,
			"msg":密码错误
			}
		登录成功：
			{
			error_code:0
			msg:登录成功
			data:{
				user_id:1
				usename：张三
				phone：15141414432
				face_url：asf.jpg		
			       }	
			
			}

发布新树洞的接口：http://59.110.237.22/Home/Message/publish_new_message

	必传参数：
		user_id：用户id
		content：树洞消息
	返回数据：
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：user_id
			}		
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：content
			}
		发布成功：
			{
			"error_code":0,
			"msg":树洞发布成功
			}

获取所有树洞数据：http://59.110.237.22/Home/Message/get_all_messages
	
	返回数据：
		获取成功：
			{
			error_code:0
			msg:获取数据成功
			data:{
				id:1
				user_id：1
				usename：张三
				face_url：xxx.jpg
				content：今天真开心
				totle_likes:0
				send_timestamp:1561156516	
			       }	
			
			}
	
			
获取指定用户的接口：http://59.110.237.22/Home/Message/get_one_user_all_messages
	必传参数：user_id
	返回数据：
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：user_id
			}
		获取成功：
			{
			error_code:0
			msg:获取数据成功
			data:{
				id:1
				user_id：1
				usename：张三
				face_url：xxx.jpg
				content：今天真开心
				totle_likes:0
				send_timestamp:1561156516	
			       }	
			
			}

点赞接口：http://59.110.237.22/Home/Message/do_like

	必传参数：
		user_id
		message_id
	返回数据：
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：user_id
			}
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：message_id
			}	
		指定树洞不存在：
			{
			"error_code":2,
			"msg":指定树洞不存在
			}
		点赞成功：
			{
			error_code:0
			msg:点赞成功
			data:{
				message_id:1
				totle_likes：3
			       }	
			
			}

删除指定树洞接口：http://59.110.237.22/Home/Message/delete_message

	必传参数：
		user_id
		message_id
	返回数据：
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：user_id
			}
		参数不足：
			{
			"error_code":1,
			"msg":参数不足：message_id
			}
		指定树洞不存在：
			{
			"error_code":2,
			"msg":指定树洞不存在
			}		
		
		点赞成功：
			{
			error_code:0
			msg:删除成功
			data:{
				message_id:1
			       }	
			
			}

