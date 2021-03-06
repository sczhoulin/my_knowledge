<?php

/**
 * 调试输出代码
 * @param type $msg
 * @param type $end
 * @param type $name
 */
function pr($msg, $end = '', $name = '') {
    if (is_array($msg) || is_object($msg)) {
        echo "<div align='left'></div>";
        echo "<pre>";
        if ($name) {
                echo $name . " = ";
        }
        print_r($msg);
        echo "</pre>";
        echo "</div>";
    } else {
        if ($name) {
            echo $name . " = ";
        }
        echo $msg . "</br>------------------------------------</br>";
    }
    if ($end) {
        exit();
    }
}

/**
 * 预防数据库攻击
 */
function checkInput($value) {
    if (get_magic_quotes_gpc) {
        $value = stripslashes($value);
    }
    if (!is_numeric($value)) { //如果不是数字，则加引号
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

/**
 * 获取文件后缀名
 * @param type $filename        文件名字
 * @return string       返回文件后缀名
 */
function getFileExt($filename) {
    $strs = explode('.', $filename);
    $len = count($strs);
    $extension = $strs[$len - 1];
    return strtolower($extension);
}

/**
 * 获取标准RUL中的文件扩展名
 * @param type $url
 * @return type
 */
function getUrlExt($url) {
    $arr = parse_url($url);
    $file = basename($arr['path']);
    $ext_arr = explode(".", $file);
    $ext = $ext_arr[1];
    return $ext;
}

/**
 * 获取文件扩展名
 * 
 * @param type $file
 * @return type
 */
function getExt ($file) {
    return ltrim(strrchr($file, '.'), '.');
}

/**
 * 获取文件扩展名
 * 
 * @param type $file
 * @return type
 */
function getExt2 ($file) {
    return ltrim(substr($file, strrpos($file, '.')), '.');
}

/**
 * 获取文件扩展名
 * 
 * @param type $file
 * @return type
 */
function getExt3 ($file) {
    $arr = explode('.', $file);
    return array_pop($arr);
}

/**
 * 获取文件扩展名
 * 
 * @param type $file
 * @return type
 */
function getExt4 ($file) {
    $arr = pathinfo($file);
    return $arr['extension'];
}

/**
 * 获取$a相对于$b的绝对路径
 * @param type $a
 * @param type $b
 * @example path 
 *      $a = '/a/b/c/d/e.php';
 *      $b = '/a/b/12/34/c.php';
 *      echo getRelativePath ($a, $b);
 *      return '../../c/d';
 */
function getRelativePath($a, $b) {
    $path = dirname($b);
    $arr_a = explode("/", $a);
    $arr_b = explode("/", $path);
    $len = count($arr_b);
    for ($n = 1; $n < $len; $n++) {
        if ($arr_b[$n] != $arr_a[$n]) {
                break;
        }
    }
    if ($len - $n > 0) {
        $return_path = array_fill(1, $len - $n, '..');
    } else {
        $return_path = array('.');
    }
    $return_path = array_merge($return_path, array_slice($arr_a, $n));
    return implode('/', $return_path);
}

/**
 * 实现中文字符串反转，包括汉字
 * @param type $str
 * @return type
 */
function reverse($str) {
    $ret = "";
    $len = mb_strwidth($str, "UTF-8");
    for ($i = 0; $i < $len; $i++) {
        $arr[] = mb_substr($str, $i, 1, "UTF-8");
    }
    return implode("", array_reverse($arr));
}

/**
 * 验证邮箱
 * @param type $email
 * @return type
 */
function checkEmail($email) {
    $pregEmail = "/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i";
    return preg_match($pregEmail, $email);
}

/**
 * 遍历一个文件夹下的所有文件和子文件夹
 * @param type $dir
 * @return type
 */
function my_scandir($dir) {
    $files = array();
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) != false) {
            if ($file != '..' && $file != '.') {
                if (is_dir($dir . "/" . $file)) {
                    $files[$file] = scandir($dir . "/" . $file);
                } else {
                    $files[] = $file;
                }
            }
        }
        closedir($handle);
        return $files;
    }
}

/**
 * 将对象转换成数组
 * 
 * @param type $obj 对象
 * @return type
 */
function obj2Arr($obj) {
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr AS $k => $v) {
        $arr = is_object($v) ? obj2Arr($v) : $v;
        $arr[$k] = $arr;
    }
    return $arr;
}

/**
 * 将数组转换成对象
 * 
 * @param type $arr 数组
 * @return type
 */
function arr2Obj ($arr) {
    if (is_array($arr)) {
        $obj = new StdClass();
        foreach ($arr AS $k => $v) {
            $obj->$k = is_array($v) ? arr2Obj($v) : $v;
        }
    } else {
        $obj = $arr;
    }
    return $obj;
}

/**
 * 判断是否是ajax传输 
 * @return boolean
 */
function isAjax () {
    if (isset($_SERVER['HTTP_X_REQUEST_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUEST_WITH'] == 'xmlhttprequest')
        ) {
        return true;
    } else {
        return false;
    }
}



