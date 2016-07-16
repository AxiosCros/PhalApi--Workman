<?php
/**
 * 容器服务类
 *
 * 承接来自客户端的请求，派发给对应的Server类和类中方法，并回调消息
 * 需注意客户端发送请求时的消息格式
 *
 * @author Axios<axioscros@aliyun.com>
 * @blog http://hanxv.cn
 */
class Server_Container extends Server_Common{
    function __construct($client_id,$message=array()){
        parent::__construct();
        $this->CLIENT_ID  = $client_id;
        $this->SERVER     = $this->formatterServer($message['server']);
        $this->ACTION     = $message['action'];
        $this->MSG_DATA   = $message['data'];
    }
    private function loadServerAction($data){
        $server = $this->SERVER;
        $Server = new $server;
        if(!is_array($data)){
            return "";
        }
        $result =  call_user_func_array(array($Server, $this->ACTION),$data);
        return $this->response($result);
    }
    public function onConnect(){
        $this->setTarget(0);
        $data = "Hello";
        return $this->response($data);
    }
    public function onMessage(){
        $data = array(
            'client_id'    =>$this->CLIENT_ID,
            'data'         =>$this->CLIENT_MSG
        );
        return $this->loadServerAction($data);
    }
    public function onClose(){
        //连接断开时，可以执行清空缓存的方法
        //DI()->cache->delete($this->CLIENT_ID);
        return ;
    }
}