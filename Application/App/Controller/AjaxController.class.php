<?php
namespace App\Controller;
use Think\Controller;

class AjaxController extends Controller
{
	protected $pagesize = 10;
	
  	//我的下级
  	public function subordinateList() {
  		$vipid = $_SESSION['WAP']['dcid'];
  		if(!$vipid) {
  			$this->error('您未登录！');
  		}  		
  		$vip = $_SESSION['WAP']['dc'];
  		$page = intval(I('p')) ? intval(I('p')) : 1;
  		$m = M('Vip');
  		$morder = M('Shop_order');
  		$likepath = $vip['path'] . '-' . $vip['id'];
  		$map['path'] = array('like', $likepath . '-%');
  		$map['pid'] = self::$vip['id'];
  		$map['_logic'] = 'OR';
  		$cache = $m->where($map)
  		->order('ctime desc')
  		->page($page, $this->pagesize)
  		->select();
  		foreach($cache as $k => $v) {
  			$where['vipid'] = $v['id'];
  			$where['status'] = array('in', array('2', '3', '5'));
  			$totalprice = $morder->where($where)->sum('payprice');
  			$cache[$k]['total_buy'] = round($totalprice, 2);
  			$cache[$k]['total_num'] = $morder->where($where)->count();;
  		}
  		$this->assign('cache',$cache);
  		$tpl = $this->fetch('./Tpl/App/Ajax/SubordinateList.html');
  		$data = array(
  				'status' => 1,
  				'info' => $tpl,
  				'more' => count($cache) < $this->pagesize ? 0 : 1
  		);
  		$this->ajaxReturn($data);
  	}
    //我的订单
    public function orderList() {
    	$vipid = $_SESSION['WAP']['dcid'];
    	if(!$vipid) {
    		$this->error('您未登录！');
    	}
    	$vip = $_SESSION['WAP']['dc'];
    	$page = intval(I('p')) ? intval(I('p')) : 1;
    	$m = M('Shop_order');
    	$mvip = M('Vip');
    	$likepath = $vip['path'] . '-' . $vip['id'];
    	$where['path'] = array('like', $likepath . '-%');
    	$where['pid'] = self::$vip['id'];
    	$where['_logic'] = 'OR';
    	$sub = $mvip->where($where)->field('id')->select();
    	$subarr = array();
    	foreach ($sub as $v) {
    		array_push($subarr, $v['id']);
    	}
    	$cache = array();
    	if(!empty($subarr)) {
    		$subarr = array_values($subarr);
    		//下线订单数
    		$map['V.id'] = array('in', $subarr);
    		$map['O.status'] = array('in', array('2', '3', '5'));
    		$cache = $m->alias('as O')
    		->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
    		->where($map)
    		->field('O.*,V.nickname,V.pid')
    		->order('O.ctime desc')
    		->page($page,$this->pagesize)
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
    	$this->assign('cache',$cache);
    	$tpl = $this->fetch('./Tpl/App/Ajax/OrderList.html');
    	$data = array(
    			'status' => 1,
    			'info' => $tpl,
    			'more' => count($cache) < $this->pagesize ? 0 : 1
    	);
    	$this->ajaxReturn($data);
    }
}