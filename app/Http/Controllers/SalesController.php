<?php

namespace App\Http\Controllers;

use TCPDF;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Sales;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Sales::get();
        return view('content.Sales.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit = Unit::get()->pluck('item_unit_name', 'id');
        $category = Category::get()
            ->pluck('item_category_name', 'id');
        $item = Item::get()->pluck('item_name', 'id');
        return view(
            'content.Sales.add',
            compact('unit', 'item', 'category')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sales_item' => 'required|array',
            'sales_item.*.item_id' => 'required|exists:items,id',
            'sales_item.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            $sales = Sales::create($request->all());
            foreach ($request->sales_item as $val) {
                $sales->items()->create($val);
                $item = Item::find($val['item_id']);
                $stock = $item->stok()->first();
                $stock->update(['last_balance' => $stock->last_balance - $val['quantity']]);
            }
            DB::commit();
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Input Sales Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Input Sales Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sale)
    {
        //
        // dd($sale);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }



    // public function print($sales)
    // {
    //     $salesInvoice = Sales::with(['items.item'])
    //         ->where('data_state', 0)
    //         ->where('id', $sales)
    //         ->first();

    //         // dd($sales);

    //     // Buat instance TCPDF dengan ukuran kertas custom untuk struk
    //     $pdf = new TCPDF('P', 'mm', array(80, 200)); // 80 mm lebar, 200 mm panjang
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('Nama Penulis');
    //     $pdf->SetTitle('Kuitansi Penjualan');
    //     $pdf->SetSubject('Kuitansi Penjualan');
    //     $pdf->SetMargins(5, 5, 5); // Margins kecil untuk struk

    //     // Tambahkan halaman baru
    //     $pdf->AddPage();

    //     // Judul Kwitansi
    //     $pdf->SetFont('helvetica', 'B', 12);
    //     $pdf->Cell(0, 10, 'Kuitansi Penjualan', 0, 1, 'C');


    //     // Data Kwitansi
    //     $pdf->SetFont('helvetica', '', 10);
    //     $pdf->Ln(2);

    //     $html = '
    //         <table cellpadding="3" cellspacing="0" border="0">
    //             <tr>
    //                 <td><strong>No. Kwitansi:</strong></td>
    //                 <td>' . $salesInvoice->id . '</td>
    //             </tr>
    //             <tr>
    //                 <td><strong>Tanggal:</strong></td>
    //                 <td>' . Carbon::parse($salesInvoice->sales_invoice_date)->format('d-m-Y') . '</td>
    //             </tr>
    //             <tr>
    //                 <td><strong>Pelanggan:</strong></td>
    //                 <td>' . $salesInvoice->customer_name . '</td>
    //             </tr>
    //         </table>
    //     ';

    //     $pdf->writeHTML($html, true, false, true, false, '');

    //     // Loop untuk item penjualan
    //     $pdf->Ln(5);
    //     $pdf->SetFont('helvetica', 'B', 10);
    //     $pdf->Cell(0, 10, 'Detail Item:', 0, 1, 'L');

    //     $pdf->SetFont('helvetica', '', 9);
    //     $htmlItems = '<table cellpadding="2" cellspacing="0" border="1" width="100%">
    //         <tr>
    //             <th>Nama Item</th>
    //             <th>Qty</th>
    //             <th>Harga</th>
    //             <th>Total</th>
    //         </tr>';

    //     foreach ($salesInvoice->items as $item) {
    //         $htmlItems .= '
    //             <tr>
    //                 <td>' . $item->item->item_name . '</td>
    //                 <td>' . $item->quantity . '</td>
    //                 <td>Rp ' . number_format($item->item_unit_price, 2, ',', '.') . '</td>
    //                 <td>Rp ' . number_format($item->item_unit_price *  $item->quantity , 2, ',', '.') . '</td>
    //             </tr>
    //         ';
    //     }

    //     $htmlItems .= '</table>';
    //     $pdf->writeHTML($htmlItems, true, false, true, false, '');

    //     // Total Pembayaran
    //     $pdf->Ln(5);
    //     $pdf->SetFont('helvetica', 'B', 10);
    //     $pdf->Cell(0, 10, 'Total: Rp ' . number_format($salesInvoice->subtotal_amount, 2, ',', '.'), 0, 1, 'R');

    //     // Tanda tangan
    //     $pdf->Ln(10);
    //     $pdf->Cell(0, 10, 'Tanda Tangan', 0, 1, 'R');
    //     $pdf->Ln(15);
    //     $pdf->Cell(0, 10, '(Nama Penerima)', 0, 1, 'R');

    //     // Output PDF
    //     $pdf->Output('Kwitansi_Penjualan_' . $sales . '.pdf', 'I');
    // }



    public function print($sales)
    {
        $salesInvoice = Sales::with(['items.item'])
            ->where('data_state', 0)
            ->where('id', $sales)
            ->first();

        $pdf = new TCPDF('P', 'mm', array(80, 190));
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();

        $logoPath = public_path('images/logo.png');
        $logoHTML = '';

        if (file_exists($logoPath)) {
            $logoHTML = '<img src="' . $logoPath . '" width="100"><br>';
        }

        $headerHTML = '
    <div style="text-align: center;">
        ' . $logoHTML . '
        <span style="font-size: 8px;">Jl Slamet Riyadi No 44 Kartasura RT 01 RW 13</span><br>
        <span style="font-size: 8px;">No. Telp: 081393754000</span><br>
        <strong style="font-size: 8px;">' . uniqid() . '</strong>
    </div>
    <hr style="border: 1px dashed;">';

        $pdf->writeHTML($headerHTML, true, false, true, false, '');

        $currentTime = Carbon::now()->format('H:i');

        $infoHTML = '
    <table style="font-size: 10px; width: 100%; margin-bottom: 5px;">
        <tr>
            <td>Tanggal:</td>
            <td>' . Carbon::parse($salesInvoice->sales_invoice_date)->format('Y-m-d') . '</td>
        </tr>
       <tr>
    <td>Waktu &nbsp;&nbsp;:</td>
    <td>' . $currentTime . '</td>
</tr>
        <tr>
            <td>Kasir &nbsp;&nbsp;&nbsp;&nbsp;:</td>
            <td>' . ($salesInvoice->cashier_name ?? 'Nita Setyati 
') . '</td>
        </tr>
    </table>
    <hr style="border: 1px dashed;">';

        $pdf->writeHTML($infoHTML, true, false, true, false, '');

        $pdf->SetFont('helvetica', '', 9);
        $itemsHTML = '<table style="width: 100%; font-size: 8px;">';
        $i = 1;

        $itemsHTML = '<table cellpadding="2" cellspacing="0" border="0" width="100%">
    <tr>
        <th><b>Nama Item</b></th>
        <th><b>Qty</b></th>
        <th><b>Harga</b></th>
        <th><b>Total</b></th>
    </tr>';

        foreach ($salesInvoice->items as $item) {
            if ($item->item) {
                $itemsHTML .= '
            <tr>
                <td>' . $item->item->item_name . '</td>
                <td>' . $item->quantity . '</td>
                <td>' . number_format($item->item_unit_price, 2, ',', '.') . '</td>
                <td>' . number_format($item->item_unit_price *  $item->quantity, 2, ',', '.') . '</td>
            </tr>
            <br>
        ';
            }
        }


        $itemsHTML .= '</table>';
        $pdf->writeHTML($itemsHTML, true, false, true, false, '');

        $totalHTML = '
    <hr style="border: 1px dashed;">
    <table style="width: 100%; font-size: 10px;">
        <tr>
            <td>Total QTY:</td>
            <td align="right">' . array_sum(array_column($salesInvoice->items->toArray(), 'quantity')) . '</td>
        </tr>
        <tr>
            <td>Sub Total:</td>
            <td align="right">Rp ' . number_format($salesInvoice->subtotal_amount, 0, ',', '.') . '</td>
        </tr>
        <tr>
            <td><strong>Total:</strong></td>
            <td align="right"><strong>Rp ' . number_format($salesInvoice->total_amount, 0, ',', '.') . '</strong></td>
        </tr>
        <tr>
            <td>Bayar (Cash):</td>
            <td align="right">Rp ' . number_format($salesInvoice->paid_amount, 0, ',', '.') . '</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td align="right">Rp ' . number_format($salesInvoice->paid_amount - $salesInvoice->total_amount, 0, ',', '.') . '</td>
        </tr>
    </table>
    <hr style="border: 1px dashed;">';
        $pdf->writeHTML($totalHTML, true, false, true, false, '');

        // Footer
        $footerHTML = '
    <br>
    <div style="text-align: center; font-size: 10px; margin-top: 10px;">
        <strong>Terimakasih Telah Berbelanja</strong><br>
    </div>';
        $pdf->writeHTML($footerHTML, true, false, true, false, '');

        // Output PDF
        $pdf->Output('Struk_Penjualan_' . $sales . '.pdf', 'I');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        $request->validate([
            'sales_item' => 'required|array',
            'sales_item.*.item_id' => 'required|exists:items,id',
            'sales_item.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            $sales->update($request->all());
            // Update logic for items if necessary
            DB::commit();
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Update Sales Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Update Sales Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }

    public function backToSales()
    {
        return redirect()->route('sales.index') 
            ->with([
                'msg' => 'Action canceled successfully!',
                'type' => 'warning',
                'icon' => 'fa fa-info-circle',
            ]);
    }

    public function destroy(Sales $sale)
    {
        try {
            DB::beginTransaction();
            $sale->delete();
            $sale->items()->delete();
            DB::commit();
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Hapus Sales Sukses',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                    'title' => 'Berhasil!'
                ]);
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            return redirect()->route('sales.index')
                ->with([
                    'msg' => 'Hapus Sales Gagal: ' . $th->getMessage(),
                    'type' => 'danger',
                    'icon' => 'fa fa-times-circle',
                    'title' => 'Gagal!'
                ]);
        }
    }




    public function addItem(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        return response()->json($item);
    }
}
