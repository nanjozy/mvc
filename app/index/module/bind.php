<?php

namespace app\admin\module;

use core\lib\Gateway;

class bind
{
    static function bind()
    {
//加载GatewayClient。关于GatewayClient参见本页面底部介绍
//        require_once './GatewayClient/Gateway.php';

// GatewayClient 3.0.0版本开始要使用命名空间


// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';

// 假设用户已经登录，用户uid和群组id在session中
        $uid = 1;
//$group_id = $_SESSION['group'];
        $group_id = 1;
        $client_id = $_POST['client_id'];
        echo json_encode([$client_id]);
// client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
// 加入某个群组（可调用多次加入多个群组）
        Gateway::joinGroup($client_id, $group_id);
    }
}
