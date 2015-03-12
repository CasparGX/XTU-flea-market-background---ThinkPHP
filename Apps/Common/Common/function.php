<?php
/**
 * 返回消息处理
 */
 function returnMsg($result,$msg) {
	$value = array(
			0 => 'error',
			1 => 'success'
		);
	$returnMsg = array(
			'result' => $value[$result],
			'msg' => $msg
		);
	//将数组转化为json格式,用ajaxReturn()时可自动转为json,不需要再转化.
	//$returnMsg = json_encode($returnMsg);
	return $returnMsg;
}

/**
 * +-----------------------------------------------------------------------------------------
 * 删除目录及目录下所有文件或删除指定文件
 * +-----------------------------------------------------------------------------------------
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * +-----------------------------------------------------------------------------------------
 * @return bool 返回删除状态
 * +-----------------------------------------------------------------------------------------
 */
 function delDirAndFile($path, $delDir = TRUE) {
    if (is_array($path)) {
        foreach ($path as $subPath)
            delDirAndFile($subPath, $delDir);
    }
    if (is_dir($path)) {
        $handle = opendir($path);
        if ($handle) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..")
                    is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
            }
            closedir($handle);
            if ($delDir)
                return rmdir($path);
        }
    } else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
    clearstatcache();
 }

?>