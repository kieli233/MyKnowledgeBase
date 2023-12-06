<?php
    header("Content-Type: text/html; charset=UTF-8");
    require 'sql.php';
    $rurl = "../html/register.html";
    $iurl = "../index.html";

    $name = mysqli_real_escape_string($link, $_POST['UserName']);
    $number = mysqli_real_escape_string($link, $_POST['AccountNumber']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $encipher = password_hash($password, PASSWORD_DEFAULT);
    $phonecode = mysqli_real_escape_string($link, $_POST['phonecode']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $eserver = mysqli_real_escape_string($link, $_POST['Es']);
    $uap = join(',',$_POST['uap']);
    // 连接的数据库里的表
    $linktables = "openlink";

    // 检查用户名是否存在
    $arp = "SELECT name,number FROM $linktables WHERE name=? or number=?";
    $stmt = mysqli_prepare($link, $arp);
    mysqli_stmt_bind_param($stmt, "ss", $name, $number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 处理文件上传
    $imgfile = basename($_FILES['file']['name']);
    $target_dir = '../img/';
    $file_parts = explode('.', $imgfile);
    $ext = end($file_parts);
    $timestamp = time();
    $ln = substr($timestamp, -5);
    $get_file = "./img/" . $number . 'v' . $ln . '.' . $ext;
    $target_file = $target_dir . $number . 'v' . $ln . '.' . $ext;

    // 判断上传文件是否为图片
    $check = getimagesize($_FILES['file']['tmp_name']);
    if($check !== false){
        if(! move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
            echo "<script>alert('上传失败了！')</script>";
            echo "<script>location.href='$rurl'</script>";
        }
    }else{
        echo "<script>alert('非图片文件，请重新上传！')</script>";
        echo "<script>location.href='$rurl'</script>";
    }

    // 判断用户是否存在，不存在就加入数据库中
    if(mysqli_num_rows($result) > 0){
        unlink($target_file);
        echo "<script>alert('账号或名称存在重复,请返回注册')</script>";
        echo "<script>location.href='$rurl'</script>";
    }else {
        $sql = "INSERT INTO $linktables (name, number, password, phonecode, phone, eserver, uap, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $number, $encipher, $phonecode, $phone, $eserver, $uap, $get_file);
        mysqli_stmt_execute($stmt);
        echo "<script>alert('注册成功')</script>";
    }

    //设置cookie
    setrawcookie("name", $name, time() + 600, '/');
    setrawcookie("img", $get_file, time() + 600, '/');

    // 返回主页
    echo "<script>location.href='$iurl'</script>";

    //关闭SQL链接
    mysqli_close($link);
?>