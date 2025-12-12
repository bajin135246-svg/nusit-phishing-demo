<?php
// view_log.php - 安全查看日志
$password = 'admin123'; // 修改为你自己的密码

if (!isset($_GET['pwd']) || $_GET['pwd'] !== $password) {
    die('<h3>请输入密码访问日志</h3>
         <form>
           <input type="password" name="pwd" placeholder="密码" required>
           <button type="submit">查看</button>
         </form>');
}

$logFile = 'ip.txt';  // 修复：正确文件名

if (file_exists($logFile)) {
    echo '<pre style="background:#000;color:#0f0;padding:15px;font-size:14px;border-radius:8px;">';
    echo htmlspecialchars(file_get_contents($logFile));
    echo '</pre>';
    echo '<p><a href="?pwd=' . $password . '&clear=1" style="color:red;">清空日志</a></p>';
    
    if (isset($_GET['clear'])) {
        file_put_contents($logFile, '');  // 修复：真正清空
        echo '<script>alert("日志已清空");location.href="view_log.php?pwd=' . $password . '";</script>';
    }
} else {
    echo '<p>暂无日志记录（ip.txt 文件不存在或为空）。</p>';
}
?>