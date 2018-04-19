<?php
// 本类仅供测试用途
namespace App\Controller;
use Think\Controller;

class DemoController extends Controller
{
	public static $SET;//全局静态配置
	public static $WAP;//WAP全局静态变量
	public static $SHOP;// Shop全局静态变量
	public static $_wx; //缓存微信对象
	//微信缓存	
	protected static $_wxappid;
	protected static $_wxappsecret;
	//授权Session
	protected static $_sqmode;//对应$_SESSION['sqmode']-wecha,-yicha,-wap
	
    public function _initialize()
    {   //缓存全局SET
        self::$SET = $_SESSION['SET'] = $this->checkSet();
        self::$_wxappid = self::$SET['wxappid'];
        self::$_wxappsecret = self::$SET['wxappsecret'];
        
        //刷新全局会员配置
        self::$WAP['vipset'] = $_SESSION['WAP']['vipset'] = $this->checkVipSet();  
        //刷新SHOP全局配置
        self::$SHOP['set'] = $_SESSION['SHOP']['set'] = $this->checkShopSet();
        $options['appid'] = self::$_wxappid;
        $options['appsecret'] = self::$_wxappsecret;
        self::$_wx = new \Util\Wx\Wechat($options);
        $_SESSION['oaurl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
	//自动生成N个分销商
    public function index()
    {
    	//exit('Access Denied');
    	for($i=0; $i<1000;$i++) {
    		$data['pid'] = 0;
    		$data['plv'] = 1;
    		$data['path'] = 0;
    		$data['openid'] = '';
    		$data['nickname'] = '';
    		$data['sex'] = '';
    		$data['city'] = '';
    		$data['province'] = '';
    		$data['country'] = '';
    		$data['headimgurl'] = '';
    		$data['score'] = 0;
    		$data['exp'] = 0;
    		$data['cur_exp'] = 0;
    		$level = '';
    		$data['levelid'] = 0;
    		$data['ctime'] = time();
    		$data['cctime'] = time();
    		$data['isfx'] = 1;
    		$data['is_system'] = 1;
    		$userId = M("Vip")->add($data);
    		$ms = M('vip_sys');
    		if($userId) {
    			$log['vipid'] = $userId;
    			$log['is_reg'] = 0;
    			$log['qrcode'] = $this->createDoctorQrcode($userId);
    			$log['ctime'] = time();
    			$log['regtime'] = 0;
    			$ms->add($log);
    			file_put_contents('./Data/yikang_sys_fxuser.txt', '生成分销用户成功:' . date('Y-m-d H:i:s') . PHP_EOL . '通知信息:'  . PHP_EOL . '用户ID:' . $userId . PHP_EOL, FILE_APPEND);
    		}
    	}
    	exit('操作成功！');
    }
	public function logout()
	{
		session(null);
	}
    //分销商信息绑定
    public function reg()
    { 
    	$user = $_SESSION['fx_userinfo'];
    	if(!$user) {
    		$this->oa();
    		$user = $_SESSION['fx_userinfo'];
    	}
    	if (IS_POST) {
    		$m = M('vip');
    		$ms = M('vip_sys');
    		$post = I('post.');
    		//判断预设用户ID
    		if(!$post['vipid']) {
    			$info['status'] = 0;
    			$info['msg'] = '用户ID不能为空！';
    			$this->ajaxReturn($info, "json");
    		}
    		if(!$post['mobile']){
    			$info['status'] = 0;
    			$info['msg'] = '手机号码不能为空！';
    			$this->ajaxReturn($info, "json");
    		}
    		if(!preg_match("/^(13[0-9]|14[57]|15[012356789]|17[03678]|18[0-9])\d{8}$/",$post['mobile'])){
    			$info['status'] = 0;
    			$info['msg'] = '手机号码格式不正确！';
    			$this->ajaxReturn($info, "json");
    		}
    		$vip = $ms->where('vipid=' . $post['vipid'])->find();
    		if(!$vip) {
    			$info['status'] = 0;
    			$info['msg'] = '预设用户不存在！';
    			$this->ajaxReturn($info, "json");
    		} elseif($vip['is_reg']) {
    			$info['status'] = 0;
    			$info['msg'] = '该用户已经被绑定！';
    			$this->ajaxReturn($info, "json");
    		}
    		$vip = $m->where('id=' . $post['vipid'])->find();
    		if(!$vip) {
    			$info['status'] = 0;
    			$info['msg'] = '预设用户不存在！';
    			$this->ajaxReturn($info, "json");
    		} elseif($vip['openid']) {
    			$info['status'] = 0;
    			$info['msg'] = '该用户已经被绑定！';
    			$this->ajaxReturn($info, "json");
    		}
    		//判断重复注册
    		if ($m->where('mobile=' . $post['mobile'])->find()) {
    			$info['status'] = 0;
    			$info['msg'] = '此手机号已注册过！';
    			$this->ajaxReturn($info, "json");
    		}
    		if ($m->where(array('openid' => $user['openid']))->find()) {
    			$info['status'] = 0;
    			$info['msg'] = '您已注册过，请联系系统管理员！';
    			$this->ajaxReturn($info, "json");
    		}
    		$post['openid'] = $user['openid'];
    		$post['nickname'] = $user['nickname'];
    		$post['sex'] = $user['sex'];
    		$post['city'] = $user['city'];
    		$post['province'] = $user['province'];
    		$post['country'] = $user['country'];
    		$post['headimgurl'] = $user['headimgurl'];
    		$post['score'] = self::$WAP['vipset']['reg_score'];
    		$post['exp'] = self::$WAP['vipset']['reg_exp'];
    		$post['cur_exp'] = self::$WAP['vipset']['reg_exp'];
    		$level = $this->getLevel($post['exp']);
    		$post['levelid'] = $level['levelid'];
    		$post['ctime'] = time();
    		$post['cctime'] = time();
    		$r = $m->where(array('id'=>$post['vipid']))->save($post);
    		if ($r) {
    			$vip = $m->where('id=' . $post['vipid'])->find();
    			/*
    			//生成二维码
    			$background = $this->createQrcodeBg();
    			$qrcode = $this->createQrcode($vip['id'], $vip['openid']);
    			if ($qrcode) {
    				$mark == false; // 是否需要写入将图片写入文件
    				$headimg = $this->getRemoteHeadImage($vip['headimgurl']);
    				if (!$headimg) {// 没有头像先从头像库查找，再没有就选择默认头像
    					if (file_exists('./QRcode/headimg/' . $vip['openid'] . '.jpg')) { // 获取不到远程头像，但存在本地头像，需要更新
    						$headimg = file_get_contents('./QRcode/headimg/' . $vip['openid'] . '.jpg');
    					} else {
    						$headimg = file_get_contents('./QRcode/headimg/' . 'default' . '.jpg');
    					}
    					$mark = true;
    				}
    				$headimg = imagecreatefromstring($headimg);
    				// 获取头像信息 结束
    				
    				// 生成二维码推广图片=======================
    				
    				// Combine QRcode and background and HeadImg
    				$b_width = imagesx($background);
    				$b_height = imagesy($background);
    				$q_width = imagesx($qrcode);
    				$q_height = imagesy($qrcode);
    				$h_width = imagesx($headimg);
    				$h_height = imagesy($headimg);
    				imagecopyresampled($background, $qrcode, $b_width * 0.24, $b_height * 0.5, 0, 0, 297, 297, $q_width, $q_height);
    				imagecopyresampled($background, $headimg, $b_width * 0.10, 12, 0, 0, 120, 120, $h_width, $h_height);
    				
    				// Set Font Type And Color
    				$fonttype = './Public/Common/fonts/wqy-microhei.ttc';
    				$fontcolor = imagecolorallocate($background, 0x00, 0x00, 0x00);
    				
    				// Combine All And Text, Then store in local
    				imagettftext($background, 18, 0, 280, 100, $fontcolor, $fonttype, $vip['nickname']);
    				imagejpeg($background, './QRcode/promotion/' . $vip['openid'] . '.jpg');
    				// 生成二维码推广图片 结束==================
    			}
    			*/
    			$vip_sys['is_reg'] = 1;
    			//$vip_sys['qrcode'] = './QRcode/promotion/' . $vip['openid'] . '.jpg';
    			$vip_sys['mobile'] = $post['mobile'];
    			$vip_sys['openid'] = $user['openid'];
    			$vip_sys['regtime'] = time();
    			$ms->where(array('vipid' => $vip['id']))->save($vip_sys);
    			//记录日志
    			$data_log['ip'] = get_client_ip();
    			$data_log['vipid'] = $r['id'];
    			$data_log['ctime'] = time();
    			$data_log['event'] = "会员注册";
    			$data_log['score'] = $post['score'];
    			$data_log['exp'] = $post['exp'];
    			$data_log['type'] = 4;
    			M('vip_log')->add($data_log);
    
    			$info['status'] = 1;
    			$info['msg'] = '绑定成功！';
    			//$info['qrcode'] = self::$SHOP['set']['url'].$vip_sys['qrcode'];
    			$sysfx = $ms->where(array('vipid' => $vip['id']))->find();
    			$info['qrcode'] = self::$SHOP['set']['url'].$sysfx['qrcode'];
    		} else {
    			$info['status'] = 0;
    			$info['msg'] = '绑定失败！';
    		}
    		$this->ajaxReturn($info, "json");
    	} else {
    
    		$this->display();
    	}
    }
    
    //注册新用户并使其成为指定ID用户的下线
	public function reg2()
	{
		$pid = intval($_GET['pid']);
		if(!$pid) {
			$this->error('参数错误！');
		}
		$user = $_SESSION['fx_userinfo'];
		if($user == NULL) {
			$this->oa();
			$user = $_SESSION['fx_userinfo'];
		} else {
			$m = M('Vip');
			//检查用户是否已存在
			$old['openid'] = $user['openid'];
			$isold = $m->where($old)->find();
			if (!$isold) {
				$old = $m->where(array('id'=>$pid))->find();
				if ($user) {
					//新用户注册政策
					$vipset = M('Vip_set')->find();
					$user['score'] = $vipset['reg_score'];
					$user['exp'] = $vipset['reg_exp'];
					$user['cur_exp'] = $vipset['reg_exp'];
					$user['levelid'] = 1;
					//追入首次时间和更新时间
					$user['ctime'] = $user['cctime'] = time();
			
					//系统追入path 追入员工
					if ($old['id']) {
						$user['pid'] = $old['id'];
						$user['path'] = $old['path'] . '-' . $old['id'];
						$user['plv'] = $old['plv'] + 1;
						$user['employee'] = $old['employee'];
					} else {
						$user['pid'] = 0;
						$user['path'] = 0;
						$user['plv'] = 1;
						$user['employee'] = D('Employee')->randomEmployee();
					}
					$revip = $m->add($user);
			
					if ($revip) {
						//赠送操作
						if ($vipset['isgift']) {
							$gift = explode(",", $vipset['gift_detail']);
							$cardnopwd = $this->getCardNoPwd();
							$data_card['type'] = $gift[0];
							$data_card['vipid'] = $revip;
							$data_card['money'] = $gift[1];
							$data_card['usemoney'] = $gift[3];
							$data_card['cardno'] = $cardnopwd['no'];
							$data_card['cardpwd'] = $cardnopwd['pwd'];
							$data_card['status'] = 1;
							$data_card['stime'] = $data_card['ctime'] = time();
							$data_card['etime'] = time() + $gift[2] * 24 * 60 * 60;
							$rcaSrd = M('Vip_card')->add($data_card);
						}
						//发送注册通知消息
						//记录日志
						$data_log['ip'] = 'wechat';    //源自微信注册
						$data_log['vipid'] = $revip;
						$data_log['ctime'] = time();
						$data_log['openid'] = $user['openid'];
						$data_log['nickname'] = $user['nickname'];
						$data_log['event'] = "会员注册";
						$data_log['score'] = $user['score'];
						$data_log['exp'] = $user['exp'];
						$data_log['type'] = 4;
						$rlog = M('Vip_log')->add($data_log);
					} else {
						$this->error('注册失败！');
					}
					//处理父亲
					if($old) {
						$tj_score = self::$WAP['vipset']['tj_score'];
						$tj_exp = self::$WAP['vipset']['tj_exp'];
						$tj_money = self::$WAP['vipset']['tj_money'];
						if ($tj_score || $tj_exp || $tj_money) {
							$msg = "推荐新用户奖励：<br>新用户：" . $user['nickname'] . "<br>奖励内容：<br>";
							$mglog = "获得新用户注册奖励:";
							if ($tj_score) {
								$old['score'] = $old['score'] + $tj_score;
								$msg = $msg . $tj_score . "个积分<br>";
								$mglog = $mglog . $tj_score . "个积分；";
							}
							if ($tj_exp) {
								$old['exp'] = $old['exp'] + $tj_exp;
								$msg = $msg . $tj_exp . "点经验<br>";
								$mglog = $mglog . $tj_exp . "点经验；";
							}
							if ($tj_money) {
								$old['money'] = $old['money'] + $tj_money;
								$msg = $msg . $tj_money . "元余额<br>";
								$mglog = $mglog . $tj_money . "元余额；";
							}
							$msg = $msg . "此奖励已自动打入您的帐户！感谢您的支持！";
							$rold = $m->save($old);
							if (FALSE !== $rold) {
								$data_msg['pids'] = $old['id'];
								$data_msg['title'] = "你获得一份推荐奖励！";
								$data_msg['content'] = $msg;
								$data_msg['ctime'] = time();
								$rmsg = M('Vip_message')->add($data_msg);
								$data_mglog['vipid'] = $old['id'];
								$data_mglog['nickname'] = $old['nickname'];
								$data_mglog['xxnickname'] = $user['nickname'];
								$data_mglog['msg'] = $mglog;
								$data_mglog['ctime'] = time();
								$rmglog = M('Fx_log_tj')->add($data_mglog);
							}
						}
						 //三层上线追溯统计
						 $old['total_xxlink'] = $old['total_xxlink'] + 1;
						 $r1 = $m->save($old);
						 if ($old['pid']) {
								 $oldold = $m->where('id=' . $old['pid'])->find();
								 $oldold['total_xxlink'] = $oldold['total_xxlink'] + 1;
								 $r2 = $m->save($oldold);
							 if ($oldold['pid']) {
								 $oldoldold = $m->where('id=' . $oldold['pid'])->find();
								 $oldoldold['total_xxlink'] = $oldoldold['total_xxlink'] + 1;
								 $r3 = $m->save($oldoldold);
							 }
						 }
					}
					//echo '注册成功';die;
					//unset($_SESSION['fx_userinfo']);
					$this->success('注册成功！',U('App/Shop/index'));
				}
			} else {
				//echo '已注册，无须再注册';die;
				//unset($_SESSION['fx_userinfo']);
				$this->error('您已注册！',U('App/Shop/index'));
			}
		}
	}
    public function oa()
    {
    	//绑定高级鉴权返回地址和高级鉴权ppid
    	$_SESSION['oappid'] = intval($_GET['ppid']) ? intval($_GET['ppid']) : 0;
    	$_SESSION['oaemployee'] = intval($_GET['employee']) ? intval($_GET['employee']) : 0;
    	//判断是否进行base鉴权
    	if (!$_SESSION['sqmode'] || !$_SESSION['fx_userinfo']) {
	    	//微信授权
	    	if (strpos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger")) {
	    		if ($_GET['code']) {
	    			//第二次鉴权
	    			$_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    			if ($_GET['code'] != 'authdeny') {
	    				//用户授权
	    				$re = self::$_wx->getOauthAccessToken($_GET['code']);//获取access_token和openid
	    				$access_token = $re['access_token'];
	    				$openid = $re['openid'];
	    				if ($re) {
	    					$_SESSION['sqmode'] = 'wecha';
	    					$_SESSION['sqopenid'] = $openid;    
	    				} 
	    				//echo 'access_token:'.$access_token.'<br>';
	    				//echo 'openid:'.$openid.'<br>';
	    				$user = self::$_wx->getOauthUserinfo($access_token, $openid);
	    				if($user) {
	    					$_SESSION['fx_userinfo'] = $user;
	    				} else {
	    					//session(null);
	    					//$this->diemsg(0, '未正常获取会员数据，请尝试重新访问！');
	    					//跳转回去重新执行一边
	    					$rurl = $_SESSION['oaurl'];
	    					session(null);
	    					header("Location:" . $rurl);
	    				}

	    				//正常处理完成，返回原链接
	    				$rurl = $_SESSION['oaurl'];
	    				header("Location:" . $rurl);    
	    			} else {
	    				//用户未授权
	    				$this->diemsg(0, '本应用需要您的授权才可以使用!');
	    			}
	    		} else {
	    			$_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    			$squrl = self::$_wx->getOauthRedirect($_url, '1', 'snsapi_userinfo');
	    			header("Location:" . $squrl);
	    		}
	    	} else {
	    		//其他浏览器不做授权跳出
	    		$this->diemsg(0, '请使用微信浏览器访问本应用！');
	    	}
    	}
    	if ($_SESSION['sqmode'] && $_SESSION['sqopenid'] && $_SESSION['fx_userinfo']) {
	    		//注销高级鉴权缓存
	    		unset($_SESSION['oappid']);
	    		unset($_SESSION['oaurl']);
    	} else {
            session(null);
            $this->diemsg(0, '未正常获取会员数据，请尝试重新访问！');
        }
    }
    // 创建二维码
    function createQrcode($id, $openid)
    {
    	if ($id == 0 || $openid == '') {
    		return false;
    	}
    	if (!file_exists('./QRcode/qrcode/' . $openid . '.png')) {
    		//二维码进入公众号
    		$this->getQRCode($id, $openid);
    	}
    	$qrcode = imagecreatefromstring(file_get_contents('./QRcode/qrcode/' . $openid . '.png'));
    	return $qrcode;
    }
    // 创建背景
    function createQrcodeBg()
    {
    	$autoset = M('Autoset')->find();
    	if (!file_exists('./' . $autoset['qrcode_background'])) {
    		$background = imagecreatefromstring(file_get_contents('./QRcode/background/default.jpg'));
    	} else {
    		$background = imagecreatefromstring(file_get_contents('./' . $autoset['qrcode_background']));
    	}
    	return $background;
    }
    
    // 创建背景
    function createQrcodeBgEmp()
    {
    	$autoset = M('Autoset')->find();
    	if (!file_exists('./' . $autoset['qrcode_emp_background'])) {
    		$background = imagecreatefromstring(file_get_contents('./QRcode/background/default.jpg'));
    	} else {
    		$background = imagecreatefromstring(file_get_contents('./' . $autoset['qrcode_emp_background']));
    	}
    	return $background;
    }
    
    // 获取头像函数
    function getRemoteHeadImage($headimgurl)
    {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_POST, 0);
    	curl_setopt($ch, CURLOPT_URL, $headimgurl);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    	$headimg = curl_exec($ch);
    	curl_close($ch);
    	return $headimg;
    }
    public function getQRCode($id, $openid)
    {
    	//用户授权
    	$ticket = self::$_wx->getQRCode($id, 1);
    
    	M('Vip')->where(array("id" => $id))->save(array("ticket" => $ticket["ticket"]));
    	$qrUrl = self::$_wx->getQRUrl($ticket["ticket"]);
    
    	$data = file_get_contents($qrUrl);
    	file_put_contents('./QRcode/qrcode/' . $openid . '.png', $data);
    }
    
    //停止不动的信息通知页面处理
    public function diemsg($status, $msg)
    {
    	//成功为1，失败为0
    	$status = $status ? $status : '0';
    	$this->assign('status', $status);
    	$this->assign('msg', $msg);
    
    	$tpl = $this->fetch('./Tpl/App/Base_diemsg.html');
    	$this->show($tpl);
    	die();
    }
    //返回全局配置
    public function checkSet()
    {
    	$set = M('Set')->find();
    	return $set ? $set : utf8error('系统全局设置未定义！');
    }
    //返回VIP配置
    public function checkVipSet()
    {
    	$set = M('vip_set')->find();
    	return $set ? $set : utf8error('会员设置未定义！');
    }
    public function getlevel($exp)
    {
    	$data = M('vip_level')->order('exp')->select();
    	if ($data) {
    		$level = array();
    		foreach ($data as $k => $v) {
    			if ($k + 1 == count($data)) {
    				if ($exp >= $data[$k]['exp']) {
    					$level['levelid'] = $data[$k]['id'];
    					$level['levelname'] = $data[$k]['name'];
    				}
    			} else {
    				if ($exp >= $data[$k]['exp'] && $exp < $data[$k + 1]['exp']) {
    					$level['levelid'] = $data[$k]['id'];
    					$level['levelname'] = $data[$k]['name'];
    				}
    			}
    		}
    	} else {
    		return false;
    	}
    	return $level;
    }
    // 返回Shop商城名称
    public function checkShopSet()
    {
    	$set = M('Shop_set')->find();
    	$_SESSION['CMS']['set']['name'] = $set['name'];
    	return $set ? $set : utf8error('系统还未配置！');
    }  
   //生成推广二维码
   public function qrcode($vip) 
   {	
	   	$background = $this->createQrcodeBg();
	   	$qrcode = $this->createQrcode($vip['id'], $vip['openid']);
	   	if (!$qrcode) {
	   		$msg = "专属二维码 生成失败";
	   		exit($msg);
	   	}
	   	// 生产二维码基本信息，存入本地文档，获取背景 结束
	   	
	   	// 获取头像信息
	   	$mark == false; // 是否需要写入将图片写入文件
	   	$headimg = $this->$vip['headimgurl'];
	   	if (!$headimg) {// 没有头像先从头像库查找，再没有就选择默认头像
	   		if (file_exists('./QRcode/headimg/' . $vip['openid'] . '.jpg')) { // 获取不到远程头像，但存在本地头像，需要更新
	   			$headimg = file_get_contents('./QRcode/headimg/' . $vip['openid'] . '.jpg');
	   		} else {
	   			$headimg = file_get_contents('./QRcode/headimg/' . 'default' . '.jpg');
	   		}
	   		$mark = true;
	   	}
	   	$headimg = imagecreatefromstring($headimg);
	   	// 获取头像信息 结束
	   	
	   	// 生成二维码推广图片=======================
	   	
	   	// Combine QRcode and background and HeadImg
	   	$b_width = imagesx($background);
	   	$b_height = imagesy($background);
	   	$q_width = imagesx($qrcode);
	   	$q_height = imagesy($qrcode);
	   	$h_width = imagesx($headimg);
	   	$h_height = imagesy($headimg);
	   	imagecopyresampled($background, $qrcode, $b_width * 0.24, $b_height * 0.5, 0, 0, 297, 297, $q_width, $q_height);
	   	imagecopyresampled($background, $headimg, $b_width * 0.10, 12, 0, 0, 120, 120, $h_width, $h_height);
	   	
	   	// Set Font Type And Color
	   	$fonttype = './Public/Common/fonts/wqy-microhei.ttc';
	   	$fontcolor = imagecolorallocate($background, 0x00, 0x00, 0x00);
	   	
	   	// Combine All And Text, Then store in local
	   	imagettftext($background, 18, 0, 280, 100, $fontcolor, $fonttype, $vip['nickname']);
	   	imagejpeg($background, './QRcode/promotion/' . $vip['openid'] . '.jpg');
	   	return './QRcode/promotion/' . $vip['openid'] . '.jpg';
	   	// 生成二维码推广图片 结束==================
   }
   // 创建医生二维码
   function createDoctorQrcode($id)
   {
   	if ($id == 0) {
   		return false;
   	}
   	if (!file_exists('./QRcode/qrcode/doctor20171026/' . $id . '.png')) {
   		$url = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . '/App/Demo/reg2?pid=' . $id;
   		\Util\QRcode::png($url, './QRcode/qrcode/doctor20171026/' .$id. '.png', 'L', 6, 2);
   	}
   	$qrcode = imagecreatefromstring(file_get_contents('./QRcode/qrcode/doctor/' . $id . '.png'));
   	return './QRcode/qrcode/doctor/' . $id . '.png';
   }
   function test(){
	   /*
	   	$m = M('Shop_order');
	   	$cache = $m->select();
	   	foreach($cache as $k => $v) {
	   		global $result;
	   		$result = 0;
	   		$fxsid = get_topfxid($v['vipid']);
	   		$m->where('id='.$v['id'])->setField('fxsid', $fxsid);
	   	}
		*/
   }
   function test2(){
   		$map['id'] = array('egt', 8606);
   		$map['is_system'] = 1;
   		$user = M('Vip')->where($map)->field('id')->select();
   		foreach($user as $k => $v) {
   			$this->createDoctorQrcode($v['id']);
   		}
   		
   		
   }
}
