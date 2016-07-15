<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        //'sign' => array('name' => 'sign', 'require' => true),
    ),
    'workman'=>array(
        'app_name'=>"my_app",        //项目应用名称
        'socket_host'=>"tcp://0.0.0.0:1212",       // socket连接端口地址
        'service_port'=>"1238",
        'lan_ip'=>"127.0.0.1",// 本机ip，分布式部署时使用通信ip
        'process_count'=>4,  //进程数
        'start_port'=>"2900",    //内部通讯起始端口
        'heartbeat'=>10,//心跳间隔时间，单位秒
        'heartbeat_data'=> '{"type":"ping"}',   //心跳数据
    )

);
