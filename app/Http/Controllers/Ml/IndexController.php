<?php

namespace App\Http\Controllers\Ml;

use App\Http\Controllers\Controller;
use Phpml\Association\Apriori;
use Phpml\Classification\NaiveBayes;

class IndexController extends Controller
{
    //php机器学习
    public function index()
    {
        //训练集
        $sampes = [
            ['内核框架', '性能优化', '设计模式'],
            ['swoole', '性能优化', '接口开发平台'],
            ['swoole', '性能优化', '游戏开发'],
            ['RPC接口开发', '性能优化', '接口开发平台'],
            ['laravel5.6', '性能优化', 'PHP7'],
            ['mysql性能优化', 'redis分布式', 'mongodb'],
            ['网站负载均衡', '性能优化', '大数据集群'],
            ['hadoop', '机器学习', 'linux'],
        ];

        //标签
        $lables = [];

        //训练、预测、支持度、置信度
        $associator = new Apriori($support = 0.1, $confidence = 0.1);
        $associator->train($sampes, $lables);
        $res = $associator->predict(['性能优化']);
        dd($res);

        $sampes2 = [
            ['幸运', '抢购'], //1
            ['开心', '不错'], //1
            ['发票', '利率'], //-1
            ['恭喜', '中奖'], //-1
            ['开心', '幸福'], //1
            ['赌博', '开心'], //-1
        ];

        $lables2 = [1, 1, -1, -1, 1, -1];

        $classifier = new NaiveBayes();//贝叶斯分类
        $classifier->train($sampes2, $lables2);
        $res2 = $classifier->predict(['发票', '利率'], ['恭喜', '中奖'], ['赌博', '开心']);

        dd($res2);
    }
}
