<?php
// 接收上传的文件和额外的参数
$fileid =$_POST['fileid'];
$videoFile = $_FILES[$fileid]; // 文件数据
$sid = $_POST['sid']; // 额外参数1
$s = $_POST['s']; // 额外参数2

$file_extension = pathinfo($videoFile["name"], PATHINFO_EXTENSION);

// 处理文件上传
if ($videoFile['error'] === UPLOAD_ERR_OK) {
    $tempFile = $videoFile['tmp_name'];
    $targetDir = 'FileUpload/' . $sid . '/'; // 上传文件保存的目录
    $targetFile = $targetDir . basename($s.".".$file_extension );

    // 如果目录不存在，则创建它
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // 第三个参数为true表示创建多级目录
    }

    // 移动上传的文件到目标目录
    if (move_uploaded_file($tempFile, $targetFile)) {
        // 文件上传成功，可以在这里执行你的业务逻辑
        echo '影片上傳成功';
    } else {
        echo '影片上傳失敗。';
    }
} else {
    echo '上傳時出現錯誤。';
}
