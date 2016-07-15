<?php
/**
 * Created by PhpStorm.
 * User: Axios
 * Date: 2016/7/6
 * Time: 15:44
 */
class Server_Common{
    public $code,$type;
    private $crypt;
    function __construct(){
        $this->code = array(
            "0"=>"异常请求",
            "200"=>"成功",
            "500"=>"异常请求",
            "501"=>"即时通信服务出现异常",
            "3001"=>"用户名或密码不正确",
            "3011"=>"三分钟内只能发送一次短信，请稍后再试",
            "3012"=>"今天短信发送过多，请明天再来",
            "3020"=>"操作不成功,请稍后再试",
            "4000"=>"短信验证码不正确",
            "4001"=>"手机格式不正确，请重新输入",
            "4040"=>"用户名已存在",
            "4041"=>"请获取短信验证码",
            "4042"=>"该用户已存在",
            "4043"=>"该用户不存在",
            "4044"=>"个人作品不存在"
        );
        $this->type = array(
            '0'=>"single",
            '1'=>"all",
            '2'=>"group"
        );
    }
    protected function response($type,$clients,$data){
        $re = array(
            'type'=>$type,
            'clients'=>$clients,
            'data'=>$data
        );
        return $re;
    }
}