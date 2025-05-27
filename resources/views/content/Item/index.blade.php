@extends('layouts.user_type.auth')

@section('content')
<link href="{{asset('css/index-item.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/footer.css')}}" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<main>
    @if(session()->has('msg'))
    <div class="alert alert-{{ session()->get('type') }} alert-dismissible fade show" role="alert">
        <i class="{{ session()->get('icon') }}"></i> {{ session()->get('title') }}

        <span>{{ session()->get('msg') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class='bx bx-x'></i>
        </button>
    </div>
    @endif



</main>


<body>
    <header>
    </header>
    <main>
        <div class="container">
        </div>
        <section class="unit-section">
            <div class="unit-header">
                <h2>Item</h2>
                <a href="{{ route('item.create') }}" type='button'>
                    <button class="btn btn-add"><i class='bx bx-plus'></i> Tambah Item</button></a>

            </div>

            <div class="search-box">
                <input
                    type="text"
                    id="filter"
                    placeholder="Search...">
                <i class="bx bx-search icon"></i>
            </div>

            <!-- <form action="{{ route('item.index') }}" method="GET">
                <div class="search-box">
                    <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                    <i class="bx bx-search icon"></i>
                </div>
            </form> -->

            <table class="unit-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Kode Item</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @forelse ($data as $value)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $value->item_name }}</td>
                        <td>{{ $value->item_code }}</td>
                        <td>{{ number_format($value->item_unit_price, 2) }}</td>
                        <td>


                            <div class="action-buttons">
                                <form action="{{ route('item.destroy', $value->id) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-delete" type="submit"><i class='bx bx-trash'></i> Hapus</button>
                                </form>
                                <a href="{{ route('item.edit', $value->id) }}" role="button" class="btn btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Tidak ada data ditemukan.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </section>
        </div>
    </main>

    <script src="{{ asset('js/index.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>




@endsection