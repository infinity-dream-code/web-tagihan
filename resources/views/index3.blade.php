<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cek Tagihan dan Pembayaran</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
*{box-sizing:border-box}
:root{
--bg:#f8fafc;--surface:#ffffff;--surface2:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;
--text:#0f172a;--text2:#475569;--text3:#94a3b8;
--blue:#2563eb;--blue-h:#1d4ed8;--green:#16a34a;--green-h:#15803d;
--danger:#dc2626;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;transition:background .2s,color .2s}
body.dark{
--bg:#0f172a;--surface:#1e293b;--surface2:#0f172a;--border:#1e293b;--border2:#334155;
--text:#f1f5f9;--text2:#94a3b8;--text3:#475569;
}
.wrap{max-width:720px;margin:0 auto;padding:2rem 1.25rem}
.topbar{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem}
.brand{font-size:11px;font-weight:600;letter-spacing:.07em;color:var(--text3);text-transform:uppercase;margin-bottom:5px}
h1{font-size:21px;font-weight:600;color:var(--text);line-height:1.3}
.theme-btn{display:flex;align-items:center;gap:7px;padding:7px 14px;border-radius:8px;border:1px solid var(--border2);background:var(--surface);font-size:13px;color:var(--text2);cursor:pointer;transition:background .15s,border .15s;flex-shrink:0;margin-top:4px}
.theme-btn:hover{background:var(--surface2)}
.card{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.75rem;margin-bottom:1.25rem}
.section-title{font-size:11px;font-weight:600;letter-spacing:.07em;color:var(--text3);text-transform:uppercase;margin-bottom:1.5rem;padding-bottom:.875rem;border-bottom:1px solid var(--border)}
.field{margin-bottom:1.125rem}
.field label{display:block;font-size:13px;font-weight:500;color:var(--text2);margin-bottom:6px}
.field label em{color:var(--danger);font-style:normal}
.field input,.field select{width:100%;padding:9px 12px;border-radius:8px;border:1px solid var(--border2);background:var(--surface2);color:var(--text);font-size:14px;outline:none;transition:border .15s,background .15s;appearance:none}
.field input:focus,.field select:focus{border-color:var(--blue);background:var(--surface)}
.field input::placeholder{color:var(--text3)}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:40px}
.pw-eye{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);padding:4px;line-height:1;display:flex;align-items:center}
.pw-eye:hover{color:var(--text2)}
.turnstile-area{display:flex;justify-content:center;padding:.5rem 0}
.submit-btn{width:100%;padding:11px 16px;border-radius:8px;border:none;background:var(--blue);color:#fff;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:1.375rem;transition:background .15s}
.submit-btn:hover{background:var(--blue-h)}
.divider{border:none;border-top:1px solid var(--border);margin:1.5rem 0}
.guide-wrap{padding-top:1.25rem;border-top:1px solid var(--border);margin-top:1.375rem}
.guide-lbl{font-size:11px;font-weight:600;letter-spacing:.07em;color:var(--text3);text-transform:uppercase;margin-bottom:.875rem;text-align:center}
.guide-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.guide-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:10px 14px;border-radius:8px;border:1px solid var(--border2);background:var(--surface2);color:var(--text2);font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:background .15s}
.guide-btn:hover{background:var(--border)}
.guide-btn svg{flex-shrink:0}
.student-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.375rem}
.sf label{font-size:12px;color:var(--text3);margin-bottom:3px}
.sf p{font-size:15px;font-weight:600;color:var(--text)}
.tbl-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:.875rem;flex-wrap:wrap;gap:.5rem}
.tbl-title{font-size:15px;font-weight:600;color:var(--text)}
.tbl-controls{display:flex;align-items:center;gap:8px}
.tbl-controls select{padding:5px 8px;border-radius:7px;border:1px solid var(--border2);background:var(--surface2);color:var(--text);font-size:12px;outline:none;cursor:pointer}
.btn-showall{padding:5px 10px;border-radius:7px;border:1px solid var(--border2);background:var(--surface2);color:var(--text2);font-size:12px;cursor:pointer;transition:background .15s}
.btn-showall:hover{background:var(--border)}
.tbl-info{font-size:12px;color:var(--text3)}
.tbl-wrap{overflow-x:auto;border-radius:10px;border:1px solid var(--border)}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{background:var(--surface2)}
th{padding:10px 12px;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border);white-space:nowrap}
td{padding:10px 12px;border-bottom:1px solid var(--border);color:var(--text);vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover{background:var(--surface2)}
.badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:100px;font-size:11px;font-weight:600}
.badge-unpaid{background:#fef2f2;color:#b91c1c}
body.dark .badge-unpaid{background:#450a0a;color:#fca5a5}
.badge-paid{background:#f0fdf4;color:#15803d}
body.dark .badge-paid{background:#052e16;color:#86efac}
.btn-detail{padding:4px 10px;border-radius:7px;border:1px solid #bfdbfe;color:#2563eb;background:transparent;font-size:12px;cursor:pointer;transition:background .15s}
.btn-detail:hover{background:#eff6ff}
body.dark .btn-detail{border-color:#1e3a5f;color:#93c5fd}
body.dark .btn-detail:hover{background:#0c1a2e}
.pagination{display:flex;gap:5px;justify-content:center;margin-top:.875rem;flex-wrap:wrap}
.pg-btn{padding:5px 10px;border-radius:7px;border:1px solid var(--border2);background:var(--surface2);color:var(--text2);font-size:12px;cursor:pointer;transition:background .15s}
.pg-btn:hover:not(.pg-active){background:var(--border)}
.pg-active{background:var(--blue);color:#fff;border-color:var(--blue)}
.hint{font-size:12px;color:var(--danger);margin-top:.75rem}
.pay-btn{width:100%;margin-top:1.125rem;padding:11px 16px;border-radius:8px;border:none;background:var(--green);color:#fff;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .15s}
.pay-btn:hover{background:var(--green-h)}
.modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:100;align-items:center;justify-content:center}
.modal-bg.open{display:flex}
.modal-box{background:var(--surface);border:1px solid var(--border2);border-radius:14px;width:92%;max-width:520px;max-height:85vh;overflow-y:auto}
.modal-head{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.25rem;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--surface)}
.modal-head h3{font-size:15px;font-weight:600;color:var(--text)}
.modal-x{background:none;border:none;cursor:pointer;color:var(--text3);padding:4px;line-height:1;border-radius:6px;display:flex}
.modal-x:hover{background:var(--surface2);color:var(--text)}
.modal-body{padding:1.25rem}
.modal-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid var(--border)}
.modal-row:last-child{border-bottom:none}
.modal-row-lbl{font-size:13px;color:var(--text2)}
.modal-row-val{font-size:13px;font-weight:600;color:var(--text)}
.modal-foot{padding:.875rem 1.25rem;border-top:1px solid var(--border)}
.btn-close-full{width:100%;padding:9px;border-radius:8px;border:1px solid var(--border2);background:transparent;color:var(--text2);font-size:13px;font-weight:500;cursor:pointer;transition:background .15s}
.btn-close-full:hover{background:var(--surface2)}
.payment-iframe-wrap{padding:0}
.payment-iframe-wrap iframe{width:100%;height:85vh;border:none;border-radius:0 0 14px 14px;display:block}
.footer{text-align:center;font-size:12px;color:var(--text3);margin-top:2rem;padding-bottom:.75rem}
.scroll-top{position:fixed;bottom:1.5rem;right:1.5rem;width:38px;height:38px;border-radius:50%;border:1px solid var(--border2);background:var(--surface);color:var(--text2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .15s}
.scroll-top:hover{background:var(--surface2)}
@media(max-width:500px){
.student-grid{grid-template-columns:1fr}
.guide-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="wrap">
  <div class="topbar">
    <div>
      <div class="brand">ICT Billing System</div>
      <h1>Cek tagihan &amp; pembayaran</h1>
    </div>
    <button class="theme-btn" onclick="toggleTheme()" id="themeBtn">
      <svg id="themeIcon" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      <span id="themeLabel">Mode gelap</span>
    </button>
  </div>

  <div class="card">
    <form method="POST" action="{{ route('tagihan.cek2') }}" id="billForm">
      @csrf
      <div class="section-title">Informasi akun</div>
      <div class="field">
        <label>Nomor virtual account <em>*</em></label>
        <input type="text" name="no_cust" id="noCust" placeholder="751000xxxxxxxx" required>
      </div>
      <div class="field">
        <label>Password <em>*</em></label>
        <div class="pw-wrap">
          <input type="password" name="password" id="pwField" placeholder="Masukkan password" required>
          <button type="button" class="pw-eye" onclick="togglePw()" aria-label="Tampilkan password">
            <svg id="pwIconEye" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <svg id="pwIconOff" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 9.96 0 011.255-2.255M9.772 9.772A3 3 0 0114.23 14.23M3 3l18 18"/></svg>
          </button>
        </div>
      </div>
      <div class="field">
        <label>Tahun akademik <em>*</em></label>
        <select id="academic_year" name="academic_year">
          <option value="">Memuat data...</option>
        </select>
      </div>
      <div class="field">
        <label>Verifikasi keamanan <em>*</em></label>
        <div class="turnstile-area">
          <div id="turnstile-widget"></div>
          <input type="hidden" name="cf_turnstile_response" id="cfToken">
        </div>
      </div>
      <button type="submit" name="submit" class="submit-btn">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Cek tagihan
      </button>
    </form>

    @if(session('error'))
    <script>Swal.fire({icon:'error',title:'Gagal',text:'{{ session('error') }}',confirmButtonColor:'#dc2626'});</script>
    @endif
    @if(session('success'))
    <script>Swal.fire({icon:'success',title:'Berhasil',text:'{{ session('success') }}',timer:2000,showConfirmButton:false});</script>
    @endif

    <div class="guide-wrap">
      <div class="guide-lbl">Panduan pembayaran</div>
      <div class="guide-grid">
        <a href="/Gambar_Panduan_Bayar.jpeg" target="_blank" class="guide-btn">
          <svg width="15" height="15" fill="none" stroke="#7c3aed" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          Panduan JPG
        </a>
        <a href="/Booklet_Panduan_Bayar.pdf" target="_blank" class="guide-btn">
          <svg width="15" height="15" fill="none" stroke="#dc2626" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Panduan PDF
        </a>
      </div>
    </div>
  </div>

  @if(isset($result))
    @if($result['status'])
      <div class="card" id="resultSection">
        <div class="section-title">Data siswa</div>
        <div class="student-grid">
          <div class="sf"><label>Nama</label><p>{{ $result['data']['nama'] ?? '-' }}</p></div>
          <div class="sf"><label>Kelas</label><p>{{ $result['data']['kelas'] ?? '-' }}</p></div>
          <div class="sf"><label>Angkatan</label><p>{{ $academic_year ?: '-' }}</p></div>
          <div class="sf"><label>Saldo VA</label><p>Rp {{ number_format($result['data']['saldo'] ?? 0, 0, ',', '.') }}</p></div>
          <div class="sf"><label>No. VA</label><p>{{ $result['data']['va_number'] ?? '-' }}</p></div>
          <div class="sf"><label>Jenjang</label><p>{{ $result['data']['jenjang'] ?? '-' }}</p></div>
        </div>

        <div class="divider"></div>

        <div class="tbl-bar">
          <div class="tbl-title">Tagihan aktif — {{ $academic_year ?: '-' }}</div>
          <div class="tbl-controls">
            <select id="tagihanPerPage" onchange="changeTagihanPerPage()">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <button class="btn-showall" onclick="showAllTagihan()">Tampilkan semua</button>
          </div>
        </div>
        <div id="tagihanInfo" class="tbl-info" style="margin-bottom:.75rem"></div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th style="width:36px"><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                <th>No</th>
                <th>Urutan</th>
                <th>Nama tagihan</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tgl tagihan</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody id="tagihanTableBody">
              @forelse($result['data']['tagihan'] as $i => $tagih)
              <tr data-index="{{ $i }}">
                <td><input type="checkbox" name="selected_tagihan[]" value="{{ $tagih['id'] ?? $i }}" class="tagihan-checkbox"></td>
                <td>{{ $i+1 }}</td>
                <td>{{ $tagih['FURUTAN'] ?? '-' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', strtolower($tagih['nama_tagihan']))) }}</td>
                <td>Rp {{ number_format($tagih['total_tagihan'], 0, ',', '.') }}</td>
                <td>
                  @if($tagih['PAIDST'] == '1')
                    <span class="badge badge-paid">Lunas</span>
                  @else
                    <span class="badge badge-unpaid">Belum lunas</span>
                  @endif
                </td>
                <td>{{ $tagih['FTGLTagihan'] ? \Carbon\Carbon::parse($tagih['FTGLTagihan'])->format('Y-m-d') : '-' }}</td>
                <td><button type="button" class="btn-detail" onclick='showDetailModal(@json($tagih))'>Lihat</button></td>
              </tr>
              @empty
              <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text3)">Tidak ada data tersedia</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="tagihanPagination" class="pagination"></div>
        <p class="hint">* Pilih satu atau beberapa tagihan untuk dibayarkan</p>
        <button type="button" onclick="showPaymentModal()" class="pay-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          Bayar tagihan
        </button>

        <div class="divider"></div>

        <div class="tbl-bar">
          <div class="tbl-title">Tagihan lunas — {{ $academic_year ?: '-' }}</div>
          <div class="tbl-controls">
            <select id="lunasPerPage" onchange="changeLunasPerPage()">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <button class="btn-showall" onclick="showAllLunas()">Tampilkan semua</button>
          </div>
        </div>
        <div id="lunasInfo" class="tbl-info" style="margin-bottom:.75rem"></div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Urutan</th>
                <th>Nama tagihan</th>
                <th>Nominal</th>
                <th>Tgl bayar</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody id="lunasTableBody">
              @forelse($result['data']['tagihan_lunas'] ?? [] as $i => $tagih)
              <tr data-index="{{ $i }}">
                <td>{{ $i+1 }}</td>
                <td>{{ $tagih['FURUTAN'] ?? '-' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', strtolower($tagih['nama_tagihan']))) }}</td>
                <td>Rp {{ number_format($tagih['total_tagihan'], 0, ',', '.') }}</td>
                <td>{{ $tagih['PAIDDT'] ? \Carbon\Carbon::parse($tagih['PAIDDT'])->format('Y-m-d') : '-' }}</td>
                <td><button type="button" class="btn-detail" onclick='showDetailModal(@json($tagih))'>Lihat</button></td>
              </tr>
              @empty
              <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text3)">Tidak ada tagihan lunas</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="lunasPagination" class="pagination"></div>
      </div>
      <script>setTimeout(()=>{document.getElementById('resultSection').scrollIntoView({behavior:'smooth',block:'start'})},100);</script>
    @else
      <div style="margin-top:1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:1rem 1.25rem">
        <p style="color:#b91c1c;font-size:14px">{{ $result['message'] ?? 'Data tidak ditemukan' }}</p>
      </div>
    @endif
  @endif

  <div class="footer">© 2024 PT. Inovasi Cipta Teknologi. All rights reserved.</div>
</div>

<div id="detailModal" class="modal-bg">
  <div class="modal-box">
    <div class="modal-head">
      <h3>Detail tagihan</h3>
      <button class="modal-x" onclick="closeDetailModal()" aria-label="Tutup">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-row"><span class="modal-row-lbl">Nama tagihan</span><span class="modal-row-val" id="mNama"></span></div>
      <div class="modal-row"><span class="modal-row-lbl">Tahun akademik</span><span class="modal-row-val" id="mTahun"></span></div>
      <div id="mDetailTable"></div>
    </div>
    <div class="modal-foot">
      <button class="btn-close-full" onclick="closeDetailModal()">Tutup</button>
    </div>
  </div>
</div>

<div id="paymentModal" class="modal-bg">
  <div class="modal-box" style="max-width:960px">
    <div class="modal-head">
      <h3>Konfirmasi pembayaran</h3>
      <button class="modal-x" onclick="closePaymentModal()" aria-label="Tutup">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div id="paymentContent" class="payment-iframe-wrap"></div>
  </div>
</div>

<button class="scroll-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Scroll ke atas">
  <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
</button>

<script>
let currentTheme = 'light';
let turnstileToken = null;
let tagihanPage = 1, tagihanPerPageVal = 10, tagihanAll = false;
let lunasPage = 1, lunasPerPageVal = 10, lunasAll = false;

function togglePw() {
  const f = document.getElementById('pwField');
  const e = document.getElementById('pwIconEye');
  const o = document.getElementById('pwIconOff');
  if (f.type === 'password') { f.type = 'text'; e.style.display = 'none'; o.style.display = 'block'; }
  else { f.type = 'password'; e.style.display = 'block'; o.style.display = 'none'; }
}

function toggleTheme() {
  const body = document.body;
  const lbl = document.getElementById('themeLabel');
  const icon = document.getElementById('themeIcon');
  if (currentTheme === 'light') {
    currentTheme = 'dark';
    body.classList.add('dark');
    lbl.textContent = 'Mode terang';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
  } else {
    currentTheme = 'light';
    body.classList.remove('dark');
    lbl.textContent = 'Mode gelap';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
  }
  localStorage.setItem('theme', currentTheme);
  resetTurnstile();
}

function initTurnstile() {
  const w = document.getElementById('turnstile-widget');
  w.innerHTML = '';
  turnstileToken = null;
  document.getElementById('cfToken').value = '';
  if (typeof turnstile === 'undefined') { setTimeout(initTurnstile, 150); return; }
  turnstile.render('#turnstile-widget', {
    sitekey: '0x4AAAAAAC4fiI9wNb1AMZ3I',
    theme: currentTheme === 'dark' ? 'dark' : 'light',
    size: 'normal',
    retry: 'auto',
    callback: t => { turnstileToken = t; document.getElementById('cfToken').value = t; },
    'error-callback': () => { turnstileToken = null; document.getElementById('cfToken').value = ''; },
    'expired-callback': () => { turnstileToken = null; document.getElementById('cfToken').value = ''; }
  });
}

function resetTurnstile() {
  if (typeof turnstile !== 'undefined') { document.getElementById('turnstile-widget').innerHTML = ''; setTimeout(initTurnstile, 100); }
}

document.addEventListener('DOMContentLoaded', () => {
  const s = document.getElementById('academic_year');
  if (s) {
    fetch("{{ url('/list-tahun-akademik') }}")
      .then(r => r.json())
      .then(data => {
        s.innerHTML = '';
        const def = document.createElement('option');
        def.value = 'all'; def.textContent = 'Semua tahun akademik';
        s.appendChild(def);
        if (data.status && data.data.length) {
          data.data.forEach(item => {
            const o = document.createElement('option');
            o.value = item.thn_aka; o.textContent = item.thn_aka;
            s.appendChild(o);
          });
        }
      })
      .catch(() => { s.innerHTML = '<option>Gagal memuat data</option>'; });
  }
  initTagihanPagination();
  initLunasPagination();
  if (localStorage.getItem('theme') === 'dark') toggleTheme();
});

window.onload = initTurnstile;

function getRows(id) {
  const el = document.getElementById(id);
  return el ? Array.from(el.querySelectorAll('tr[data-index]')) : [];
}

function paginateRows(rows, page, perPage, showAll, infoId, paginationFn) {
  const total = rows.length;
  rows.forEach(r => r.style.display = 'none');
  if (showAll) { rows.forEach(r => r.style.display = ''); }
  else {
    const s = (page - 1) * perPage;
    for (let i = s; i < Math.min(s + perPage, total); i++) rows[i].style.display = '';
  }
  const s2 = showAll ? 1 : (page - 1) * perPage + 1;
  const e2 = showAll ? total : Math.min(page * perPage, total);
  const inf = document.getElementById(infoId);
  if (inf) inf.textContent = `Menampilkan ${s2} – ${e2} dari ${total} data`;
  paginationFn(showAll ? 1 : Math.ceil(total / perPage), total);
}

function renderPagination(id, totalPages, totalRows, showAll, getCurrent, goTo) {
  const el = document.getElementById(id);
  if (!el) return;
  if (showAll || totalRows === 0) { el.innerHTML = ''; return; }
  const cur = getCurrent();
  let h = '';
  if (cur > 1) h += `<button class="pg-btn" onclick="${goTo}(${cur-1})">‹</button>`;
  const max = 5;
  let sp = Math.max(1, cur - Math.floor(max/2));
  let ep = Math.min(totalPages, sp + max - 1);
  if (ep - sp < max - 1) sp = Math.max(1, ep - max + 1);
  if (sp > 1) { h += `<button class="pg-btn" onclick="${goTo}(1)">1</button>`; if (sp > 2) h += `<span style="padding:5px 4px;color:var(--text3)">…</span>`; }
  for (let i = sp; i <= ep; i++) h += `<button class="pg-btn${i === cur ? ' pg-active' : ''}" onclick="${goTo}(${i})">${i}</button>`;
  if (ep < totalPages) { if (ep < totalPages - 1) h += `<span style="padding:5px 4px;color:var(--text3)">…</span>`; h += `<button class="pg-btn" onclick="${goTo}(${totalPages})">${totalPages}</button>`; }
  if (cur < totalPages) h += `<button class="pg-btn" onclick="${goTo}(${cur+1})">›</button>`;
  el.innerHTML = h;
}

function initTagihanPagination() {
  const rows = getRows('tagihanTableBody');
  if (rows.length) paginateRows(rows, tagihanPage, tagihanPerPageVal, tagihanAll, 'tagihanInfo', (tp, tr) => renderPagination('tagihanPagination', tp, tr, tagihanAll, () => tagihanPage, 'goToTagihanPage'));
}

function initLunasPagination() {
  const rows = getRows('lunasTableBody');
  if (rows.length) paginateRows(rows, lunasPage, lunasPerPageVal, lunasAll, 'lunasInfo', (tp, tr) => renderPagination('lunasPagination', tp, tr, lunasAll, () => lunasPage, 'goToLunasPage'));
}

function goToTagihanPage(p) { tagihanPage = p; paginateRows(getRows('tagihanTableBody'), tagihanPage, tagihanPerPageVal, tagihanAll, 'tagihanInfo', (tp, tr) => renderPagination('tagihanPagination', tp, tr, tagihanAll, () => tagihanPage, 'goToTagihanPage')); }
function goToLunasPage(p) { lunasPage = p; paginateRows(getRows('lunasTableBody'), lunasPage, lunasPerPageVal, lunasAll, 'lunasInfo', (tp, tr) => renderPagination('lunasPagination', tp, tr, lunasAll, () => lunasPage, 'goToLunasPage')); }

function changeTagihanPerPage() { tagihanPerPageVal = parseInt(document.getElementById('tagihanPerPage').value); tagihanPage = 1; tagihanAll = false; initTagihanPagination(); }
function changeLunasPerPage() { lunasPerPageVal = parseInt(document.getElementById('lunasPerPage').value); lunasPage = 1; lunasAll = false; initLunasPagination(); }
function showAllTagihan() { tagihanAll = true; initTagihanPagination(); }
function showAllLunas() { lunasAll = true; initLunasPagination(); }

function toggleSelectAll(cb) {
  getRows('tagihanTableBody').filter(r => r.style.display !== 'none').forEach(r => { const c = r.querySelector('.tagihan-checkbox'); if (c) c.checked = cb.checked; });
}

function showDetailModal(tagihan) {
  document.getElementById('mNama').textContent = tagihan.nama_tagihan ? tagihan.nama_tagihan.toLowerCase().replace(/_/g,' ').replace(/\b\w/g, l => l.toUpperCase()) : '-';
  document.getElementById('mTahun').textContent = tagihan.tahun_akademik_tagihan || '-';
  let t = '<table style="width:100%;border-collapse:collapse;margin-top:.75rem"><thead><tr style="background:var(--surface2)"><th style="padding:9px 12px;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border)">Komponen</th><th style="padding:9px 12px;text-align:right;font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border)">Nominal</th></tr></thead><tbody>';
  if (Array.isArray(tagihan.detail) && tagihan.detail.length) {
    tagihan.detail.forEach(d => { t += `<tr><td style="padding:9px 12px;border-bottom:1px solid var(--border);font-size:13px;color:var(--text)">${d.akun_detail||'-'}</td><td style="padding:9px 12px;border-bottom:1px solid var(--border);text-align:right;font-size:13px;color:var(--text);font-weight:600">Rp ${parseInt(d.nominal_detail||0).toLocaleString('id-ID')}</td></tr>`; });
  } else { t += `<tr><td colspan="2" style="padding:1.5rem;text-align:center;color:var(--text3);font-size:13px">Tidak ada rincian</td></tr>`; }
  t += '</tbody></table>';
  document.getElementById('mDetailTable').innerHTML = t;
  document.getElementById('detailModal').classList.add('open');
}

function closeDetailModal() { document.getElementById('detailModal').classList.remove('open'); }

function showPaymentModal() {
  const rows = getRows('tagihanTableBody').filter(r => r.style.display !== 'none');
  const checked = rows.map(r => r.querySelector('.tagihan-checkbox:checked')).filter(Boolean);
  if (!checked.length) { alert('Pilih minimal satu tagihan untuk dibayar!'); return; }
  const allData = @json($result['data']['tagihan'] ?? []);
  const selected = checked.map(cb => {
    const id = cb.value;
    return allData.find((item, idx) => (item.id && item.id == id) || idx == id) || {};
  });
  sessionStorage.setItem('siswa_data', JSON.stringify({
    nama: '{{ $result["data"]["nama"] ?? "" }}',
    kelas: '{{ $result["data"]["kelas"] ?? "" }}',
    va_number: '{{ $result["data"]["va_number"] ?? "" }}'.replace(/^751000/, ''),
    tahun_akademik: '{{ $result["data"]["tahun_akademik"] ?? "" }}',
    jenjang: '{{ $result["data"]["jenjang"] ?? "" }}',
    saldo: '{{ $result["data"]["saldo"] ?? 0 }}',
    nis: '{{ $result["data"]["nis"] ?? "" }}'
  }));
  sessionStorage.setItem('selected_tagihan', JSON.stringify(selected));
  const modal = document.getElementById('paymentModal');
  document.getElementById('paymentContent').innerHTML = '<p style="padding:2rem;text-align:center;color:var(--text2);font-size:13px">Memuat halaman pembayaran...</p>';
  modal.classList.add('open');
  setTimeout(() => { document.getElementById('paymentContent').innerHTML = `<iframe src="{{ url('/tagihan/view') }}"></iframe>`; }, 500);
}

function closePaymentModal() { document.getElementById('paymentModal').classList.remove('open'); }

window.addEventListener('click', e => {
  if (e.target.id === 'detailModal') closeDetailModal();
  if (e.target.id === 'paymentModal') closePaymentModal();
});

document.getElementById('billForm').addEventListener('submit', e => {
  if (!turnstileToken) { e.preventDefault(); alert('Selesaikan verifikasi keamanan terlebih dahulu!'); }
});
</script>
</body>
</html>