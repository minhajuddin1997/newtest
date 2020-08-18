<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\model\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $category=category::paginate(10);
        $response=[
            'pagination' => [
                'total' => $category->total(),
                'per_page' => $category->perPage(),
                'current_page' => $category->currentPage(),
                'last_page' => $category->lastPage(),
                'from' => $category->firstItem(),
                'to' => $category->lastItem()
            ],
            "data"=>$category
        ];
;       return response()->json($response);
    }

    public function insert(){
        if(request()->ajax()) {
            category::create([
                "name" => request()->get('name') ?? ''
            ]);
            return array("success", "Category Created Successfully.");
        }
    }


    public function update(){
        if(request()->ajax()) {
            $category=category::find(request()->get("id"));
            $category->update([
                "name" => request()->get('name') ?? ''
            ]);
            return array("success", "Category Updated Successfully.");
        }
    }

    public function delete($id){
        category::find($id)->delete();
        return array("success", "Category Deleted Successfully.");
    }
}
