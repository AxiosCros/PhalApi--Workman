<?php
/**
 * Created by PhpStorm.
 * User: Axios
 * Date: 2016/7/15
 * Time: 17:32
 */
class Server_Container extends Server_Common{
    protected $binds;

    protected $instances;

    private $server;
    function __construct(){
        parent::__construct();
        $this->server = array(
            'hello'=>function(){return new Server_Hello();},
        );
    }
    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        array_unshift($parameters, $this);

        return call_user_func_array($this->binds[$abstract], $parameters);
    }

    public function onConnect($client_id){
        $type = "group";
        $clients = array($client_id);
        $data = "Hello";
        return $this->response($type,$clients,$data);
    }

    public function onMessage($client_id,$message){
        //分析消息类型
        $type = $message['server'];
        $action = $message['action'];
        if(empty($type) || empty($action)){
            return $this->res("single",$this->response("0"));
        }
        $Container = new Server_Container();
        $Container->bind($type,$this->server[$type]);
        $Server = $Container->make($type,[]);
        $data = array(
            'client_id'=>$client_id,
            'data'=>$message['data']
        );
        return $Server->index($action,$data);
    }

    public function onClose($client_id){
        //DI()->cache->delete($client_id);
    }
}