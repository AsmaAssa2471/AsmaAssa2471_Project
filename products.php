<?php
$pageTitle = 'Products';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';

// Fetch categories
try {
    $stmt = $pdo->query('SELECT id, category_name, slug FROM categories ORDER BY category_name');
    $categories = $stmt->fetchAll();
} catch (Exception $e) {
    $categories = [];
}

// Fetch products with category info
try {
    $stmt = $pdo->query(
        'SELECT p.*, c.category_name, c.slug
         FROM products p
         JOIN categories c ON p.category_id = c.id
         ORDER BY p.created_at DESC'
    );
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    $products = [];
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Products</h1>
  <div id="filter-buttons" class="btn-group" role="group" aria-label="Category filters">
    <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">All</button>
    <?php foreach ($categories as $cat): ?>
      <button type="button" class="btn btn-outline-secondary filter-btn" data-filter="<?php echo htmlspecialchars($cat['slug']); ?>"><?php echo htmlspecialchars($cat['category_name']); ?></button>
    <?php endforeach; ?>
  </div>
</div>

<div class="row" id="product-grid">
  <?php if (!empty($products)):
    foreach ($products as $product): ?>
      <div class="col-md-4 mb-4 product-card" data-category="<?php echo htmlspecialchars($product['slug']); ?>">
        <div class="card h-100">
          <div class="d-flex align-items-center justify-content-center bg-light p-2" style="height: 220px; overflow: hidden;">
            <img src="<?php echo htmlspecialchars(!empty($product['image_path']) ? $product['image_path'] : 'uploads/default.jpg'); ?>" class="img-fluid w-100" style="height: 200px; width: 100%; object-fit: contain;" alt="<?php echo htmlspecialchars($product['title']); ?>" onerror="this.onerror=null;this.src='uploads/default.jpg';">
          </div>
          <div class="card-body d-flex flex-column">
            <span class="badge bg-success mb-2"><?php echo htmlspecialchars($product['category_name']); ?></span>
            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
            <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars(substr($product['description'] ?? '', 0, 160))); ?><?php echo (strlen($product['description'] ?? '') > 160) ? '...' : ''; ?></p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <strong class="text-primary">$<?php echo number_format($product['price'], 2); ?></strong>
              <a href="<?= BASE_URL ?>product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">View</a>
            </div>
          </div>
        </div>
      </div>
  <?php endforeach; else: ?>
    <div class="col-12">
      <p class="text-muted">No products available.</p>
    </div>
  <?php endif; ?>
</div>

<!-- jQuery for client-side filtering -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function(){
    $('#filter-buttons').on('click', '.filter-btn', function(){
      var filter = $(this).data('filter');
      $('#filter-buttons .filter-btn').removeClass('active');
      $(this).addClass('active');

      if (filter === 'all') {
        $('.product-card').fadeIn(200);
      } else {
        $('.product-card').each(function(){
          var cat = $(this).data('category');
          if (cat === filter) {
            $(this).fadeIn(200);
          } else {
            $(this).fadeOut(150);
          }
        });
      }
    });
  });
</script>

<?php
require_once __DIR__ . '/footer.php';
?>
