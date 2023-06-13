<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama | Sistem Kasir Sederhana</title>
    <!-- Mengimpor library Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
       @media print {
            body {
                -webkit-filter: grayscale(100%);
                -moz-filter: grayscale(100%);
                -ms-filter: grayscale(100%);
                filter: grayscale(100%);
            }
        }
        .container {
            max-width: 70%;
        }

        .box-label {
            border: 2px solid gray;
            background-color: gray;
            color: white;
            padding: 5px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container justify-content-center">
        <div class="card" style="background-color:#1a77c3;">
            <div class="card-header">
                <div class="row">
                    <div class="col text-left">
                        <button class="btn btn-dark">Preview</button>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-dark">Next</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="invoiceForm">
                    @csrf
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-3">
                                <label for="no_faktur" class="box-label">No. Faktur</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_faktur" name="no_faktur" value="<?= 'PSI-' . date('yd') . '-' . rand(1000, 9999); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-3">
                                <label for="kode_kasir" class="box-label">Kode Kasir</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kode_kasir" name="kode_kasir">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-3">
                                <label for="nama_kasir" class="box-label">Nama Kasir</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-3">
                                <label for="waktu" class="box-label">Waktu</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="waktu" name="waktu" readonly>
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 2px solid;">
                    <div id="dynamic-form">
                    </div>
                    <hr style="border-top: 2px solid;">
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-8 text-center">
                                <label for="total" class="box-label">Total</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-8 text-center">
                                <label for="jumlah_bayar" class="box-label">Jumlah Bayar</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row g-2 align-items-center">
                            <div class="col-sm-8 text-center">
                                <label for="kembali" class="box-label">Kembali</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="kembali" name="kembali" readonly>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-dark" id="cetakStruk">Cetak Struk</button>
                        <a type="button" href="{{ route('history-faktur') }}" class="btn btn-dark">History Faktur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mengimpor library Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            // Mengisi Nama Kasir otomatis setelah input Kode Kasir
            $('#kode_kasir').on('change', function() {
                var kodeKasir = $(this).val();
                // Lakukan permintaan AJAX ke server untuk mendapatkan Nama Kasir berdasarkan Kode Kasir
                if (kodeKasir == '' || kodeKasir == null) {
                            $('#nama_kasir').val("");
                        }
                else{
                    $.ajax({
                    url: '/get-kasir/' + kodeKasir,
                    type: 'GET',
                    success: function(response) {
                        $('#nama_kasir').val(response.nama_kasir);

                    }
                });
                }
            });

            function updateWaktu() {
                var waktu = new Date();
                var formattedTime = waktu.toISOString().slice(0, 19).replace('T', ' ');
                $('#waktu').val(formattedTime);
            }

            // Memperbarui waktu setiap detik (1000 ms)
            setInterval(updateWaktu, 1000);

            // Memperbarui waktu saat halaman dimuat
            $(document).ready(function() {
                updateWaktu();
            });

            // Fungsi untuk menghitung subtotal per item
            function calculateSubtotal(row) {
                var harga = parseFloat($(row).find('.harga').val()) || '';
                var qty = parseInt($(row).find('.qty').val()) || '';

                var subtotal = harga * qty;
                $(row).find('.subtotal').val(subtotal);
            }

            // Fungsi untuk menghitung total keseluruhan
            function calculateTotal() {
                var total = 0;
                $('.append_item_barang').each(function() {
                    var subtotal = $(this).find('.subtotal').val() || '';
                    if (parseFloat(subtotal) !== 0 && !isNaN(parseFloat(subtotal))) {
                        total += parseFloat(subtotal);
                    }
                });
                if(total == 0){
                    $('#total').val("")
                }else{
                    $('#total').val(total)
                }
            }

            // Fungsi untuk menghitung kembali
            function calculateKembali() {
                var total = parseFloat($('#total').val()) || '';
                var jumlahBayar = parseFloat($('#jumlah_bayar').val()) || '';
                if(!jumlahBayar == 0){
                    var kembali = jumlahBayar - total;
                    $('#kembali').val(kembali);
                }else{
                    $('#kembali').val("");
                }
            }

            var newRow = `
                        <div class="row mt-3 append_item_barang">
                            <input type="hidden" name="id_barang[]" class="id_barang">
                            <div class="col-md-2">
                                <label for="kode_barang" class="box-label">Kode Barang</label>
                                <input type="text" class="form-control kode_barang" name="kode_barang[]">
                            </div>
                            <div class="col-md-2">
                                <label for="nama_barang" class="box-label">Nama Barang</label>
                                <input type="text" class="form-control nama_barang" name="nama_barang[]" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="harga" class="box-label">Harga</label>
                                <input type="number" class="form-control harga" name="harga[]" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="qty" class="box-label">Qty</label>
                                <input type="number" class="form-control qty" name="qty[]" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="jumlah" class="box-label">Jumlah</label>
                                <input type="number" class="form-control subtotal" name="subtotal[]" readonly>
                            </div>
                            <div class="col-auto add-label">
                                <button class="btn btn-warning add-quantity-btn" type="button" data-type="plus">+</button>
                            </div>
                            <div class="col-auto remove-label">
                                <button class="btn btn-danger remove_item_btn_barang">-</button>
                            </div>
                        </div>`;

            $('#dynamic-form').append(newRow);
            var rowItems = $('.append_item_barang');
            rowItems.each(function(index) {
                if (index == 0) {
                    $(this).find('.remove-label').hide();
                }
            });
            $(document).ready(function() {
                // Tambahkan event handler untuk tombol tambah item
                $('.add-quantity-btn').click(function(e) {
                    var row = $(this).closest('.append_item_barang');
                    e.preventDefault();
                    $('#dynamic-form').append(newRow);
                    $(row).find('.remove-label').hide();
                    var rowItems = $('.append_item_barang');
                    rowItems.each(function(index) {
                        if (index > 0) {
                            $(this).find('label').hide();
                            $(this).find('.add-label').hide();
                        }
                    });
                });

                // Tambahkan event handler untuk tombol hapus item
                $(document).on('click', '.remove_item_btn_barang', function(e) {
                    e.preventDefault();
                    var rowItem = $(this).parent().parent();
                    $(rowItem).remove();
                    calculateTotal();
                    calculateKembali();
                });

                // Tambahkan event handler untuk perubahan kode barang
                $(document).on('input', '.kode_barang', function() {
                    var row = $(this).closest('.append_item_barang');
                    var kodeBarang = $(this).val();

                    // Lakukan permintaan AJAX untuk mendapatkan data barang berdasarkan kode barang
                    // Ganti dengan kode AJAX Anda untuk mengambil data barang sesuai dengan kode barang yang diinputkan
                    $.ajax({
                        url: '/get-barang/' + kodeBarang,
                        method: 'GET',
                        success: function(response) {
                            if (response) {
                                var idBarang = response.id_barang;
                                var namaBarang = response.nama_barang;
                                var harga = response.harga;
                                $(row).find('.id_barang').val(idBarang);
                                $(row).find('.nama_barang').val(namaBarang);
                                $(row).find('.harga').val(harga);
                                calculateSubtotal(row);
                                calculateTotal();
                                calculateKembali();

                                // Aktifkan kolom .qty
                                $(row).find('.qty').prop('disabled', false);
                            } else {
                                $(row).find('.nama_barang').val("");
                                $(row).find('.harga').val("");
                                $(row).find('.qty').val("");
                                $(row).find('.subtotal').val("");
                                calculateSubtotal(row);
                                calculateTotal();
                                calculateKembali();

                                // Nonaktifkan kolom .qty
                                $(row).find('.qty').prop('disabled', true);
                            }
                        },
                        error: function() {
                            $(row).find('.nama_barang').val("");
                            $(row).find('.harga').val("");
                            $(row).find('.qty').val("");
                            $(row).find('.subtotal').val("");
                            calculateSubtotal(row);
                            calculateTotal();
                            calculateKembali();

                            // Nonaktifkan kolom .qty
                            $(row).find('.qty').prop('disabled', true);
                        }
                    });
                });

                // Tambahkan event handler untuk perubahan qty
                $(document).on('input', '.qty', function() {
                    var row = $(this).closest('.append_item_barang');
                    calculateSubtotal(row);
                    calculateTotal();
                    if($('#jumlah_bayar').val() == '' || $('#jumlah_bayar').val() == null){
                        $('#jumlah_bayar').val("");
                    }else{
                        calculateKembali();
                    }
                });

                // Tambahkan event handler untuk perubahan jumlah bayar
                $(document).on('input', '#jumlah_bayar', function() {
                    if($('#jumlah_bayar').val() == '' || $('#jumlah_bayar').val() == null){
                        $('#kembali').val("");
                    }else{
                        calculateKembali();
                    }
                });

                $("#cetakStruk").click(function() {
                    // Mengirim permintaan Ajax ke server
                    var isValid = true;
                    $('#invoiceForm input').each(function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        return false; // Menghentikan iterasi jika ada input kosong
                    }
                    });

                    // Jika ada input yang kosong, tampilkan pesan error
                    if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Struk gagal dicetak',
                        text: 'Struk Anda telah gagal dicetak, Data pada form ada yang belum terisi',
                    });
                    return;
                    }

                    $.ajax({
                        url: "/invoice/simpan",
                        type: "POST",
                        data: $("#invoiceForm").serialize(), // Mengambil data dari form dengan ID "invoiceForm"
                        success: function(response) {
                            // Mencetak Struk
                            window.print();
                            // Mengosongkan isi form
                            document.getElementById("invoiceForm").reset();
                            // Menampilkan notifikasi SweetAlert setelah pencetakan selesai
                            Swal.fire({
                                icon: 'success',
                                title: 'Struk Berhasil Dicetak',
                                text: 'Struk Anda telah berhasil dicetak, Data Anda berhasil masuk ke History Faktur',
                            });
                        },
                        error: function(xhr) {
                            // Menangani error jika permintaan gagal
                            console.log(xhr.responseText); // Ubah atau sesuaikan dengan kebutuhan Anda
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
