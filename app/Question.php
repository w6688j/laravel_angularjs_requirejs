<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * add     创建问题api
     *
     * @author wangjian
     * @time   2018/4/14 16:38
     * @return array
     */
    public function add()
    {
        /*检查用户是否登录*/
        checkLogin();

        /*检查是否存在标题*/
        if (!rq('title'))
            return ['status' => 0, 'msg' => 'login title!'];

        $this->title   = rq('title');
        $this->user_id = session('user_id');

        /*检查是否存在描述*/
        if (rq('desc'))
            $this->desc = rq('desc');

        /*保存数据*/

        return $this->save() ?
            ['status' => 1, 'id' => $this->id] :
            ['status' => 0, 'msg' => 'db insert failed!'];
    }

    /**
     * change  跟新问题api
     *
     * @author wangjian
     * @time   2018/4/14 16:50
     * @return array
     */
    public function change()
    {
        /*检查用户是否登录*/
        checkLogin();

        /*检查传参中是否有问题id*/
        if (!rq('id'))
            return ['status' => 0, 'msg' => 'id required!'];

        /*获取指定id的model*/
        $question = $this->find(rq('id'));

        /*判断问题是否存在*/
        if (!$question)
            return ['status' => 0, 'msg' => 'question not exists!'];

        if ($question->user_id != session('user_id'))
            return ['status' => 0, 'msg' => 'permission denied!'];

        if (rq('title'))
            $question->title = rq('title');

        if (rq('desc'))
            $question->desc = rq('desc');

        /*保存数据*/

        return $question->save() ?
            ['status' => 1] :
            ['status' => 0, 'msg' => 'db update failed!'];
    }

    /**
     * read    查看问题api
     *
     * @author wangjian
     * @time   2018/4/14 17:17
     * @return array
     */
    public function read()
    {
        /*请求参数中是否有id，如果有id直接返回id所在的行*/
        if (rq('id'))
            return ['status' => 1, 'data' => $this->find(rq('id'))];

        /*limit条件*/
        $limit = rq('limit') ?: 15;
        /*skip条件，用于分页*/
        $skip = (rq('page') ? rq('page') - 1 : 0) * $limit;

        /*构建query并返回collection数据*/

        return [
            'status' => 1,
            'data'   => $this
                ->orderBy('created_at', 'DESC')
                ->limit($limit)
                ->skip($skip)
                ->get(['id', 'title', 'desc', 'user_id', 'created_at', 'updated_at']),
        ];
    }

    /**
     * remove  删除问题api
     *
     * @author wangjian
     * @time   2018/4/14 17:33
     * @return array
     */
    public function remove()
    {
        /*检查用户是否登录*/
        checkLogin();

        /*检查传参中是否有问题id*/
        if (!rq('id'))
            return ['status' => 0, 'msg' => 'id required!'];

        /*获取指定id的model*/
        $question = $this->find(rq('id'));

        /*判断问题是否存在*/
        if (!$question)
            return ['status' => 0, 'msg' => 'question not exists!'];

        /*检查当前用户是否为问题的所有者*/
        if ($question->user_id != session('user_id'))
            return ['status' => 0, 'msg' => 'permission denied!'];

        /*删除数据*/

        return $question->delete() ?
            ['status' => 1] :
            ['status' => 0, 'msg' => 'db delete failed!'];
    }
}
