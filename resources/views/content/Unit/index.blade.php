@extends('layouts.user_type.auth')

@section('content')
<link href="{{asset('css/index-unit.css')}}" rel="stylesheet" type="text/css">
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
        <div>
            <div class="container">
            </div>
            <section class="unit-section">
                <div class="unit-header">
                    <h2>Unit</h2>
                    <a href="{{ route('unit.create') }}" type='button'>
                        <button class="btn btn-add"><i class='bx bx-plus'></i> Tambah Unit</button></a>

                </div>

                <div class="search-box">
                    <input
                        type="text"
                        id="filter"
                        placeholder="Search...">
                    <i class="bx bx-search icon"></i>
                </div>

                <table class="unit-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Unit</th>
                            <th>Kode Unit</th>
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
                            <td>{{ $value->item_unit_name }}</td>
                            <td>{{ $value->item_unit_code }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('unit.destroy', $value->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-delete" type="submit"><i class='bx bx-trash'></i> Hapus</button>
                                    </form>
                                    <a href="{{ route('unit.edit', $value->id) }}" role="button" class="btn btn-edit"><i class='bx bx-edit-alt'></i> Edit</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>

    </main>
</body>
<script src="{{ asset('js/index-unit.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@endsection