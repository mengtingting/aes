<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/2
 * Time: 13:39
 */

namespace App\Http\Controllers\API;


use App\Components\AES;
use App\Components\RequestValidator;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /*
     * 测试解密
     * By Ada
     * 2019-02-02
     */
    public function decryptData(Request $request)
    {
        $data = Utils::requestParameter($request);
//        dd($data);
//        $header = Utils::getHeaders($request);
        $requestValidationResult = RequestValidator::validator(Utils::requestParameter($request), [
//            'id' => 'required',//系统
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
//        $test = $data['test'];
        return ApiResponse::makeResponse(true, $data, ApiResponse::SUCCESS_CODE);
    }

    /*
     * 加密
     * By Ada
     * 2019-02-02
     */
    public function encryptData(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $header = Utils::getHeaders($request);
        $data = $body = json_encode($data, true);
//        dd($data);
        $data = AES::encryptData($data, $header['clientSession']);
        return ApiResponse::makeResponse(true, $data, ApiResponse::SUCCESS_CODE, $header);
    }


}