<?php
    header("Content-Type: text/html; charset=UTF-8");
    require 'sql.php';
    
    $name = mysqli_real_escape_string($link, $_POST["user"]);
    $phone = mysqli_real_escape_string($link, $_POST["phone"]);
    $password = mysqli_real_escape_string($link, $_POST["password"]);
    // 连接的数据库里的表
    $linktables = "openlink";

    $stmt = mysqli_prepare($link, "SELECT number, phone FROM $linktables WHERE number=? AND phone=?");
    mysqli_stmt_bind_param($stmt, "ss", $name, $phone);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_array($result)){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($link, "UPDATE $linktables SET password=? WHERE name=?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $name);
        mysqli_stmt_execute($stmt);
        mysqli_close($link);
        $url = '../html/login.html';
        echo "<script>alert('修改成功')</script>";
        echo "<script>location.href='$url'</script>";
    }else{
        $url = '../html/forget.html';
        echo "<script>alert('账号或手机号错误')</script>";
        echo "<script>location.href='$url'</script>";
        mysqli_close($link);
    }
?>