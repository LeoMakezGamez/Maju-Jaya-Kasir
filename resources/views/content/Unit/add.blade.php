@extends('layouts.user_type.auth')

@section('content')
<link href="{{ asset('css/add.css') }}" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<body>
    <main>
        <div class="container">
            <div class="unit-form-header">
                <h2>Tambah Unit</h2>
                <a href="{{ route('unit.index') }}" class="btn btn-back" type="button">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
            <form action="{{ route('unit.store') }}" method="post" class="unit-form">
                @csrf
                <div class="form-group">
                    <label for="nama_unit">
                        <i class='bx bxs-package'></i> Nama Unit
                    </label>
                    <input type="text" name="item_unit_name" id="item_unit_name" placeholder="Masukkan Nama Unit" required>
                </div>
                <div class="form-group">
                    <label for="kode_unit">
                        <i class='bx bxs-barcode'></i> Kode Unit
                    </label>
                    <input type="text" name="item_unit_code" id="item_unit_code" placeholder="Masukkan Kode Unit" required>
                </div>
                <div class="form-buttons">
                    <a href="{{ route('back.to.unit') }}" class="btn btn-cancel">
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