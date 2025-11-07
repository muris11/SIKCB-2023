<?php
/**
 * 🚀 DYNAMIC SITEMAP GENERATOR for SEO
 * Automatically generates sitemap with environment-aware BASE URL
 */

// Load config (prefer production on non-localhost)
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$isLocal = $host === 'localhost' || $host === '127.0.0.1' || preg_match('/^localhost:\\d+$/', $host);
$prod = __DIR__ . '/app/Config/config_production.php';
$dev  = __DIR__ . '/app/Config/config.php';
if (!$isLocal && is_file($prod)) { require_once $prod; }
else { require_once $dev; }

header("Content-Type: application/xml; charset=UTF-8");

// Database connection for dynamic content
$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Fallback to static sitemap if DB fails
}

$baseUrl = rtrim(url(), '/');
$currentDate = date('c');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

  <!-- 🏠 HOMEPAGE -->
  <url>
    <loc><?= $baseUrl ?>/</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>

  <!-- 📄 STATIC PAGES -->
  <url>
    <loc><?= $baseUrl ?>/about</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.9</priority>
  </url>

  <url>
    <loc><?= $baseUrl ?>/contact</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/login</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/register</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/password/forgot</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/privacy</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.6</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/terms</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.6</priority>
  </url>

  <!-- 📚 SEMESTERS (dynamic) -->
  <?php if ($pdo instanceof PDO): try {
      $stmt = $pdo->query("SELECT id, created_at FROM semesters ORDER BY id DESC");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        $semId = (int)($row['id'] ?? 0);
        if ($semId <= 0) continue;
        $last = !empty($row['created_at']) && is_numeric($row['created_at']) ? date('c', (int)$row['created_at']) : $currentDate;
  ?>
  <url>
    <loc><?= $baseUrl ?>/semester/<?= $semId ?></loc>
    <lastmod><?= $last ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/semester/<?= $semId ?>/gallery</loc>
    <lastmod><?= $last ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  <?php endwhile; } catch (Exception $e) { /* ignore */ } endif; ?>

  <!-- 🖼️ GALLERY IMAGES (attach to /gallery page) -->
  <url>
    <loc><?= $baseUrl ?>/gallery</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
    <?php if ($pdo instanceof PDO): try {
      $g = $pdo->query("SELECT id, caption, created_at FROM gallery ORDER BY id DESC LIMIT 50");
      while ($img = $g->fetch(PDO::FETCH_ASSOC)):
        $gid = (int)($img['id'] ?? 0);
        if ($gid <= 0) continue;
        $imgUrl = $baseUrl . '/image/gallery/' . $gid;
        $caption = htmlspecialchars((string)($img['caption'] ?? ''), ENT_QUOTES, 'UTF-8');
    ?>
    <image:image>
      <image:loc><?= $imgUrl ?></image:loc>
      <?php if ($caption !== ''): ?><image:title><?= $caption ?></image:title><?php endif; ?>
    </image:image>
    <?php endwhile; } catch (Exception $e) { /* ignore */ } endif; ?>
  </url>
  <url>
    <loc><?= $baseUrl ?>/privacy</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.6</priority>
  </url>
  <url>
    <loc><?= $baseUrl ?>/terms</loc>
    <lastmod><?= $currentDate ?></lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.6</priority>
  </url>
</urlset>
