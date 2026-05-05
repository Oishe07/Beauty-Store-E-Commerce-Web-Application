<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>

<!-- HERO BANNER -->
<div class="container-fluid p-0">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/banner1.jpg" class="d-block w-100" alt="Banner 1">
      </div>
      <div class="carousel-item">
        <img src="images/banner2.jpg" class="d-block w-100" alt="Banner 2">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<!-- CATEGORY + PRODUCTS -->
<div class="container mt-5">
  <div class="row">

    <!-- CATEGORY SIDEBAR -->
    <div class="col-md-3">
      <div class="sidebar-box p-3 mb-4">
        <h5 class="fw-bold mb-3">Categories</h5>
<ul class="list-group custom-category-list">
  <li class="list-group-item"><a href="category.php?cat=Skincare">Skincare</a></li>
  <li class="list-group-item"><a href="category.php?cat=Makeup">Makeup</a></li>
  <li class="list-group-item"><a href="category.php?cat=Haircare">Haircare</a></li>
  <li class="list-group-item"><a href="category.php?cat=Fragrances">Fragrances</a></li>
  <li class="list-group-item"><a href="category.php?cat=Body">Body</a></li>
</ul>


        <div class="mt-4 text-center">
          <img src="images/offer.jpg" class="img-fluid rounded promo-img" alt="Promo">
        </div>
      </div>
    </div>

    <!-- DYNAMIC PRODUCT DISPLAY -->

  <!-- Product 1 -->
  <div class="col-md-3">
    <div class="card h-100 shadow-sm">
      <img src="images/product1.jpg" class="card-img-top" alt="Lipstick">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Velvet Matte Lipstick</h5>
        <p class="card-text text-muted">৳299.00</p>
        <div class="mt-auto d-grid gap-2">
          <a href="addtocart.php?id=1" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?id=1" class="btn btn-danger btn-sm">Buy Now</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Product 2 -->
  <div class="col-md-3">
    <div class="card h-100 shadow-sm">
      <img src="images/product2.jpg" class="card-img-top" alt="Niacinamide Serum">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Niacinamide Serum 10%</h5>
        <p class="card-text text-muted">৳1188.00</p>
        <div class="mt-auto d-grid gap-2">
          <a href="addtocart.php?id=2" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?product_id=2" class="btn btn-danger btn-sm">Buy Now</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Product 3 -->
  <div class="col-md-3">
    <div class="card h-100 shadow-sm">
      <img src="images/product3.jpg" class="card-img-top" alt="Moisturizer">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Hydrating Moisturizer</h5>
        <p class="card-text text-muted">৳850.00</p>
        <div class="mt-auto d-grid gap-2">
          <a href="addtocart.php?id=3" class="btn btn-success btn-sm">Add to Cart</a>
          <a href="checkout.php?product_id=3" class="btn btn-danger btn-sm">Buy Now</a>
        </div>
      </div>
    </div>
  </div>

<?php include("includes/footer.php"); ?>


