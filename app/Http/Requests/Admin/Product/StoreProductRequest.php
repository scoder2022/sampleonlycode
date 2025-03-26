<?php

namespace App\Http\Requests\Admin\Product;

use App\Rules\ProductAttributeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $attrs = Request::get('sizes');
        // $ff = $this->attr_rules($attrs);
        $rules = ['name_en' => 'required|string'];
        // foreach (config('app.available_locale') as $locale) {
        //     $rules['title_' . $locale] = 'required|string';
        // }
        $all_rules = $rules + [
            'slug' => 'nullable|unique:categories,slug',
            'quantity' => 'required|numeric',
            'status' => 'required|boolean',
            'tax' => 'required|in:Yes,No',
            'negotiable' => 'required|in:Yes,No',
            'quality' => 'required|in:Brand New,Used,Old',
            'approvals' => 'required|in:Approved,Pending,Rejected',
            'slug' => 'nullable|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sale_prices.*' => 'required|digits_between:1,999999',
            'real_prices.*' => 'required|digits_between:1,999999'
            // 'prices' => ['array', new ProductAttributeRule($this->request->all())],
        ];
        return $all_rules;
    }

    public function attr_rules($attrs)
    {
        $custom_rules = [];
        for ($i = 0; $i < count($attrs); $i++) {
            $custom_rules['sku_' . $i] = 'required';
            $custom_rules['prices_' . $i] = 'required|numeric';
            $custom_rules['colors' . $i] = 'required';
            $custom_rules['sizes_' . $i] = 'required';
        }
        return $custom_rules;
    }
}
