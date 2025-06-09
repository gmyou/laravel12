<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    // 사용자 잔액 조회
    public function get_cash(Request $request)
    {
        $membership_code = $request->input('membership_code');
        $user_no = $request->input('user_no');
        $user_id = $request->input('user_id');

        // Validate the input parameters
        if (empty($membership_code) || empty($user_no) || empty($user_id)) {
            return response()->json([
                'result_code' => '0400',
                'error' => 'Invalid parameters.'
            ], 400);
        }

        $customer = \DB::table('customers')
            ->where('membership_code', $membership_code)
            ->where('user_no', $user_no)
            ->where('user_id', $user_id)
            ->first();

        if (!$customer) {
            return response()->json(['result_code' => '0404', 'error' => 'Customer not found'], 404);
        }

        $result = [
            'cash' => $customer->remain_cash ?? 0,
            'bonus' => $customer->remain_bonus ?? 0,
        ];
        return response()->json(['result_code' => '0200', 'data' => $result], 200);
    }
}
