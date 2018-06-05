<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    /**
     * add     添加回答api
     *
     * @author wangjian
     * @time   2018/4/14 18:18
     * @return array
     */
    public function add()
    {
        /*检查用户是否登录*/
        checkLogin();
        if (!rq('question_id') || !rq('content'))
            return ['status' => 0, 'msg' => 'question_id and content are required!'];

        /*判断问题是否存在*/
        $question = question_ins()->find(rq('question_id'));
        if (!$question)
            return ['status' => 0, 'msg' => 'question not exists!'];

        /*判断问题是否回答*/
        $answered = $this
            ->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
            ->count();

        if ($answered)
            return ['status' => 0, 'msg' => 'duplicate answer!'];

        $this->content     = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id     = session('user_id');

        /*保存数据*/

        return $this->save() ?
            ['status' => 1] :
            ['status' => 0, 'msg' => 'db insert failed!'];

    }

    /**
     * change  更新回答api
     *
     * @author wangjian
     * @time   2018/4/14 18:20
     * @return array
     */
    public function change()
    {
        /*检查用户是否登录*/
        checkLogin();

        /*检查传参中是否有问题id*/
        if (!rq('id') || !rq('content'))
            return ['status' => 0, 'msg' => 'id and content are required!'];

        /*获取指定id的model*/
        $answer = $this->find(rq('id'));

        /*判断回答是否存在*/
        if (!$answer)
            return ['status' => 0, 'msg' => 'answer not exists!'];

        if ($answer->user_id != session('user_id'))
            return ['status' => 0, 'msg' => 'permission denied!'];

        $answer->content = rq('content');

        /*保存数据*/

        return $answer->save() ?
            ['status' => 1] :
            ['status' => 0, 'msg' => 'db update failed!'];
    }

    /**
     * read    查看回答api
     *
     * @author wangjian
     * @time   2018/4/14 18:22
     * @return array
     */
    public function read()
    {
        /*请求参数中是否有id，如果有id直接返回id所在的行*/
        if (!rq('id') && !rq('question_id'))
            return ['status' => 0, 'msg' => 'id or question_id is required!'];

        /*查看单个回答*/
        if (rq('id')) {
            $answer = $this->find(rq('id'));
            if (!$answer)
                return ['status' => 0, 'msg' => 'answer not exists!'];

            return ['status' => 1, 'data' => $answer];
        }

        /*检查问题是否存在*/
        if (!question_ins()->find(rq('question_id')))
            return ['status' => 0, 'msg' => 'question not exists!'];

        /*查看同一问题下的所有回答*/
        $answers = $this
            ->where('question_id', rq('question_id'))
            ->get()
            ->keyBy('id');

        return ['status' => 1, 'data' => $answers];
    }
}
