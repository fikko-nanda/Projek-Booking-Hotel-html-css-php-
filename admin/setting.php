<?php require  'header.php';
require 'footer.php';
session_start();
if (!isset($_SESSION['log'])) {
    header('Location: login.php');
    exit;
}
?>
?>  

<section class="home-section">
      <div class="text">Settings</div>
      <a>Ini adalah settings</a>
  </section>