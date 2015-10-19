<?php
namespace Common\Model;
use Think\Model;
class WorkerModel extends Model {
    protected $fields = array('wid', 'username', 'password', 'name', 'isadmin', 'status');
    protected $pk = 'wid';
}