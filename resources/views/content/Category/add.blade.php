@extends('layouts.user_type.auth')

@section('content')
<link href="{{ asset('css/add.css') }}" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<body>
    <main>
        <div class="container">
            <div class="unit-form-header">
                <h2>Tambah Category</h2>
                <a href="{{ route('category.index') }}" class="btn btn-back" type="button">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
            <form action="{{ route('category.store') }}" method="post" class="unit-form">
                @csrf
                <div class="form-group">
                    <label for="nama_unit">
                        <i class='bx bxs-category'></i>Nama Category
                    </label>
                    <input type="text" name="item_category_name" id="item_category_name" placeholder="Masukkan Nama Category" required>
                </div>
                <div class="form-group">
                    <label for="kode_unit">
                        <i class='bx bxs-barcode'></i> Kode Category
                    </label>
                    <input type="text" name="item_category_code" id="item_category_code" placeholder="Masukkan Kode Category" required>
                </div>
                <div class="form-buttons">
                    <a href="{{ route('back.to.category') }}" class="btn btn-cancel">
                        <i class="bx bx-x-circle"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class='bx bx-save'></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
@endsection