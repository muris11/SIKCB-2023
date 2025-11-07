<!-- Google Analytics 4 - SEO Optimized -->
<?php if (!DEVELOPMENT_MODE): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D9KLQN41Y5"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-D9KLQN41Y5', {
  page_title: '<?php echo $pageTitle ?? "Portal SIKC B 2023"; ?>',
  page_location: '<?php echo (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>'
});
</script>
<?php endif; ?>

<!-- ✅ READY: Analytics ID G-D9KLQN41Y5 configured -->
