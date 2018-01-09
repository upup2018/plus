<?php

namespace SlimKit\PlusQuestion\API2\Controllers;

use Illuminate\Http\Request;
use Zhiyi\Plus\Models\Report as ReportModel;
use SlimKit\PlusQuestion\Models\Topic as TopicModel;
use SlimKit\PlusQuestion\Models\Answer as AnswerModel;
use SlimKit\PlusQuestion\Models\Question as QuestionModel;

class ReportController extends Controller
{
    /**
     * 举报一个问题.
     *
     * @param Request $request
     * @param QuestionModel $question
     * @param ReportModel $reportModel
     * @return mixed
     * @author BS <414606094@qq.com>
     */
    public function question(Request $request, QuestionModel $question, ReportModel $reportModel)
    {
        $auth_user = $request->user();

        $reportModel->user_id = $auth_user->id;
        $reportModel->target_user = $question->user_id;
        $reportModel->status = 0;
        $reportModel->reason = $request->input('reason');
        $reportModel->subject = sprintf('问题：%s', $question->subject);

        $question->reports()->save($reportModel);

        return response()->json(['message' => ['操作成功']], 201);
    }

    /**
     * 举报一个答案.
     *
     * @param Request $request
     * @param AnswerModel $answer
     * @param ReportModel $reportModel
     * @return mixed
     * @author BS <414606094@qq.com>
     */
    public function answer(Request $request, AnswerModel $answer, ReportModel $reportModel)
    {
        $auth_user = $request->user();

        $reportModel->user_id = $auth_user->id;
        $reportModel->target_user = $answer->user_id;
        $reportModel->status = 0;
        $reportModel->reason = $request->input('reason');
        $reportModel->subject = sprintf('问题回答：%s', mb_substr($answer->body, 0, 50));

        $answer->reports()->save($reportModel);

        return response()->json(['message' => ['操作成功']], 201);
    }
}