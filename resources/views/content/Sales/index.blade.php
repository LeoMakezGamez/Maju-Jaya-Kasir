@extends('layouts.user_type.auth')

@section('content')
<link href="{{asset('css/index-sales.css')}}" rel="stylesheet" type="text/css">
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


    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                <h2>Sales</h2>
                <a href="{{ route('sales.create') }}" type='button'>
                    <button class="btn btn-add"><i class='bx bx-plus'></i> Tambah Sales</button></a>

            </div>
            <table class="unit-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>SubTotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $value)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $value->sales_invoice_date }}</td>
                        <td>{{ $value->subtotal_amount }}</td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('sales.destroy', $value->id) }}" method="post">
                                    @method('delete')
                                    @csrf

                                    <button class="btn btn-delete" type="submit"><i class='bx bx-trash'></i> Hapus</button>
                                </form>
                                <!--<a href="{{ route('sales.edit', $value->id) }}" role="button" class="btn btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>-->
                                <a href="{{ route('sales.print', $value->id) }}" role="button" class="btn btn-kuitansi" target="_blank"><i class='bx bx-printer'></i>Kuitansi</a>

                            </div>
                        </td>

                    </tr>
                    @endforeach
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