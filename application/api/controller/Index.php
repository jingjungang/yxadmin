<?php

namespace app\api\controller;


class Index extends BaseAction
{

    public function getData()
    {
        $para = $_GET;
        if ($para['token'] == '') {
            $result['code'] = 0;
        } else {
            $result['code'] = 1;
            $result['id'] = $para['id'];
            $data = model('article')->getArticles(3);

            $result['data'] = $data['data'];
            $result['page'] = $data['page'];

        }
        $para['addtime'] = time();
        echo json_encode($result);
    }

    /**
     * 登录
     * @param appid,appsecret,code,grant_type
     * @return 1.uid 2.token 3.头像url 4.昵称 5.是否VIP 6.评价数 7.更正数 8.是否认证 9.积分
     */
    public function login()
    {
        $POST = $_POST;
        $paras['js_code'] = $POST['code'];

        $paras['appid'] = 'wxb0439acb084588de';
        $paras['secret'] = '92c7228a4da4037ababfe573d0821ed6';
        $paras['grant_type'] = 'authorization_code';

        $url = 'https://api.weixin.qq.com/sns/jscode2session'; // 微信API

        $res = $this->httpGet($url, $paras);
        $li = json_decode($res, true);
        $errcode = $li['errcode'];
        if ($errcode) { //有错误
            $result['code'] = 2;
            $result['errmsg'] = $li['errmsg'];
        } else { //无错误
            $openid = $li['openid'];
            $token = $this->setToken($openid);
            $user_mod = M('user');
            $res = $user_mod->where('openid=\'' . $openid . '\'')->find();
            $result['code'] = 1;
            if ($res) {//查询有openid
                $uid = $res['id'];
                $result['uid'] = $res['id'];
                $result['token'] = $res['token'];
                $result['avatar'] = $res['avatar'];
                $result['name'] = $res['name'];
                $result['vip'] = $res['vip'];
                $result['judege'] = '';
                $result['gz'] = '';
                $result['isrz'] = '';
                $result['myscore'] = $res['myscore'];
                //登录一次更新一次token有效期
                $tokentime = strtotime(date() . ' +30 day'); //30天有效时间
                $param['tokentime'] = $tokentime;
                $uid = $user_mod->where('openid=' . $openid)->save($param);
            } else {//查询没有openid
                $param['openid'] = $openid;
                $param['token'] = $token;
                $param['tokentime'] = strtotime(date() . ' +30 day'); //30天有效时间
                $uid = $user_mod->add($param);
                $result['uid'] = $uid;
                $result['token'] = $token;
                $result['avatar'] = '';
                $result['name'] = '';
                $result['vip'] = '';
                $result['judege'] = '';
                $result['gz'] = '';
                $result['isrz'] = '';
                $result['myscore'] = '';
            }
        }
        echo json_encode($result);

    }

    // 检查token过期
    public function checkToken()
    {
        $POST = $_POST;
        $token = $POST['token'];

        $mod = M('user');
        $str = $mod->where('token=\'' . $token . '\'')->find();
        if ($str) {
            $tokentime = $str['tokentime'];
            //过期判断
            if ($tokentime < time()) {
                $result['code'] = 2;
                $result['data'] = "无效";
            } else {
                $result['code'] = 1;
                $result['data'] = "有效";
            }
        } else {
            $result['code'] = 2;
            $result['data'] = 'token not exit';
        }
        echo json_encode($result);

    }

    public function httpGet($url, $param = array())
    {
        if (!is_array($param)) {
            throw new Exception("参数必须为array");
        }
        $p = '';
        foreach ($param as $key => $value) {
            $p = $p . $key . '=' . $value . '&';
        }
        if (preg_match('/\?[\d\D]+/', $url)) {//matched ?c
            $p = '&' . $p;
        } else if (preg_match('/\?$/', $url)) {//matched ?$
            $p = $p;
        } else {
            $p = '?' . $p;
        }
        $p = preg_replace('/&$/', '', $p);
        $url = $url . $p;
        //echo $url;
        $httph = curl_init($url);
        curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");

        curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httph, CURLOPT_HEADER, 0);
        $rst = curl_exec($httph);
        curl_close($httph);
        return $rst;
    }

    /**
     *
     * 生成时间戳
     */
    public function get_3rd_session($len)
    {

        $fp = @fopen('/dev/urandom', 'rb');
        $result = '';
        if ($fp !== FALSE) {
            $result .= @fread($fp, $len);
            @fclose($fp);

        } else {
            trigger_error('Can not open /dev/urandom.');
        }
        // convert from binary to string
        $result = base64_encode($result);
        // remove none url chars
        $result = strtr($result, '+/', '-_');
        return substr($result, 0, $len);
    }

    /**
     *设置登录token  唯一性
     * @param openid
     * @retrun  String
     */
    function setToken($openid)
    {
        $str = md5(uniqid(md5(microtime(true)), true));
        $token = sha1($str . $openid);
        return $token;
    }
}

?>