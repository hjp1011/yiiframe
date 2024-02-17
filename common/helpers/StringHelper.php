<?php

namespace common\helpers;

use Yii;
use yii\helpers\BaseStringHelper;
use Ramsey\Uuid\Uuid;

/**
 * Class StringHelper
 * @package common\helpers
 * @author YiiFrame <21931118@qq.com>
 */
class StringHelper extends BaseStringHelper
{
    /**
     * 生成Uuid
     *
     * @param string $type 类型 默认时间 time/md5/random/sha1/uniqid 其中uniqid不需要特别开启php函数
     * @param string $name 加密名
     * @return string
     * @throws \Exception
     */
    public static function uuid($type = 'time', $name = 'php.net')
    {
        switch ($type) {
            // 生成版本1（基于时间的）UUID对象
            case  'time' :
                $uuid = Uuid::uuid1();

                break;
            // 生成第三个版本（基于名称的和散列的MD5）UUID对象
            case  'md5' :
                $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $name);

                break;
            // 生成版本4（随机）UUID对象
            case  'random' :
                $uuid = Uuid::uuid4();

                break;
            // 产生一个版本5（基于名称和散列的SHA1）UUID对象
            case  'sha1' :
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $name);

                break;
            // php自带的唯一id
            case  'uniqid' :
                return md5(uniqid(md5(microtime(true) . self::random(8)), true));

                break;
        }

        return $uuid->toString();
    }

    /**
     * 日期转时间戳
     *
     * @param $value
     * @return false|int
     */
    public static function dateToInt($value)
    {
        if (empty($value)) {
            return $value;
        }

        if (!is_numeric($value)) {
            return strtotime($value);
        }

        return $value;
    }

    /**
     * 时间戳转日期
     *
     * @param $value
     * @return false|int
     */
    public static function intToDate($value, $format = 'Y-m-d H:i:s')
    {
        if (empty($value)) {
            return date($format);
        }

        if (is_numeric($value)) {
            return date($format, $value);
        }

        return $value;
    }

    /**
     * 获取缩略图地址
     *
     * @param string $url
     * @param int $width
     * @param int $height
     */
    public static function getThumbUrl($url, $width, $height)
    {
        $url = str_replace('attachment/images', 'attachment/thumb', $url);

        return self::createThumbUrl($url, $width, $height);
    }

    /**
     * 创建缩略图地址
     *
     * @param string $url
     * @param int $width
     * @param int $height
     */
    public static function createThumbUrl($url, $width, $height)
    {
        $url = explode('/', $url);
        $nameArr = explode('.', end($url));
        $url[count($url) - 1] = $nameArr[0] . "@{$width}x{$height}." . $nameArr[1];

        return implode('/', $url);
    }

    /**
     * 获取压缩图片地址
     *
     * @param $url
     * @param $quality
     * @return string
     */
    public static function getAliasUrl($url, $alias = 'compress')
    {
        $url = explode('/', $url);
        $nameArr = explode('.', end($url));
        $url[count($url) - 1] = $nameArr[0] . "@{$alias}." . $nameArr[1];

        return implode('/', $url);
    }

    /**
     * 根据Url获取本地绝对路径
     *
     * @param $url
     * @param string $type
     * @return string
     */
    public static function getLocalFilePath($url, $type = 'images')
    {
        if (RegularHelper::verify('url', $url)) {
            if (!RegularHelper::verify('url', Yii::getAlias("@attachurl"))) {
                $hostInfo = Yii::$app->request->hostInfo . Yii::getAlias("@attachurl");
                $url = str_replace($hostInfo, '', $url);
            } else {
                $url = str_replace(Yii::getAlias("@attachurl"), '', $url);
            }
        } else {
            $url = str_replace(Yii::getAlias("@attachurl"), '', $url);
        }

        return Yii::getAlias("@attachment") . $url;
    }

    /**
     * 分析枚举类型配置值
     *
     * 格式 a:名称1,b:名称2
     *
     * @param $string
     * @return array
     */
    public static function parseAttr($string)
    {
        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if (strpos($string, ':')) {
            $value = [];
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k] = $v;
            }
        } else {
            $value = $array;
        }

        return $value;
    }

    /**
     * 返回字符串在另一个字符串中第一次出现的位置
     *
     * @param $string
     * @param $find
     * @return bool
     * true | false
     */
    public static function strExists($string, $find)
    {
        return !(strpos($string, $find) === false);
    }

    /**
     * XML 字符串载入对象中
     *
     * @param string $string 必需。规定要使用的 XML 字符串
     * @param string $class_name 可选。规定新对象的 class
     * @param int $options 可选。规定附加的 Libxml 参数
     * @param string $ns
     * @param bool $is_prefix
     * @return bool|\SimpleXMLElement
     */
    public static function simplexmlLoadString(
        $string,
        $class_name = 'SimpleXMLElement',
        $options = 0,
        $ns = '',
        $is_prefix = false
    ) {
        libxml_disable_entity_loader(true);
        if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $string)) {
            return false;
        }

        return simplexml_load_string($string, $class_name, $options, $ns, $is_prefix);
    }

    /**
     * 字符串提取汉字
     *
     * @param $string
     * @return mixed
     */
    public static function strToChineseCharacters($string)
    {
        preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $string, $chinese);

        return $chinese;
    }

    /**
     * 字符首字母转大小写
     *
     * @param $str
     * @return mixed
     */
    public static function strUcwords($str)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    }

    /**
     * 驼峰命名法转下划线风格
     *
     * @param $str
     * @return string
     */
    public static function toUnderScore($str)
    {
        $array = [];
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == strtolower($str[$i])) {
                $array[] = $str[$i];
            } else {
                if ($i > 0) {
                    $array[] = '-';
                }

                $array[] = strtolower($str[$i]);
            }
        }

        return implode('', $array);
    }

    /**
     * 获取字符串后面的字符串
     *
     * @param string $fileName 文件名
     * @param string $type 字符类型
     * @param int $length 长度
     * @return bool|string
     */
    public static function clipping($fileName, $type = '.', $length = 0)
    {
        return substr(strtolower(strrchr($fileName, $type)), $length);
    }

    /**
     * 获取随机字符串
     *
     * @param $length
     * @param bool $numeric
     * @return string
     */
    public static function random($length, $numeric = false)
    {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));

        $hash = '';
        if (!$numeric) {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }

        $max = strlen($seed) - 1;
        $seed = str_split($seed);
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed[mt_rand(0, $max)];
        }

        return $hash;
    }

    /**
     * 获取数字随机字符串
     *
     * @param bool $prefix 判断是否需求前缀
     * @param int $length 长度
     * @return string
     */
    public static function randomNum($prefix = false, $length = 8)
    {
        $str = $prefix ?? '';

        return $str . substr(implode(null, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, $length);
    }

    /**
     * 去除内容的注释
     *
     * @param $content
     * @return string|string[]|null
     */
    public static function removeAnnotation($content)
    {
        return preg_replace("/(\/\*(\s|.)*?\*\/)|(\/\/.(\s|.*))|(#(\s*)?(.*))/", '',
            str_replace(["\r\n", "\r"], "\n", $content));
    }

    /**
     * 生成随机code
     *
     * @param $merchant_id
     * @return false|string
     */
    public static function code($merchant_id)
    {
        $time_str = date('YmdHis');
        $rand_code = rand(0, 999999);

        return substr(md5($time_str . $rand_code . $merchant_id), 16, 32);
    }

    /**
     * 字符串匹配替换
     *
     * @param string $search 查找的字符串
     * @param string $replace 替换的字符串
     * @param string $subject 字符串
     * @param null $count
     * @return mixed
     */
    public static function replace($search, $replace, $subject, &$count = null)
    {
        return str_replace($search, $replace, $subject, $count);
    }

    /**
     * 验证是否Windows
     *
     * @return bool
     */
    public static function isWindowsOS()
    {
        return strncmp(PHP_OS, 'WIN', 3) === 0;
    }

    /**
     * 文字自动换行
     *
     * @param integer $fontsize 字体大小
     * @param integer $angle 角度
     * @param string $fontface 字体名称
     * @param string $string 字符串
     * @param integer $width 预设宽度
     * @param null $max_line
     * @return string
     */
    public static function autoWrap($font_size, $angle, $font_face, $string, $width, $max_line = null)
    {
        // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        $letter = [];
        for ($i = 0; $i < mb_strlen($string, 'UTF-8'); $i++) {
            $letter[] = mb_substr($string, $i, 1, 'UTF-8');
        }

        $line_count = 0;
        foreach ($letter as $l) {
            $test_str = $content . " " . $l;
            $test_box = imagettfbbox($font_size, $angle, $font_face, $test_str);

            // 判断拼接后的字符串是否超过预设的宽度
            if (($test_box[2] > $width) && ($content !== "")) {
                $line_count++;

                if ($max_line && $line_count >= $max_line) {
                    $content = mb_substr($content, 0, -1, 'UTF-8') . "...";
                    break;
                }

                $content .= "\n";
            }

            $content .= $l;
        }

        return $content;
    }

    /**
     * 省略文字
     *
     * @param $text
     * @param int $num
     * @return string|string[]
     */
    public static function textOmit($string, $num = 26)
    {
        $letter = [];
        for ($i = 0; $i < mb_strlen($string, 'UTF-8'); $i++) {
            $letter[] = mb_substr($string, $i, 1, 'UTF-8');
        }

        $content = "";
        foreach ($letter as $key => $l) {
            if ($key + 1 == $num) {
                $content .= '...';
                break;
            }

            $content .= $l;
        }

        return $content;
    }

    /**
     * 换行显示内容
     *
     * @param string $string 字符串
     * @param int $num 每行长度
     * @param int $cycle_index 行数
     * @return array
     */
    public static function textNewLine($string, $num = 26, $cycle_index = 2)
    {
        $letter = [];
        for ($i = 0; $i < mb_strlen($string, 'UTF-8'); $i++) {
            $letter[] = mb_substr($string, $i, 1, 'UTF-8');
        }

        $data = [];
        for ($j = 1; $j <= $cycle_index; $j++) {
            $str = implode('', array_slice($letter, ($j - 1) * $num, $j * $num));
            if ($j + 1 > $cycle_index && count($letter) > $cycle_index * $num) {
                $str .= '...';
            }

            $data[] = $str;
        }

        foreach ($data as $key => $datum) {
            if (empty($datum)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param $string
     * @return string
     */
    public static function strToInt($string)
    {
        $versionArr = explode('.', $string);
        if (count($versionArr) > 3) {
            return false;
        }

        $version_id = 0;
        isset($versionArr[0]) && $version_id += BcHelper::mul((int)$versionArr[0], 100000000000, 12);
        isset($versionArr[1]) && $version_id += BcHelper::mul((int)$versionArr[1], 10000000, 8);
        isset($versionArr[2]) && $version_id += BcHelper::mul((int)$versionArr[2], 1000, 4);

        return $version_id;
    }

    /**
     * 将一个字符串部分字符用*替代隐藏
     *
     * @param string $string 待转换的字符串
     * @param int $bengin 起始位置，从0开始计数，当$type=4时，表示左侧保留长度
     * @param int $len 需要转换成*的字符个数，当$type=4时，表示右侧保留长度
     * @param int $type 转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
     * @param string $glue 分割符
     * @return bool|string
     */
    public static function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@")
    {
        if (empty($string)) {
            return false;
        }

        $array = [];
        if ($type == 0 || $type == 1 || $type == 4) {
            $strlen = $length = mb_strlen($string);

            while ($strlen) {
                $array[] = mb_substr($string, 0, 1, "utf8");
                $string = mb_substr($string, 1, $strlen, "utf8");
                $strlen = mb_strlen($string);
            }
        }

        switch ($type) {
            case 0 :
                for ($i = $bengin; $i < ($bengin + $len); $i++) {
                    isset($array[$i]) && $array[$i] = "*";
                }

                $string = implode("", $array);
                break;
            case 1 :
                $array = array_reverse($array);
                for ($i = $bengin; $i < ($bengin + $len); $i++) {
                    isset($array[$i]) && $array[$i] = "*";
                }

                $string = implode("", array_reverse($array));
                break;
            case 2 :
                $array = explode($glue, $string);
                $array[0] = self::hideStr($array[0], $bengin, $len, 1);
                $string = implode($glue, $array);
                break;
            case 3 :
                $array = explode($glue, $string);
                $array[1] = self::hideStr($array[1], $bengin, $len, 0);
                $string = implode($glue, $array);
                break;
            case 4 :
                $left = $bengin;
                $right = $len;
                $tem = array();
                for ($i = 0; $i < ($length - $right); $i++) {
                    if (isset($array[$i])) {
                        $tem[] = $i >= $left ? "*" : $array[$i];
                    }
                }

                $array = array_chunk(array_reverse($array), $right);
                $array = array_reverse($array[0]);
                for ($i = 0; $i < $right; $i++) {
                    $tem[] = $array[$i];
                }
                $string = implode("", $tem);
                break;
        }

        return $string;
    }
    /**
     * 匹配2个之间字符的字符串
     *
     * @param $str
     * @param string $start
     * @param string $end
     * @return array
     */
    public static function matchStr($str, $start = '{', $end = '}')
    {
        $strPattern = "/(?<=" . $start . ")[^" . $end . "]+/";
        $arrMatches = [];
        preg_match_all($strPattern, $str, $arrMatches);

        return $arrMatches[0] ?? [];
    }
    /**
     * php截取指定两个字符之间字符串，默认字符集为utf-8 Power by 大耳朵图图
     * @param string $begin  开始字符串
     * @param string $end    结束字符串
     * @param string $str    需要截取的字符串
     * @return string
     */
    public static function cut($begin,$end,$str){
        $b = mb_strpos($str,$begin) + mb_strlen($begin);
        $e = mb_strpos($str,$end) - $b;

        return mb_substr($str,$b,$e);
    }

    /**
     *  根据身份证号码获取性别
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     *  @return int $sex 性别 1男 2女 0未知
     */
    public static function get_sex($idcard) {
        if(empty($idcard)) return null;
        $sexint = (int) substr($idcard, 16, 1);
        return $sexint;
    }

    /**
     *  根据身份证号码获取生日
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     *  @return $birthday
     */
    public static function get_birthday($idcard) {
        if(empty($idcard)) return null;
        $bir = substr($idcard, 6, 8);
        $year = (int) substr($bir, 0, 4);
        $month = (int) substr($bir, 4, 2);
        $day = (int) substr($bir, 6, 2);
        return $year . "-" . $month . "-" . $day;
    }

    /**
     *  根据身份证号码计算年龄
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     *  @return int $age
     */
    public static function get_age($idcard){
        if(empty($idcard)) return null;
        #  获得出生年月日的时间戳
        $date = strtotime(substr($idcard,6,8));
        #  获得今日的时间戳
        $today = strtotime('today');
        #  得到两个日期相差的大体年数
        $diff = floor(($today-$date)/86400/365);
        #  strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        $age = strtotime(substr($idcard,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;
        return $age;
    }

    /**
     *  根据身份证号码获取出身地址
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     *  @return string $address
     */
    public static function get_address($idcard, $type=1){
        if(empty($idcard)) return null;
        $address = include('./address.php');
        switch ($type) {
            case 1:
                # 截取前六位数(获取基体到县区的地址)
                $key = substr($idcard,0,6);
                if(!empty($address[$key])) return $address[$key];
                # 截取前两位数(没有基体到县区的地址就获取省份)
                $key = substr($idcard,0,2);
                if(!empty($address[$key])) return $address[$key];
                # 都没有
                return '未知地址';
                break;
            case 2:
                # 截取前两位数(只获取省份)
                $key = substr($idcard,0,2);
                if(!empty($address[$key])) return $address[$key];
                break;
            default:
                return null;
                break;
        }
    }

    /**
     *  判断字符串是否是身份证号
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     */
    public static function isIdCard($idcard){
        #  转化为大写，如出现x
        $idcard = strtoupper($idcard);
        #  加权因子
        $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        #  按顺序循环处理前17位
        $sigma = 0;
        #  提取前17位的其中一位，并将变量类型转为实数
        for ($i = 0; $i < 17; $i++) {
            $b = (int)$idcard[$i];
            #  提取相应的加权因子
            $w = $wi[$i];
            #  把从身份证号码中提取的一位数字和加权因子相乘，并累加
            $sigma += $b * $w;
        }
        #  计算序号
        $sidcard = $sigma % 11;
        #  按照序号从校验码串中提取相应的字符。
        $check_idcard = $ai[$sidcard];
        if ($idcard[17] == $check_idcard) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  根据身份证号，返回对应的生肖
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     */
    public static function get_zodiac($idcard){ //
        if(empty($idcard)) return null;
        $start = 1901;
        $end = (int)substr($idcard, 6, 4);
        $x = ($start - $end) % 12;
        $val = '';
        if ($x == 1 || $x == -11) $val = '鼠';
        if ($x == 0)              $val = '牛';
        if ($x == 11 || $x == -1) $val = '虎';
        if ($x == 10 || $x == -2) $val = '兔';
        if ($x == 9 || $x == -3)  $val = '龙';
        if ($x == 8 || $x == -4)  $val = '蛇';
        if ($x == 7 || $x == -5)  $val = '马';
        if ($x == 6 || $x == -6)  $val = '羊';
        if ($x == 5 || $x == -7)  $val = '猴';
        if ($x == 4 || $x == -8)  $val = '鸡';
        if ($x == 3 || $x == -9)  $val = '狗';
        if ($x == 2 || $x == -10) $val = '猪';
        return $val;
    }

    /**
     *  根据身份证号，返回对应的星座
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     */
    public static function get_starsign($idcard){
        if(empty($idcard)) return null;
        $b = substr($idcard, 10, 4);
        $m = (int)substr($b, 0, 2);
        $d = (int)substr($b, 2);
        $val = '';
        if(($m == 1 && $d <= 21) || ($m == 2 && $d <= 19)){
            $val = "水瓶座";
        }else if (($m == 2 && $d > 20) || ($m == 3 && $d <= 20)){
            $val = "双鱼座";
        }else if (($m == 3 && $d > 20) || ($m == 4 && $d <= 20)){
            $val = "白羊座";
        }else if (($m == 4 && $d > 20) || ($m == 5 && $d <= 21)){
            $val = "金牛座";
        }else if (($m == 5 && $d > 21) || ($m == 6 && $d <= 21)){
            $val = "双子座";
        }else if (($m == 6 && $d > 21) || ($m == 7 && $d <= 22)){
            $val = "巨蟹座";
        }else if (($m == 7 && $d > 22) || ($m == 8 && $d <= 23)){
            $val = "狮子座";
        }else if (($m == 8 && $d > 23) || ($m == 9 && $d <= 23)){
            $val = "处女座";
        }else if (($m == 9 && $d > 23) || ($m == 10 && $d <= 23)){
            $val = "天秤座";
        }else if (($m == 10 && $d > 23) || ($m == 11 && $d <= 22)){
            $val = "天蝎座";
        }else if (($m == 11 && $d > 22) || ($m == 12 && $d <= 21)){
            $val = "射手座";
        }else if (($m == 12 && $d > 21) || ($m == 1 && $d <= 20)){
            $val = "魔羯座";
        }
        return $val;
    }
    //微信特殊字符过滤
    public static function wx_name_filter($clean_text) {
          // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $clean_text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }
    //取子串
    public static function  get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}