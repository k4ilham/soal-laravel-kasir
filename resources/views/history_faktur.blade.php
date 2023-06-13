<head>
    <title>History Faktur | Sistem Kasir Sederhana</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Link DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style>
        .container-table {
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .container-table table {
            border-radius: 10px;
        }

        .btn-kembali {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <div class="container container-table">
        <h1 class="text-center mt-4">History Faktur</h1>

        <table id="history-table" class="table table-striped">
            <thead>
                <tr>
                    <th>No Faktur</th>
                    <th>Kode Kasir</th>
                    <th>Nama Kasir</th>
                    <th>Waktu Input</th>
                    <th>Total</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historyFaktur as $faktur)
                <tr>
                    <td>{{ $faktur->no_faktur }}</td>
                    <td>{{ $faktur->kode_kasir }}</td>
                    <td>{{ $faktur->nama_kasir }}</td>
                    <td>{{ $faktur->waktu_input }}</td>
                    <td>{{ $faktur->total }}</td>
                    <td>{{ $faktur->jumlah_bayar }}</td>
                    <td>{{ $faktur->kembali }}</td>
                    <td>
                        <button class="btn btn-primary btn-detail" data-faktur-id="{{ $faktur->id_faktur }}">Detail Barang</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('index') }}" class="btn btn-warning mt-3">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#history-table').DataTable();
        });

        $(document).ready(function() {
            $('#history-table').DataTable();
            // Tangani klik tombol detail
            $('.btn-detail').on('click', function() {
                var fakturId = $(this).data('faktur-id');

                // Buat AJAX request untuk memuat data barang berdasarkan fakturId
                $.ajax({
                    url: '/load-barang/' + fakturId,
                    method: 'GET',
                    success: function(response) {
                        // Hapus data barang sebelumnya (jika ada)
                        $('#barang-body').empty();

                        // Tambahkan data barang ke dalam tabel
                        $.each(response.data, function(index, barang) {
                            var row = `
                            <tr>
                                <td>${barang.barang.nama_barang}</td>
                                <td>${barang.barang.harga}</td>
                                <td>${barang.qty_barang}</td>
                                <td>${barang.jumlah_harga_barang}</td>
                            </tr>
                        `;
                            $('#barang-body').append(row);
                        });

                        // Tampilkan modal
                        $('#detailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Barang</h5>
                </div>
                <div class="modal-body">
                    <table id="barang-table" class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga Barang</th>
                                <th>Qty</th>
                                <th>Jumlah Harga</th>
                            </tr>
                        </thead>
                        <tbody id="barang-body">
                            <!-- Data barang akan ditampilkan di sini -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
