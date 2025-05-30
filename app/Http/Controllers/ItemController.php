<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Item::get();
        return view('content.Item.index', compact('data'));

        $search = $request->input('search');

        $data = Item::when($search, function ($query, $search) {
            return $query->where('item_name', 'like', "%$search%")
                ->orWhere('item_code', 'like', "%$search%");
        })->get();

        dd($data);

        return view('content.Item.index', compact('data'));


        $search = $request->input('search');
        $search = trim(strtolower($search)); 

        $data = Item::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(item_name) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(item_code) LIKE ?', ["%$search%"]);
        })->get();
    }

    public function backToItem()
    {
        return redirect()->route('item.index') 
            ->with([
                'msg' => 'Action canceled successfully!',
                'type' => 'warning',
                'icon' => 'fa fa-info-circle',
            ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit = Unit::get()->pluck('item_unit_name', 'id');
        $category = Category::get()
            ->pluck('item_category_name', 'id');
        return view(
            'content.Item.add',
            compact('unit', 'category')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        DB::beginTransaction();
        $item = Item::create($request->all());
        $item->stok()->create($request->only('last_balance'));
        DB::commit();
        return redirect()->route('item.index')
            ->with([
                'msg' => 'Input Item Sukses',
                'type' => 'success',
                'icon' => 'fa fa-check-circle',
                'title' => 'Berhasil!'
            ]);
    } catch (\Throwable $th) {
        DB::rollback();
        dd($th);
        report($th);
        return redirect()->route('item.index')
            ->with([
                'msg' => 'Input Item Gagal',
                'type' => 'danger',
                'icon' => 'fa fa-times-circle',
                'title' => 'Gagal!'
            ]);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $unit = Unit::get()->pluck('item_unit_name', 'id');
        $category = Category::get()
            ->pluck('item_category_name', 'id');
        return view(
            'content.Item.edit',
            compact('item', 'category', 'unit')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
{
    try {
        DB::beginTransaction();
        $item->update($request->all());
        $item->stok()->update($request->only('last_balance'));
        DB::commit();
        return redirect()->route('item.index')
            ->with([
                'msg' => 'Update Item Sukses',
                'type' => 'success',
                'icon' => 'fa fa-check-circle',
                'title' => 'Berhasil!'
            ]);
    } catch (\Throwable $th) {
        DB::rollback();
        dd($th);
        report($th);
        return redirect()->route('item.index')
            ->with([
                'msg' => 'Update Item Gagal',
                'type' => 'danger',
                'icon' => 'fa fa-times-circle',
                'title' => 'Gagal!'
            ]);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try {
            DB::beginTransaction();
            $item->delete();
            $item->stok()->delete();
            DB::commit();
            return redirect()->route('item.index')
                ->with([
                    'msg' => 'Hapus Item Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            report($th);
            return redirect()->route('item.index')
                ->with([
                    'msg' => 'Hapus Item Gagal',
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }
}
