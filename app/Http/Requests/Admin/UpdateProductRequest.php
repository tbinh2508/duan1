<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('product');
        return [
            'name' => ['required', 'max:100', Rule::unique(Product::class)->ignore($id)],
            'sku' => ['required', Rule::unique(Product::class)->ignore($id)],
            'description' => 'nullable',
            'img_thumbnail' => 'nullable|image|max:2048',
            'price_regular' =>  [
                'required',
                'numeric',     // Đảm bảo rằng đây là số (bao gồm số thập phân)
                'min:0',       // Giá trị tối thiểu
                'max:99999999.99', // Giá trị tối đa, tương ứng với decimal(10,2)
            ],
            'price_sale' =>  [
                'nullable',
                'numeric',
                'min:0',       // Giá trị tối thiểu
                'max:99999999.99',
            ],
            'featured' => ['nullable', Rule::in('0', '1')],
            'views' => 'nullable',
            'category_id' => 'required',

            'product_variants' => 'required|array',
            'product_variants.*.quantity' => 'required|integer|min:0',

            'image_galleries'     => 'nullable|array',
            'image_galleries.*'   => 'nullable|image',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "Vui lòng nhập Name",
            'name.unique' => "Name đã tồn tại",

            'sku.required' => "Vui lòng nhập Sku",
            'sku.unique' => "Sku đã tồn tại",

            'img_thumbnail.image' => "Vui lòng chọn lại Image",
            'img_thumbnail.max' => "Image không được vượt quá 2MB",

            'price_regular.required' => "Vui lòng nhập Price Regular",
            'price_regular.numeric' => "Vui lòng nhập Price numeric",
            'price_regular.min' => "Price numeric phải lớn hơn 0",
            'price_regular.max' => "Price numeric quá lớn",

            'price_sale.numeric' => "Vui lòng nhập Price numeric",
            'price_sale.min' => "Price numeric phải lớn hơn 0",
            'price_sale.max' => "Price numeric quá lớn",

            'category_id'  => "Vui lòng chọn Category",

            'product_variants.*.quantity.required' => "Vui lòng nhập Quantity cho biến thể",
            'product_variants.*.quantity.integer' => "Vui lòng không để số 0 đầu tiên trong Quantity",
            'product_variants.*.quantity.min' => "Quantity phải lớn hơn hoặc bằng 0",

            'tags.required' => "Vui lòng chọn Tag",

            'image_galleries.required' => "Vui lòng chọn Gallery Image",
            'image_galleries.image' => "Vui lòng chọn lại Gallery phải là Image",
        ];
    }
}
