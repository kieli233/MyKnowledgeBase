<?php
    header("Content-Type: text/html; charset=UTF-8");
    require 'sql.php';

    // 获取并清理用户输入
    $user = mysqli_real_escape_string($link, $_POST['user']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    // 连接的数据库里的表
    $linktables = "openlink";

    // 使用预处理语句执行SQL查询
    $sql = "SELECT name,number, password,img FROM $linktables WHERE number=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($result)) {
        // 验证密码是否匹配哈希值
        if (password_verify($password, $row['password'])) {
            $url = '../index.html';
            session_start();
            $name = $row['name'];
            $img = $row['img'];
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $row['password'];
            setrawcookie("name", $name, time() + 600, '/');
            setrawcookie("img", $img, time() + 600, '/');
            echo "<script>location.href='$url'</script>";
        } else {
            $url = '../html/login.html';
            echo "<script>alert('账号或密码错误，请重试。')</script>";
            echo "<script>location.href='$url'</script>";
        }
    } else {
        $url = '../html/login.html';
        echo "<script>alert('账号或密码错误，请重试。')</script>";
        echo "<script>location.href='$url'</script>";
    }

    mysqli_close($link);
?>