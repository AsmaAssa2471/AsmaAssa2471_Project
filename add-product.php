<?php
$pageTitle = 'Add Product';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';

$success = '';
$error = '';
$categories = [];

try {
    $stmt = $pdo->query('SELECT id, category_name FROM categories ORDER BY category_name');
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Unable to load categories. Please try again later.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category_id = trim($_POST['category_id'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    if ($title === '' || $category_id === '' || $description === '' || $price === '') {
        $error = 'Please complete all required fields.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Please enter a valid price.';
    } elseif (empty($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
        $error = 'Please upload a product image.';
    } else {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            $error = 'Unable to create upload directory.';
        }
    }

    if ($error === '') {
        $image = $_FILES['product_image'];
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        $fileExt = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($fileExt, $allowedTypes, true)) {
            $error = 'Only JPG, JPEG and PNG images are allowed.';
        } elseif ($image['size'] > $maxSize) {
            $error = 'Image size must be 2MB or less.';
        } else {
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', basename($image['name']));
            $destination = $uploadDir . $safeName;

            if (!move_uploaded_file($image['tmp_name'], $destination)) {
                $error = 'Failed to save uploaded image.';
            }
        }
    }

    if ($error === '') {
        try {
            $stmt = $pdo->prepare('INSERT INTO products (category_id, title, description, price, image_path, is_featured) VALUES (:category_id, :title, :description, :price, :image_path, :is_featured)');
            $stmt->execute([
                ':category_id' => $category_id,
                ':title' => $title,
                ':description' => $description,
                ':price' => number_format((float)$price, 2, '.', ''),
                ':image_path' => 'uploads/' . $safeName,
                ':is_featured' => $is_featured,
            ]);
            $success = 'Product added successfully.';
            $title = $description = $price = '';
            $category_id = '';
            $is_featured = 0;
        } catch (PDOException $e) {
            $error = 'Database error while saving the product.';
            if (isset($destination) && file_exists($destination)) {
                unlink($destination);
            }
        }
    }
}
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h2 class="h5 mb-3">Add New Product</h2>

        <?php if ($success): ?>
          <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif ($error): ?>
          <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="add-product.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label">Product Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
          </div>

          <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
              <option value="">Select category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo (isset($category_id) && $category_id == $category['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($category['category_name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($price ?? ''); ?>" required>
          </div>

          <div class="mb-3">
            <label for="product_image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" <?php echo (!empty($is_featured)) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_featured">Is Featured</label>
          </div>

          <button type="submit" class="btn btn-emerald">Save Product</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
