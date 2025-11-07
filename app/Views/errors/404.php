<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Halaman Tidak Ditemukan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      background: #f8fafc;
    }
    .error-page {
      max-width: 480px;
      background: #fff;
      border-radius: 1.25rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      padding: 3rem 2rem;
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }
    .text-mustard {
      color: #d4af37 !important;
    }
    .btn-mustard {
      background-color: #d4af37;
      border-color: #d4af37;
      color: #fff;
      transition: all .2s ease;
    }
    .btn-mustard:hover {
      background-color: #b8941f;
      border-color: #b8941f;
      color: #fff;
      transform: translateY(-2px);
    }
    .error-svg {
      width: 140px;
      height: 140px;
      margin-bottom: 1.25rem;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center">

  <div class="error-page">
    <div class="mb-3">
      <svg class="error-svg" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="70" cy="70" r="70" fill="#FFF6E0"/>
        <ellipse cx="70" cy="110" rx="38" ry="8" fill="#F2E1B8"/>
        <ellipse cx="50" cy="60" rx="8" ry="12" fill="#D4AF37"/>
        <ellipse cx="90" cy="60" rx="8" ry="12" fill="#D4AF37"/>
        <rect x="55" y="90" width="30" height="8" rx="4" fill="#D4AF37"/>
        <ellipse cx="50" cy="62" rx="2" ry="3" fill="#fff"/>
        <ellipse cx="90" cy="62" rx="2" ry="3" fill="#fff"/>
      </svg>
    </div>

    <h1 class="display-3 fw-bold text-mustard mb-0">404</h1>
    <h2 class="fw-semibold mt-1 mb-3">Halaman Tidak Ditemukan</h2>

    <p class="text-muted fs-5 mb-4">
      Maaf, halaman yang Anda cari tidak dapat ditemukan.<br>
      Mungkin halaman telah dipindahkan, dihapus, atau tidak tersedia.
    </p>

    <div class="d-flex justify-content-center">
      <a href="<?= url() ?>" class="btn btn-mustard btn-lg">
        <i class="fas fa-home me-2"></i> Kembali ke Beranda
      </a>
    </div>

    <small class="text-muted d-block mt-4">
      Jika Anda merasa ini adalah kesalahan, silakan hubungi admin.
    </small>
  </div>

</body>
</html>
