<?php

use yii\helpers\Html;

$this->title = '用户协议';

?>

<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <!-- /.mailbox-read-info -->
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                    <p><?= Yii::$app->debris->addonConfig('Member')['member_protocol_cooperation']; ?></p>
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>