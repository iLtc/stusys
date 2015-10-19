<?php
namespace Admin\Controller;
use Think\Controller;
class OutputController extends AdminController {
	public function __construct(){
        parent::__construct();

		$this->outputs = array(
			'Volunteertime' => '志愿时'
		);
    }
	
    public function index(){
		$this->assign('outputs', $this->outputs);
		$this->display();
    }
	
	public function option(){
		switch(I('type')){
			case 'Volunteertime':
				$this->assign('students', getStuArray());
				$this->display('volunteertime_option');
			break;
				
			default:
				$this->error('未知模块');
		}		
	}
	
	public function show(){
		$this->display('output_default');
	}
	
	public function view(){
		switch(I('type')){
			case 'Volunteertime':
				$times = I('times');
				$students = I('students');
				//var_dump($times ,$students);
				if($times != 'whole'){
					$start = I('start');
					$end = I('end');
					
					if(!$start || !$end) $this->error('请选择日期范围', 'javascript:window.parent.history.back();');
					else{
						$start = explode('-', $start);
						$start_stape = mktime(0, 0, 0, $start[1], $start[2], $start[0]);
						
						$end = explode('-', $end);
						$end_stape = mktime(23, 59, 59, $end[1], $end[2], $end[0]);
					}
				}
				
				$where = array(
					'a.type' => 'volunteertime',
					'a.status' => '2',
					's.stutype' => array('in', $students)
				);
				$datas = M('apply a')->join('account s ON a.uid = s.uid')->where($where)->select();
				
				$result = array();
				foreach($datas as $data){
					$form = json_decode($data['data'], true);
					$time = $form['time']['value'];
					
					$time = explode('年', $time);
					$year = $time[0];
					
					$time = explode('月', $time[1]);
					$month = $time[0];
					
					$time = explode('日', $time[1]);
					$day = $time[0];
					
					$timestape = mktime(0, 0, 0, $month, $day, $year);

					if($times == 'whole' || ($start_stape <= $timestape && $end_stape >= $timestape)){
						if(!$result[$data['sid']]['info']) $result[$data['sid']]['info'] = getStudentData($data['uid']);
						$result[$data['sid']]['datas'] .= $result[$data['sid']]['datas'] ? ', '.$data['aid'] : $data['aid'];
						$result[$data['sid']]['sum'] += $form['number']['value'];
					}
				}
				
				$this->assign('results', $result);
				$this->display('volunteertime_print');
			break;
			
			default:
				$this->error('未知模块');
		}
	}
	
	private function getOutputDir() {
		$fileArray = array();
		if (false != ($handle = opendir($this->outputDir))) {
			while ( false !== ($file = readdir ( $handle )) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".." && !strpos($file,".")) $fileArray[] = $file;
			}
			//关闭句柄
			closedir ( $handle );
		}
		return $fileArray;
	}
}