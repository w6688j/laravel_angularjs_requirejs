<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/4/14
 * Time: 17:54
 */

/**
 * rq
 *
 * @param null $key
 * @param null $default
 *
 * @author wangjian
 * @time   2018/4/14 16:20
 *
 * @return array|mixed
 */
function rq($key = null, $default = null)
{
    if (!$key) return Request::all();

    return Request::get($key, $default);
}

/**
 * user_ins
 *
 * @author wangjian
 * @time   2018/4/14 15:31
 * @return \App\User
 */
function user_ins()
{
    return new \App\User();
}

/**
 * question_ins
 *
 * @author wangjian
 * @time   2018/4/14 16:20
 * @return \App\Question
 */
function question_ins()
{
    return new \App\Question();
}

/**
 * answer_ins
 *
 * @author wangjian
 * @time   2018/4/14 17:55
 * @return \App\Answers
 */
function answer_ins()
{
    return new \App\Answers();
}

/**
 * checkLogin 检查用户是否登录
 *
 * @author wangjian
 * @time   2018/4/14 18:02
 * @return array
 */
function checkLogin()
{
    if (!user_ins()->isLogin())
        return ['status' => 0, 'msg' => 'login required!'];
}

/**
 * ajaxReturn Ajax返回
 *
 * @param int    $status 状态码
 * @param string $msg    返回信息
 * @param array  $data   返回数据
 *
 * @author wangjian
 * @time   2018/5/24 13:56
 *
 * @return array
 */
function ajaxReturn($status, $msg, $data = [])
{
    return ['status' => $status, 'msg' => $msg, 'data' => $data];
}