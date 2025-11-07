<?php
namespace App\Controllers;

use App\Core\{Auth, Session};
use App\Models\{User, Semester, Kelas, Gallery, MiniLibrary};
use PDO, PDOException, Exception;

class AdminController {
    private PDO $pdo;
    private User $users;
    private Semester $sem;
    private Kelas $cls;
    private Gallery $gal;
    private MiniLibrary $miniLib;

    public function __construct() {
        global $pdo;
        
        if (!($pdo instanceof PDO)) {
            $this->initializeDatabase();
            $pdo = $GLOBALS['pdo'];
        }
        
        $this->pdo = $pdo;
        $this->users = new User($pdo);
        $this->sem = new Semester($pdo);
        $this->cls = new Kelas($pdo);
        $this->gal = new Gallery($pdo);
        $this->miniLib = new MiniLibrary($pdo);
    }

    /**
     * Initialize database connection
     */
    private function initializeDatabase(): void {
        global $pdo;
        
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            $GLOBALS['pdo'] = $pdo;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed. Please contact administrator.");
        }
    }

    /**
     * Render view with layout
     */
    private function render(string $view, array $data = []): void {
        extract($data);
        include __DIR__ . '/../Views/layout/admin_header.php';
        include __DIR__ . '/../Views/' . $view . '.php';
        include __DIR__ . '/../Views/layout/admin_footer.php';
    }

    /**
     * Admin dashboard
     */
    public function index(): void {
        Auth::requireAdmin();
        $this->render('admin/index');
    }

    // ==================== USER MANAGEMENT ====================

    /**
     * Display all users
     */
    public function users(): void {
        Auth::requireAdmin();
        
        $stmt = $this->pdo->query('SELECT * FROM users ORDER BY id DESC');
        $rows = $stmt->fetchAll();
        
        $this->render('admin/users', compact('rows'));
    }

    /**
     * Add new user
     */
    public function userAdd(): void {
        Auth::requireAdmin();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Session::flash('error', 'Invalid request method.');
                redirect('admin/users');
                return;
            }
            
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';
            
            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                Session::flash('error', 'Semua field harus diisi.');
                redirect('admin/users');
                return;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::flash('error', 'Format email tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if (!in_array($role, ['user', 'admin'])) {
                Session::flash('error', 'Role tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if (strlen($password) < 6) {
                Session::flash('error', 'Password minimal 6 karakter.');
                redirect('admin/users');
                return;
            }
            
            // Check if email exists
            $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                Session::flash('error', 'Email sudah terdaftar.');
                redirect('admin/users');
                return;
            }
            
            // Insert user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare(
                'INSERT INTO users (name, email, password_hash, role, created_at) 
                 VALUES (?, ?, ?, ?, UNIX_TIMESTAMP())'
            );
            
            if ($stmt->execute([$name, $email, $hashedPassword, $role])) {
                Session::flash('success', 'User "' . htmlspecialchars($name) . '" berhasil ditambahkan.');
            } else {
                Session::flash('error', 'Gagal menambahkan user.');
            }
            
        } catch (Exception $e) {
            error_log("Error in userAdd: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menambahkan user.');
        }
        
        redirect('admin/users');
    }

    /**
     * Edit user
     */
    public function userEdit(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'user';
            
            // Validation
            if ($id <= 0 || empty($name) || empty($email)) {
                Session::flash('error', 'Data tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::flash('error', 'Format email tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if (!in_array($role, ['user', 'admin'])) {
                Session::flash('error', 'Role tidak valid.');
                redirect('admin/users');
                return;
            }
            
            // Check email uniqueness (excluding current user)
            $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
            $stmt->execute([$email, $id]);
            
            if ($stmt->fetch()) {
                Session::flash('error', 'Email sudah digunakan oleh user lain.');
                redirect('admin/users');
                return;
            }
            
            $stmt = $this->pdo->prepare('UPDATE users SET name=?, email=?, role=? WHERE id=?');
            
            if ($stmt->execute([$name, $email, $role, $id])) {
                Session::flash('success', 'User "' . htmlspecialchars($name) . '" berhasil diperbarui.');
            } else {
                Session::flash('error', 'Gagal memperbarui user.');
            }
            
        } catch (Exception $e) {
            error_log("Error in userEdit: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat memperbarui user.');
        }
        
        redirect('admin/users');
    }

    /**
     * Change user role
     */
    public function changeRole(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            $role = $_POST['role'] ?? 'user';
            
            if ($id <= 0) {
                Session::flash('error', 'ID user tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if (!in_array($role, ['user', 'admin'])) {
                Session::flash('error', 'Role tidak valid.');
                redirect('admin/users');
                return;
            }
            
            if ($this->users->setRole($id, $role)) {
                Session::flash('success', 'Role user berhasil diperbarui menjadi ' . ucfirst($role) . '.');
            } else {
                Session::flash('error', 'Gagal memperbarui role user.');
            }
            
        } catch (Exception $e) {
            error_log("Error in changeRole: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat memperbarui role.');
        }
        
        redirect('admin/users');
    }

    /**
     * Delete user
     */
    public function deleteUser(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                Session::flash('error', 'ID user tidak valid.');
                redirect('admin/users');
                return;
            }
            
            // Prevent self-deletion
            if ($id === (int)(Auth::user()['id'] ?? 0)) {
                Session::flash('warning', 'Anda tidak dapat menghapus akun Anda sendiri.');
                redirect('admin/users');
                return;
            }
            
            // Get user info before deletion
            $stmt = $this->pdo->prepare('SELECT name, email FROM users WHERE id = ?');
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            
            if ($this->users->delete($id)) {
                $userName = $user ? ($user['name'] ?: $user['email']) : 'User';
                Session::flash('success', 'User "' . htmlspecialchars($userName) . '" berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus user.');
            }
            
        } catch (Exception $e) {
            error_log("Error in deleteUser: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menghapus user.');
        }
        
        redirect('admin/users');
    }

    // ==================== SEMESTER MANAGEMENT ====================

    /**
     * Display all semesters
     */
    public function semesters(): void {
        Auth::requireAdmin();
        
        $semesters = $this->sem->all();
        $this->render('admin/semesters', compact('semesters'));
    }

    /**
     * Save semester (add/edit)
     */
    public function semesterSave(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $operation = $_POST['operation'] ?? 'add';
            $data = $_POST;
            $semesterName = htmlspecialchars($data['name'] ?? 'Semester');
            
            if ($this->handleSemesterOperation($operation, $data)) {
                $message = $operation === 'add' 
                    ? 'Semester "' . $semesterName . '" berhasil ditambahkan.'
                    : 'Semester "' . $semesterName . '" berhasil diperbarui.';
                Session::flash('success', $message);
            } else {
                Session::flash('error', 'Gagal menyimpan semester.');
            }
            
        } catch (Exception $e) {
            error_log("Error in semesterSave: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menyimpan semester.');
        }
        
        redirect('admin/semesters');
    }

    /**
     * Delete semester
     */
    public function semesterDelete(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                Session::flash('error', 'ID semester tidak valid.');
                redirect('admin/semesters');
                return;
            }
            
            // Get semester info before deletion
            $stmt = $this->pdo->prepare('SELECT name FROM semesters WHERE id = ?');
            $stmt->execute([$id]);
            $semester = $stmt->fetch();
            
            if ($this->sem->delete($id)) {
                $semesterName = htmlspecialchars($semester['name'] ?? 'Semester');
                Session::flash('success', 'Semester "' . $semesterName . '" berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus semester.');
            }
            
        } catch (Exception $e) {
            error_log("Error in semesterDelete: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menghapus semester.');
        }
        
        redirect('admin/semesters');
    }

    // ==================== CLASS MANAGEMENT ====================

    /**
     * Display all classes
     */
    public function classes(): void {
        Auth::requireAdmin();
        
        $semesters = $this->sem->all();
        $users = $this->pdo->query(
            "SELECT id, name, email FROM users WHERE role = 'user' ORDER BY name"
        )->fetchAll();
        
        $semesterFilter = (int)($_GET['semester_id'] ?? 0);
        
        $query = "
            SELECT c.*, s.name as semester_name, u.name as pj_name 
            FROM classes c 
            LEFT JOIN semesters s ON c.semester_id = s.id 
            LEFT JOIN users u ON c.pj_user_id = u.id 
        ";
        
        if ($semesterFilter > 0) {
            $query .= " WHERE c.semester_id = " . $semesterFilter;
        }
        
        $query .= " ORDER BY s.name, c.name";
        $classes = $this->pdo->query($query)->fetchAll();
        
        $this->render('admin/classes', compact('semesters', 'users', 'classes'));
    }

    /**
     * Save class (add/edit)
     */
    public function classSave(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $operation = $_POST['operation'] ?? 'add';
            $semester_id = (int)($_POST['semester_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $teacher = trim($_POST['teacher'] ?? '');
            $schedule = trim($_POST['schedule'] ?? '');
            $sks = (int)($_POST['sks'] ?? 3);
            $status = $_POST['status'] ?? 'active';
            $description = trim($_POST['description'] ?? '');
            $pj_user_id = !empty($_POST['pj_user_id']) ? (int)$_POST['pj_user_id'] : null;
            $link = trim($_POST['link'] ?? '');
            // Validation
            if ($semester_id <= 0 || empty($name)) {
                Session::flash('error', 'Semester dan nama mata kuliah harus diisi.');
                redirect('admin/classes');
                return;
            }
            
            if ($operation === 'add') {
                $stmt = $this->pdo->prepare(
                    'INSERT INTO classes (semester_id, name, status, description, teacher, schedule, sks, pj_user_id, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP())'
                );
                
                if ($stmt->execute([$semester_id, $name, $status, $description, $teacher, $schedule, $sks, $pj_user_id])) {
                    Session::flash('success', 'Mata kuliah "' . htmlspecialchars($name) . '" berhasil ditambahkan.');
                }
                
            } elseif ($operation === 'edit') {
                $id = (int)($_POST['id'] ?? 0);
                
                if ($id <= 0) {
                    Session::flash('error', 'ID mata kuliah tidak valid.');
                    redirect('admin/classes');
                    return;
                }
                
                $stmt = $this->pdo->prepare(
                    'UPDATE classes 
                     SET semester_id=?, name=?, status=?, description=?, teacher=?, schedule=?, sks=?, pj_user_id=? 
                     WHERE id=?'
                );
                
                if ($stmt->execute([$semester_id, $name, $status, $description, $teacher, $schedule, $sks, $pj_user_id, $id])) {
                    Session::flash('success', 'Mata kuliah "' . htmlspecialchars($name) . '" berhasil diperbarui.');
                }
            }
            
        } catch (Exception $e) {
            error_log("Error in classSave: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menyimpan mata kuliah.');
        }
        
        redirect('admin/classes');
    }

    /**
     * Delete class
     */
    public function classDelete(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            $semesterId = (int)($_POST['semester_id'] ?? 0);
            
            if ($id <= 0) {
                Session::flash('error', 'ID mata kuliah tidak valid.');
                redirect('admin/classes');
                return;
            }
            
            if ($this->cls->delete($id)) {
                Session::flash('success', 'Mata kuliah berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus mata kuliah.');
            }
            
        } catch (Exception $e) {
            error_log("Error in classDelete: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menghapus mata kuliah.');
        }
        
        redirect('admin/classes' . ($semesterId > 0 ? '?semester_id=' . $semesterId : ''));
    }

    // ==================== GALLERY MANAGEMENT ====================

    /**
     * Display gallery
     */
    public function gallery(): void {
        Auth::requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleGalleryUpload();
            return;
        }
        
        $semesters = $this->sem->all();
        $sid = (int)($_GET['semester_id'] ?? ($semesters[0]['id'] ?? 0));
        $gallery = $sid ? $this->gal->bySemester($sid) : [];
        
        // Add image URL for each item
        foreach ($gallery as &$item) {
            $item['image_url'] = url('image/gallery/' . $item['id']);
        }
        
        $this->render('admin/gallery', compact('semesters', 'sid', 'gallery'));
    }

    /**
     * Handle gallery upload
     */
    private function handleGalleryUpload(): void {
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $semesterId = (int)($_POST['semester_id'] ?? 0);
            $caption = $_POST['caption'] ?? null;
            
            if (!isset($_FILES['gallery_image']) || $_FILES['gallery_image']['error'] !== UPLOAD_ERR_OK) {
                Session::flash('error', 'Pilih file gambar.');
                redirect('admin/gallery?semester_id=' . $semesterId);
                return;
            }
            
            $imageData = $this->processImageUpload($_FILES['gallery_image']);
            
            if ($imageData && $this->gal->save(null, $semesterId, $imageData, $caption)) {
                Session::flash('success', 'Gambar berhasil diupload.');
            } else {
                Session::flash('error', 'Gagal mengupload gambar.');
            }
            
        } catch (Exception $e) {
            error_log("Error in handleGalleryUpload: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat mengupload gambar.');
        }
        
        redirect('admin/gallery?semester_id=' . ($semesterId ?? 0));
    }

    /**
     * Delete gallery item
     */
    public function galleryDelete(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            $semesterId = (int)$_POST['semester_id'];
            
            if ($id <= 0) {
                Session::flash('error', 'ID gambar tidak valid.');
                redirect('admin/gallery');
                return;
            }
            
            if ($this->gal->delete($id)) {
                Session::flash('success', 'Gambar berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus gambar.');
            }
            
        } catch (Exception $e) {
            error_log("Error in galleryDelete: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menghapus gambar.');
        }
        
        redirect('admin/gallery?semester_id=' . $semesterId);
    }

    // ==================== MINI LIBRARY MANAGEMENT ====================

    /**
     * Display mini library
     */
    public function miniLibrary(): void {
        Auth::requireAdmin();
        
        $libraries = $this->miniLib->getAllWithMembers();
        $this->render('admin/mini_library', compact('libraries'));
    }

    /**
     * Save mini library (add/edit)
     */
    public function miniLibrarySave(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $groupName = trim($_POST['group_name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $image = trim($_POST['image'] ?? '');
            $members = $_POST['members'] ?? [];
            $link = trim($_POST['link'] ?? '');
            if (!empty($link) && !preg_match('/^https?:\/\//i', $link)) {
                $link = 'https://' . $link;
            }
            // Validation
            if (empty($groupName) || empty($description) || empty($category)) {
                Session::flash('error', 'Semua field wajib harus diisi.');
                redirect('admin/mini_library');
                return;
            }
            // Handle image upload or use existing/default
            if (isset($_FILES['library_image']) && $_FILES['library_image']['error'] === UPLOAD_ERR_OK) {
                $imageData = $this->processImageUpload($_FILES['library_image']);
                
                if ($imageData) {
                    $base64 = base64_encode($imageData['data']);
                    $image = 'data:' . $imageData['type'] . ';base64,' . $base64;
                } else {
                    redirect('admin/mini_library');
                    return;
                }
            } elseif (empty($image)) {
                $image = 'https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?q=80&w=500&auto=format&fit=crop';
            }
            // Filter empty members
            $members = array_values(array_filter(
                array_map('trim', $members),
                function($m) { return !empty($m); }
            ));
            
            if (empty($members)) {
                Session::flash('error', 'Minimal harus ada satu anggota tim.');
                redirect('admin/mini_library');
                return;
            }
            
            // Save
            if ($id) {
                // Ambil gambar lama dari database jika tidak ada upload baru
                if ((empty($image) || $image === '') && (!isset($_FILES['library_image']) || $_FILES['library_image']['error'] !== UPLOAD_ERR_OK)) {
                    $stmt = $this->pdo->prepare('SELECT image FROM mini_library WHERE id = ?');
                    $stmt->execute([$id]);
                    $row = $stmt->fetch();
                    if ($row && !empty($row['image'])) {
                        $image = $row['image'];
                    }
                }
                
                $result = $this->miniLib->update($id, $groupName, $description, $category, $link, $image, $members);
                $message = $result 
                    ? 'Mini Library "' . htmlspecialchars($groupName) . '" berhasil diperbarui.'
                    : 'Gagal memperbarui Mini Library.';
            } else {
                $result = $this->miniLib->create($groupName, $description, $category, $link, $image, $members);
                $message = $result 
                    ? 'Mini Library "' . htmlspecialchars($groupName) . '" berhasil ditambahkan.'
                    : 'Gagal menambahkan Mini Library. ' . (isset($this->miniLib->lastError) ? $this->miniLib->lastError : '');
            }
            
            Session::flash($result ? 'success' : 'error', $message);
            
        } catch (Exception $e) {
            error_log("Error in miniLibrarySave: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menyimpan Mini Library. ' . $e->getMessage());
        }
        
        redirect('admin/mini_library');
    }

    /**
     * Delete mini library
     */
    public function miniLibraryDelete(): void {
        Auth::requireAdmin();
        
        try {
            Session::checkCsrf($_POST['_csrf'] ?? null);
            
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                Session::flash('error', 'ID tidak valid.');
                redirect('admin/mini_library');
                return;
            }
            
            // Get library info before deletion
            $stmt = $this->pdo->prepare('SELECT group_name FROM mini_library WHERE id = ?');
            $stmt->execute([$id]);
            $library = $stmt->fetch();
            
            if ($this->miniLib->delete($id)) {
                $libraryName = htmlspecialchars($library['group_name'] ?? 'Mini Library');
                Session::flash('success', 'Mini Library "' . $libraryName . '" berhasil dihapus.');
            } else {
                Session::flash('error', 'Gagal menghapus Mini Library.');
            }
            
        } catch (Exception $e) {
            error_log("Error in miniLibraryDelete: " . $e->getMessage());
            Session::flash('error', 'Terjadi kesalahan saat menghapus Mini Library.');
        }
        
        redirect('admin/mini_library');
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get upload error message
     */
    private function getUploadErrorMessage(int $error): string {
        return match($error) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File terlalu besar',
            UPLOAD_ERR_PARTIAL => 'File tidak terupload sempurna',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang dipilih',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ada',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi',
            default => 'Error tidak diketahui'
        };
    }

    /**
     * Process image upload to database with automatic compression
     */
    private function processImageUpload(array $file): ?array {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Upload gagal: ' . $this->getUploadErrorMessage($file['error']));
            return null;
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            Session::flash('error', 'Format file tidak didukung. Gunakan: JPG, PNG, GIF, atau WEBP');
            return null;
        }

        $tmpPath = $file['tmp_name'];
        $mime = $file['type'] ?? null;

        // Try to compress and resize image. If compression fails, store original bytes.
        $compressed = $this->compressAndResizeImage($tmpPath, $file['name'], $mime);
        if ($compressed) {
            return $compressed;
        }

        // Fallback to original file bytes if compression is unavailable
        $imageData = @file_get_contents($tmpPath);
        if ($imageData === false) {
            Session::flash('error', 'Gagal membaca file gambar');
            return null;
        }

        return [
            'data' => $imageData,
            'type' => $mime ?: 'application/octet-stream',
            'name' => $file['name']
        ];
    }

    /**
     * Compress and resize image using GD (if available)
     * - Resizes to max 1600px on longer side
     * - Outputs WebP (quality 80) when supported, else JPEG (quality 80)
     * - Preserves PNG transparency when writing WebP; if JPEG fallback, flattens on white
     * - For animated GIFs, returns original (to avoid losing animation)
     */
    private function compressAndResizeImage(string $tmpPath, string $originalName, ?string $mime): ?array {
        if (!function_exists('imagecreatetruecolor')) {
            return null; // GD not available
        }

        // Detect mime if not provided
        if (!$mime) {
            $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : null;
            $mime = $finfo ? finfo_file($finfo, $tmpPath) : null;
            if ($finfo) finfo_close($finfo);
        }

        $mime = strtolower((string)$mime);

        // Handle animated GIF: keep original to avoid breaking animation
        if (str_contains($mime, 'gif')) {
            // Quick check for animated GIF (multiple frames)
            $isAnimated = false;
            $fh = @fopen($tmpPath, 'rb');
            if ($fh) {
                $chunk = @fread($fh, 1024 * 100); // read first 100KB
                @fclose($fh);
                if ($chunk !== false) {
                    $isAnimated = (substr_count($chunk, "\x00\x21\xF9\x04") > 1) && (substr_count($chunk, "\x00\x2C") > 1);
                }
            }
            if ($isAnimated) {
                $bytes = @file_get_contents($tmpPath);
                if ($bytes === false) return null;
                return [
                    'data' => $bytes,
                    'type' => 'image/gif',
                    'name' => $originalName
                ];
            }
        }

        // Create image resource
        $src = @imagecreatefromstring(@file_get_contents($tmpPath));
        if (!$src) { return null; }

        $width = imagesx($src);
        $height = imagesy($src);
        if (!$width || !$height) { imagedestroy($src); return null; }

        // Handle EXIF orientation for JPEGs
        if (function_exists('exif_read_data') && (str_contains($mime, 'jpeg') || str_contains($mime, 'jpg'))) {
            $exif = @exif_read_data($tmpPath);
            $orientation = $exif['Orientation'] ?? 1;
            if (in_array($orientation, [3, 6, 8], true)) {
                if ($orientation === 3) { $src = imagerotate($src, 180, 0); }
                if ($orientation === 6) { $src = imagerotate($src, -90, 0); }
                if ($orientation === 8) { $src = imagerotate($src, 90, 0); }
                $width = imagesx($src);
                $height = imagesy($src);
            }
        }

        // Resize maintaining aspect ratio to max 1400px (leaner)
        $maxDim = 1400;
        $scale = 1.0;
        if ($width > $height && $width > $maxDim) { $scale = $maxDim / $width; }
        elseif ($height >= $width && $height > $maxDim) { $scale = $maxDim / $height; }

        $dst = $src;
        if ($scale < 1.0) {
            $newW = max(1, (int)round($width * $scale));
            $newH = max(1, (int)round($height * $scale));
            $dst = imagecreatetruecolor($newW, $newH);

            // Preserve alpha for PNG/WebP
            if (str_contains($mime, 'png') || str_contains($mime, 'webp')) {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                imagefilledrectangle($dst, 0, 0, $newW, $newH, $transparent);
            }
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $width, $height);
            imagedestroy($src);
        }

        // Output: Prefer WebP if supported, else JPEG
        $supportsWebP = function_exists('imagewebp');
        $useWebP = $supportsWebP;
        $buffer = null;
        $outMime = $useWebP ? 'image/webp' : 'image/jpeg';
        $outName = pathinfo($originalName, PATHINFO_FILENAME) . ($useWebP ? '.webp' : '.jpg');

        ob_start();
        if ($useWebP) {
            // quality 75 is lean balance
            imagewebp($dst, null, 75);
        } else {
            // Flatten alpha onto white when using JPEG
            if (str_contains($mime, 'png') || str_contains($mime, 'webp')) {
                $bg = imagecreatetruecolor(imagesx($dst), imagesy($dst));
                $white = imagecolorallocate($bg, 255, 255, 255);
                imagefilledrectangle($bg, 0, 0, imagesx($dst), imagesy($dst), $white);
                imagecopy($bg, $dst, 0, 0, 0, 0, imagesx($dst), imagesy($dst));
                imagedestroy($dst);
                $dst = $bg;
            }
            imagejpeg($dst, null, 75);
        }
        $buffer = ob_get_clean();

        if (is_resource($dst) || (class_exists('GdImage', false) && $dst instanceof \GdImage)) { imagedestroy($dst); }

        if ($buffer === false) { return null; }
        return [
            'data' => $buffer,
            'type' => $outMime,
            'name' => $outName,
        ];
    }

    /**
     * Handle semester operations
     */
    private function handleSemesterOperation(string $operation, array $data): bool {
        try {
            $coverImageData = null;
            
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $coverImageData = $this->processImageUpload($_FILES['cover_image']);
                if (!$coverImageData) {
                    return false;
                }
            }
            
            return match($operation) {
                'add' => $this->sem->save(null, $data['name'], $data['term_label'], $data['description'], $coverImageData),
                'edit' => $this->sem->save($data['id'], $data['name'], $data['term_label'], $data['description'], $coverImageData),
                'delete' => $this->sem->delete($data['id']),
                default => false
            };
            
        } catch (Exception $e) {
            error_log("Error in handleSemesterOperation: " . $e->getMessage());
            return false;
        }
    }
}
