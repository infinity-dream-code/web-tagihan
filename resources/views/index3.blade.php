<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cek Tagihan | Sulaiman Al Fauzan</title>
<link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">
<link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}">
<meta name="theme-color" content="#0f172a">
<script>
(function(){
  try {
    if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
  } catch (e) {}
})();
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
*{box-sizing:border-box}
:root{
--bg:#f8fafc;--surface:#ffffff;--surface2:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;
--text:#0f172a;--text2:#475569;--text3:#64748b;
--blue:#2563eb;--blue-h:#1d4ed8;--green:#16a34a;--green-h:#15803d;
--danger:#dc2626;
color-scheme:light;
}
html.dark{
--bg:#0f172a;--surface:#1e293b;--surface2:#273549;--border:#334155;--border2:#475569;
--text:#f1f5f9;--text2:#cbd5e1;--text3:#94a3b8;
color-scheme:dark;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;transition:background .2s,color .2s}
.wrap{max-width:720px;margin:0 auto;padding:2rem 1.25rem}
.topbar{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem;gap:12px}
.brand-wrap{display:flex;align-items:center;gap:12px;min-width:0}
.brand-logo{width:48px;height:48px;border-radius:10px;object-fit:cover;flex-shrink:0;border:1px solid var(--border);background:var(--surface)}
.brand{font-size:11px;font-weight:600;letter-spacing:.07em;color:var(--text3);text-transform:uppercase;margin-bottom:5px}
h1{font-size:21px;font-weight:600;color:var(--text);line-height:1.3}
.theme-btn{display:flex;align-items:center;gap:7px;padding:7px 14px;border-radius:8px;border:1px solid var(--border2);background:var(--surface);font-size:13px;color:var(--text2);cursor:pointer;transition:background .15s,border .15s;flex-shrink:0;margin-top:4px}
.theme-btn:hover{background:var(--surface2)}
.card{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:1.75rem;margin-bottom:1.25rem}
.section-title{font-size:11px;font-weight:600;letter-spacing:.07em;color:var(--text3);text-transform:uppercase;margin-bottom:1.5rem;padding-bottom:.875rem;border-bottom:1px solid var(--border)}
.field{margin-bottom:1.125rem}
.field label{display:block;font-size:13px;font-weight:500;color:var(--text2);margin-bottom:6px}
.field label em{color:var(--danger);font-style:normal}
.field input,.field select{width:100%;padding:9px 12px;border-radius:8px;border:1px solid var(--border2);background-color:var(--surface2);color:var(--text);font-size:14px;outline:none;transition:border .15s,background .15s}
.field select{appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%2364748b' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;background-size:16px;padding-right:36px}
html.dark .field select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E")}
.field input:focus,.field select:focus{border-color:var(--blue);background-color:var(--surface)}
.field input::placeholder{color:var(--text3)}
.field select option{background:var(--surface);color:var(--text)}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:40px}
.pw-eye{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text3);padding:4px;line-height:1;display:flex;align-items:center}
.pw-eye:hover{color:var(--text2)}
.turnstile-area{display:flex;justify-content:center;padding:.5rem 0}
.submit-btn{width:100%;padding:11px 16px;border-radius:8px;border:none;background:var(--blue);color:#fff;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:1.375rem;transition:background .15s}
.submit-btn:hover{background:var(--blue-h)}
.divider{border:none;border-top:1px solid var(--border);margin:1.5rem 0}
.student-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.375rem}
.sf label{font-size:12px;color:var(--text3);margin-bottom:3px}
.sf p{font-size:15px;font-weight:600;color:var(--text)}
.tbl-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:.875rem;flex-wrap:wrap;gap:.5rem}
.tbl-title{font-size:15px;font-weight:600;color:var(--text)}
.tbl-controls{display:flex;align-items:center;gap:8px}
.tbl-controls select{padding:5px 28px 5px 8px;border-radius:7px;border:1px solid var(--border2);background-color:var(--surface2);color:var(--text);font-size:12px;outline:none;cursor:pointer;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2364748b' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 8px center}
html.dark .tbl-controls select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E")}
.btn-showall{padding:5px 10px;border-radius:7px;border:1px solid var(--border2);background:var(--surface2);color:var(--text2);font-size:12px;cursor:pointer;transition:background .15s}
.btn-showall:hover{background:var(--border)}
.tbl-info{font-size:12px;color:var(--text3)}
.tbl-wrap{overflow-x:auto;border-radius:10px;border:1px solid var(--border);background:var(--surface)}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{background:var(--surface2)}
th{padding:10px 12px;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--text3);text-transform:uppercase;border-bottom:1px solid var(--border);white-space:nowrap}
td{padding:10px 12px;border-bottom:1px solid var(--border);color:var(--text);vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover{background:var(--surface2)}
.badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:100px;font-size:11px;font-weight:600}
.badge-unpaid{background:#fef2f2;color:#b91c1c}
html.dark .badge-unpaid{background:#450a0a;color:#fca5a5}
.badge-paid{background:#f0fdf4;color:#15803d}
html.dark .badge-paid{background:#052e16;color:#86efac}
.btn-detail{padding:4px 10px;border-radius:7px;border:1px solid #bfdbfe;color:#2563eb;background:transparent;font-size:12px;cursor:pointer;transition:background .15s}
.btn-detail:hover{background:#eff6ff}
html.dark .btn-detail{border-color:#1e3a5f;color:#93c5fd}
html.dark .btn-detail:hover{background:#0c1a2e}
.pagination{display:flex;gap:5px;justify-content:center;margin-top:.875rem;flex-wrap:wrap}
.pg-btn{padding:5px 10px;border-radius:7px;border:1px solid var(--border2);background:var(--surface2);color:var(--text2);font-size:12px;cursor:pointer;transition:background .15s}
.pg-btn:hover:not(.pg-active){background:var(--border)}
.pg-active{background:var(--blue);color:#fff;border-color:var(--blue)}
.error-box{margin-top:1rem;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:1rem 1.25rem}
.error-box p{color:#b91c1c;font-size:14px;margin:0}
html.dark .error-box{background:#450a0a;border-color:#7f1d1d}
html.dark .error-box p{color:#fca5a5}
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
.footer{text-align:center;font-size:12px;color:var(--text3);margin-top:2rem;padding-bottom:.75rem}
.scroll-top{position:fixed;bottom:1.5rem;right:1.5rem;width:38px;height:38px;border-radius:50%;border:1px solid var(--border2);background:var(--surface);color:var(--text2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .15s}
.scroll-top:hover{background:var(--surface2)}
@media(max-width:500px){
.student-grid{grid-template-columns:1fr}
.brand-logo{width:40px;height:40px}
h1{font-size:18px}
}
</style>
</head>
<body>
<div class="wrap">
  <div class="topbar">
    <div class="brand-wrap">
      <img src="{{ asset('logo.jpeg') }}" alt="Sulaiman Al Fauzan" class="brand-logo" width="48" height="48">
      <div>
        <div class="brand">Sulaiman Al Fauzan</div>
        <h1>Cek tagihan</h1>
      </div>
    </div>
    <button class="theme-btn" onclick="toggleTheme()" id="themeBtn" type="button">
      <svg id="themeIcon" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      <span id="themeLabel">Mode gelap</span>
    </button>
  </div>

  <div class="card">
    <form method="POST" action="/" id="billForm">
      @csrf
      <div class="section-title">Informasi akun</div>
      <div class="field">
        <label>Nomor virtual account <em>*</em></label>
        <input type="text" name="no_cust" id="noCust" placeholder="751000xxxxxxxx" value="{{ old('no_cust', $va ?? '') }}" required>
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      var dark = document.documentElement.classList.contains('dark');
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626',
        background: dark ? '#1e293b' : '#fff',
        color: dark ? '#f1f5f9' : '#0f172a'
      });
    });
    </script>
    @endif
    @if(session('success'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      var dark = document.documentElement.classList.contains('dark');
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false,
        background: dark ? '#1e293b' : '#fff',
        color: dark ? '#f1f5f9' : '#0f172a'
      });
    });
    </script>
    @endif
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
            <button class="btn-showall" type="button" onclick="showAllTagihan()">Tampilkan semua</button>
          </div>
        </div>
        <div id="tagihanInfo" class="tbl-info" style="margin-bottom:.75rem"></div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
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
              <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text3)">Tidak ada data tersedia</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="tagihanPagination" class="pagination"></div>

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
            <button class="btn-showall" type="button" onclick="showAllLunas()">Tampilkan semua</button>
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
      <div class="error-box">
        <p>{{ $result['message'] ?? 'Data tidak ditemukan' }}</p>
      </div>
    @endif
  @endif

  <div class="footer">© {{ date('Y') }} Sulaiman Al Fauzan. All rights reserved.</div>
</div>

<div id="detailModal" class="modal-bg">
  <div class="modal-box">
    <div class="modal-head">
      <h3>Detail tagihan</h3>
      <button class="modal-x" onclick="closeDetailModal()" aria-label="Tutup" type="button">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-row"><span class="modal-row-lbl">Nama tagihan</span><span class="modal-row-val" id="mNama"></span></div>
      <div class="modal-row"><span class="modal-row-lbl">Tahun akademik</span><span class="modal-row-val" id="mTahun"></span></div>
      <div id="mDetailTable"></div>
    </div>
    <div class="modal-foot">
      <button class="btn-close-full" onclick="closeDetailModal()" type="button">Tutup</button>
    </div>
  </div>
</div>

<button class="scroll-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Scroll ke atas" type="button">
  <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
</button>

<script>
let currentTheme = (typeof localStorage !== 'undefined' && localStorage.getItem('theme') === 'dark') ? 'dark' : 'light';
let turnstileToken = null;
let tagihanPage = 1, tagihanPerPageVal = 10, tagihanAll = false;
let lunasPage = 1, lunasPerPageVal = 10, lunasAll = false;
const preselectedYear = @json(old('academic_year', $academic_year ?? 'all'));

const ICON_MOON = '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
const ICON_SUN = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';

function togglePw() {
  const f = document.getElementById('pwField');
  const e = document.getElementById('pwIconEye');
  const o = document.getElementById('pwIconOff');
  if (f.type === 'password') { f.type = 'text'; e.style.display = 'none'; o.style.display = 'block'; }
  else { f.type = 'password'; e.style.display = 'block'; o.style.display = 'none'; }
}

function syncThemeUI(theme) {
  currentTheme = theme;
  const lbl = document.getElementById('themeLabel');
  const icon = document.getElementById('themeIcon');
  if (theme === 'dark') {
    lbl.textContent = 'Mode terang';
    icon.innerHTML = ICON_SUN;
  } else {
    lbl.textContent = 'Mode gelap';
    icon.innerHTML = ICON_MOON;
  }
}

function applyTheme(theme, resetWidget) {
  document.documentElement.classList.toggle('dark', theme === 'dark');
  localStorage.setItem('theme', theme);
  syncThemeUI(theme);
  if (resetWidget) resetTurnstile();
}

function toggleTheme() {
  applyTheme(currentTheme === 'light' ? 'dark' : 'light', true);
}

function initTurnstile() {
  const w = document.getElementById('turnstile-widget');
  w.innerHTML = '';
  turnstileToken = null;
  document.getElementById('cfToken').value = '';
  if (typeof turnstile === 'undefined') { setTimeout(initTurnstile, 150); return; }
  turnstile.render('#turnstile-widget', {
    sitekey: @json(config('services.turnstile.site_key')),
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
  syncThemeUI(currentTheme);
  document.documentElement.classList.toggle('dark', currentTheme === 'dark');

  const s = document.getElementById('academic_year');
  if (s) {
    fetch("/list-tahun-akademik")
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
        const match = Array.from(s.options).find(o => o.value === preselectedYear);
        s.value = match ? preselectedYear : 'all';
      })
      .catch(() => { s.innerHTML = '<option>Gagal memuat data</option>'; });
  }
  initTagihanPagination();
  initLunasPagination();
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
    const start = (page - 1) * perPage;
    for (let i = start; i < Math.min(start + perPage, total); i++) rows[i].style.display = '';
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
  if (cur > 1) h += `<button class="pg-btn" type="button" onclick="${goTo}(${cur-1})">‹</button>`;
  const max = 5;
  let sp = Math.max(1, cur - Math.floor(max/2));
  let ep = Math.min(totalPages, sp + max - 1);
  if (ep - sp < max - 1) sp = Math.max(1, ep - max + 1);
  if (sp > 1) { h += `<button class="pg-btn" type="button" onclick="${goTo}(1)">1</button>`; if (sp > 2) h += `<span style="padding:5px 4px;color:var(--text3)">…</span>`; }
  for (let i = sp; i <= ep; i++) h += `<button class="pg-btn${i === cur ? ' pg-active' : ''}" type="button" onclick="${goTo}(${i})">${i}</button>`;
  if (ep < totalPages) { if (ep < totalPages - 1) h += `<span style="padding:5px 4px;color:var(--text3)">…</span>`; h += `<button class="pg-btn" type="button" onclick="${goTo}(${totalPages})">${totalPages}</button>`; }
  if (cur < totalPages) h += `<button class="pg-btn" type="button" onclick="${goTo}(${cur+1})">›</button>`;
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

window.addEventListener('click', e => {
  if (e.target.id === 'detailModal') closeDetailModal();
});

document.getElementById('billForm').addEventListener('submit', e => {
  if (!turnstileToken) { e.preventDefault(); alert('Selesaikan verifikasi keamanan terlebih dahulu!'); }
});
</script>
</body>
</html>
