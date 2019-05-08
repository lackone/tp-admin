<?php

namespace Common\Lib;

/**
 * 自定义的后台权限管理类
 */
class MyAuth {

    protected $config = array(
        'AUTH_USER' => 'users',
        'AUTH_RULE' => 'auth_rule',
        'AUTH_GROUP_ACCESS' => 'auth_group_access',
        'AUTH_GROUP' => 'auth_group',
    );

    /**
     * 构造函数
     * @param type $config
     */
    public function __construct($config = array()) {
        if (!empty($config)) {
            $this->config = array_merge($this->config, $config);
        } else {
            if (C('AUTH_CONFIG')) {
                $this->config = array_merge($this->config, C('AUTH_CONFIG'));
            }
        }

        $prefix = C('DB_PREFIX');
        if (!empty($prefix)) {
            foreach ($this->config as &$item) {
                $item = $prefix . $item;
            }
        }
        unset($item);
    }

    /**
     * 检查权限
     */
    public function check($rule, $userId) {
        if(empty($userId)) {
            return false;
        }
        
        $ruleList = $this->getUserRules($userId);
        
        if(empty($ruleList)) {
            return false;
        }
        
        foreach ($ruleList as $item) {
            if(strtolower($item['name']) == strtolower($rule)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取用户的用户组
     */
    public function getUserGroups($userId) {
        if(empty($userId)) {
            return array();
        }
        
        $userGroups = M()->field('aga.user_id,aga.group_id,ag.name,ag.rules')
                ->table("{$this->config['AUTH_GROUP_ACCESS']} AS aga")
                ->join("LEFT JOIN {$this->config['AUTH_GROUP']} AS ag ON aga.group_id=ag.id")
                ->where("aga.user_id={$userId} AND aga.status=1")
                ->order('aga.sort ASC')
                ->select();
        return !empty($userGroups) ? $userGroups : array();
    }

    /**
     * 获取用户的权限列表
     */
    public function getUserRules($userId) {
        $userGroups = $this->getUserGroups($userId);

        $ruleIds = '';
        if (!empty($userGroups)) {
            foreach ($userGroups as $item) {
                $ruleIds .= trim($item['rules'], ',') . ',';
            }
            $ruleIdArr = array_unique(explode(',', rtrim($ruleIds, ',')));
            $ruleIds = implode(',', $ruleIdArr);

            $ruleList = M()->field('id,pid,name,title,type')
                    ->table("{$this->config['AUTH_RULE']}")
                    ->where("status=1 AND id IN({$ruleIds})")
                    ->order('sort ASC')
                    ->select();

            return !empty($ruleList) ? $ruleList : array();
        }
        return array();
    }

}
