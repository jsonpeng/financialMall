<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Log;

use App\Models\Category;

class PaperController extends Controller
{
 
 
    public function allTypes(){
        return zcjy_callback_data(app('commonRepo')->paperTypeRepo()->all());
    }

    /**
     * 获取所有试卷列表/根据题库分类id获取对应的试卷列表
     *
     * @SWG\Get(path="/api/paper/list_all/{paper_type_id}",
     *   tags={"考试接口"},
     *   summary="获取所有试卷列表/根据题库分类id获取对应的试卷列表",
     *   description="获取所有试卷列表/根据题库分类id获取对应的试卷列表,需要用户登录后使用,paper_type_id可传可不传,不传默认返回所有分类的题库列表,其中topic_num是题目数量,及格达标分数是pass_grade字段",
     *   operationId="paperAllLists",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *          name="paper_type_id",
     *          in="path",
     *          required=false,
     *          description="题库分类id,可传可不传,不传默认返回所有分类的题库列表",
     *          type="integer"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回题库试卷列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function allLists(Request $request,$paper_type_id=null){

        if(is_numeric($paper_type_id)){
            #题库分类
            $paper_type = app('commonRepo')->paperTypeRepo()->findWithoutFail($paper_type_id);

            if(empty($paper_type) && is_numeric($paper_type_id) && !empty($paper_type_id)){
                    return zcjy_callback_data('没有找到该题库',1);
            }
        }
    
        
        #对应题库分类的试卷列表
        $paper_list = app('commonRepo')->paperRepo()->allTypeList($paper_type_id);
    

        return zcjy_callback_data($paper_list);

    }

    /**
     * 根据试卷id获取对应的试题列表
     *
     * @SWG\Get(path="/api/paper/topic/{paper_id}",
     *   tags={"考试接口"},
     *   summary="根据试卷id获取对应的试题列表",
     *   description="根据试卷id获取对应的试题列表,需要用户登录后使用,paper_id必须要传",
     *   operationId="paperTopics",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *          name="paper_id",
     *          in="path",
     *          required=true,
     *          description="试卷id,必须要传",
     *          type="integer"
     *     ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="string",
     *     description="跳过多少个,不传默认是0",
     *     required=false,
     *   ),
     *
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="string",
     *     description="一次拿多少个,不传或者传0默认是全部",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回题库试卷列表,其中data中的selections字段为对应题目的选项,is_result等于1的是答案是0的不是答案",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function paperTopics(Request $request, $paper_id){
        #对应的试卷
        $paper = app('commonRepo')->paperRepo()->findWithoutFail($paper_id);

        if(empty($paper)){
                return zcjy_callback_data('没有找到该试卷',1);
        }

        $skip = 0;
        $take = 0;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) 
        {
            if($request->input('take'))
            {
                $take = $request->input('take');
            }
        }

        #对应试卷下的题目
        $topics = app('commonRepo')->topicsRepo()->paperTopicsFirstOrAll($paper_id,$skip,$take);

        return zcjy_callback_data($topics);
    }

    private function varifyInputParam($input,$attr=[]){
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

    /**
     * 存储考试记录
     *
     * @SWG\Get(path="/api/paper/store_record",
     *   tags={"考试接口"},
     *   summary="存储考试记录",
     *   description="存储考试记录,需要用户登录后使用",
     *   operationId="testRecordsStore",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="paper_id",
     *     type="string",
     *     description="考试试卷id",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="topic_num",
     *     type="string",
     *     description="答题数量",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="grade",
     *     type="string",
     *     description="答题成绩",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="user_id",
     *     type="string",
     *     description="用户id,这里做测试使用",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回题库试卷列表,其中data中的selections字段为对应题目的选项,is_result等于1的是答案是0的不是答案",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function testRecordsStore(Request $request){
        $input = $request->all();

        $varify = $this->varifyInputParam($input,['paper_id','topic_num','grade']);

        if($varify){
            return zcjy_callback_data('参数不完整',1, 'api');
        }
        
        $paper = app('commonRepo')->paperRepo()->findWithoutFail($input['paper_id']);

        if(empty($paper)){
            return zcjy_callback_data('该试卷不存在',1, 'api');
        }

        $input['paper_type_id'] = $paper->paper_type_id;

        $user = auth()->user();

        if(!empty($user)){
            $input['user_id'] = $user->id;
        }

        if($input['grade'] >= $paper->pass_grade ){
            $input['is_pass'] = 1;
        }

        $record = app('commonRepo')->testRecordsRepo()->create($input);

        return zcjy_callback_data('考试记录添加成功', 0, 'api');
    }

    /**
     * 对应用户的考试记录
     *
     * @SWG\Get(path="/api/paper/auth_records/{paper_type_id}",
     *   tags={"考试接口"},
     *   summary="对应用户的考试记录",
     *   description="对应用户的考试记录,需要用户登录后使用",
     *   operationId="testRecordsList",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="paper_type_id",
     *     type="string",
     *     description="题库id,可传可不传,不传取出所有的题库id",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="skip",
     *     type="string",
     *     description="跳过数量,默认不传是0",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="take",
     *     type="string",
     *     description="一次拿的数量,默认不传是12个",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="user_id",
     *     type="string",
     *     description="用户id,这里做测试使用",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回记录列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function testRecordsList(Request $request,$paper_type_id=null){
        #题库分类
        $paper_type = app('commonRepo')->paperTypeRepo()->findWithoutFail($paper_type_id);

        if(empty($paper_type) && is_numeric($paper_type_id)){
                return zcjy_callback_data('没有找到该题库',1);
        }

        $input = $request->all();
        $user = auth()->user();

        if(!empty($user)){
            $input['user_id'] = $user->id;
        }

        $skip = 0;
        $take = 12;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) {
            $take = $request->input('take');
        }

        if(!is_numeric($paper_type_id)){
            $paper_type_id = null;
        }

        $records = app('commonRepo')->testRecordsRepo()->paperTypeRecords($paper_type_id,$input['user_id'],$skip,$take);

        foreach ($records as $key => $value) {
            $value['paper'] = $value->paper;
        }

        return zcjy_callback_data($records);

    }






}
