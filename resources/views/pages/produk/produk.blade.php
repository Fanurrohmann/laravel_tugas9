@extends('layouts.master')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4">Daftar Produk</h2>
        <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Product Display in Card Format -->
        <div class="row">
            @foreach ($produk as $item)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('uploads/' . $item->foto_produk) }}" class="card-img-top img-fluid"
                            alt="{{ $item->nama }}" onerror="this.onerror=null;this.src='path/to/placeholder.jpg';"
                            style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title text-primary font-weight-bold">{{ $item->nama }}</h5>
                            <p class="card-text text-success">Harga: Rp <span
                                    class="font-weight-bold">{{ number_format($item->harga, 0, ',', '.') }}</span></p>
                            <p class="card-text text-muted">Kategori: {{ $item->kategori->nama }}</p>
                            <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm cekOngkirBtn" data-bs-toggle="modal"
                                data-bs-target="#cekOngkirModal" data-produk-id="{{ $item->id }}"
                                data-produk-harga="{{ $item->harga }}">
                                Cek Ongkir
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="cekOngkirModal" tabindex="-1" aria-labelledby="cekOngkirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cekOngkirModalLabel">Cek Ongkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Message Display -->
                    <div id="error-message" class="alert alert-danger d-none"></div>

                    <form id="cekOngkirForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="province_origin" id="province_origin" class="form-control">
                                    <option value="">Pilih Provinsi Asal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="city_origin" id="city_origin" class="form-control" disabled>
                                    <option value="">Pilih Kota Asal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="province_destination" id="province_destination" class="form-control">
                                    <option value="">Pilih Provinsi Tujuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="city_destination" id="city_destination" class="form-control" disabled>
                                    <option value="">Pilih Kota Tujuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="number" name="weight" id="weight" class="form-control"
                                    placeholder="Berat (gram)">
                            </div>
                            <div class="col-md-6">
                                <select name="courier" id="courier" class="form-control">
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">Pos Indonesia</option>
                                </select>
                            </div>
                        </div>
                        <!-- Button to Check Shipping Costs -->
                        <button type="button" id="cekOngkirButton" class="btn btn-primary">Cek Ongkir</button>
                    </form>
                    <div class="row mt-3" id="cost-content">
                        <div class="ongkir-options" style="max-width: 100%; overflow-x: auto;">
                            <!-- Shipping cost results will be appended here -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3" id="pesan-container" style="display: none;">
                        <button type="button" id="pesanButton" class="btn btn-success" disabled>Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.cekOngkirBtn').on('click', function() {
                const produkId = $(this).data('produk-id');
                const produkHarga = $(this).data('produk-harga');
                $('#cekOngkirModal').data('produk-id', produkId);
                $('#cekOngkirModal').data('produk-harga', produkHarga);
            });

            function loadProvinces() {
                $.ajax({
                    url: 'http://localhost:8000/api/provinces',
                    type: 'GET',
                    success: function(result) {
                        let options = '<option value="">Pilih Provinsi</option>';
                        result.rajaongkir.results.forEach(province => {
                            options +=
                                `<option value="${province.province_id}">${province.province}</option>`;
                        });
                        $('#province_origin').html(options);
                        $('#province_destination').html(options);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching provinces:', error);
                    }
                });
            }
            loadProvinces();

            $('#province_origin').on('change', function() {
                loadCities($(this).val(), '#city_origin');
            });
            $('#province_destination').on('change', function() {
                loadCities($(this).val(), '#city_destination');
            });

            function loadCities(provinceId, citySelector) {
                if (provinceId) {
                    $.ajax({
                        url: 'http://localhost:8000/api/cities/' + provinceId,
                        type: 'GET',
                        success: function(result) {
                            let options = '<option value="">Pilih Kota</option>';
                            result.rajaongkir.results.forEach(city => {
                                options +=
                                    `<option value="${city.city_id}">${city.type} ${city.city_name}</option>`;
                            });
                            $(citySelector).removeAttr('disabled').html(options);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching cities:', error);
                        }
                    });
                }
            }

            $('#cekOngkirButton').on('click', function() {
                const origin = $('#city_origin').val();
                const destination = $('#city_destination').val();
                const weight = $('#weight').val();
                const courier = $('#courier').val();

                if (!origin || !destination || !weight || !courier) {
                    $('#error-message').removeClass('d-none').text(
                        'Harap lengkapi semua field sebelum menghitung ongkir.');
                    return;
                }
                $('#error-message').addClass('d-none');

                $.ajax({
                    url: 'http://localhost:8000/api/cost',
                    type: 'POST',
                    data: {
                        origin,
                        destination,
                        weight,
                        courier
                    },
                    success: function(result) {
                        $('#cost-content').empty(); // Kosongkan konten sebelumnya
                        result.rajaongkir.results.forEach((res) => {
                            res.costs.forEach((cost) => {
                                $('#cost-content').append(`
                                    <div class="form-check p-3 mb-3 border rounded bg-light">
                                        <input class="form-check-input ongkir-option me-3" type="radio"
                                            name="ongkir" data-cost="${cost.cost[0].value}"
                                            data-service="${cost.service}"
                                            data-etd="${cost.cost[0].etd}"> <!-- Hapus data-description -->
                                        <label class="form-check-label">
                                            ${res.name} (${cost.service}) - Rp ${cost.cost[0].value.toLocaleString()}
                                            <br>Estimasi: ${cost.cost[0].etd} hari
                                        </label>
                                    </div>
                                `);
                            });
                        });
                        $('#pesan-container').show(); // Tampilkan kontainer pemesanan
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching cost:', error);
                    }
                });

            });

            $(document).on('change', '.ongkir-option', function() {
                $('#pesanButton').removeAttr('disabled');
            });

            $('#pesanButton').on('click', function() {
                const selectedOngkirElement = $('input[name="ongkir"]:checked');

                // Ambil data dari elemen yang dipilih
                const selectedOngkir = selectedOngkirElement.data('cost'); // Nilai ongkir
                const service = selectedOngkirElement.data('service'); // Layanan ongkir
                const etd = selectedOngkirElement.data('etd'); // Estimasi waktu pengiriman
                const produkId = $('#cekOngkirModal').data('produk-id'); // ID produk
                const produkHarga = $('#cekOngkirModal').data('produk-harga'); // Harga produk

                // Pastikan untuk menghitung gross_amount sebagai produk_harga + ongkir
                const grossAmount = produkHarga + selectedOngkir;

                // Periksa apakah semua data yang diperlukan tersedia
                if (selectedOngkir && produkId && produkHarga && service && etd) {
                    // Mengirim data transaksi ke backend untuk disimpan
                    $.ajax({
                        url: "{{ route('transactions.create') }}", // Ganti dengan URL yang sesuai untuk menyimpan transaksi
                        type: 'POST',
                        data: {
                            produk_id: produkId,
                            ongkir: selectedOngkir,
                            gross_amount: grossAmount,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                // Setelah transaksi berhasil disimpan, arahkan ke halaman transaksi/create
                                window.location.href = '/transactions/create?produk_id=' +
                                    produkId + '&ongkir=' + selectedOngkir + '&gross_amount=' +
                                    grossAmount;
                            } else {
                                alert('Gagal menyimpan transaksi. Silakan coba lagi.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    alert("Harap pilih opsi ongkir dan pastikan informasi produk lengkap.");
                }
            });
        });
    </script>
@endpush
