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

    public static function response($data, $error="")
    {
        return response(["error" => $error, "data" => $data], 200)
            ->header('Access-Control-Allow-Origin', "*")
            ->header(
                'Access-Control-Allow-Headers',
                'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN'
            )
            ->header('Access-Control-Expose-Headers', 'Authorization, authenticated')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS')
            ->header('Access-Control-Allow-Credentials', 'true');
    }

    public function index()
    {

        return 1;
    }

    public function association_list(Request $request)
    {

        $data['list']  = AssociationModel::orderBy("ticket", "desc")->get();
        foreach ($data['list'] as &$value)
        {
            $value->association_image = explode("|", $value->association_image);
        }

        return self::response($data,"");
    }

    public function get_last_ticket(Request $request)
    {
        $telPhone = $request->input("tel_phone");
        if (!$telPhone)
        {
            return self::response([],"缺少参数");
        }
        $vote_log = VoteLogModel::where("tel_phone", $telPhone)->get();

        return self::response(["num" => 40 - count($vote_log)]);
    }

    public function association_info(Request $request)
    {
        $sid = $request->input("sid");
        if (!$sid)
        {
            return self::response([],"缺少参数");
        }

        $data["error"] = "";
        $data["info"]  = AssociationModel::find($sid);
        if (empty($data["info"]))
        {
            return self::response([],"不存在该社团");
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
            return self::response([],"缺少参数");
        }
        $vote_log = VoteLogModel::where("tel_phone", $telPhone)->get();
        if (count($vote_log) >= 40)
        {
            return self::response([],"只能投40票");

        }
        foreach ($vote_log as $value)
        {
            if ($value->sid == $sid)
            {
                return self::response([],"已经投票过该社团");
            }
        }

        $log            = new VoteLogModel();
        $log->sid       = $sid;
        $log->tel_phone = $telPhone;
        $log->time      = date("Y-m-d H:i:s", time());
        $log->save();

        return self::response([]);
    }
}
