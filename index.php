<?php
$pageTitle = 'Home';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';

// Fetch featured products
try {
    $stmt = $pdo->prepare(
        'SELECT p.*, c.category_name
         FROM products p
         JOIN categories c ON p.category_id = c.id
         WHERE p.is_featured = 1
         ORDER BY p.created_at DESC'
    );
    $stmt->execute();
    $featured = $stmt->fetchAll();
} catch (Exception $e) {
    $featured = [];
}
?>

<section class="py-5 text-center bg-light rounded-3 mb-5">
  <div class="container">
    <h1 class="display-5 fw-bold">Verdant Tech Farms</h1>
    <p class="lead mb-4">Sustainable, smart hydroponic systems for modern growers — efficient, automated, and organic.</p>
    <a class="btn btn-emerald btn-lg" href="products.php" role="button">Browse Products</a>
  </div>
</section>

<section id="featured" class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h4">Featured Systems</h2>
    <a href="products.php" class="small">View all products &raquo;</a>
  </div>

  <div class="row">
    <?php if (!empty($featured)):
      foreach ($featured as $product): ?>
        <div class="col-md-4 mb-4 fade-item">
          <div class="card h-100">
            <div class="d-flex align-items-center justify-content-center bg-light p-2" style="height: 220px; overflow: hidden;">
              <img src="<?php echo htmlspecialchars(!empty($product['image_path']) ? $product['image_path'] : 'uploads/default.jpg'); ?>" class="img-fluid w-100" style="height: 200px; width: 100%; object-fit: contain;" alt="<?php echo htmlspecialchars($product['title']); ?>" onerror="this.onerror=null;this.src='uploads/default.jpg';">
            </div>
            <div class="card-body d-flex flex-column">
              <span class="badge bg-success mb-2"><?php echo htmlspecialchars($product['category_name']); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
              <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars(substr($product['description'] ?? '', 0, 140))); ?><?php echo (strlen($product['description'] ?? '') > 140) ? '...' : ''; ?></p>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <strong class="text-primary">$<?php echo number_format($product['price'], 2); ?></strong>
                <a href="<?= BASE_URL ?>product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">View</a>
              </div>
            </div>
          </div>
        </div>
    <?php endforeach; else: ?>
      <div class="col-12">
        <p class="text-muted">No featured products at this time. Check back soon.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<section id="why" class="py-5">
  <div class="text-center mb-4">
    <h2 class="h4">Why Choose Verdant Tech Farms</h2>
    <p class="text-muted">Proven benefits that help you grow better, faster, and greener.</p>
  </div>

  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded h-100">
        <h5>90% Less Water</h5>
        <p class="small text-muted">Our closed-loop hydroponic systems drastically reduce water usage compared to traditional farming.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded h-100">
        <h5>Automated IoT Control</h5>
        <p class="small text-muted">Schedule lights, nutrients, and irrigation with our smart controllers and remote monitoring.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded h-100">
        <h5>Year-Round Organic Yields</h5>
        <p class="small text-muted">Optimize growth cycles and harvest consistently using organic nutrient formulas tailored for hydroponics.</p>
      </div>
    </div>
  </div>
</section>

<!-- jQuery (for simple animations) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function(){
    $('.fade-item').hide().each(function(i){
      $(this).delay(120*i).fadeIn(450);
    });
    // Smooth scroll for internal anchors
    $('a[href^="#"]').on('click', function(e){
      var target = $(this.getAttribute('href'));
      if (target.length) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: target.offset().top - 60 }, 500);
      }
    });
  });
</script>

<?php
require_once __DIR__ . '/footer.php';
?>
