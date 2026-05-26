<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$webname ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/navbar.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/footer.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/contact.css?v=1.5" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

</head>
<style>
    .headcon{
        height: 250px;
        background: linear-gradient(135deg, #1a0f0a 0%, #2d1a12 100%);
        color:#fff;
        display: flex;
        justify-content:center;
        align-items:center;
    }
    .headcon h1{
        font-size:3rem;
        color: #c19a4e !important;
    }
    </style>
<body>
<?php include('header.php'); ?>
 <div class="container-fluid headcon">
<h1 class="text-center mb-4">Contact Us</h1>
</div>
 <div class="container my-4 py-4 bg-light">

    <!-- Section Heading -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Get in Touch</h2>
        <p class="text-muted">We’d love to hear from you. Reach out using the details or send us a message.</p>
    </div>

    <div class="row g-5 align-items-stretch ">

        <!-- Contact Details -->
        <div class="col-lg-5">
            <div class="contact-info-box h-100 p-4">

                <h5 class="mb-4 fw-semibold">Contact Information</h5>

                <div class="mb-3">
                    <small class="text-muted d-block">Address</small>
                    <span>Sialkot, Pakistan</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Phone</small>
                    <span>+92 300 1234567</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span>stitchsmartofficial@gmail.com</span>
                </div>

                <div class="mt-4">
                    <small class="text-muted d-block">Working Hours</small>
                    <span>Mon - Sat, 9:00 AM - 6:00 PM</span>
                </div>

            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="contact-form-box p-4">
<?php if(isset($_SESSION['success'])): ?>

    <div class="alert alert-success">
        <?= $_SESSION['success']; ?>
    </div>

<?php unset($_SESSION['success']); endif; ?>


<?php if(isset($_SESSION['error'])): ?>

    <div class="alert alert-danger">
        <?= $_SESSION['error']; ?>
    </div>

<?php unset($_SESSION['error']); endif; ?>
                <h5 class="mb-4 fw-semibold">Send a Message</h5>

               <form id="contactForm" method="POST" action="<?= BASE_URL ?>/index.php?page=contact_send">
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="text" 
                   name="name"
                   class="form-control form-control-lg" 
                   placeholder="Full Name" 
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <input type="email" 
                   name="email"
                   class="form-control form-control-lg" 
                   placeholder="Email Address" 
                   required>
        </div>
    </div>

    <div class="mb-3">
        <textarea name="message"
                  class="form-control form-control-lg" 
                  rows="5" 
                  placeholder="Write your message..." 
                  required></textarea>
    </div>

    <button type="submit" class="btn btn-dark px-4 py-2">
        Send Message
    </button>

</form>

            </div>
        </div>

    </div>

    <!-- Map -->
    <div class="mt-5">
        <div class="map-box">
            <iframe src="https://www.google.com/maps?q=karachi&output=embed"></iframe>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
