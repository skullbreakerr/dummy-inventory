<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Db;
class ProductService
{
    public function updateProduct($request)
    {
        try{
            Db::beginTransaction();
            $product = Product::where('id', $request->id)->first();
            if (!$product) {
                return [
                    'success' => false,
                    'message' => 'Product not found',
                ];
            }
            $product->item = [
                'name' => $request->name,
                'cost_price' => $request->cost_price ?? null,
                'is_active' => $request->is_active ?? false,
                'is_customizable' => $request->is_customizable ?? false,
                'description' => $request->description ?? null,
                'product_code' => $request->product_code ?? null,
            ];
            $product->save();
            Db::commit();
            return [
                'success' => true,
                'message' => 'Product Updated Successfully',
                'data' => $product
            ];
        }catch(\Exception $e){
            Db::rollBack();
            return [
                'success' => false,
                'message' => 'Failed to update Product: ' .$e->getMessage(),
            ];
        }
    }
    public function deleteProduct($request)
    {
        try {
            Db::beginTransaction();
            $uuid = rtrim($request->query('sdx'), '/');
            $data = Product::where('id', $uuid)->first();
            if (!$data) {
                return [
                    'success' => false,
                    'message' => 'Product not found',
                ];
            }

            $data->delete();
            Db::commit();
            return [
                'success' => true,
                'message' => 'Product Deleted successfully !!',
            ];
        } catch (\Exception $e) {
            Db::rollBack();
            return [
            'success' => false,
            'message' => 'Error in Deleting the Product !!:'. $e->getMessage(),
            ];
        }
    }
    public function addProduct($request)
    {
        try{
            Db::beginTransaction();
            $data = Product::create([
                'name' => $request->name,
                'cost_price' => $request->cost_price ?? null,
                'is_active' => $request->is_active ?? false,
                'is_customizable' => $request->is_customizable ?? false,
                'description' => $request->description ?? null,
                'product_code' => $request->product_code ?? null,
            ]);
            Db::commit();
            return [
                'success' => true,
                'message' => 'Product Added Successfully',
                'data' => $data
            ];
        }catch(\Exception $e){
            Db::rollBack();
            return [
                'success' => false,
                'message' => 'Failed to add Product: ' .$e->getMessage(),
            ];
        }
    }
    public function getProduct($request)
    {
        $perPage = is_numeric($request->input('per_page')) ? (int) $request->input('per_page') : 25;
        $page = is_numeric($request->input('page')) ? (int) $request->input('page') : 1;
        $search = $request->input('search', "");
        $filter = $request->input('filter', "");
        $startDate = $request->input('startDate', "");
        $endDate = $request->input('endDate', "");
        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "{$search}%")
              ->orWhere('product_id', 'like', "%{$search}%")
              ->orWhere('cost_price', 'like', "{$search}%");
            });
        }

        if ($filter) {
            $query->where('status', $filter);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $query->orderBy('created_at', 'desc');

        $product = $query->paginate($perPage, ['*'], 'page', $page);

        if ($product->isEmpty()) {
            return ['success' => false, 'message' => 'No Data Found !'];
        }

        return [
            'success' => true,
            'message' => 'Product Data',
            'data' => $product->items(),
            'meta' => [
            'current_page' => $product->currentPage(),
            'last_page' => $product->lastPage(),
            'per_page' => $product->perPage(),
            'total' => $product->total(),
            ],
        ];
    }
}