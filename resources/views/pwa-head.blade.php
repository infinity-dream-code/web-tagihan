<!-- PWA Primary Meta Tags -->
<link rel="manifest" href="{{ url('/app.webmanifest') }}">
@php
    $pwaSwPath = parse_url(asset('sw.js'), PHP_URL_PATH) ?: '/sw.js';
@endphp
<script>
window.deferredPwaPrompt = null;
window.addEventListener('beforeinstallprompt', function (event) {
  event.preventDefault();
  window.deferredPwaPrompt = event;
  window.dispatchEvent(new Event('pwa-installable'));
});
window.addEventListener('appinstalled', function () {
  window.deferredPwaPrompt = null;
  window.dispatchEvent(new Event('pwa-installed'));
});
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register(@json($pwaSwPath)).catch(function () {});
}
</script>
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Tagihan SAF">
<meta name="application-name" content="Tagihan SAF">
<meta name="theme-color" content="#15803d">
<meta name="msapplication-TileColor" content="#15803d">
<meta name="msapplication-TileImage" content="{{ asset('icons/icon-144x144.png') }}">

<!-- Apple Touch Icons -->
<link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
<link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">

<!-- Standard Favicon & PWA Icons -->
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/icon-96x96.png') }}">
<link rel="icon" type="image/jpeg" href="{{ asset('logo.jpeg') }}">
