<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Unit::get();
        return view('content.Unit.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.Unit.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            Unit::create($request->all());
            DB::commit();
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Input Unit Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Input Unit Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        // Implementasi jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('content.Unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        try {
            DB::beginTransaction();
            $unit->update($request->all());
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


    public function backToUnit()
    {
        return redirect()->route('unit.index') 
            ->with([
                'msg' => 'Action canceled successfully!',
                'type' => 'warning',
                'icon' => 'fa fa-info-circle',
            ]);
    }
 
    public function destroy(Unit $unit)
    {
        try {
            DB::beginTransaction();
            $unit->delete();
            DB::commit();
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Hapus Unit Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('unit.index')
                ->with([
                    'msg' => 'Hapus Unit Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }
}