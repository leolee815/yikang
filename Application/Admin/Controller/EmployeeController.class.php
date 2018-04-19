<?php
// +----------------------------------------------------------------------
// | 员工管理基础类--Admin分组Employee类
// +----------------------------------------------------------------------
namespace Admin\Controller;

class EmployeeController extends BaseController
{

    public static $_memployee;

    public function _initialize()
    {
        //你可以在此覆盖父类方法
        parent::_initialize();
        //是否开启分销
        if (!self::$SHOP['set']['isfx']) {
        	exit;
        }
        self::$_memployee = D('employee');
    }

    //默认跳转至登陆页面
    public function index()
    {
        $this->redirect('Admin/Public/login');
    }

    // 员工列表
    public function employeeList()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '员工列表',
                'url' => U('Admin/Employee/employeeList'),
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //绑定搜索条件与分页
        $m = M('employee');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $search = I('search') ? I('search') : '';
        if ($search) {
            $map['username'] = array('like', "%$search%");
            $this->assign('search', $search);
        }
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        $cache = $m->where($map)->page($p, $psize)->select();
        $count = $m->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '员工列表', 'App-search');
        $this->assign('cache', $cache);
        $this->display();
    }

    // 员工业绩
    public function achievement()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '业绩统计',
                'url' => U('Admin/Employee/achievement'),
            ),
            '1' => array(
                'name' => '详情',
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //绑定搜索条件与分页
        $m = M('employee');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $search = I('search') ? I('search') : '';
        if ($search) {
            $map['username'] = array('like', "%$search%");
            $this->assign('search', $search);
        }
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        $cache = $m->where($map)->page($p, $psize)->select();
        $cache = D('employee')->caculateAchievement($cache);
        $count = $m->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '员工列表', 'App-search');
        $this->assign('cache', $cache);
        $this->display();
    }

    // 会员业绩
    public function vipAchievement()
    {
        $memployee = M('employee');

        $eid = I('eid') ? I('eid') : 0;
        $employee = $memployee->where(array('id' => $eid))->find();

        // 过滤员工
        if (!$employee) {
            echo "非法操作！";
            exit();
        }
        $this->assign('employee', $employee);

        // 设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '业绩统计',
                'url' => U('Admin/Employee/achievement'),
            ),
            '1' => array(
                'name' => $employee['name'] . " 会员列表",
                'url' => U('Admin/Employee/vipAchievement', array('eid' => $eid)),
            ),
            '2' => array(
                'name' => '详情',
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));

        //绑定搜索条件与分页
        $mvip = D('Vip');
        $morder = M('Shop_order');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $search = I('search') ? I('search') : '';
        if ($search) {
            $map['name|nickname'] = array('like', "%$search%");
            $this->assign('search', $search);
        }
        $map['employee'] = $eid;
        $map['is_system'] = 1;
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        $cache = $mvip->where($map)->page($p, $psize)->select();
        $cache = $mvip->caculateVipAchievement($cache, self::$SHOP['set']['fxname']);
        $count = $mvip->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '会员列表', 'App-search');
        $this->assign('cache', $cache);
        $this->display();
    }

    // 员工设置
    public function employeeSet()
    {
        $id = I('id');
        $m = M('employee');
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '员工列表',
                'url' => U('Admin/User/userList'),
            ),
            '1' => array(
                'name' => '员工编辑',
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        //处理POST提交
        if (IS_POST) {
            //die('aa');
            $data = I('post.');
            // 总权重不能超标
            $weight = $m->where(array('id' => array('neq', $id)))->sum('weight');
            if ($weight + $data['weight'] > 100) {
                $info['status'] = 0;
                $info['msg'] = '所有员工总权重不可超过100！';
                $this->ajaxReturn($info);
            }
            if ($id) {
                if ($data['userpass']) {
                    $data['userpass'] = md5($data['userpass']);
                } else {
                    unset($data['userpass']);
                }
                $re = $m->save($data);
                if (FALSE !== $re) {
                    $info['status'] = 1;
                    $info['msg'] = '设置成功！';
                } else {
                    $info['status'] = 0;
                    $info['msg'] = '设置失败！';
                }
            } else {
                $data['userpass'] = md5($data['userpass']);
                $re = $m->add($data);
                if ($re) {
                    $info['status'] = 1;
                    $info['msg'] = '设置成功！';
                } else {
                    $info['status'] = 0;
                    $info['msg'] = '设置失败！';
                }
            }
            $this->ajaxReturn($info);
        }
        // $oath = M('User_oath')->where(array('status' => 1))->select();
        // $this->assign('oath', $oath);
        //处理编辑界面
        if ($id) {
            $cache = $m->where('id=' . $id)->find();
            $this->assign('cache', $cache);
        }
        $this->display();
    }

    // 员工绑定二维码
    public function getqrcode()
    {
        $employeeid = I('eid');
        $employee = M('employee')->where(array('id' => $employeeid))->find();
        $url = self::$SYS['set']['wxurl'] . '/App/Employee/bindVip/employee/' . $employee['userpass'] . '/eid/' . $employee['id'];
        $QR = new \Util\QRcode();
        $QR::png($url);
    }

    // 解除绑定
    public function unbindVip()
    {
        $employeeid = $_GET['eid'];
        $employee = M('employee')->where(array('id' => $employeeid))->find();
        if ($employee) {
            $employee['vipid'] = 0;
            $re = M('employee')->save($employee);
            if ($re) {
                $info['status'] = 1;
                $info['msg'] = '解绑成功!';
            } else {
                $info['status'] = 0;
                $info['msg'] = '解绑失败!';
            }
        } else {
            $info['status'] = 0;
            $info['msg'] = '未知数据!';
        }
        $this->ajaxReturn($info);
    }

    // 删除员工
    public function employeeDel()
    {
        $id = $_GET['id'];//必须使用get方法
        $m = M('Employee');
        if (!$id) {
            $info['status'] = 0;
            $info['msg'] = 'ID不能为空!';
            $this->ajaxReturn($info);
        }
        $re = $m->delete($id);
        if ($re) {
            $info['status'] = 1;
            $info['msg'] = '删除成功!';
        } else {
            $info['status'] = 0;
            $info['msg'] = '删除失败!';
        }
        $this->ajaxReturn($info);
    }

    // =====================================================
    // 以下为员工个人模块控制器
    // =====================================================
    // 个人中心
    public function main()
    {
        /*
        $bread = array(
            '0' => array(
                'name' => '主控面板',
                'url' => U('Admin/Employee/main'),
            ),
        );
        $this->assign('breadhtml',$this->getBread($bread));
        */
        $this->display();
    }

    // 员工会员中心
    public function vipCenter()
    {

        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '会员列表',
                'url' => U('Admin/Vip/vipList'),
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));

        // 员工介入
        $employee = $_SESSION['CMS']['user'];
        // $temparr = array();
        // $temp = M('Vip')->field('id')->where(array('employee'=>$employee['id']))->select();
        // foreach($temp as $v){
        // 	array_push($temparr,$v['id']);
        // }
        if (!$employee) {
            echo "请重新登陆";
            exit();
        }

        $map['employee'] = $employee['id'];
        //绑定搜索条件与分页
        $m = M('Vip');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $search = I('search') ? I('search') : '';
        if ($search) {
            $map['nickname|mobile'] = array('like', "%$search%");
            $this->assign('search', $search);
        }
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        //只显示预设分销商
        $map['is_system'] = 1;
        $cache = $m->where($map)->page($p, $psize)->order('total_xxbuy DESC')->select();
        foreach ($cache as $k => $v) {
            $cache[$k]['levelname'] = M('Vip_level')->where('id=' . $cache[$k]['levelid'])->getField('name');
            if ($v['isfxgd']) {
                $cache[$k]['fxname'] = '超级VIP';
            } else {
                if ($v['isfx']) {
                    $cache[$k]['fxname'] = $_SESSION['SHOP']['set']['fxname'];
                } else {
                    $cache[$k]['fxname'] = '会员';
                }
            }
            // 写入员工数据
            if ($v['employee']) {
                $cache[$k]['employee'] = $employee[$v['employee']]['nickname'];
            } else {
                $cache[$k]['employee'] = '无';
            }
            $morder = M('Shop_order');
            $likepath = $v['path'] . '-' . $v['id'];
            $condition['V.pid'] = $v['id'];
            $condition['V.path'] = array('like', $likepath . '-%');
            $condition['_logic'] = 'OR';
            $where['_complex'] = $condition;
            $where['O.status'] = array('in', array('2', '3', '5'));
            //下级订单量
            $count = $morder
		            ->alias ( 'O' )
		            ->join ( 'LEFT JOIN ' . C ( 'DB_PREFIX' ) . 'vip as V on O.vipid=V.id' )
		            ->where($where)
		            ->count();
		    $cache[$k]['totalnum'] = $count;
            //统计业绩
            $payprice = $morder
			            ->alias ( 'O' )
			            ->join ( 'LEFT JOIN ' . C ( 'DB_PREFIX' ) . 'vip as V on O.vipid=V.id' )
			            ->where($where)
			            ->sum('payprice');
            $cache[$k]['achievement'] = round($payprice,2);
        }
        $count = $m->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '会员列表', 'App-search');
        $this->assign('cache', $cache);
        $this->display();
    }

    // 员工订单中心
    public function orderCenter()
    {
        $bread = array(
            '0' => array(
                'name' => '订单中心',
                'url' => U('Admin/Employee/index'),
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        $status = I('status');
        if ($status || $status == '0') {
            $map['O.status'] = $status;
        }
        $this->assign('status', $status);
        //绑定搜索条件与分页
        $employee = $_SESSION['CMS']['user'];
        $temparr = array();
        $temp = M('Vip')->field('id,path')->where(array('employee' => $employee['id'],'is_system'=>1))->select();
        foreach ($temp as $v) {
        	$condition['pid'] = $v['id'];
        	$likepath = $v['path'] . '-' . $v['id'];        	
        	$condition['path'] = array('like', $likepath . '-%');
        	$condition['_logic'] = 'OR';
        	$tempvipids = M('Vip')->field('id')->where($condition)->select();
        	foreach ($tempvipids as $vv) {
        		array_push($temparr, $vv['id']);
        	}
        }
        $map['vipid'] = array('in', in_parse_str($temparr));
        $m = M('Shop_order');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $keyword = I('keyword') ? I('keyword') : '';
        if ($keyword) {
        	$where['V.name'] = array('like', "%$keyword%");
        	$where['V.mobile'] = array('like', "%$keyword%");
        	$where['V.pid'] = array('eq', $keyword);
        	$where['_logic'] = 'OR';
        	$map['_complex'] = $where;
        	$this->assign('keyword', $keyword);
        }
        $name = I('name') ? I('name') : '';
        if ($name) {
        	//订单号绑定
        	$map['oid|vipmobile'] = array('like', "%$name%");
        	$this->assign('name', $name);
        }
        $date = I('date') ? I('date') : '';
        if ($date) {
        	$timeArr = explode(" - ", $date);
        	$fromtime = strtotime($timeArr[0]);
        	$endtime = strtotime($timeArr[1])+60*60*24;
        	$map['O.ctime'] = array('between',array($fromtime, $endtime));
        }
        $this->assign('date', $date);
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        $cache = $m->alias('as O')
        ->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
        ->where($map)
        ->field('O.*,V.pid,V.name as pname')
        ->page($p, $psize)
        ->order('O.ctime desc')->select();
        if ($cache) {
        	foreach ($cache as $k => $v) {
        		if ($v['items']) {
        			$cache[$k]['items'] = unserialize($v['items']);
        		}
        	}
        }
        $count = $m->alias('as O')
        ->join('LEFT JOIN `'.C('DB_PREFIX').'vip` AS V ON V.id = O.vipid')
        ->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '我的订单', 'App-search');
        $this->assign('cache', $cache);
        $this->display();
    }
    
    //CMS后台商品设置
    public function vipSet()
    {
    	$id = I('id');
    	$m = M('Vip');
    	//设置面包导航，主加载器请配置
    	$bread = array(
    			'0' => array(
    					'name' => '会员中心',
    					'url' => U('Admin/Employee/vipCenter'),
    			),
    			'1' => array(
    					'name' => '我的会员列表',
    					'url' => U('Admin/Employee/vipCenter'),
    			),
    			'1' => array(
    					'name' => '会员编辑',
    					'url' => U('Admin/Employee/vipSet', array('id' => $id)),
    			),
    	);
    	$this->assign('breadhtml', $this->getBread($bread));
    	// 员工介入
    	$employee = $_SESSION['CMS']['user'];
    	//处理POST提交
    	if (IS_POST) {
    		$data = I('post.');
    		if($data['password']) {
    			$data['password'] = md5($data['password']);
    		} else {
    			unset($data['password']);
    		}
    		if ($id) {
    			if($employee) {
    				$vip = $m->where(array('id'=>$id,'employee'=>$employee['id']))->find();
    			}
    			if(!$vip) {
    				$info['status'] = 0;
    				$info['msg'] = '会员不存在！';
    				$this->ajaxReturn($info);
    			}
    			$re = $m->save($data);
    			if (FALSE !== $re) {
    				$info['status'] = 1;
    				$info['msg'] = '设置成功！';
    			} else {
    				$info['status'] = 0;
    				$info['msg'] = '设置失败！';
    			}
    		} else {
    			$info['status'] = 0;
    			$info['msg'] = '未获取会员ID！';
    		}
    		$this->ajaxReturn($info);
    	}
    
    	//处理编辑界面
    	if ($id) {
    		$cache = $m->where('id=' . $id)->find();
    		$this->assign('cache', $cache);
    	} else {
    		$info['status'] = 0;
    		$info['msg'] = '未获取会员ID！';
    		$this->ajaxReturn($info);
    	}
    	$this->assign('shopset', self::$SHOP['set']);
    	$this->display();
    }
    //会员明细
    public function vipSubordinate() {
    	$id = I('id');
    	$m = M('Vip');
    	//设置面包导航，主加载器请配置
    	$bread = array(
    			'0' => array(
    					'name' => '会员中心',
    					'url' => U('Admin/Employee/vipCenter'),
    			),
    			'1' => array(
    					'name' => '我的会员列表',
    					'url' => U('Admin/Employee/vipCenter'),
    			),
    			'1' => array(
    					'name' => '会员明细',
    					'url' => U('Admin/Employee/vipSubordinate', array('id' => $id)),
    			),
    	);
    	$this->assign('breadhtml', $this->getBread($bread));
    	// 员工介入
    	$employee = $_SESSION['CMS']['user'];
    	//绑定搜索条件与分页
    	$mvip = D('Vip');
    	$morder = M('Shop_order');
    	if($employee) {
    		$vip = $m->where(array('id'=>$id,'employee'=>$employee['id']))->find();
    		$this->assign('vip', $vip);
    	}
    	if(!$vip) {
    		exit('会员不存在！');
    	}
    	$p = $_GET['p'] ? $_GET['p'] : 1;
    	$search = I('search') ? I('search') : '';
    	if ($search) {
    		$map['name|nickname|mobile'] = array('like', "%$search%");
    		$this->assign('search', $search);
    	}
    	$likepath = $vip['path'] . '-' . $vip['id'];
    	$map['path'] = array('like', $likepath . '%');
    	$psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
    	$cache = $mvip->where($map)->page($p, $psize)->select();
    	foreach($cache as $k=>$v) {
    		$where['vipid'] = $v['id'];
    		$where['status'] = array('in', array('2', '3', '5'));
    		$totalprice = $morder->where($where)->sum('payprice');
    		$cache[$k]['total_buy'] = round($totalprice, 2);
    		$cache[$k]['total_num'] = $morder->where($where)->count();
    	}
    	$count = $mvip->where($map)->count();
    	$this->getPage($count, $psize, 'App-loader', '会员列表', 'App-search');
    	$this->assign('cache', $cache);
    	$this->display();
    }
    // =====================================================
    // 以上为员工个人模块控制器
    // =====================================================
}

?>