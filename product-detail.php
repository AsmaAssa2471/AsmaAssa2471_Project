
<?php
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($pageTitle)) { $pageTitle = 'Product Detail'; }
require_once __DIR__ . '/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: ' . BASE_URL . 'products.php');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();
} catch (Exception $e) {
    $product = false;
}

if (!$product) {
    header('Location: ' . BASE_URL . 'products.php');
    exit;
}

// Friendly field fallbacks
$title = $product['title'] ?? 'Untitled Product';
$description = $product['description'] ?? '';
$price = isset($product['price']) ? number_format($product['price'], 2) : '0.00';
$category = $product['category_name'] ?? 'Uncategorized';
$stock = isset($product['stock']) ? (int)$product['stock'] : null;
$sku = $product['sku'] ?? ($product['product_code'] ?? 'N/A');
$created = isset($product['created_at']) && $product['created_at'] ? date('M j, Y', strtotime($product['created_at'])) : 'Unknown';
$image = !empty($product['image_path']) ? $product['image_path'] : BASE_URL . 'uploads/default.jpg';

?>

<div class="py-4">
  <?php if (!empty($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <a href="<?= BASE_URL ?>products.php" class="btn btn-outline-secondary mb-3">&larr; Back to Products</a>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="border rounded p-3 d-flex align-items-center justify-content-center" style="height:520px; background:#fff;">
            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($title); ?>" class="img-fluid rounded shadow-sm" style="max-height:100%; width:auto; object-fit:contain;" onerror="this.onerror=null;this.src='<?= BASE_URL ?>uploads/default.jpg';">
          </div>
          <div class="text-muted small mt-2">Product code: <?php echo htmlspecialchars($sku); ?> · Added: <?php echo htmlspecialchars($created); ?></div>
        </div>

        <div class="col-md-6">
          <h2 class="mb-2"><?php echo htmlspecialchars($title); ?></h2>
          <div class="mb-3">
            <span class="h4 text-primary">$<?php echo $price; ?></span>
            <span class="badge bg-secondary ms-2"><?php echo htmlspecialchars($category); ?></span>
            <?php if ($stock === null): ?>
              <span class="badge bg-warning text-dark ms-2">Stock unknown</span>
            <?php elseif ($stock > 0): ?>
              <span class="badge bg-success ms-2">In Stock</span>
            <?php else: ?>
              <span class="badge bg-danger ms-2">Out of Stock</span>
            <?php endif; ?>
          </div>

          <?php
          // Prepare enhanced product copy and fallbacks
          $plain_desc = trim(strip_tags($description));
          $is_short = $plain_desc === '' || mb_strlen($plain_desc) < 150;

          if ($is_short) {
              $headline = sprintf('%s — Exceptional %s for everyday performance.', $title, $category);

              $features = [
                  'Premium build quality: crafted from high-grade materials to withstand daily use and last for years.',
                  'Precision engineered: delivers reliable performance and consistent results with every use.',
                  'User-friendly design: intuitive setup and comfortable handling for both beginners and experienced users.',
                  'Dependable support: backed by responsive customer service and a limited warranty for peace of mind.',
              ];

              $specs = [
                  'Model' => $sku,
                  'Category' => $category,
                  'Price' => '$' . $price,
                  'Material' => $product['material'] ?? 'High-grade components',
                  'Dimensions' => $product['dimensions'] ?? 'Varies by model',
                  'Weight' => $product['weight'] ?? 'N/A',
                  'Warranty' => $product['warranty'] ?? '1 year limited warranty',
              ];
          } else {
              // Use provided description but still extract a short headline
              $sentences = preg_split('/(?<=[.!?])\s+/', $plain_desc, 2);
              $headline = isset($sentences[0]) ? $sentences[0] : ($title . ' — Great choice');

              // Derive features from the longer description by splitting into lines or sentences
              $features = [];
              $pieces = preg_split('/[\r\n]+|(?<=[.!?])\s+/', $plain_desc);
              $count = 0;
              foreach ($pieces as $p) {
                  $p = trim($p);
                  if ($p === '') continue;
                  $features[] = $p;
                  $count++;
                  if ($count >= 5) break;
              }

              $specs = [
                  'Model' => $sku,
                  'Category' => $category,
                  'Price' => '$' . $price,
                  'Warranty' => $product['warranty'] ?? '1 year limited warranty',
              ];
          }
          ?>

          <div class="mb-4">
            <h5>Description</h5>

            <p class="lead text-dark mb-2"><?php echo htmlspecialchars($headline); ?></p>

            <div class="mb-3 text-muted small">
              <?php if (!$is_short): ?>
                <?php echo nl2br(htmlspecialchars($description)); ?>
              <?php else: ?>
                <p><?php echo htmlspecialchars($plain_desc ?: 'Discover a reliable, well-made product that exceeds expectations.'); ?></p>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <h6>Key Features & Benefits</h6>
              <ul class="list-unstyled small">
                <?php foreach ($features as $f): ?>
                  <li class="mb-1">&check; <?php echo htmlspecialchars($f); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="mb-3">
              <h6>Technical Specifications</h6>
              <table class="table table-sm">
                <tbody>
                  <?php foreach ($specs as $k => $v): ?>
                    <tr>
                      <th style="width:35%;"><?php echo htmlspecialchars($k); ?></th>
                      <td><?php echo htmlspecialchars($v); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="mb-3 d-flex gap-2">
              <div class="badge bg-light text-dark border">Free 7-Day Returns</div>
              <div class="badge bg-light text-dark border">100% Authentic Quality</div>
              <div class="badge bg-light text-dark border">Fast Delivery</div>
            </div>

            <div class="accordion" id="shippingWarrantyAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Shipping & Warranty Info
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#shippingWarrantyAccordion">
                  <div class="accordion-body small text-muted">
                    <strong>Shipping:</strong> We offer fast, trackable shipping options with same-week dispatch on most orders. Delivery times vary by destination and selected shipping method.
                    <br><strong>Warranty:</strong> This product includes a <?php echo htmlspecialchars($specs['Warranty'] ?? '1 year limited warranty'); ?>. Please retain your receipt for warranty claims.
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form method="post" action="<?= BASE_URL ?>cart.php" class="d-flex align-items-center">
            <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">
            <input type="hidden" name="price" value="<?php echo isset($product['price']) ? htmlspecialchars($product['price']) : '0'; ?>">
            <div class="me-2" style="width:110px;">
              <label for="quantity" class="form-label small mb-1">Quantity</label>
              <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" <?php echo ($stock !== null && $stock > 0) ? 'max="' . $stock . '"' : ''; ?> <?php echo ($stock === 0) ? 'disabled' : ''; ?> >
            </div>

            <div class="ms-2">
              <button type="submit" class="btn btn-emerald" <?php echo ($stock === 0) ? 'disabled' : ''; ?>>Add to Cart</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

