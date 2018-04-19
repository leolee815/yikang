<?php
namespace Admin\Controller;

class DemoController extends BaseController
{

    public function _initialize()
    {
        //你可以在此覆盖父类方法
        parent::_initialize();
    }

    // VIP列表
    public function vipList()
    {
        //设置面包导航，主加载器请配置
        $bread = array(
            '0' => array(
                'name' => '会员中心',
                'url' => U('Admin/Vip/#'),
            ),
            '1' => array(
                'name' => '预设分销商列表',
                'url' => U('Admin/Demo/vipList'),
            ),
        );
        $this->assign('breadhtml', $this->getBread($bread));
        // 员工介入
        $temp = M('employee')->select();
        $employee = array();
        foreach ($temp as $k => $v) {
            $employee[$v['id']] = $v;
        }
        //绑定搜索条件与分页
        $m = M('vip_sys');
        $p = $_GET['p'] ? $_GET['p'] : 1;
        $search = I('search') ? I('search') : '';
        if ($search) {
            $map['mobile'] = array('like', "%$search%");
            $this->assign('search', $search);
        }
        $psize = self::$CMS['set']['pagesize'] ? self::$CMS['set']['pagesize'] : 20;
        $cache = $m->where($map)->order(array('vipid'=>'ASC'))->page($p, $psize)->select();
        $count = $m->where($map)->count();
        $this->getPage($count, $psize, 'App-loader', '预设会员列表', 'App-search');
        $this->assign('cache', $cache);
        $shopset = self::$SHOP['set'];
        $this->assign('shopset', $shopset);
        $this->display();
    }
}