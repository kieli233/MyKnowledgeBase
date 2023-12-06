<?php
    header("Content-Type: text/html; charset=UTF-8");

    $host = '127.0.0.1';
    $serveruser = 'root';
    $serverpassword = '123456';
    $dbName = 'link';

    // 创建数据库连接
    $link = mysqli_connect($host, $serveruser, $serverpassword, $dbName);

    // 检查连接是否成功
    if (!$link) {
        die("连接失败: " . mysqli_connect_error());
    }

    // 设置字符集
    if (!mysqli_set_charset($link, "utf8")) {
        echo "Error loading character set utf8: " . mysqli_error($link);
        exit();
    }
?>