<?php

namespace common\helpers;


/**
 * Class Authorization
 * @package common\components
 * @author YiiFrame <21931118@qq.com>
 */
class Gethttp
{
    public static function get_api($url,$type = 'Au'){
        $curl = curl_init(); // 启动一个CURL会话
        $header[] = "Content-type: text/html;charset=utf-8";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl, CURLOPT_NOSIGNAL,1);    
        curl_setopt($curl, CURLOPT_TIMEOUT_MS,200);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');
        $contents = curl_exec($curl);     //返回api的json对象
        //$contents = mb_convert_encoding($contents, 'utf-8', 'GBK,UTF-8,ASCII');
    	$errno = curl_errno($curl);
    	$error = curl_error($curl);
        //关闭URL请求
        curl_close($curl);
    	$official = 'https://www.yiiframe.com/'; //设置授权提示官方跳转地址
    	if ($errno>0) {
    			if($type == 'Up'){
					return '{"code":404,"message":"NO","data":{"msg":"远程检查失败了,请联系QQ:21931118"}}';
				}else{
					echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="UTF-8"><title>Authorization For YiiFrame</title></head><body data-new-gr-c-s-check-loaded="9.53.0" data-gr-ext-installed=""><style>html, body {background-color: #fff;color: #636b6f;font-family: sans-serif;font-weight: 100;height: 100vh;margin: 0;}.full-height {height: 100vh;}.flex-center {align-items: center;display: flex;justify-content: center; }.position-ref { position: relative;}.top-right {position: absolute;right: 10px;top: 18px;}.content {text-align: center;}.title {font-size: 54px;}.links > a {color: #636b6f;padding: 0 25px;font-size: 18px;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;}.m-b-md {margin-bottom: 30px;}</style><div class="flex-center position-ref full-height"><div class="content"><div class="title m-b-md">授权提示</div><div class="links"><a href="'.$official.'" target="_blank">远程检查失败了,请联系QQ:21931118</a></div></div></div></body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>';
					exit;
				}
    		} else {
    			return $contents;
    		}
    }

    public static function get_file($url,$name,$folder = './')
    {
        set_time_limit((24 * 60) * 60);
        // 设置超时时间
        $destination_folder = $folder . '/';
        // 文件下载保存目录，默认为当前文件目录
        if (!is_dir($destination_folder)) {
            // 判断目录是否存在
            self::mkdirs($destination_folder);
        }
        $newfname = $destination_folder.$name;
        // 取得文件的名称
        $file = fopen($url, 'rb');
        // 远程下载文件，二进制模式
        if ($file) {
            // 如果下载成功
            $newf = fopen($newfname, 'wb');
            // 远在文件文件
            if ($newf) {
                // 如果文件保存成功
                while (!feof($file)) {
                    // 判断附件写入是否完整
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
        return true;
    }
    public static function mkdirs($path, $mode = '0777')
    {
        if (!is_dir($path)) {
            // 判断目录是否存在
            Self::mkdirs(dirname($path), $mode);
            // 循环建立目录
            mkdir($path, $mode);
        }
        return true;
    }
	
    //循环删除目录和文件函数
    public static function delDirAndFile($path, $delDir = false)
    {
        if (is_array($path)) {
            foreach ($path as $subPath) {
                self::delDirAndFile($subPath, $delDir);
            }

        }
        if (is_dir($path)) {
            $handle = opendir($path);
            if ($handle) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != "." && $item != "..") {
                        is_dir("$path/$item") ? self::delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
                    }

                }
                closedir($handle);
                if ($delDir) {
                    rmdir($path);
					//return rmdir($path);
                }

            }
        } else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return false;
            }
        }
        clearstatcache();
    }

}