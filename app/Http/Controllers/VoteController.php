<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class VoteController extends Controller
{
    function test()
    {
        echo 2;
    }
    public function vote_association(Request $request)
    {
        //        $telPhone = $request->input("tel_phone");
        //        $sid      = $request->input("sid");
        //        if (!$sid || !$telPhone)
        //        {
        //            return self::response([], "缺少参数");
        //        }
        //        $vote_log = VoteLogModel::select()->where("tel_phone", $telPhone)->get();
        //        if (count($vote_log) >= 40)
        //        {
        //            return self::response([], "只能投40票");
        //
        //        }
        //
        //        foreach ($vote_log as $value)
        //        {
        //
        //            if ($value->sid == $sid)
        //            {
        //                dd($vote_log);
        //                return self::response(["{$value->sid}|{$sid}"], "已经投票过该社团");
        //            }
        //        }
        //        dd($vote_log);
        //        $log            = new VoteLogModel();
        //        $log->sid       = $sid;
        //        $log->tel_phone = $telPhone;
        //        $log->time      = date("Y-m-d H:i:s", time());
        //        $log->save();


        //        return self::response([]);
    }
}
