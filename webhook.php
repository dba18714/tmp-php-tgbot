<?php

// 记录开始时间
$startTime = microtime(true);

require_once __DIR__ . '/vendor/autoload.php';

// 配置信息
$botToken = '8158437622:AAG0jnHHIVwi-KhuS0XQwHM24qnuPdcouzA'; // 替换为您的bot token

// 获取传入的更新
$update = json_decode(file_get_contents('php://input'), true);

// 记录日志
file_put_contents('telegram_log.txt', date('Y-m-d H:i:s') . ' - ' . print_r($update, true) . "\n", FILE_APPEND);

if (isset($update['message'])) {
    $message = $update['message'];
    $chatId = $message['chat']['id'];
    $text = $message['text'] ?? '';

    // 创建响应客户端
    $client = new GuzzleHttp\Client();

    // 处理命令
    if (strpos($text, '/start') === 0) {
        $responseText = '欢迎使用这个机器人！';
    } elseif (strpos($text, '/help') === 0) {
        $responseText = "可用命令列表：\n/start - 开始使用\n/help - 显示帮助";
    } else {
        $responseText = '收到您的消息：' . $text;
    }

    // 计算当前用时
    $currentTime = microtime(true);
    $currentExecutionTime = ($currentTime - $startTime) * 1000;
    
    // 在回复中添加处理用时
    $responseText .= "\n\n处理用时: " . number_format($currentExecutionTime, 2) . 'ms';

    // 发送响应
    try {
        $response = $client->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'json' => [
                'chat_id' => $chatId,
                'text' => $responseText
            ]
        ]);
    } catch (Exception $e) {
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", FILE_APPEND);
    }
}

// 计算总用时
$endTime = microtime(true);
$executionTime = ($endTime - $startTime) * 1000; // 转换为毫秒

// 记录执行时间到日志
file_put_contents('performance_log.txt', 
    date('Y-m-d H:i:s') . 
    ' - 执行时间: ' . number_format($executionTime, 2) . 'ms' . 
    "\n", 
    FILE_APPEND
);

// 返回成功响应
http_response_code(200);
echo json_encode([
    'status' => 'OK',
    'execution_time' => number_format($executionTime, 2) . 'ms'
]); 