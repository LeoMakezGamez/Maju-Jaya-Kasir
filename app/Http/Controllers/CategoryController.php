<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::get();
        // return view('content.Unit.index', ['data' => $data]);
        return view('content.Category.index', compact(var_name: 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.Category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            try {
                DB::beginTransaction();
                Category::create($request->all());
                DB::commit();
                return redirect()->route('category.index')
                    ->with([
                        'msg' => 'Input Category Sukses',
                        'type' => 'success',
                        'icon' => 'fa fa-check-circle',
                        'title' => 'Berhasil!'
                    ]);
            } catch (\Throwable $th) {
                DB::rollback();
                report($th);
                return redirect()->route('category.index')
                    ->with([
                        'msg' => 'Input Category Gagal: ' . $th->getMessage(),
                        'type' => 'danger',
                        'icon' => 'fa fa-times-circle',
                        'title' => 'Gagal!'
                    ]);
            }
        }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(
            'content.Category.edit',
            compact('category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            DB::beginTransaction();
            $category->update($request->all());
            DB::commit();
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Update Unit Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Update Unit Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }
 

    public function backToCategory()
    {
        return redirect()->route('category.index') 
            ->with([
                'msg' => 'Action canceled successfully!',
                'type' => 'warning',
                'icon' => 'fa fa-info-circle',
            ]);
    }

    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            return redirect()->route('category.index')
                ->with([
                    'msg' => 'Hapus Category Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('category.index')
                ->with([
                    'msg' => 'Hapus Category Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }
}
