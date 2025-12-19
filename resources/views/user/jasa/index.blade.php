@extends('layouts.user')

@section('title', 'Daftar Harga Jasa Service Lengkap - Bengkel Momo')

@section('content')

{{-- CSS --}}
<style>
    .page-header {
        background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ asset('images/banner-1.jpeg') }}');
        background-size: cover;
        background-position: center;
        padding: 60px 0;
        border-bottom: 2px solid var(--primary-red);
        margin-bottom: 40px;
    }
    .table-container {
        background-color: var(--surface-dark);
        border: 1px solid var(--border-dark);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.4);
    }
    .custom-table { width: 100%; border-collapse: collapse; color: var(--text-main); }
    .custom-table thead { background-color: #1a1a1a; border-bottom: 2px solid var(--primary-red); }
    .custom-table th { padding: 15px; text-align: left; font-weight: 700; color: var(--primary-red); text-transform: uppercase; font-size: 0.9rem; }
    .custom-table td { padding: 12px 15px; border-bottom: 1px solid #333; vertical-align: middle; font-size: 0.95rem; }
    .custom-table tr:hover { background-color: #1f1f1f; }
    .badge-category { font-size: 0.75rem; padding: 4px 8px; border-radius: 4px; background: #333; color: var(--text-muted); border: 1px solid #444; display: inline-block; }
    .price-tag { font-weight: 700; color: var(--primary-green); font-family: monospace; font-size: 1rem; }
    .search-jasa { background: var(--surface-dark); border: 1px solid var(--border-dark); color: white; padding: 12px 20px; border-radius: 50px; width: 100%; font-size: 1rem; transition: 0.3s; }
    .search-jasa:focus { border-color: var(--primary-red); outline: none; }
    
    /* Styles untuk Modal Gelap */
    .modal-content {
        background-color: #1A1A1A;
        color: white;
        border: 1px solid #333;
    }
    .modal-header { border-bottom: 1px solid #333; }
    .modal-footer { border-top: 1px solid #333; }
    .form-control-dark {
        background-color: #000;
        border: 1px solid #333;
        color: white;
    }
    .form-control-dark:focus {
        background-color: #111;
        color: white;
        border-color: var(--primary-red);
        box-shadow: none;
    }
    
    @media (max-width: 768px) {
        .hide-mobile { display: none; }
        .custom-table th, .custom-table td { font-size: 0.85rem; padding: 10px; }
    }
</style>

{{-- HEADER --}}
<section class="page-header text-center">
    <div class="container">
        <h2 class="fw-bold text-white mb-1">Daftar Harga Jasa</h2>
        <p class="text-muted mb-0 small">Menampilkan 104 Layanan Servis Profesional</p>
    </div>
</section>

<div class="container mb-5">
    
    {{-- ALERT SUKSES --}}
    @if(session('success'))
    <div class="alert alert-success border-0 bg-success text-white mb-4 shadow">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
    </div>
    @endif

    <div class="row justify-content-center mb-4" style="margin-top: -60px;">
        <div class="col-md-6">
            <div class="position-relative">
                <input type="text" id="searchInput" class="search-jasa shadow" placeholder="Cari layanan...">
                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="custom-table" id="tableJasa">
                <thead>
                    <tr>
                        <th width="15%">Kode</th>
                        <th width="40%">Nama Layanan</th>
                        <th width="20%" class="hide-mobile">Kategori</th>
                        <th width="15%">Harga</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
        <div id="noResult" class="text-center p-4 d-none"><p class="text-muted mb-0">Layanan tidak ditemukan.</p></div>

        <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--surface-dark); border-top: 1px solid #333;">
            <button class="btn btn-sm btn-outline-secondary rounded-pill" id="btnPrev" onclick="prevPage()"><i class="bi bi-chevron-left"></i> Prev</button>
            <span class="text-muted small" id="pageInfo"></span>
            <button class="btn btn-sm btn-outline-secondary rounded-pill" id="btnNext" onclick="nextPage()">Next <i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="bookingModalLabel">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Silakan lengkapi data di bawah ini. Invoice akan dikirim ke email Baginda.</p>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Layanan Dipilih</label>
                        <input type="text" class="form-control form-control-dark fw-bold" id="modalItemName" name="item_name" readonly>
                        <input type="hidden" id="modalItemCode" name="item_code">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Harga Estimasi</label>
                        <input type="text" class="form-control form-control-dark text-danger fw-bold" id="modalItemPrice" name="item_price" readonly>
                    </div>

                    <hr class="border-secondary">

                    <div class="mb-3">
                        <label class="form-label text-white">Nama Pemesan</label>
                        <input type="text" class="form-control form-control-dark" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required placeholder="Masukkan Nama Baginda">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-white">Email (Untuk Invoice)</label>
                        <input type="email" class="form-control form-control-dark" name="customer_email" value="{{ Auth::check() ? Auth::user()->email : '' }}" required placeholder="email@contoh.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white">No. WhatsApp</label>
                        <input type="number" class="form-control form-control-dark" name="customer_phone" required placeholder="08123456789">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white">Tanggal Booking</label>
                        <input type="date" class="form-control form-control-dark" name="booking_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Kirim Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DATA SERVICES (Sama seperti sebelumnya, disingkat untuk contoh)
        const allServices = [
            {code: "ANTAR", name: "ONGKOS ANTAR JEMPUT SERVIS", cat: "UMUM", price: "50.000"},
            {code: "B/P BAN", name: "BONGKAR PASANG BAN", cat: "KAKI-KAKI", price: "25.000"},
            {code: "BC-OLI", name: "SERVIS KEBOCORAN OLI", cat: "MESIN", price: "100.000"},
            {code: "BU", name: "PEMBUBUTAN", cat: "SERVIS", price: "100.000"},
            {code: "CEK", name: "PENGECEKAN (GENERAL CHECK)", cat: "DIAGNOSA", price: "50.000"},
            {code: "CHARGE-AKI", name: "CAS AKI (CHARGE)", cat: "KELISTRIKAN", price: "50.000"},
            {code: "CL", name: "SERVIS CLEANER", cat: "SERVIS", price: "30.000"},
            {code: "DEREK", name: "JASA DEREK", cat: "DARURAT", price: "100.000"},
            {code: "EFP", name: "GANTI FUEL PUMP", cat: "MESIN", price: "150.000"},
            {code: "EGR-CL", name: "EGR CLEANING", cat: "MESIN", price: "300.000"},
            {code: "ENG-CL", name: "ENGINE CLEANER", cat: "MESIN", price: "100.000"},
            {code: "ETU", name: "ENGINE TUNE UP", cat: "MESIN", price: "250.000"},
            {code: "FL-AC", name: "FLUSH AC", cat: "AC MOBIL", price: "300.000"},
            {code: "FL-KONDENSOR", name: "FLUSHING KONDENSOR", cat: "AC MOBIL", price: "100.000"},
            {code: "FL-OLIMESIN", name: "FLUSHING OLI MESIN DIESEL", cat: "OLI", price: "200.000"},
            {code: "FUEL", name: "BENSIN CAIRAN", cat: "UMUM", price: "50.000"},
            {code: "GN-MOUNT", name: "GANTI MOUNTING", cat: "MESIN", price: "400.000"},
            {code: "GOFAT", name: "GANTI OLI MATIC FLUSHING", cat: "OLI", price: "250.000"},
            {code: "GOGAR", name: "GANTI OLI GARDAN", cat: "OLI", price: "25.000"},
            {code: "GOM", name: "GANTI OLI MESIN", cat: "OLI", price: "25.000"},
            {code: "GOTAT", name: "GANTI OLI MATIC", cat: "OLI", price: "50.000"},
            {code: "GOTM", name: "GANTI OLI TRANSMISI", cat: "OLI", price: "25.000"},
            {code: "HRD-WELD", name: "HARDENING WELDING", cat: "SERVIS", price: "100.000"},
            {code: "INST-GPS", name: "PASANG GPS", cat: "AKSESORIS", price: "200.000"},
            {code: "ISIFREON", name: "ISI FREON SINGLE BLOWER", cat: "AC MOBIL", price: "225.000"},
            {code: "ISIFREON2", name: "ISI FREON DOUBLE BLOWER", cat: "AC MOBIL", price: "275.000"},
            {code: "JASA-KF", name: "PASANG KACA FILM TRUK", cat: "AKSESORIS", price: "200.000"},
            {code: "JASA-SELONGSONG", name: "GANTI SELONGSONG COIL", cat: "MESIN", price: "50.000"},
            {code: "JS-MB", name: "JASA SEWA MOBIL", cat: "RENTAL", price: "100.000"},
            {code: "KACA", name: "PASANG KACA DEPAN", cat: "BODY", price: "200.000"},
            {code: "KBODY", name: "SERVIS KELISTRIKAN BODY", cat: "KELISTRIKAN", price: "200.000"},
            {code: "KBPW", name: "SERVIS POWER WINDOW", cat: "KELISTRIKAN", price: "75.000"},
            {code: "KENG", name: "SERVIS KELISTRIKAN MESIN", cat: "KELISTRIKAN", price: "200.000"},
            {code: "KR-RAD", name: "KOROK RADIATOR", cat: "MESIN", price: "250.000"},
            {code: "K-SPEDO", name: "SERVIS SPEEDOMETER", cat: "KELISTRIKAN", price: "400.000"},
            {code: "KSTAR", name: "SERVIS STARTER", cat: "KELISTRIKAN", price: "250.000"},
            {code: "LAS-BR-RAD", name: "LAS BRACKET RADIATOR", cat: "LAS", price: "100.000"},
            {code: "LAS-FUEL", name: "LAS TANGKI BENSIN", cat: "LAS", price: "200.000"},
            {code: "LAS-RP", name: "LAS RUMAH PENTIL", cat: "LAS", price: "75.000"},
            {code: "LU-BC", name: "LUKIR BAN CADANGAN", cat: "KAKI-KAKI", price: "100.000"},
            {code: "MOUNT", name: "JASA PASANG MOUNTING", cat: "MESIN", price: "150.000"},
            {code: "OH-CALIPER", name: "OH KALIPER REM", cat: "PENGEREMAN", price: "70.000"},
            {code: "OH-CH", name: "OVERHAUL CYLINDER HEAD", cat: "SERVIS BERAT", price: "1.500.000"},
            {code: "OH-CL", name: "OH KOPLING", cat: "SERVIS BERAT", price: "550.000"},
            {code: "OH-CO", name: "GANTI CYLINDER KOPLING", cat: "SERVIS BERAT", price: "150.000"},
            {code: "OH-ENG", name: "OVERHAUL ENGINE", cat: "SERVIS BERAT", price: "2.000.000"},
            {code: "OH-TRANS", name: "OVERHAUL TRANSMISI", cat: "SERVIS BERAT", price: "800.000"},
            {code: "PAS-CAM", name: "PASANG KAMERA MUNDUR", cat: "AKSESORIS", price: "100.000"},
            {code: "PAS-MF", name: "PASANG MOTOR FAN", cat: "MESIN", price: "50.000"},
            {code: "PGL", name: "SERVIS PANGGILAN", cat: "HOME SERVICE", price: "100.000"},
            {code: "PL-LAMPU", name: "POLES LAMPU", cat: "EKSTERIOR", price: "200.000"},
            {code: "PRES", name: "JASA PRESS", cat: "KAKI-KAKI", price: "50.000"},
            {code: "PRESA", name: "PRESS G BUSHING", cat: "KAKI-KAKI", price: "50.000"},
            {code: "PRESB", name: "PRES KAKI-KAKI", cat: "KAKI-KAKI", price: "20.000"},
            {code: "PS-SELANG", name: "PRES SELANG", cat: "MESIN", price: "200.000"},
            {code: "R.AKI", name: "REPAIR COR POOL AKI", cat: "KELISTRIKAN", price: "25.000"},
            {code: "REP-JOK", name: "REPAIR JOK", cat: "INTERIOR", price: "350.000"},
            {code: "REP-SEKR", name: "REPAIR SEKRING", cat: "KELISTRIKAN", price: "20.000"},
            {code: "RP-HDCOMP", name: "REPAIR HEAD COMPRESSOR", cat: "AC MOBIL", price: "300.000"},
            {code: "RP-KABELAKI", name: "REPAIR KABEL AKI", cat: "KELISTRIKAN", price: "30.000"},
            {code: "RP-PS", name: "SERVIS POWER STEERING", cat: "KAKI-KAKI", price: "100.000"},
            {code: "RP-RACK", name: "REPAIR RACK STEER", cat: "KAKI-KAKI", price: "250.000"},
            {code: "RPSL-CALIPER", name: "REPAIR SEAL CALIPER", cat: "PENGEREMAN", price: "50.000"},
            {code: "RSAC", name: "REPAIR SELANG AC", cat: "AC MOBIL", price: "300.000"},
            {code: "SBB", name: "SERVIS BESAR BENSIN", cat: "MESIN", price: "550.000"},
            {code: "SBD", name: "SERVIS BESAR DIESEL", cat: "MESIN", price: "400.000"},
            {code: "SCAN", name: "SCANNING ENGINE", cat: "DIAGNOSA", price: "250.000"},
            {code: "SER", name: "SERVIS RINGAN", cat: "MESIN", price: "150.000"},
            {code: "SET-BP", name: "SETEL BOSH PUMP", cat: "MESIN", price: "250.000"},
            {code: "SET-TB", name: "SETEL TIMING BELT", cat: "MESIN", price: "200.000"},
            {code: "SET-WORMST", name: "SETEL WORM STEER", cat: "KAKI-KAKI", price: "100.000"},
            {code: "SHR", name: "SETEL HAND REM", cat: "PENGEREMAN", price: "100.000"},
            {code: "SL-RATA", name: "SLEP RATA FLYWHEEL", cat: "MESIN", price: "200.000"},
            {code: "SPR", name: "SPOORING", cat: "KAKI-KAKI", price: "125.000"},
            {code: "SR2", name: "SERVIS REM 2 RODA", cat: "PENGEREMAN", price: "125.000"},
            {code: "SR4L", name: "SERVIS REM 4 RODA LENGKAP", cat: "PENGEREMAN", price: "700.000"},
            {code: "SR4M", name: "SERVIS REM 4 RODA MEDIUM", cat: "PENGEREMAN", price: "400.000"},
            {code: "SR4S", name: "SERVIS REM 4 RODA STANDARD", cat: "PENGEREMAN", price: "250.000"},
            {code: "ST4R", name: "SETEL REM 4 RODA", cat: "PENGEREMAN", price: "120.000"},
            {code: "ST4RB", name: "SETEL REM 4 RODA CDD", cat: "PENGEREMAN", price: "160.000"},
            {code: "STNZ", name: "SETEL NOZZLE DIESEL", cat: "MESIN", price: "70.000"},
            {code: "SVAC", name: "SERVICE AC", cat: "AC MOBIL", price: "200.000"},
            {code: "SV-ALT", name: "SERVICE ALTERNATOR", cat: "KELISTRIKAN", price: "200.000"},
            {code: "SV-BDY", name: "SERVICE BODY", cat: "BODY", price: "75.000"},
            {code: "SVBKL", name: "SERVICE BERKALA", cat: "MESIN", price: "300.000"},
            {code: "SV-BP", name: "SERVICE BOSHPUMP", cat: "MESIN", price: "500.000"},
            {code: "SV-CHASIS", name: "SERVICE CHASSIS", cat: "KAKI-KAKI", price: "100.000"},
            {code: "SVCOOL", name: "SERVICE RADIATOR", cat: "MESIN", price: "150.000"},
            {code: "SV-ECU", name: "SERVICE ECU", cat: "KELISTRIKAN", price: "500.000"},
            {code: "SV-ELECTR", name: "SERVICE ELECTRICAL", cat: "KELISTRIKAN", price: "100.000"},
            {code: "SV-ENG", name: "SERVIS MESIN", cat: "MESIN", price: "70.000"},
            {code: "SV-HDUNIT", name: "SERVIS HEADUNIT", cat: "AKSESORIS", price: "100.000"},
            {code: "SV-JUAKI", name: "JUMPER AKI", cat: "DARURAT", price: "100.000"},
            {code: "SV-KABEL", name: "SERVICE KABEL", cat: "KELISTRIKAN", price: "50.000"},
            {code: "SV-KAKI", name: "SERVIS KAKI-KAKI", cat: "KAKI-KAKI", price: "150.000"},
            {code: "SV-KARBU", name: "SERVICE KARBU", cat: "MESIN", price: "100.000"},
            {code: "SV-MSKOP", name: "SERVIS MASTER KOPLING", cat: "TRANSMISI", price: "250.000"},
            {code: "SV-REM", name: "SERVICE REM", cat: "PENGEREMAN", price: "50.000"},
            {code: "SV-SISTEMFUEL", name: "SERVIS SISTEM BAHAN BAKAR", cat: "MESIN", price: "550.000"},
            {code: "SV-START", name: "SERVIS STARTER", cat: "KELISTRIKAN", price: "150.000"},
            {code: "SV-TRANS", name: "SERVIS TRANSMISI", cat: "TRANSMISI", price: "250.000"},
            {code: "SWP-CL", name: "GANTI CENTRAL LOCK", cat: "AKSESORIS", price: "150.000"},
            {code: "TRBLSHOOT", name: "CEK KONDISI (TROUBLESHOOT)", cat: "DIAGNOSA", price: "150.000"},
            {code: "XBAUT", name: "EXTRACTOR BAUT", cat: "SERVIS", price: "150.000"}
            // ... (Tambahkan sisa data 104 item di sini nanti) ...
        ];

        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredData = allServices;

        window.renderTable = function() { // Expose function global
            const tableBody = document.getElementById('tableBody');
            const noResult = document.getElementById('noResult');
            const pagination = document.getElementById('pageInfo').parentNode;

            tableBody.innerHTML = "";
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = filteredData.slice(start, end);

            if (pageData.length === 0) {
                noResult.classList.remove('d-none');
                pagination.classList.add('d-none');
                return;
            }
            
            noResult.classList.add('d-none');
            pagination.classList.remove('d-none');

            pageData.forEach(item => {
                const row = `
                    <tr>
                        <td><span class="text-muted small">${item.code}</span></td>
                        <td><strong>${item.name}</strong></td>
                        <td class="hide-mobile"><span class="badge-category">${item.cat}</span></td>
                        <td class="price-tag">Rp ${item.price}</td>
                        <td class="text-center">
                            <button type="button" onclick="openBookingModal('${item.name}', '${item.code}', '${item.price}')" 
                               class="btn btn-sm btn-outline-danger rounded-pill px-3">
                               Book
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            document.getElementById('pageInfo').innerText = `Halaman ${currentPage} dari ${totalPages}`;
            document.getElementById('btnPrev').disabled = (currentPage === 1);
            document.getElementById('btnNext').disabled = (currentPage === totalPages);
        }

        window.nextPage = function() {
            if ((currentPage * itemsPerPage) < filteredData.length) { currentPage++; renderTable(); }
        }
        window.prevPage = function() {
            if (currentPage > 1) { currentPage--; renderTable(); }
        }

        // FUNGSI BUKA MODAL
        window.openBookingModal = function(name, code, price) {
            document.getElementById('modalItemName').value = name;
            document.getElementById('modalItemCode').value = code;
            document.getElementById('modalItemPrice').value = 'Rp ' + price;
            
            // Panggil Bootstrap Modal
            var myModal = new bootstrap.Modal(document.getElementById('bookingModal'));
            myModal.show();
        }

        renderTable();
    });
</script>

@endsection