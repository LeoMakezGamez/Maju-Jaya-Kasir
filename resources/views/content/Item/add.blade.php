@extends('layouts.user_type.auth')

@section('content')
<link href="{{asset('css/tambah-item.css')}}" rel="stylesheet" type="text/css">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


<div class="form-container">
    <div class="form-header">
        <h2><i class="bx bx-box"></i> Tambah Item</h2>
        <a href="{{ route('item.index') }}" class="btn btn-back" type="button">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
    </div>
    <form action="{{ route('item.store') }}" method="post" class="item-form">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="item-name"><i class="bx bx-tag"></i> Nama Item</label>
                <input required placeholder="Masukan Item" type="text"
                    name="item_name" id="item_name">
            </div>
            <div class="form-group">
                <label for="item-code"><i class="bx bx-barcode"></i> Kode Item</label>
                <input required placeholder="Masukan Kode Item" type="text"
                    name="item_code" id="item_code">

            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="item-barcode"><i class="bx bx-qr"></i> Barcode Item</label>
                <input required placeholder="Masukan Barcode Item" type="text"
                    name="item_barcode" id="item_barcode">

            </div>
            <div class="form-group">
                <label for="item-stock"><i class="bx bx-package"></i> Stock Item</label>
                <input required placeholder="Masukan Stock Item" type="number"
                    name="last_balance" id="last_balance">

            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="item-purchase-price"><i class="bx bx-money"></i> Harga Beli</label>
                <input required placeholder="Masukan Harga Beli Item" type="number"
                    name="item_unit_cost" id="item_unit_cost">
            </div>
            <div class="form-group">
                <label for="item-sale-price"><i class="bx bx-credit-card"></i> Harga Jual</label>
                <input required placeholder="Masukan Harga Jual Item" type="number"
                    name="item_unit_price" id="item_unit_price">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="unit"><i class="fas fa-ruler"></i> Unit</label>
                <select class="form-select" name="item_unit_id" id="item_unit_id">
                    @foreach ($unit as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="category"><i class="bx bx-category"></i> Category</label>
                <select class="form-select" name="item_category_id" id="item_category_id">
                    @foreach ($category as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('back.to.item') }}" class="btn btn-cancel">
                <i class="bx bx-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-submit"><i class="bx bx-save"></i> Simpan</button>
        </div>
    </form>
</div>

@endsection