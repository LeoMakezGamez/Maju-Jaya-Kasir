@extends('layouts.user_type.auth')

@section('content')


<link href="{{ asset('css/add.css') }}" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<body>
  <main>
    <div class="container">
      <div class="unit-form-header">
        <h2>Edit Category</h2>
        <a href="{{ route('category.index') }}" class="btn btn-back" type="button">
          <i class='bx bx-arrow-back'></i> Kembali
        </a>
      </div>
      <form action="{{ route('category.update', $category->id) }}" method="post" class="unit-form">
        @csrf
        @method('put')
        <form action="{{ route('category.store') }}" method="post">
          @csrf
          <div class="form-container">
            <form>
              <div class="form-group">
                <label for="nama-unit">
                  <i class="fas fa-pencil-alt"></i> Nama Category
                </label>
                <input required placeholder="Masukan Category" type="text" class='form-control'
                  name="item_category_name" id="item_category_name" value="{{ $category->item_category_name }}">
              </div>

              <div class="form-group">
                <label for="kode-unit">
                  <i class='bx bxs-barcode'></i> Kode Category
                </label>
                <input required placeholder="Masukan Kode Category" type="text" class='form-control'
                  name="item_category_code" id="item_category_code" value="{{ $category->item_category_code }}">
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