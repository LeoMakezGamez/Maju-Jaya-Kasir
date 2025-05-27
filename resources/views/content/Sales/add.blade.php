@extends('layouts.user_type.auth')

@section('content')
<link href="{{asset('css/add-sales.css')}}" rel="stylesheet" type="text/css">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>


<script>
    function addItem() {
        let item_id = $('#item_id').val();
        let quantity = $('#quantity').val();
        let id = Math.floor(Math.random() * 100) + item_id;
        if (quantity == '' || quantity == '0') {
            alert('harap masukan quantity');
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{ route('sales-create-item') }}",
            data: {
                'item_id': item_id,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                let subTotal = (parseInt(data.item_unit_price) * parseInt(quantity));
                let row = `
                    <tr class='sales-item' data-id='${id}' id='sales-item-${id}'>
                        <td>${data.item_name}</td>
                        <td>${data.item_unit_price}
                            <input type='hidden' name='sales_item[${id}][quantity]' value='${quantity}'>
                            <input type='hidden' name='sales_item[${id}][item_id]' value='${item_id}'>
                            <input type='hidden' name='sales_item[${id}][item_unit_price]' value='${data.item_unit_price}'>
                            <input type='hidden' name='sales_item[${id}][subTotal]' value='${subTotal}' id='subtotal-item-${id}'>
                        </td>
                        <td>${quantity}</td>
                        <td>${subTotal}</td>
                        <td><button class='btn btn-hapus' onclick='hapusItem(${id})'><i class='bx bx-trash'></i>hapus</button></td>
                    </tr>
                    `;
                $('#sales-item-table').append(row);

                calculate();
            }
        });
    }

    function hapusItem(id) {
        $(`#sales-item-${id}`).remove();
        calculate();
    }

    function calculate() {
        let total = 0;
        $('.sales-item').each(function() {
            let id = $(this).data('id');
            total += parseInt($('#subtotal-item-' + id).val());
        });
        $('#subtotal_amount').val(total);
        $('#total_amount').val(total);


    }
</script>

<form action="{{ route('sales.store') }}" method="post">
    @csrf

    <a href="{{ route('sales.index') }}" class="btn btn-back" type="button">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>
    <div class="form-container">
        <div class="form-header">
            <h2><i class='bx bx-cart'></i> Tambah Sales</h2>
        </div>
        <form action="{{ route('item.store') }}" method="post" class="item-form">
            @csrf
            <div class="form-row">
                <div class="form-group">

                    <label for="item-name"><i class="bx bx-tag"></i> Nama Item</label>
                        <select name="item_id" id="item_id" class="js-example-basic-single">
                            @foreach ($item as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>

                </div>
                <div class="form-group">
                    <label for="item-code"><i class='bx bx-bar-chart-square'></i>Quantity</label>
                    <div class="text-dark"></div>
                    <input required placeholder="Masukan Quantity" type="number" class='form-control' name="quantity"
                        id="quantity">
                </div>

                <div class="form-group">
                    <label for="item-code"><i class='bx bx-calendar'></i>Tanggal</label>
                    <input required placeholder="tanggal" type="date" class='form-control' name="sales_invoice_date"
                        id="sales_invoice_date">

                </div>
            </div>
            <button type="button" class="btn btn-tambah" onclick="addItem()"><i class='bx bx-plus'></i>
                Tambah
            </button>

    </div>

    <br><br><br>

    <div class="form-container">
        <table class="unit-table">
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>SubTotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id='sales-item-table'>

            </tbody>
        </table>
        <tbody id='sales-item-table'>

        </tbody>
    </div>

    <br><br>

    <div class="form-container">

        <label for="item-code">Subtotal</label>
        <input required readonly placeholder="" type="number" class='form-control' name="subtotal_amount"
            id="subtotal_amount">

        <label for="item-code">Total</label>
        <input required readonly placeholder="" type="number" class='form-control' name="total_amount"
            id="total_amount">

        <label for="item-code">Bayar</label>
        <input required placeholder="" type="number" class='form-control' name="paid_amount"
            id="paid_amount">

        <br><br>
        <div class="form-actions">

            <a href="{{ route('back.to.sales') }}" class="btn btn-cancel">
                <i class="bx bx-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-submit"><i class="bx bx-save"></i> Simpan</button>
        </div>
    </div>




</form>
@endsection