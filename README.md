## 订阅助手(小鸡管理)

![图1](https://cdn.exia.xyz/img/blog/588/20201127084700.png)

![图2](https://cdn.exia.xyz/img/blog/588/20201127084808.png)

![图3](https://cdn.exia.xyz/img/blog/588/20201127084900.png)



### 相较于上一个版本的更改

- 前端使用了体验更好的vue.js
- UI更加可人
- 使用server酱代替邮箱
- ~~等等，还有上一个版本？~~
- 使用Medoo数据库框架



### 使用说明

打开你的php的sqlite拓展

编辑项目`X`目录下`main.class.php`中的`key`和`serverChanKey`变量，前者为小鸡管理登录密钥，后者为serverChan发信密钥。

如果可以，设置crontab每天执行一次`X`目录下的cron.php



### 其他说明

因为精力有限，没有做更多安全处理，如果有需要的可以自己修改一下代码。
