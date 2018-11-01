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
        '1004' => '删除成功',


        '2000' => '获取失败',
        '2001' => '操作失败',
        '2002' => '修改失败',
        '2003' => '新增失败',
        '2004' => '无权查看',
        '2005' => '系统错误，请稍后再试',
        '2006' => '参数不完整',
        '2007' => '无此内容',
        '2008' => '数据异常',
        '2009' => '删除失败'
    ];
    if(!array_key_exists($code,$code_msg)) {
        return '';
    }
    return $code_msg[$code];
}

function dataYieldRange($data){
    foreach($data as $item){
        yield $item;
    }
}

function my_log($msg,$path,$log_type){

    $log_types = ['info','error'];
    if (!in_array($log_type,$log_types)) {
        return false;
    }

    \Log::useDailyFiles(storage_path($path));
    \Log::$log_type($msg);
}