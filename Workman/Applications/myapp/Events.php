<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
use \GatewayWorker\Lib\Gateway;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} \n gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  \n client_id:$client_id \n session:".json_encode($_SESSION)." \n ";
        $Connect = new Server_Container($client_id);
        $re = $Connect->onConnect();
        $data = is_array($re['data']) ?json_encode($re['data']) : $re['data'];
        if($re['type'] =="present"){
            Gateway::sendToClient($client_id,$data);
        }else if($re['type'] =="single"){
            Gateway::sendToClient($re['clients'][0],$data);
        }else if($re['type']=="all"){
            GateWay::sendToAll($data);
        }else{
            $clients = $re['clients'];
            foreach($clients as $key=>$val){
                Gateway::sendToClient($val,$data);
            }
        }
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id,$message) {
       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} \n gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  \n client_id:$client_id \n session:".json_encode($_SESSION)." \n onMessage:".$message."\n";
       $message = json_decode($message,true);

       $Connect = new Server_Container($client_id, $message);
       $re = $Connect->onMessage();
       $data = is_array($re['data']) ?json_encode($re['data']) : $re['data'];
       if($re['type'] =="present"){
           Gateway::sendToClient($client_id,$data);
       }else if($re['type'] =="single"){
           Gateway::sendToClient($re['clients'][0],$data);
       }else if($re['type']=="all"){
           GateWay::sendToAll($data);
       }else{
           $clients = $re['clients'];
           foreach($clients as $key=>$val){
               Gateway::sendToClient($val,$data);
           }
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       $Connect = new Server_Container($client_id);
       $re = $Connect->onClose();
       if(!empty($re)){
           $data = is_array($re['data']) ?json_encode($re['data']) : $re['data'];
           if($re['type'] =="present"){
               Gateway::sendToClient($client_id,$data);
           }else if($re['type'] =="single"){
               Gateway::sendToClient($re['clients'][0],$data);
           }else if($re['type']=="all"){
               GateWay::sendToAll($data);
           }else{
               $clients = $re['clients'];
               foreach($clients as $key=>$val){
                   Gateway::sendToClient($val,$data);
               }
           }
       }
   }
}
