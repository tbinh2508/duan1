<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function update(Request $request, string $id)
    {
        try {
            $CartItem = CartItem::query()->find($id);
            if (!$CartItem) {
                return response()->json([
                    'code' => 0,
                    'message' => "Không tồn tại sản phẩm trong giỏ hàng !!!"
                ]);
            }
            $CartItem->update($request->all());
            return response()->json([
                'code' => 1,
                'message' => "Thao tác thành công  !!!"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 0,
                'message' => "Thao tác không thành công !!!"
            ]);
        }
    }
}