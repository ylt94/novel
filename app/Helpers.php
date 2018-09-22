<?php


function check_variable($data){
    if(!is_array($data) && !$data) {
        return false;
    }
    
    if(is_array($data)){
        foreach($data as $value) {
            if(!$value){
                return false;
            }
        }
    }

    return true;
}

function ret_res(int $code,string $msg_code,$data = null){

    $msg = get_msg_by_code($msg_code);
    $return = ['status'=>$code,'msg'=>$msg];

    if($data){
        $return['data'] = $data;
    }

    return $return;
}

/**
 * 信息码
 * 10 成功
 * 00 失败
 */
function get_msg_by_code($code){
    $code_msg = [
        '1000' => '请求成功',
        '1001' => '操作成功',
        '1002' => '修改成功',
        '1003' => '新增成功',


        '0000' => '获取失败',
        '0001' => '操作失败',
        '0002' => '修改失败',
        '0003' => '新增失败',
        '0004' => '无权查看',
        '0005' => '系统错误，请稍后再试',
        '0006' => '参数不完整',
        '0007' => '无此内容',
        '0008' => '数据异常'
    ];
    if(!array_key_exists($code,$code_msg)) {
        return '';
    }
    return $code_msg[$code];
}