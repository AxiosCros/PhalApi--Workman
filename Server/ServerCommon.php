<?php
/**
 * 公共类
 *
 * 其它Server类继承该公共类
 *
 * @author Axios<axioscros@aliyun.com>
 * @blog http://hanxv.cn
 */
class Server_Common{
    protected $message_type;
    protected $CLIENT_ID,$SERVER ,$ACTION , $CLIENT_MSG;
    protected $TARGET , $CLIENTS=array() ;
    function __construct(){
        $this->message_type = array(
            '0'=>"present",   //给当前用户发送
            '1'=>"single",    //给特定用户发送
            '2'=>"group",     //给所有正在连接的用户发送
            '3'=>"all"        //给多个用户发送
        );
    }
    protected function response($data){
        $re = array(
            'type'=>$this->TARGET,
            'clients'=>$this->CLIENTS,
            'data'=>$data
        );
        return $re;
    }
    protected function formatterServer($server){
        return "Server_".ucfirst($server);
    }
    protected function setTarget($type="0"){
        $this->TARGET = in_array($type,$this->message_type) ? $this->message_type[$type] : "present";
    }
    protected function setClient($client){
        $this->TARGET = is_array($client) ? $client : array(0=>$client);
    }
}