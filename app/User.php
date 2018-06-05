<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    /**
     * signup 注册api
     *
     * @author wangjian
     * @time   2018/4/14 14:54
     * @return array
     */
    public function signup()
    {
        $user  = $this;
        $check = $this->checkUserAndPassword();
        if (empty($check))
            return ['status' => 0, 'msg' => '用户名和密码不能为空！'];
        else {
            list($username, $password) = $check;
        }

        /*检查用户名是否存在*/
        $user_exists = $user->where('username', $username)->exists();

        if ($user_exists)
            return ['status' => 0, 'msg' => '用户名已经存在!'];

        /*加密密码*/
        $hashed_password = Hash::make($password);

        /*存入数据库*/
        $user->username = $username;
        $user->password = $hashed_password;
        if ($user->save())
            return ajaxReturn(0, 'success!');
        else
            return ajaxReturn(1, 'db insert failed!');
    }

    /**
     * login   登录api
     *
     * @author wangjian
     * @time   2018/4/14 15:02
     * @return array
     */
    public function login()
    {
        /*检查用户名和密码是否为空*/
        $check = $this->checkUserAndPassword();
        if (empty($check))
            return ['status' => 0, 'msg' => '用户名和密码不能为空！'];
        else {
            list($username, $password) = $check;
        }

        /*检查用户名是否存在*/
        $user = $this->where('username', $username)->first();
        if (!$user)
            return ['status' => 0, 'msg' => '用户不存在!'];

        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if (!Hash::check($password, $hashed_password))
            return ['status' => 0, 'msg' => '密码有误!'];

        /*将用户信息写入Session*/
        session()->put('user_id', $user->id);
        session()->put('username', $user->username);

        return ['status' => 1, 'id' => $user->id];
    }

    /**
     * logout  退出登录
     *
     * @author wangjian
     * @time   2018/4/14 15:20
     * @return array
     */
    public function logout()
    {
        session()->forget('user_id');
        session()->forget('username');
        if (!$this->isLogin())
            return ['status' => 1, 'msg' => '注销成功！'];
        else
            return ['status' => 0, 'msg' => '注销失败!'];
    }

    /**
     * checkUserAndPassword 检查用户名和密码是否为空
     *
     * @author wangjian
     * @time   2018/4/14 14:54
     * @return array
     */
    public function checkUserAndPassword()
    {
        $username = rq('username');
        $password = rq('password');

        if ($username && $password)
            return [$username, $password];
        else
            return [];
    }

    /**
     * isLogin 判断是否已经登录
     * isLogin 判断是否已经登录
     *
     * @author wangjian
     * @time   2018/4/14 15:19
     * @return bool
     */
    public function isLogin()
    {
        return !empty(session('user_id'));
    }

    /**
     * exist 检查用户是否存在
     *
     * @author wangjian
     * @time   2018/5/24 13:58
     */
    public function exist()
    {
        $rq    = rq();
        $count = $this->where('username', $rq['username'])->count();
        if ($count > 0)
            return ajaxReturn(0, '用户名已经存在!', ['count' => $count]);
        else
            return ajaxReturn(1, 'success!', ['count' => $count]);
    }
}
