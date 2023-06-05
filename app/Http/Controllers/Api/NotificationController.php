<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use App\Http\Controllers\Controller;
use App\NotificationToken;

class NotificationController extends Controller
{
    use SendResponseTrait;

    public function save_user_token(Request $request)
    {
        try{
            if(!auth('sanctum')->check()):
                return $this->SendResponse(false, 'User not logged in',[]);
            endif;
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'token' => 'required',
                'device_id' => 'required',
            ]);
            if ($validator->fails()) {
                $erorrs = $validator->errors()->first('token').''.$validator->errors()->first('server_key');
                return $this->SendResponse(false, $erorrs, []);
            }
            $data = [
                'user_id' => auth('sanctum')->user()->id,
                'token' => $request->token,
                'device_id' => $request->device_id,
            ];
            $where = [
                'user_id' => auth('sanctum')->user()->id,
                'device_id' => $request->device_id,
            ];
            NotificationToken::updateOrCreate($where,$data);
            return $this->SendResponse(true, 'Token saved', []);
        }
        catch(\Exception $e){
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function delete_user_token(Request $request)
    {
        try{
        
            if(!auth('sanctum')->check()):
                return $this->SendResponse(false, 'User not logged in',[]);
            endif;
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'device_id' => 'required',
            ]);
            if ($validator->fails()) {
                $erorrs = $validator->errors()->first('token').''.$validator->errors()->first('server_key');
                return $this->SendResponse(false, $erorrs, []);
            }
            $data = [
                'user_id' => auth('sanctum')->user()->id,
                'device_id' => $request->device_id,
            ];
            NotificationToken::where($data)->delete();
            return $this->SendResponse(true, 'Token deleted', []);
        }
        catch(\Exception $e){
            return $this->rSendResponse(false, $e->getMessage(), []);
        }
    }
}
