<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Models\StaffMst;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use App\Helpers\AccessToken;

class StaffController extends Controller {

    //

    /*
     * @Auth : HienNV
     * @Date : 29-12-2016
     */
    public function login(Guard $auth) {

        $reason = [];
        $data = Request::all();
        $data = json_decode($data['dataPost']);
        //check param
        if (!isset($data->username) || ($data->username == '')) {
            $reason['username'] = 'username không được để trống.';
        }

        if (!isset($data->password) || ($data->password == '')) {
            $reason['password'] = 'password không được để trống.';
        }

//        if(!isset($data['device_token']) || ($data['device_token'] == '')) {
//                $reason['device_token'] = 'デバイスのトークン' . $this->GetError->getError(1);
//        }
        if (!empty($reason)) {
            $result = array(
                'result' => 0,
                'reason' => $reason
            );
        } else {
            //get data user
            $member = StaffMst::where(['staff_name' => $data->username, 'staff_password' => $data->password, 'staff_status' => 1]);
            if ($member) {
                $accessToken = AccessToken::generateAccessToken();
                $member->auth_key = $accessToken;
                $dataUpdate = [
                    'auth_key' => $accessToken,
                    'staff_expired_date_key' => date('Y-m-d H:i:s')
                ];
                $member->update($dataUpdate);
                $result = array(
                    'result' => 1,
                    'data' => array(
                        'access_token' => $accessToken
                    )
                );
            } else {
                $result = array(
                    'result' => 0,
                    'reason' => array(
                        'user_invalid' => $this->GetError->getError(8)
                    )
                );
            }
        }
        return response()->json($result);
    }

}
