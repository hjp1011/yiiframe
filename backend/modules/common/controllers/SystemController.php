<?php

namespace backend\modules\common\controllers;

use Yii;
use common\helpers\FileHelper;
use backend\controllers\BaseController;
use yiiframe\authorization\Auth;
use common\helpers\Gethttp;
/**
 * Class SystemController
 * @package backend\modules\base\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class SystemController extends BaseController
{

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionInfo()
    {

        // 禁用函数
        $disableFunctions = ini_get('disable_functions');
        $disableFunctions = !empty($disableFunctions) ? explode(',', $disableFunctions) : '未禁用';
        // 附件大小
        $attachmentSize = FileHelper::getDirSize(Yii::getAlias('@attachment'));
        $updateinfo = Auth::Version();
        return $this->render('info', [
            'mysql_size' => Yii::$app->services->backend->getDefaultDbSize(),
            'attachment_size' => $attachmentSize ?? 0,
            'disable_functions' => $disableFunctions,
            'updateinfo' => $updateinfo['info'],
            'domain_time' => $updateinfo['time'],
        ]);
    }
    public function actionUpdate()
    {

        $root = Yii::getAlias('@root');
        Gethttp::get_file(Auth::Down(), 'update.zip', $root);
        $updatezip = $root . '/update.zip';
        $zip = new \ZipArchive();
        if($zip->open($updatezip)===TRUE){
            $zip->extractTo(Yii::getAlias('@root'));
            $zip->close();
            $files = $this->getFileList(Yii::getAlias('@root').'/update');
            $flag = true;
            foreach ($files as $file) {
                if (!$this->copyFile($root, "update/$file", $file)) {
                    $flag = false;
                    break;
                }
            }
            include Yii::getAlias('@root').'/update/sql.php';
            if (file_exists(Yii::getAlias('@root').'/update.zip')) unlink(Yii::getAlias('@root').'/update.zip');
            if (file_exists(Yii::getAlias('@root').'/update/sql.php')) unlink(Yii::getAlias('@root').'/update/sql.php');

            if (!$flag) {
                return $this->message('更新文件失败,请手动将/update目录下的文件覆盖到站点根目录!', $this->redirect(['info']));
            }
            // Gethttp::delDirAndFile(Yii::getAlias('@root').'/update','update');
            return $this->message('升级完成', $this->redirect(['info']));
        }else{
            return $this->message('更新文件不存在或站点没有读写权限,升级失败！', $this->redirect(['info']));
        }

    }

    function getFileList($root, $basePath = '')
    {
        $files = [];
        $handle = opendir($root);
        while (($path = readdir($handle)) !== false) {
            if ($path === 'sql.php' || $path === '.DS_Store' || $path === '.git' || $path === '.svn' || $path === '.' || $path === '..') {
                continue;
            }
            $fullPath = "$root/$path";
            $relativePath = $basePath === '' ? $path : "$basePath/$path";
            if (is_dir($fullPath)) {
                $files = array_merge($files, $this->getFileList($fullPath, $relativePath));
            } else {
                $files[] = $relativePath;
            }
        }
        closedir($handle);
        return $files;
    }

    function copyFile($root, $source, $target)
    {
        if (is_file($root . '/' . $target)) {
            if(@file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source)))
                return true;
            else 
                return false;
        }
        @mkdir(dirname($root . '/' . $target), 0777, true);
        file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
        return true;
    }

}