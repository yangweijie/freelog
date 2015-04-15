<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

use Think\Controller;
use Com\Wechat;
use Com\WechatAuth;

class WeixinController extends Controller{
    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     */
    public function index($id = ''){

        $token = C('WEIXIN.TOKEN'); //微信后台填写的TOKEN

        /* 加载微信SDK */
        $wechat = new Wechat($token);

        /* 获取请求信息 */
        $data = $wechat->request();

        if($data && is_array($data)){
            switch ($data['MsgType']) {
                //订阅提示消息
                case Wechat::MSG_EVENT_SUBSCRIBE:
                    $wechat->response('欢迎关注freelog, 你可以留言引号内内容获得本账号的某些服务比如: 回复"听大白"， 会收到一条语音消息, 回复“看视频”，会收到JobDeer官方介绍视频，回复"看图片"，看到一个Jobdeer的三行广告，回复“推荐文章”，收到一个推荐的图文消息，回复“功能菜单”，收到欢迎文本', Wechat::MSG_TYPE_TEXT);
                    break;
                case Wechat::MSG_TYPE_TEXT:
                    $this->responseText($data['content']);
                    break;
                default:
                    $wechat->response('其他功能尚在开发中', Wechat::MSG_TYPE_TEXT);
                    break;
            }
            slog($data);
            /**
             * 你可以在这里分析数据，决定要返回给用户什么样的信息
             * 接受到的信息类型有9种，分别使用下面九个常量标识
             * Wechat::MSG_TYPE_TEXT       //文本消息
             * Wechat::MSG_TYPE_IMAGE      //图片消息
             * Wechat::MSG_TYPE_VOICE      //音频消息
             * Wechat::MSG_TYPE_VIDEO      //视频消息
             * Wechat::MSG_TYPE_MUSIC      //音乐消息
             * Wechat::MSG_TYPE_NEWS       //图文消息（推送过来的应该不存在这种类型，但是可以给用户回复该类型消息）
             * Wechat::MSG_TYPE_LOCATION   //位置消息
             * Wechat::MSG_TYPE_LINK       //连接消息
             * Wechat::MSG_TYPE_EVENT      //事件消息
             *
             * 事件消息又分为下面五种
             * Wechat::MSG_EVENT_SUBSCRIBE          //订阅
             * Wechat::MSG_EVENT_SCAN               //二维码扫描
             * Wechat::MSG_EVENT_LOCATION           //报告位置
             * Wechat::MSG_EVENT_CLICK              //菜单点击
             * Wechat::MSG_EVENT_MASSSENDJOBFINISH  //群发消息成功
             */

            $content = '这里是Freelog'; //回复内容，回复不同类型消息，内容的格式有所不同
            $type    = Wechat::MSG_TYPE_TEXT; //回复消息的类型

            /* 响应当前请求(自动回复) */
            $wechat->response($content, $type);

            /**
             * 响应当前请求还有以下方法可以只使用
             * 具体参数格式说明请参考文档
             *
             * $wechat->replyText($text); //回复文本消息
             * $wechat->replyImage($media_id); //回复图片消息
             * $wechat->replyVoice($media_id); //回复音频消息
             * $wechat->replyVideo($media_id, $title, $discription); //回复视频消息
             * $wechat->replyMusic($title, $discription, $musicurl, $hqmusicurl, $thumb_media_id); //回复音乐消息
             * $wechat->replyNews($news, $news1, $news2, $news3); //回复多条图文消息
             * $wechat->replyNewsOnce($title, $discription, $url, $picurl); //回复单条图文消息
             *
             */
        }
    }

    public function responseText($text){
        if(false !== strpos('听大白', $text)){
            //回复音频消息
            $wechat->replyVoice(204248804);
        }else if(false !== strpos('看视频', $text)){
            //回复视频消息
        }else if(false !== strpos('看图片', $text)){
            //回复图片消息
            $wechat->replyImage(204248824);
        }else if(false !== strpos('推荐文章', $text)){
            //回复单条图文消息
            $wechat->replyNewsOnce('最新一篇文章', 'Hello, Weixin', 'http://freelog.coding.io/Post/44.html', 'http://freelog.coding.io/Uploads/ueditor/image/20150326/551419ea33999.jpg');
        }else{
            $wechat->replyText('欢迎关注freelog, 你可以留言引号内内容获得本账号的某些服务比如: 回复"听大白"， 会收到一条语音消息, 回复“看视频”，会收到JobDeer官方介绍视频，回复"看图片"，看到一个Jobdeer的三行广告，回复“推荐文章”，收到一个推荐的图文消息，回复“功能菜单”，收到欢迎文本');
        }
    }

    //获取带参二维码
    public function weixinQr($sence_id, $expire_seconds = 0){
        $wechatauth = new WechatAuth(C('WEIXIN.APPID'), C('WEIXIN.SECRET'));
        $result = $wechatauth->qrcodeCreate($sence_id, $expire_seconds);
        if(isset($result['errcode'])){
            return false;
        }else{
            return $wechatauth->showqrcode($result['ticket']);
        }
    }
}
