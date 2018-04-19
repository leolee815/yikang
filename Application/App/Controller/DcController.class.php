<?php
// 本类由系统自动生成，仅供测试用途
namespace App\Controller;
use Think\Controller;

class DcController extends Controller
{
	public static $vipid;
	public static $vip;
	public $pagesize = 10;
    public function _initialize()
    {
    	if (strtolower(ACTION_NAME) != 'login') {
	        if(!$this->checkLogin()) {
	        	if(IS_AJAX) {
	        		$this->error('请先登录！');
	        	} else {
	        		$this->redirect(U('App/Dc/login'));
	        	}
	        }
    	} 
    	self::$vipid = $_SESSION['WAP']['dcid'];
    	self::$vip = $_SESSION['WAP']['dc'];
    }

    public function index()
    {
    	$m = M('Shop_order');
    	$mvip = M('Vip');
    	//下线人数
    	$likepath = self::$vip['path'] . '-' . self::$vip['id'];
    	$where['path'] = array('like', $likepath . '-%');
    	$where['pid'] = self::$vip['id'];
    	$where['_logic'] = 'OR';
    	$vipCount = $mvip->where($where)->count();
    	$sub = $mvip->where($where)->field('id')->select();
    	$subarr = array();
    	foreach ($sub as $v) {
    		array_push($subarr, $v['id']);
    	}    
    	$orderCount = $orderPrice = 0;
    	if(!empty($subarr)) {
    		$subarr = array_values($subarr);   		
    		//下线订单数
    		$map['V.id'] = array('in', $subarr);
    		$map['O.status'] = array('in', array('2', '3', '5'));
    		$orderCount = $m->alias('as O')
    		->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
    		->where($map)->count();
    		//下线订单总额
    		$orderPrice = $m->alias('as O')
    		->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
    		->where($map)
    		->sum('payprice');
    	}    	
    	$this->assign('vip', self::$vip);
    	$this->assign('vipCount', $vipCount);
    	$this->assign('orderCount', $orderCount);
    	$this->assign('orderPrice', $orderPrice);
        $this->display();
    }
    public function subordinate()
    {
    	$m = M('Vip');
    	$morder = M('Shop_order');
    	$likepath = self::$vip['path'] . '-' . self::$vip['id'];
    	$map['path'] = array('like', $likepath . '-%');
    	$map['pid'] = self::$vip['id'];
    	$map['_logic'] = 'OR';
    	$count = $m->where($map)->count();
    	$cache = $m->where($map)
	    			->order('ctime desc')
	    			->page(1,$this->pagesize)
	    			->select();
    	foreach($cache as $k => $v) {
    		$where['vipid'] = $v['id'];
    		$where['status'] = array('in', array('2', '3', '5'));
    		$totalprice = $morder->where($where)->sum('payprice');
    		$cache[$k]['total_buy'] = round($totalprice, 2);
    		$cache[$k]['total_num'] = $morder->where($where)->count();;
    	}
    	$this->assign('datamore', $count > 10 ? 1 :0);
    	$this->assign('cache', $cache);
    	$this->display();
    }
    public function orderlist()
    {
    	$m = M('Shop_order');
    	$mvip = M('Vip');
    	$likepath = self::$vip['path'] . '-' . self::$vip['id'];
    	$where['path'] = array('like', $likepath . '-%');
    	$where['pid'] = self::$vip['id'];
    	$where['_logic'] = 'OR';
    	$sub = $mvip->where($where)->field('id')->select();
    	$subarr = array();
    	foreach ($sub as $v) {
    		array_push($subarr, $v['id']);
    	}
    	$count = 0;
    	$cache = array();
    	if(!empty($subarr)) {
    		$subarr = array_values($subarr);
    		$map['V.id'] = array('in', $subarr);
    		$map['O.status'] = array('in', array('2', '3', '5'));
    		$count = $m->alias('as O')
    		->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
    		->where($map)
    		->count();
    		$cache = $m->alias('as O')
    		->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
    		->where($map)
    		->field('O.*,V.nickname,V.pid')
    		->order('O.ctime desc')
    		->page(1,$this->pagesize)
    		->select();
    		if ($cache) {
    			foreach ($cache as $k => $v) {
    				if ($v['items']) {
    					$cache[$k]['items'] = unserialize($v['items']);
    				}
    				if($v['pid']>0) {
    					$cache[$k]['pname'] = $mvip->where('id='.$v['pid'])->getField('nickname');
    				} else {
    					$cache[$k]['pname'] = '无';
    				}
    				
    			}
    		}
    	}   	
    	$this->assign('datamore', $count > $this->pagesize ? 1 :0);
    	$this->assign('cache', $cache);
    	$this->display();
    }
    public function login()
    {
    	if (IS_POST) {
    		$m = M('vip');
    		$post = I('post.');
    		if(!$post['mobile']) {
    			$this->error('手机号码不能为空！');
    		}
    		$reg = "/^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$/";
    		if(!preg_match($reg, $post['mobile'])) {
    			$this->error('手机号码格式不正确！');
    		}
    		if(!$post['password']) {
    			$this->error('密码为空！');
    		}
    		$r = $m->where("mobile='" . $post['mobile'] . "' and password='" . md5($post['password']) . "' and is_system=1")->find();
    		if ($r) {
    			//记录最后登陆
    			$data_vip['cctime'] = time();
    			$m->where('id=' . $r['id'])->save($data_vip);

    			$_SESSION['WAP']['dcid'] = $r['id'];
    			$_SESSION['WAP']['dc'] = $r;
    			$this->success("登陆成功");
    		} else {
    			$this->error("账号密码错误！");
    		}
    	} else {
    		$this->display();
    	}
    }
    
    public function logout()
    {
    	session(null);
    	$this->redirect('App/Dc/login');
    }
    public function checkLogin()
    {
    	if (!isset($_SESSION['WAP']['dcid'])) {
    		return false;
    	}
    	return true;
    }
}
