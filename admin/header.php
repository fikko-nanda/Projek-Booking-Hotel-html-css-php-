<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Admin Website Booking Hotel</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-hotel' ></i>
        <div class="logo_name">Rimberio Hotel</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="beranda.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Beranda</span>
        </a>
         <span class="tooltip">Beranda</span>
      </li>
      <li>
       <a href="booking.php">
        <i class='bx bxs-book-bookmark' ></i>
         <span class="links_name">Booked</span>
       </a>
       <span class="tooltip">Booked</span>
     </li>
     <li>
       <a href="proses_bayar.php">
        <i class='bx bx-credit-card'></i>
         <span class="links_name">Pembayaran</span>
       </a>
       <span class="tooltip">pembayaran</span>
     </li>
     <li>
       <a href="checkin.php">
        <i class='bx bxs-log-in'></i>
         <span class="links_name">Check In</span>
       </a>
       <span class="tooltip">Check In</span>
     </li>
     <li>
       <a href="checkout.php">
        <i class='bx bxs-log-out' ></i>
         <span class="links_name">Check Out</span>
       </a>
       <span class="tooltip">Check Out</span>
     </li>
     <li>
       <a href="kategori.php">
        <i class='bx bxs-bed'></i>
         <span class="links_name">Kategori Kamar</span>
       </a>
       <span class="tooltip">Kategori</span>
     </li>
     <li>
       <a href="kamar.php">
        <i class='bx bx-photo-album' ></i>
         <span class="links_name">galeri hotel</span>
       </a>
       <span class="tooltip">fasilitas</span>
     </li>
     <li>
     <a href="logout.php">
    <i class='bx bx-log-out'></i>
    <span class="links_name">Logout</span>
</a>
<span class="tooltip">Logout</span>
     </li>
     <li class="profile">
         <div class="profile-details">
           <div class="name_job">
             <div class="name">Admin</div>
             <div class="job">Web Admin</div>
           </div>
         </div>
         <a href="../user/index.php">
         <i class='bx bx-user' id="log_out" ></i>
         </a>
         
     </li>
    </ul>
  </div>