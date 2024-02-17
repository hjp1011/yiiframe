## YiiFrame

基于Yii2的重量级二次开发框架

### 前言

YiiFrame 是一个基于Yii2+Bootstrap的快速后台开发框架，可完美运行在linux、mac和windows环境下，用于开发各种基于PHP构建的应用程序，包括APP、小程序、H5、网站等。 基于插件的框架结构特别适合开发大型应用系统的后端和提供接口服务，如门户网站、社区网站、CMS、CRM、ERP、OA、电子商务等项目。

### 特色

- 极强的可扩展性，应用化，模块化，插件化机制敏捷开发，支持国际化，内置简体中文、繁体、英语、日语等语言包。
- 强大的应用插件扩展功能，在线安装卸载升级应用插件；微核架构，良好的功能延伸性，功能之间是隔离，可定制性高，可以渐进式地开发，逐步增加功能，安装和卸载不会对原来的系统产生影响,强大的功能完全满足各阶段的需求，支持用户多端访问(后台、微信、Api、前台等)。
- 完善的 RBAC 权限控制管理、无限父子级权限分组、可自由分配子级权限，且按钮/链接/自定义内容/插件等都可加入权限控制。
- 精简的后台管理系统，不会在上面开发过多的业务内容，满足绝大多数的系统二次开发。
- 多入口模式，多入口分为 Backend (后台)、Merchant (企业端)、Frontend (PC前端)、Html5 (手机端)、Console (控制台)、Api (对内接口)、OAuth2 Server (对外接口)、MerApi (企业接口)、Storage (静态资源)，不同的业务，不同的设备，进入不同的入口。
- 支持微信公众号和企业微信，大幅度的提升了微信开发效率。
- 支持第三方登录，目前有 QQ、微信、微博、GitHub 等等。
- 支持第三方支付，目前有微信支付、支付宝支付、银联支付，二次封装为网关多个支付一个入口一个出口。
- 支持 RESTful API，支持前后端分离接口开发和 App 接口开发，可直接上手开发业务。
- 支持本地存储，无缝整合第三方云存储，支持腾讯 COS、阿里云 OSS、七牛云存储，且增加其他第三方存储也非常方便。
- 全面监控系统报错，报错日志写入数据库，方便定位错误信息。
- 快速高效的 Servises (服务层)，遵循 Yii2 的懒加载方式，只初始化使用到的组件服务。
- 丰富的表单控件(时间、日期、时间日期、日期范围选择、颜色选择器、省市区三级联动、省市区勾选、单图上传、多图上传、单文件上传、多文件上传、百度编辑器、百度图表、多文本编辑框、地图经纬度选择器、图片裁剪上传、TreeGrid、JsTree、Markdown 编辑器)和组件(二维码生成、Curl、IP地址转地区)，快速开发，不必再为基础组件而担忧。
- 一键生成 CURD ,无需编写代码，只需创建表设置路径就能出现一个完善的 CURD ,其中所需表单控件也是勾选即可直接生成。
- 一键生成API接口文档
- 完善的文档和辅助类，方便二次开发与集成。
- 支持在线更新功能，可以一键安装更新到最新版本。
- 丰富的应用插件市场，基础插件应有尽有。

### 应用架构流程

![image](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/app-flow.png)

### 系统快照

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E7%B3%BB%E7%BB%9F%E9%A6%96%E9%A1%B5.png "系统首页")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E7%AB%99%E7%82%B9%E8%AE%BE%E7%BD%AE.png "站点设置")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E9%85%8D%E7%BD%AE%E7%AE%A1%E7%90%86.png "配置管理")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E5%BA%94%E7%94%A8%E7%AE%A1%E7%90%86.png "插件中心")

![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/YiiFrame-%E6%9D%83%E9%99%90%E7%AE%A1%E7%90%86.png "权限管理")

### 案例截图

安装插件
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%AE%89%E8%A3%85%E6%8F%92%E4%BB%B6.png "屏幕截图.png")

已安装插件
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%B2%E5%AE%89%E8%A3%85%E6%8F%92%E4%BB%B6.png "屏幕截图.png")

工作流列表
![](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%A5%E4%BD%9C%E6%B5%81%E5%88%97%E8%A1%A8.png "屏幕截图.png")

流程状态
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%B5%81%E7%A8%8B%E7%8A%B6%E6%80%81.png "屏幕截图.png")

配置审核人员
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E9%85%8D%E7%BD%AE%E5%AE%A1%E6%A0%B8%E4%BA%BA%E5%91%98.png "屏幕截图.png")

工作流转
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%A5%E4%BD%9C%E6%B5%81%E8%BD%AC.png "屏幕截图.png")

新增流程节点
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%88%9B%E5%BB%BA%E6%B5%81%E7%A8%8B%E8%8A%82%E7%82%B9.png "屏幕截图.png")

待办工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%BE%85%E5%8A%9E%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")

已办工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%B7%B2%E5%8A%9E%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")

审核工作
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%AE%A1%E6%A0%B8%E5%B7%A5%E4%BD%9C.png "屏幕截图.png")

创建申请
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E5%88%9B%E5%BB%BA%E7%94%B3%E8%AF%B7.png "屏幕截图.png")

查看进度
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%9F%A5%E7%9C%8B%E8%BF%9B%E5%BA%A6.png "屏幕截图.png")

班次管理
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%8F%AD%E6%AC%A1%E7%AE%A1%E7%90%86.png "屏幕截图.png")

排班管理
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%8E%92%E7%8F%AD%E7%AE%A1%E7%90%86.png "屏幕截图.png")

我的排班
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E6%88%91%E7%9A%84%E6%8E%92%E7%8F%AD.png "屏幕截图.png")

签到列表
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%AD%BE%E5%88%B0%E5%88%97%E8%A1%A8.png "屏幕截图.png")

新建打卡
![输入图片说明](https://wephp-unioa.oss-cn-shenzhen.aliyuncs.com/%E7%AD%BE%E5%88%B0%E6%89%93%E5%8D%A1.png "屏幕截图.png")

### 开始之前

- 具备 PHP 基础知识
- 具备 Yii2 基础开发知识
- 具备 开发环境的搭建技能
- 如果要做小程序或微信开发需要明白微信接口的组成，自有服务器、微信服务器、公众号（还有其它各种号）、测试号、以及通信原理（交互过程）
- 如果需要做接口开发(RESTful API)了解基本的 HTTP 协议，Header 头、请求方式（`GET\POST\PUT\PATCH\DELETE`）等
- 能查看日志和 Debug 技能
- 使用前请仔细阅读文档，一般常见的报错可以自行先解决，解决不了再来提问


### 官网

https://www.yiiframe.com

### 文档

http://doc.yiiframe.com

###框架下载

github：https://github.com/hjp1011/yiiframe

gitee：https://gitee.com/hjp1011/yiiframe

官网：https://www.yiiframe.com/672/

### 插件下载

https://www.yiiframe.com/category/addons/

### 问题反馈

在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

问答社区：https://www.yiiframe.com/question/

Github：https://github.com/hjp1011/yiiframe/issues

Gitee：https://gitee.com/hjp1011/yiiframe/issues

QQ：21931118

### 特别鸣谢

感谢以下的项目，排名不分先后

Yiifrawork：http://www.yiiframework.com

Bootstrap：http://getbootstrap.com

AdminLTE：https://adminlte.io

EasyWechat：https://www.easywechat.com

Rageframe：http://www.rageframe.com
...

### 版权信息

YiiFrame 遵循 Apache2 开源协议发布，并提供免费试用，请勿用于商业用途，如果您想将此套系统用于商业用途，您可以联系我们，以取得商业授权。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2021-2026 by YiiFrame ([www.yiiframe.com](https://www.yiiframe.com)) All rights reserved。
