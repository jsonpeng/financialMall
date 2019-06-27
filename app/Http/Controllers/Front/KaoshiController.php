<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class KaoshiController extends Controller
{
	public function index()
	{
		$paper_type = app('commonRepo')->paperTypeRepo()->all();
    	return view('front.kaoshi.index', compact('paper_type'));
	}

	public function papers(Request $request, $id)
	{
		$paper_list = app('commonRepo')->paperRepo()->allTypeList($id);
		return view('front.kaoshi.papers', compact('paper_list'));
	}

	public function question(Request $request, $id)
	{
		//$topic = app('commonRepo')->topicsRepo()->paperTopicsFirstOrAll($id,false,0,1)->first();
		return view('front.kaoshi.question', compact('id'));
	}

	public function ajaxQuestion(Request $request, $id)
	{
		$skip = 0;
		if ($request->has('skip')) {
			$skip = $request->input('skip');
		}
		$topic = app('commonRepo')->topicsRepo()->paperTopicsFirstOrAll($id,false,$skip,1)->first();
		return ['code' => 0, 'data' => $topic];
	}

	public function ajaxStoreRecord(Request $request)
	{
		$input = $request->all();

    	$varify = $this->varifyInputParam($input,['paper_id','topic_num','grade']);

    	if($varify){
    		return ['code'=>1, 'data' => '参数错误'];
    	}
    	
    	$paper = app('commonRepo')->paperRepo()->findWithoutFail($input['paper_id']);

    	if(empty($paper)){
    		return ['code'=>1, 'data' => '该试卷不存在'];
    	}

    	$input['paper_type_id'] = $paper->paper_type_id;

    	$user = auth('web')->user();

    	if(!empty($user)){
    		$input['user_id'] = $user->id;
    	}

    	if($input['grade'] >= $paper->pass_grade ){
    		$input['is_pass'] = 1;
    	}

    	$record = app('commonRepo')->testRecordsRepo()->create($input);

    	return ['code'=>0, 'data' => '考试记录添加成功'];;
	}

	/**
	 * 考试记录
	 * @Author   yangyujiazi
	 * @DateTime 2018-06-26
	 * @param    Request     $request [description]
	 * @return   [type]               [description]
	 */
	public function records(Request $request)
	{
		$user = auth('web')->user();
		$records = app('commonRepo')->testRecordsRepo()->paperTypeRecords(null,$user->id,0,50);

		return view('front.kaoshi.record', compact('records'));
	}

	public function varifyInputParam($input,$attr=[]){
    	$status = false;
    	#第二种是针对提交的指定键值
    	if(count($attr)){
	    	foreach ($attr as $key => $val) {
				if(!array_key_exists($val,$input)){
					$status = true;
				}
	    	}
    	}
		return $status;
    }
    
}
