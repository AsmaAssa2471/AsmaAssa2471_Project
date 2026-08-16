<?php
$pageTitle = 'Register';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';

$error = '';
$success = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($username === '' || $password === '' || $confirmPassword === '') {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
            $stmt->execute([':username' => $username]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $error = 'That username is already taken. Please choose another.';
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)');
                $stmt->execute([
                    ':username' => $username,
                    ':password_hash' => $passwordHash,
                ]);
                $success = 'Registration complete! <a href="login.php" class="alert-link">Click here to log in</a>.';
                $username = '';
            }
        } catch (PDOException $e) {
            $error = 'Unable to complete registration at this time. Please try again later.';
        }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-md-7 col-lg-6">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h2 class="card-title mb-3">Create Your Account</h2>
        <p class="text-muted mb-4">Join Verdant Tech Farms and manage your sustainable hydroponic solutions.</p>

        <?php if ($success): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif ($error): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form action="register.php" method="post">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-4">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-emerald">Register</button>
          </div>
        </form>

        <p class="text-center text-muted mt-4 mb-0">Already have an account? <a href="login.php">Log in here</a>.</p>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
