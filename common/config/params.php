<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'senderEmail'=>'admin@example.com',
    'senderName'=>'YiiFrame',
    'user.passwordMinLength' => 6,
    'user.log.noPostData' => [ // 安全考虑,不接收Post某些字段存储到日志的路由
        'password',
        'passwd',
        'passwd_new',
        'passwd_repetition',
        'password_hash',
        'password_repetition',

    ],
    // 是否在模块内
    'inAddon' => false,
    // 系统管理员账号id
    'adminAccount' => '0',
    // 开发模式
    'devPattern' => 'enterprise',
    // 请求全局唯一ID
    'uuid' => '',
    // 真实 app id
    'realAppId' => '',
    // 百度编辑器默认上传驱动
    'UEditorUploadDrive' => 'local',
    // 全局上传配置
    'uploadConfig' => [
        // 图片
        'images' => [
            'originalName' => false, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'takeOverUrl' => '', // 配置后，接管所有的上传地址
            'drive' => 'local', // 默认本地 可修改 qiniu/oss/cos 上传
            'md5Verify' => true, // md5 校验
            'maxSize' => 1024 * 1024 * 10,// 图片最大上传大小,默认10M
            'extensions' => ["png", "jpg", "jpeg", "gif", "bmp"],// 可上传图片后缀不填写即为不限
            'path' => 'images/', // 图片创建路径
            'subName' => 'Y/m/d', // 图片上传子目录规则
            'prefix' => 'image_', // 图片名称前缀
            'mimeTypes' => 'image/*', // 媒体类型
            'compress' => false, // 是否开启压缩
            'compressibility' => [ // 100不压缩 值越大越清晰 注意先后顺序
                1024 * 100 => 100, // 0 - 100k 内不压缩
                1024 * 1024 => 30, // 100k - 1M 区间压缩质量到30
                1024 * 1024 * 2  => 20, // 1M - 2M 区间压缩质量到20
                1024 * 1024 * 1024  => 10, // 2M - 1G 区间压缩质量到20
            ],
        ],
        // 视频
        'videos' => [
            'originalName' => true, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'takeOverUrl' => '', // 配置后，接管所有的上传地址
            'drive' => 'local', // 默认本地 可修改 qiniu/oss/cos 上传
            'md5Verify' => true, // md5 校验
            'maxSize' => 1024 * 1024 * 50,// 最大上传大小,默认50M
            'extensions' => ['mp4', 'mp3'],// 可上传文件后缀不填写即为不限
            'path' => 'videos/',// 创建路径
            'subName' => 'Y/m/d',// 上传子目录规则
            'prefix' => 'video_',// 名称前缀
            'mimeTypes' => 'video/*', // 媒体类型
        ],
        // 语音
        'voices' => [
            'originalName' => true, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'takeOverUrl' => '', // 配置后，接管所有的上传地址
            'drive' => 'local', // 默认本地 可修改 qiniu/oss/cos 上传
            'md5Verify' => true, // md5 校验
            'maxSize' => 1024 * 1024 * 30,// 最大上传大小,默认30M
            'extensions' => ['amr', 'mp3'],// 可上传文件后缀不填写即为不限
            'path' => 'voice/',// 创建路径
            'subName' => 'Y/m/d',// 上传子目录规则
            'prefix' => 'voice_',// 名称前缀
            'mimeTypes' => 'image/*', // 媒体类型
        ],
        // 文件
        'files' => [
            'originalName' => true, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'takeOverUrl' => '', // 配置后，接管所有的上传地址
            'drive' => 'local', // 默认本地 可修改 qiniu/oss/cos 上传
            'md5Verify' => true, // md5 校验
            'maxSize' => 1024 * 1024 * 150,// 最大上传大小,默认150M
            'extensions' => [],// 可上传文件后缀不填写即为不限
            'path' => 'files/',// 创建路径
            'subName' => 'Y/m/d',// 上传子目录规则
            'prefix' => 'file_',// 名称前缀
            'mimeTypes' => '*', // 媒体类型
            'blacklist' => [ // 文件后缀黑名单
                'php', 'php5', 'php4', 'php3', 'php2', 'php1',
                'java', 'asp', 'jsp', 'jspa', 'javac',
                'py', 'pl', 'rb', 'sh', 'ini', 'svg', 'html', 'jtml','phtml','pht', 'js'
            ],
        ],
        // 缩略图
        'thumb' => [
            'path' => 'thumb/',// 图片创建路径
        ],
    ],

    /** ------ 微信配置 ------ **/

    // 微信配置 具体可参考EasyWechat
    'wechatConfig' => [],
    // 微信支付配置 具体可参考EasyWechat
    'wechatPaymentConfig' => [],
    // 微信小程序配置 具体可参考EasyWechat
    'wechatMiniProgramConfig' => [],
    // 微信开放平台第三方平台配置 具体可参考EasyWechat
    'wechatOpenPlatformConfig' => [],
    // 微信企业微信配置 具体可参考EasyWechat
    'wechatWorkConfig' => [],
    // 微信企业微信开放平台 具体可参考EasyWechat
    'wechatOpenWorkConfig' => [],

    /** ------ 插件类型 ------ **/
    'addonsGroup' => [
        'approve' => [
            'name' => 'approve',
            'title' => Yii::t('app','审批管理'),
            'icon' => 'fa fa-user-circle-o',
        ],
        'daily' => [
            'name' => 'daily',
            'title' => Yii::t('app','日常管理'),
            'icon' => 'fa fa-calendar',
        ],
        'personnel' => [
            'name' => 'personnel',
            'title' => Yii::t('app','人事管理'),
            'icon' => 'fa fa-user-plus',
        ],
        'sales' => [
            'name' => 'sales',
            'title' => Yii::t('app','销售管理'),
            'icon' => 'fa fa-shopping-bag',
        ],
        'activity' => [
            'name' => 'activity',
            'title' => Yii::t('app','营销活动'),
            'icon' => 'fa fa-cubes',
        ],
        'customer' => [
            'name' => 'customer',
            'title' => Yii::t('app','客户关系'),
            'icon' => 'fa fa-users',
        ],
        'financial' => [
            'name' => 'financial',
            'title' => Yii::t('app','财务管理'),
            'icon' => 'fa fa-credit-card-alt',
        ],
        'inventory' => [
            'name' => 'inventory',
            'title' => Yii::t('app','库存管理'),
            'icon' => 'fa fa-database',
        ],
        'purchase' => [
            'name' => 'purchase',
            'title' => Yii::t('app','采购管理'),
            'icon' => 'fa fa-cart-plus',
        ],
        'knowledge' => [
            'name' => 'knowledge',
            'title' => Yii::t('app','知识管理'),
            'icon' => 'fa fa-cloud',
        ],
        'project' => [
            'name' => 'project',
            'title' => Yii::t('app','项目管理'),
            'icon' => 'fa fa-sitemap',
        ],
        'personal' => [
            'name' => 'personal',
            'title' => Yii::t('app','个人管理'),
            'icon' => 'fa fa-user',
        ],
        'services' => [
            'name' => 'services',
            'title' => Yii::t('app','常用服务'),
            'icon' => 'fa fa-magnet',
        ],
        'plug' => [
            'name' => 'plug',
            'title' => Yii::t('app','功能扩展'),
            'icon' => 'fa fa-puzzle-piece',
        ],
        'business' => [
            'name' => 'business',
            'title' => Yii::t('app','商务功能'),
            'icon' => 'fa fa-puzzle-piece',
        ],
    ],
];
