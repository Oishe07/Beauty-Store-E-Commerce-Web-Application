<?php include("includes/header.php"); ?>

<?php
$cat_name = isset($_GET['cat']) ? $_GET['cat'] : '';
$cat_name_lower = strtolower($cat_name);
?>

<div class="container mt-5">
  <h3 class="mb-4 text-capitalize"><?= htmlspecialchars($cat_name) ?> Products</h3>
  <div class="row g-4">

    <?php if ($cat_name_lower == 'skincare'): ?>
      <!-- Skincare -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/skincare1.jpg" class="card-img-top" alt="Cleanser">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Gentle Skin Cleanser</h5>
            <p class="card-text text-muted mb-1">৳650.00</p>
            <div class="mb-3 text-warning">★★★★☆</div>
            <div class="mt-auto d-grid gap-2">
          <a href="addtocart.php?id=101" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=101" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/skincare2.jpg" class="card-img-top" alt="Toner">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Hydrating Toner</h5>
            <p class="card-text text-muted mb-1">৳480.00</p>
            <div class="mb-3 text-warning">★★★★★</div>
            <div class="mt-auto d-grid gap-2">
      <a href="addtocart.php?id=102" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=102" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/skincare3.jpg" class="card-img-top" alt="Moisturizer">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Daily Moisturizer SPF 30</h5>
            <p class="card-text text-muted mb-1">৳850.00</p>
            <div class="mb-3 text-warning">★★★☆☆</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=103" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=103" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

    <?php elseif ($cat_name_lower == 'makeup'): ?>
      <!-- Makeup -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/makeup1.jpg" class="card-img-top" alt="Foundation">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Longwear Foundation</h5>
            <p class="card-text text-muted mb-1">৳999.00</p>
            <div class="mb-3 text-warning">★★★★☆</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=201" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=201" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/makeup2.jpg" class="card-img-top" alt="Blush">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Cream Blush</h5>
            <p class="card-text text-muted mb-1">৳499.00</p>
            <div class="mb-3 text-warning">★★★★★</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=202" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=202" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/makeup3.jpg" class="card-img-top" alt="Highlighter">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Glowy Highlighter</h5>
            <p class="card-text text-muted mb-1">৳720.00</p>
            <div class="mb-3 text-warning">★★★☆☆</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=203" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=203" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

    <?php elseif ($cat_name_lower == 'haircare'): ?>
      <!-- Haircare -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/hair1.jpg" class="card-img-top" alt="Shampoo">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Anti-Dandruff Shampoo</h5>
            <p class="card-text text-muted mb-1">৳540.00</p>
            <div class="mb-3 text-warning">★★★★☆</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=301" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=301" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/hair2.jpg" class="card-img-top" alt="Hair Oil">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Coconut Hair Oil</h5>
            <p class="card-text text-muted mb-1">৳360.00</p>
            <div class="mb-3 text-warning">★★★★★</div>
            <div class="mt-auto d-grid gap-2">
            <a href="addtocart.php?id=302" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=302" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/hair3.jpg" class="card-img-top" alt="Conditioner">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Silky Conditioner</h5>
            <p class="card-text text-muted mb-1">৳450.00</p>
            <div class="mb-3 text-warning">★★★☆☆</div>
            <div class="mt-auto d-grid gap-2">
           <a href="addtocart.php?id=303" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=303" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

    <?php elseif ($cat_name_lower == 'fragrances'): ?>
       <!-- Fragrances -->
      
<div class="col-md-4">
  <div class="card h-100 shadow-sm">
    <img src="images/perfume1.jpg" class="card-img-top" alt="Floral Bloom">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Floral Bloom</h5>
      <p class="card-text text-muted mb-1">৳1,250.00</p>
      <div class="mb-3 text-warning">★★★★★</div>
      <div class="mt-auto d-grid gap-2">
        <a href="addtocart.php?id=401" class="btn btn-success btn-sm">Add to Cart</a>
        <a href="checkout.php?id=401" class="btn btn-danger btn-sm">Buy Now</a>
      </div>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card h-100 shadow-sm">
    <img src="images/perfume2.jpg" class="card-img-top" alt="Musk Night">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Musk Night</h5>
      <p class="card-text text-muted mb-1">৳1,420.00</p>
      <div class="mb-3 text-warning">★★★★★</div>
      <div class="mt-auto d-grid gap-2">
        <a href="addtocart.php?id=402" class="btn btn-success btn-sm">Add to Cart</a>
        <a href="checkout.php?id=402" class="btn btn-danger btn-sm">Buy Now</a>
      </div>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card h-100 shadow-sm">
    <img src="images/perfume3.jpg" class="card-img-top" alt="Ocean Mist">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">Ocean Mist</h5>
      <p class="card-text text-muted mb-1">৳1,110.00</p>
      <div class="mb-3 text-warning">★★★★★</div>
      <div class="mt-auto d-grid gap-2">
        <a href="addtocart.php?id=403" class="btn btn-success btn-sm">Add to Cart</a>
        <a href="checkout.php?id=403" class="btn btn-danger btn-sm">Buy Now</a>
      </div>
    </div>
  </div>
</div>


    <?php elseif ($cat_name_lower == 'body'): ?>
      <!-- Body -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/body1.jpg" class="card-img-top" alt="Lotion">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Body Lotion</h5>
            <p class="card-text text-muted mb-1">৳599.00</p>
            <div class="mb-3 text-warning">★★★★☆</div>
            <div class="mt-auto d-grid gap-2">
           <a href="addtocart.php?id=401" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=401" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/body2.jpg" class="card-img-top" alt="Body Butter">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Shea Body Butter</h5>
            <p class="card-text text-muted mb-1">৳850.00</p>
            <div class="mb-3 text-warning">★★★★★</div>
            <div class="mt-auto d-grid gap-2">
        <a href="addtocart.php?id=402" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=402" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="images/body3.jpg" class="card-img-top" alt="Scrub">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Exfoliating Body Scrub</h5>
            <p class="card-text text-muted mb-1">৳420.00</p>
            <div class="mb-3 text-warning">★★★☆☆</div>
            <div class="mt-auto d-grid gap-2">
<a href="addtocart.php?id=403" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=403" class="btn btn-danger btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
      </div>

    <?php else: ?>
      <p>No products found in this category.</p>
    <?php endif; ?>

  </div>
</div>

<?php include("includes/footer.php"); ?>

