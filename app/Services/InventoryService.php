<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\Inventory;
use GuzzleHttp\Client;
class InventoryService
{
    public function updateInventory($request)
    {
        $inventory = Inventory::where('uuid', $request->uuid)->first();
        if ($inventory) {
            if ($request->has('name') || $request->has('total_value') || $request->has('qty') || $request->has('unit_price') || $request->has('seller') || $request->has('location')) {
                $inventory->item = [
                    'name' => $request->name,
                    'total_value' => $request->total_value,
                    'qty' => $request->qty,
                    'unit_price' => $request->unit_price,
                    'seller' => $request->seller,
                    'location' => $request->location,
                ];
            }
            if ($request->has('status')) {
                $inventory->status = $request->status;
            }
            if ($inventory->save()) {
                return [
                    'success' => true,
                    'message' => 'Inventory Updated Successfully',
                    'data' => $inventory
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Failed to update Inventory',
        ];
    }
    public function deleteInventory($request)
    {
        $uuid = rtrim($request->query('sdx'), '/');
        $data = Inventory::where('uuid', $uuid)->first();

        if ($data && $data->delete()) {
            return [
                'success' => true,
                'message' => 'Inventory Deleted successfully !!',
            ];
        }

        return [
            'success' => false,
            'message' => 'Error in Deleting the Inventory !!',
        ];
    }
    public function addInventory($request)
    {
        $data = Inventory::create([
            // 'user_id' => $request->user_id,
            'item' => [
                'name' => $request->name,
                'total_value' => $request->total_value,
                'qty' => $request->qty,
                'unit_price' => $request->unit_price,
                'seller' => $request->seller,
                'location' => $request->location,
            ],
            'status' => 'In Stock',
        ]);

        if ($data) {
            return [
                'success' => true,
                'message' => 'Inventory Added Successfully',
                'data' => $data
            ];
        }
        return [
            'success' => false,
            'message' => 'Failed to add Inventory',
        ];
    }
    public function getInventory($request)
    {
        $perPage = is_numeric($request->input('per_page')) ? (int) $request->input('per_page') : 25;
        $page = is_numeric($request->input('page')) ? (int) $request->input('page') : 1;
        $search = $request->input('search', "");
        $filter = $request->input('filter', "");
        $startDate = $request->input('startDate', "");
        $endDate = $request->input('endDate', "");
        // dd('Search: ' . $search . ', Filter: ' . $filter . ', Start Date: ' . $startDate . ', End Date: ' . $endDate);
        $query = Inventory::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
            $q->where('item->name', 'like', "{$search}%")
              ->orWhere('item->seller', 'like', "{$search}%")
              ->orWhere('item->location', 'like', "{$search}%");
            });
        }

        if ($filter) {
            $query->where('status', $filter);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $query->orderBy('created_at', 'desc');

        $inventory = $query->paginate($perPage, ['*'], 'page', $page);

        if ($inventory->isEmpty()) {
            return ['success' => false, 'message' => 'No Data Found !'];
        }

        return [
            'success' => true,
            'message' => 'Inventory Data',
            'data' => $inventory->items(),
            'meta' => [
            'current_page' => $inventory->currentPage(),
            'last_page' => $inventory->lastPage(),
            'per_page' => $inventory->perPage(),
            'total' => $inventory->total(),
            ],
        ];
        // $inventory = Inventory::orderBy('created_at', 'desc')->get();
        // if ($inventory) {
        //     return [
        //         'success' => true,


        //         'data' => $inventory
        //     ];
        // } else {
        //     return [
        //         'success' => false,
        //         'message' => 'No Inventory Data found',
        //     ];
        // }
    }
}