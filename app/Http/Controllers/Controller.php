<?php

namespace App\Http\Controllers;

use App\AssociationModel;
use App\VoteLogModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function association_list(Request $request)
    {
        $data["error"] = "";
        $data['list']  = AssociationModel::orderBy("ticket", "desc")->get();
        foreach ($data['list'] as &$value)
        {
            $value->association_image = explode("|", $value->association_image);
        }

        return $data;
    }

    public function get_last_ticket(Request $request)
    {
        $telPhone = $request->input("tel_phone");
        if (!$telPhone)
        {
            return ["error" => "缺少参数"];
        }
        $vote_log = VoteLogModel::where("tel_phone", $telPhone)->get();

        return ["error" => "", "last" => 40 - count($vote_log)];
    }

    public function association_info(Request $request)
    {
        $sid = $request->input("sid");
        if (!$sid)
        {
            return ["error" => "缺少参数"];
        }

        $data["error"] = "";
        $data["info"]  = AssociationModel::find($sid);
        if (empty($data["info"]))
        {
            return ["error" => "不存在该社团"];
        }
        $data["info"]->association_image = explode("|", $data["info"]->association_image);

        return $data;
    }

    public function vote_association(Request $request)
    {
        $telPhone = $request->input("tel_phone");
        $sid      = $request->input("sid");
        if (!$sid || !$telPhone)
        {
            return ["error" => "缺少参数"];
        }
        $vote_log = VoteLogModel::where("tel_phone", $telPhone)->get();
        if (count($vote_log) >= 40)
        {
            return ["error" => "只能投40票"];
        }
        foreach ($vote_log as $value)
        {
            if ($value->sid == $sid)
            {
                return ["error" => "已经投票过该社团"];
            }
        }

        $log            = new VoteLogModel();
        $log->sid       = $sid;
        $log->tel_phone = $telPhone;
        $log->time      = date("Y-m-d H:i:s", time());
        $log->save();

        return ["error" => ""];
    }
}
