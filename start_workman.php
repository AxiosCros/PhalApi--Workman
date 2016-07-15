<?php
/**
 * Created by PhpStorm.
 * User: Axios
 * Date: 2016/7/15
 * Time: 16:58
 */

require_once "Public/init.php"; //引入PhalApi项目入口文件
//装载你的接口
DI()->loader->addDirs('Demo');

$workman_config = DI()->config->get('app.workman');
if(empty($workman_config)){
    //载入默认配置
    $workman_config = array(
        'app_name'=>"my_app",        //项目应用名称
        'socket_host'=>"tcp://0.0.0.0:1212",       // socket连接地址及端口号
        'service_port'=>"1238",
        'lan_ip'=>"127.0.0.1",// 本机ip，分布式部署时使用通信ip
        'process_count'=>4,  //进程数
        'start_port'=>"2900",    //内部通讯起始端口
        'heartbeat'=>10,//心跳间隔时间，单位秒
        'heartbeat_data'=> '{"type":"ping"}',   //心跳数据
    );
}
require_once "Library/Workman/start.php"; //引入workman服务启动文件

