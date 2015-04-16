# freelog

这是一个基于ThinkPHP3.2.3的多人社交轻博客，自由、轻快的交换你的成长。

## 为什么会有这个博客
- 为后面我要写的ThinkPHP 方面的书 做案列
- 像点点网致敬，同时满足大家的娱乐分享需求
- 实现Bootstrap的默认博客静态案列的动态化(不会设计啊，真想找个前端的妹子当女朋友(*^\_\_^*) )
## 技术构成
- ThinkPHP3.2.3最新版
- 基于Bower安装了一些常用插件比如**Bootstrap**、**jcrop**、**tagsinput**、**uploadify**等前端组件
- 基于Thinkphp的Rest控制器实现了api层
- 用audio.js实现了mp3音乐的播放
- ThinkSDK实现的第三方登录绑定，目前只在个人信息里做了绑定，设计了数据库，获得了登录认证，qq的差不多，不过腾讯应用的审核你懂的。。微博的要备案，so，本的登录应用配置只能测试本人的，你们还是自己申请吧！
- 苗儿的Wechat实现的微信号一些基本功能（关注回复消息、响应文本消息、后台获取微信服务器等），因为我只是个人，高级接口要成为微信认证用户，然后注册微信公众平台时订阅号选择了个人，想用的时候才发现个人没法成为认证用户啊（尼玛%\>\_\<%）。而且微信这混蛋还不支持注销用户，我都注册了3个微信号，邮箱用完了。(╯‵□′)╯︵┻━┻
## 实现功能
1. 用户注册、登录（没做验证邮箱激活，其实做也不难，只是时间用于开发核心功能了）、登出
![](assets/DraggedImage.png "登录")

![](assets/DraggedImage-1.png "注册")

![](assets/DraggedImage-2.png)
2. 用户发布文字、图片、视频、音乐类型文章  
      
    图片和音乐是上传、视频支持上传和插入在线视频

![](assets/DraggedImage-3.png) ![](assets/DraggedImage-4.png "发布文字") ![](assets/DraggedImage-5.png "定时发布图片") ![](assets/DraggedImage-6.png "发布视频") ![](assets/DraggedImage-7.png "发布音乐")
3. 普通搜索和基于标签的归类、归档搜索
![](assets/DraggedImage-8.png "标签") ![](assets/DraggedImage-9.png "归档") 
4. 我的主页（我发布的新闻）
![](assets/DraggedImage-10.png)
5. 列表及分页列表支持图片多图的相册式预览（支持快捷键哦），音乐多个的话文章详情里是播放列表（别怪我没告诉你）
![](assets/DraggedImage-11.png) ![](assets/DraggedImage-12.png)
6. 头像裁剪(差读取)
![](assets/DraggedImage-13.png)
7. 不同类型文章的详情页+社会化评论   
    ![](assets/DraggedImage-14.png)
8. restful的api模块
![](assets/DraggedImage-15.png)
9. 后台（登录、登出、文件、图片列表、标签列表、文章列表、动态配置、微信iframe和服务器ip获取）
![](assets/DraggedImage-16.png) ![](assets/DraggedImage-17.png) ![](assets/DraggedImage-18.png)![](assets/DraggedImage-19.png)  ![](assets/DraggedImage-20.png) ![](assets/DraggedImage-21.png) 
10. 引入Socketlog chrome调试插件
## TODO列表，希望有能力的童鞋能完成，自己锻炼下
- 列表页视频可以弹出来看
- 多个音频时 ，一个播放，其他的停止播放
- 后台 用 bootstrap editable 插件ajax更新单个字段 (已安装过资源)
- 使用 bootstrap-material-design 做美化  (已安装过资源)
- 前后台都可以编辑文章，目前没做，因为太麻烦了。发布时候，多音乐和图片都支持删除和排序给自己挖了坑。
- 单元测试，写到单元测试时后再写吧
