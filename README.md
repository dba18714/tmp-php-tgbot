# Telegram Bot PHP Webhook 示例

这是一个简单的 Telegram Bot 实现，使用 webhook 方式接收和处理消息。

## 安装步骤

1. 克隆此仓库到您的服务器
2. 运行 `composer install` 安装依赖
3. 编辑 `webhook.php` 文件，将 `YOUR_BOT_TOKEN` 替换为您的 Telegram Bot Token

## 设置 Webhook

1. 确保您的服务器有 SSL 证书（Telegram 要求 webhook 必须使用 HTTPS）
2. 访问以下 URL 来设置 webhook（替换相应的值）：
   ```
   https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://your-domain.com/path-to/webhook.php
   ```

## 功能

目前支持的命令：
- `/start` - 显示欢迎消息
- `/help` - 显示帮助信息

## 日志

- `telegram_log.txt` - 记录所有接收到的更新
- `error_log.txt` - 记录错误信息

## 要求

- PHP 7.4 或更高版本
- SSL 证书
- 可公网访问的服务器 