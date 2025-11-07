<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private PHPMailer $mail;

    public function __construct() {
        // Load email configuration
        $emailConfig = __DIR__ . '/../../config/email.php';
        if (file_exists($emailConfig)) {
            require_once $emailConfig;
        }
        
        // Fallback to main config
        if (!defined('APP_URL')) {
            $cfgPath = __DIR__ . '/../../Config/config.php';
            if (is_file($cfgPath)) {
                require_once $cfgPath;
            }
        }
        
        $this->mail = new PHPMailer(true);
        $this->configure();
    }

    /** Getter config pure PHP: prioritas constant -> getenv() -> default */
    private function cfg(string $key, $default = null) {
        if (defined($key)) return constant($key);
        $env = getenv($key);
        if ($env !== false && $env !== null && $env !== '') return $env;
        return $default;
    }

    private function configure(): void {
        try {
            // === Baca konfigurasi ===
            $host       = (string) $this->cfg('MAIL_HOST', 'smtp.gmail.com');
            $port       = (int)    $this->cfg('MAIL_PORT', 587);
            $username   = (string) $this->cfg('MAIL_USERNAME', '');
            $password   = (string) $this->cfg('MAIL_PASSWORD', '');
            $encryption = strtolower((string)$this->cfg('MAIL_ENCRYPTION', 'tls')); // tls|ssl
            $fromEmail  = (string) $this->cfg('MAIL_FROM_ADDRESS', $username);
            $fromName   = (string) $this->cfg('MAIL_FROM_NAME', 'SIKC B 2023');

            // === PHPMailer dasar ===
            $this->mail->SMTPDebug  = 0; // ubah ke SMTP::DEBUG_SERVER saat debug
            $this->mail->isSMTP();
            $this->mail->Host       = $host;
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = $username;
            $this->mail->Password   = $password;

            if ($encryption === 'ssl' || $port === 465) {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $this->mail->Port       = 465;
            } else {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port       = $port ?: 587;
            }

            // Shared hosting sering CA-nya kurang → longgarkan (masih TLS, hanya verifikasi dimatikan)
            $this->mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $this->mail->isHTML(true);
            $this->mail->CharSet      = 'UTF-8';
            $this->mail->SMTPKeepAlive= false;
            $this->mail->setFrom($fromEmail ?: $username, $fromName ?: 'No-Reply');
            $this->mail->addReplyTo($fromEmail ?: $username, $fromName ?: 'No-Reply');

        } catch (Exception $e) {
            error_log("Mailer configure error: ".$e->getMessage());
        }
    }

    /** Kirim email reset password (fallback 587→465 otomatis) */
    public function sendPasswordReset(string $toEmail, string $toName, string $resetToken): bool {
        try {
            // Bersih dulu
            $this->mail->clearAllRecipients();
            $this->mail->clearAttachments();
            $this->mail->clearCustomHeaders();
            $this->mail->Subject = 'Reset Password - SIKC B 2023';

            // Penerima
            $this->mail->addAddress($toEmail, $toName);

            // Link reset
            $resetLink = $this->buildResetLink($resetToken);

            // Body
            $this->mail->Body    = $this->getPasswordResetTemplate($toName, $resetLink);
            $this->mail->AltBody = $this->getPasswordResetTextTemplate($toName, $resetLink);

            // Coba kirim jalur utama
            try {
                return $this->mail->send();
            } catch (Exception $e) {
                // Fallback ke SMTPS:465
                $this->mail->smtpClose();
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $this->mail->Port       = 465;
                $altHost = $this->cfg('MAIL_HOST_SSL', null);
                if ($altHost) $this->mail->Host = $altHost;
                return $this->mail->send();
            }
        } catch (Exception $e) {
            error_log("Mail sending error: ".$e->getMessage());
            return false;
        } finally {
            if (method_exists($this->mail, 'smtpClose')) $this->mail->smtpClose();
        }
        // Ensure a return value in case all other paths are bypassed
        return false;
    }

    /** Build URL reset murni dari APP_URL (stable di hosting & proxy) */
    private function buildResetLink(string $token): string {
        try {
            // Log untuk debugging
            error_log("Building reset link for token: " . substr($token, 0, 10) . "...");
            
            $base = rtrim((string)$this->cfg('APP_URL', ''), '/');
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            
            // Log environment detection
            error_log("Host detected: " . $host);
            error_log("APP_URL from config: " . ($base ?: 'empty'));
            
            // Jika APP_URL tidak diset, deteksi environment
            if ($base === '') {
                // Production hosting detection
                if (strpos($host, 'sikcb.my.id') !== false || 
                    strpos($host, '.infinityfreeapp.com') !== false || 
                    !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                    $base = 'https://sikcb.my.id';
                    error_log("Production environment detected, using: " . $base);
                } else {
                    // Development fallback
                    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                            (($_SERVER['SERVER_PORT'] ?? null) == 443);
                    $scheme = $https ? 'https://' : 'http://';
                    $base = $scheme . $host;
                    
                    // Add base path if needed (untuk subfolder development)
                    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
                    if (strpos($scriptName, '/kelaskita-cms') !== false) {
                        $base .= '/kelaskita-cms';
                    }
                    error_log("Development environment detected, using: " . $base);
                }
            }
            
            $resetUrl = $base . '/password/reset?token=' . urlencode($token);
            error_log("Final reset URL generated: " . $resetUrl);
            
            return $resetUrl;
            
        } catch (Exception $e) {
            error_log("Error in buildResetLink: " . $e->getMessage());
            // Fallback ke production URL
            return 'https://sikcb.my.id/password/reset?token=' . urlencode($token);
        }
    }

    /** Template HTML */
    private function getPasswordResetTemplate(string $name, string $resetLink): string {
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeLink = htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8');

        return '
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Reset Password</title>
<style>
body{margin:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#333}
.wrap{max-width:640px;margin:0 auto;padding:24px}
.card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 8px 28px rgba(0,0,0,.08)}
.hd{background:linear-gradient(135deg,#D4AF37,#B8941F);padding:28px;text-align:center}
.hd h1{color:#fff;margin:0;font-size:26px;letter-spacing:.3px}
.bd{padding:28px;background:#fafafa}
.bd h2{margin:0 0 8px;font-size:20px;color:#111827}
.bd p{margin:8px 0;line-height:1.6;color:#374151}
.btn{display:inline-block;background:#D4AF37;color:#fff!important;padding:14px 22px;border-radius:10px;text-decoration:none;font-weight:700;letter-spacing:.3px}
.btn:hover{background:#B8941F}
.warning{background:#fffbe6;border:1px solid #ffe58f;padding:14px;border-radius:8px;margin:18px 0;color:#8c6d1f}
.mono{word-break:break-all;background:#eef2f7;padding:12px;border-radius:8px;font-size:13px;border:2px solid #D4AF37;color:#111827}
.ft{text-align:center;color:#6b7280;font-size:12px;padding:20px}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <div class="hd"><h1>🎓 SIKC B 2023</h1></div>
    <div class="bd">
      <h2>Halo, '.$safeName.'!</h2>
      <p>Kami menerima permintaan untuk mereset password akun Anda di portal SIKC B 2023.</p>
      <p>Klik tombol di bawah ini untuk mereset password Anda:</p>
      <p style="text-align:center;margin:20px 0;">
        <a href="'.$safeLink.'" class="btn">Reset Password Saya</a>
      </p>
      <div class="warning">
        <strong>⚠️ Penting:</strong>
        <ul style="margin:8px 0 0 18px;padding:0;">
          <li>Link ini hanya berlaku selama <strong>1 jam</strong></li>
          <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
          <li>Jangan bagikan link ini kepada siapa pun</li>
        </ul>
      </div>
      <p><strong>Alternatif:</strong> Copy & paste link berikut ke address bar browser:</p>
      <p class="mono">'.$safeLink.'</p>
      <p style="color:#6b7280;font-size:12px;margin-top:10px;"><em>💡 Jika ada peringatan blokir tautan, buka tab baru lalu paste link di atas.</em></p>
      <p>Terima kasih,<br><strong>Tim SIKC B 2023</strong></p>
    </div>
    <div class="ft">
      Email ini dikirim otomatis, mohon jangan balas email ini.<br>
      &copy; '.date('Y').' SIKC B 2023. All rights reserved.
    </div>
  </div>
</div>
</body>
</html>';
    }

    /** Template plain text */
    private function getPasswordResetTextTemplate(string $name, string $resetLink): string {
        return "Halo, {$name}!\n\n".
               "Kami menerima permintaan untuk mereset password akun Anda di portal SIKC B 2023.\n\n".
               "LINK RESET PASSWORD:\n{$resetLink}\n\n".
               "CARA:\n1) Copy link di atas\n2) Paste ke address bar browser\n\n".
               "PENTING:\n- Berlaku 1 jam\n- Jika tidak merasa meminta, abaikan\n- Jangan bagikan link ini\n\n".
               "Terima kasih,\nTim SIKC B 2023\n";
    }

    /** Test koneksi SMTP (bisa gagal jika hosting blokir outbound SMTP) */
    public function testConnection(): bool {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress('test@example.com', 'Test User');
            $this->mail->Subject = 'Test Connection';
            $this->mail->Body    = 'Test email connection';

            $this->mail->SMTPDebug = 0;
            $ok = $this->mail->smtpConnect();
            $this->mail->smtpClose();
            $this->mail->clearAllRecipients();
            return $ok;
        } catch (Exception $e) {
            error_log("SMTP connection test failed: ".$e->getMessage());
            return false;
        }
    }


}
