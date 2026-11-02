<style>
.pwa-install-banner {
  position: fixed;
  bottom: 1.25rem;
  left: 50%;
  transform: translateX(-50%) translateY(120px);
  max-width: 460px;
  width: calc(100% - 2rem);
  background: var(--surface, #ffffff);
  border: 1px solid var(--border, #dce6df);
  border-radius: 16px;
  padding: 0.9rem 1rem;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.16);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s;
  opacity: 0;
  pointer-events: none;
}
.pwa-install-banner.show {
  transform: translateX(-50%) translateY(0);
  opacity: 1;
  pointer-events: auto;
}
.pwa-banner-left {
  display: flex;
  align-items: center;
  gap: 10px;
  min-width: 0;
}
.pwa-banner-icon {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  object-fit: cover;
  flex-shrink: 0;
  border: 1px solid var(--border, #dce6df);
}
.pwa-banner-text {
  min-width: 0;
}
.pwa-banner-title {
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--text, #13261a);
  margin: 0 0 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pwa-banner-desc {
  font-size: 0.72rem;
  color: var(--text3, #6b8173);
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pwa-banner-actions {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
}
.pwa-btn-install {
  background: var(--accent, #15803d);
  color: #ffffff;
  border: none;
  padding: 0.45rem 0.85rem;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: opacity 0.15s;
}
.pwa-btn-install:hover {
  opacity: 0.9;
}
.pwa-btn-close {
  background: transparent;
  border: none;
  color: var(--text3, #6b8173);
  font-size: 1.25rem;
  line-height: 1;
  width: 28px;
  height: 28px;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.15s;
}
.pwa-btn-close:hover {
  background: var(--surface2, #f0f4f1);
}
.pwa-float-download {
  position: fixed;
  right: max(1rem, env(safe-area-inset-right));
  bottom: max(1.15rem, env(safe-area-inset-bottom));
  z-index: 9998;
  display: flex;
  align-items: center;
  gap: 6px;
  min-height: 44px;
  padding: 0 14px;
  border: none;
  border-radius: 12px;
  background: #15803d;
  color: #fff;
  font-family: inherit;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 10px 24px rgba(21, 128, 61, 0.28);
}
.pwa-float-download[hidden],
.pwa-install-btn[hidden] {
  display: none !important;
}
</style>

<div id="pwaInstallBanner" class="pwa-install-banner">
  <div class="pwa-banner-left">
    <img src="{{ asset('icons/icon-96x96.png') }}" alt="Logo" class="pwa-banner-icon">
    <div class="pwa-banner-text">
      <div class="pwa-banner-title">Pasang Tagihan SAF</div>
      <div class="pwa-banner-desc">Akses cepat & praktis dari layar utama</div>
    </div>
  </div>
  <div class="pwa-banner-actions">
    <button type="button" id="pwaInstallBtn" class="pwa-btn-install">
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
      </svg>
      Download
    </button>
    <button type="button" id="pwaDismissBtn" class="pwa-btn-close" aria-label="Tutup">&times;</button>
  </div>
</div>

<button type="button" id="pwaFloatDownload" class="pwa-float-download" aria-label="Download aplikasi" hidden>
  <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
  </svg>
  Download
</button>

<script>
(function() {
  const banner = document.getElementById('pwaInstallBanner');
  const installBtn = document.getElementById('pwaInstallBtn');
  const dismissBtn = document.getElementById('pwaDismissBtn');
  const topbarBtn = document.getElementById('topbarInstallBtn');
  const floatBtn = document.getElementById('pwaFloatDownload');
  const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
  const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
  let installSettled = false;

  if (!topbarBtn && floatBtn && !isStandalone) floatBtn.hidden = false;

  function hideInstallUi() {
    if (banner) banner.classList.remove('show');
    if (topbarBtn) topbarBtn.hidden = true;
    if (floatBtn) floatBtn.hidden = true;
  }

  function showBanner() {
    const dismissed = sessionStorage.getItem('pwa_dismissed') === '1';
    if (!isStandalone && !dismissed && banner && window.deferredPwaPrompt) {
      banner.classList.add('show');
    }
  }

  function triggerInstall() {
    const promptEvent = window.deferredPwaPrompt;
    if (promptEvent) {
      window.deferredPwaPrompt = null;
      if (banner) banner.classList.remove('show');
      promptEvent.prompt();
      promptEvent.userChoice.then(function (choice) {
        if (choice.outcome === 'accepted') hideInstallUi();
      }).catch(function () {});
      return;
    }

    if (isStandalone) {
      hideInstallUi();
      return;
    }

    if (isIOS) {
      const message = 'Di iPhone/iPad, buka menu Bagikan di Safari lalu pilih Tambahkan ke Layar Utama.';
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'info', title: 'Download di iPhone / iPad', text: message, confirmButtonColor: '#15803d', confirmButtonText: 'Mengerti' });
      } else {
        alert(message);
      }
      return;
    }

    if (!installSettled) {
      const label = document.getElementById('topbarInstallLabel');
      if (label) label.textContent = 'Klik lagi';
      return;
    }

    const message = window.isSecureContext
      ? 'Browser belum menampilkan dialog download. Buka situs ini di Chrome atau Edge, lalu klik Download lagi.'
      : 'Dialog download hanya muncul di HTTPS atau localhost. Buka situs lewat koneksi aman, lalu klik Download.';
    if (typeof Swal !== 'undefined') {
      Swal.fire({ icon: 'info', title: 'Download aplikasi', text: message, confirmButtonColor: '#15803d', confirmButtonText: 'Mengerti' });
    } else {
      alert(message);
    }
  }

  [installBtn, topbarBtn, floatBtn].forEach(function (button) {
    if (button) button.addEventListener('click', triggerInstall);
  });

  if (dismissBtn) {
    dismissBtn.addEventListener('click', function () {
      if (banner) banner.classList.remove('show');
      sessionStorage.setItem('pwa_dismissed', '1');
    });
  }

  window.addEventListener('pwa-installable', function () {
    const label = document.getElementById('topbarInstallLabel');
    if (label) label.textContent = 'Download';
    showBanner();
  });
  window.addEventListener('pwa-installed', hideInstallUi);

  if (isStandalone) {
    hideInstallUi();
  } else if (window.deferredPwaPrompt) {
    showBanner();
  }

  setTimeout(function () { installSettled = true; }, 4000);
})();
</script>
