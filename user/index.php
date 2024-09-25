<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include 'koneksi.php'; ?>
<head>
  <title>Hotel Website</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="path/to/owl.carousel.min.css">
  <link rel="stylesheet" href="path/to/owl.theme.default.min.css">

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
</head>

<body>
  <header class="header" id="navigation-menu">
    <div class="container">
      <nav>
        <a href="#" class="logo"><img src="image/logo.jpg" alt=""></a>

        <ul class="nav-menu">
          <li> <a href="#rooms" class="nav-link">Booking</a> </li>
          <li> <a href="#restaurant"  class="nav-link">Restoran</a> </li>
          <li> <a href="#contact" class="nav-link">Contact</a> </li>
        </ul>

        <div class="hambuger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </div>
  </header>
  <script>
    const hambuger = document.querySelector('.hambuger');
    const navMenu = document.querySelector('.nav-menu');

    hambuger.addEventListener("click", mobileMenu);

    function mobileMenu() {
      hambuger.classList.toggle("active");
      navMenu.classList.toggle("active");
    }

    const navLink = document.querySelectorAll('.nav-link');
    navLink.forEach((n) => n.addEventListener("click", closeMenu));

    function closeMenu() {
      hambuger.classList.remove("active");
      navMenu.classList.remove("active");
    }
  </script>

  <section class="home" id="home">
    <div class="head_container">
      <div class="box">
        <div class="text">
          <h1>RIMBERIO HOTEL</h1>
          <p>Hotel ini memadukan keindahan tradisional Bali dengan kenyamanan modern, menawarkan pengalaman yang memesona bagi para tamu yang mencari ketenangan dan kedamaian. Dikelilingi oleh alam yang memukau dan arsitektur khas Bali, hotel ini menyediakan akomodasi yang elegan dan fasilitas yang lengkap untuk menikmati liburan yang tak terlupakan.. </p>
        </div>
      </div>
      <div class="image">
        <img src="image/arsitektur-bali-modern-cover.jpg" class="slide">
      </div>
      <div class="image_item">
        <img src="image/arsitektur-bali-modern-cover.jpg" alt="" class="slide active" onclick="img('image/arsitektur-bali-modern-cover.jpg')">
        <img src="image/restoran2.jpg" alt="" class="slide" onclick="img('image/restoran2.jpg')">
        <img src="image/w1.jpg" alt="" class="slide" onclick="img('image/w1.jpg')">
        <img src="image/g3.jpg" alt="" class="slide" onclick="img('image/g3.jpg')">
      </div>
    </div>
  </section>
  <script>
    function img(anything) {
      document.querySelector('.slide').src = anything;
    }

    function change(change) {
      const line = document.querySelector('.image');
      line.style.background = change;
    }
  </script>
<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $dewasa = $_POST['dewasa'];
    $nama_users = $_POST['nama_users'];

    // Cek apakah entri sudah ada sebelumnya
    $check_sql = "SELECT * FROM checkin WHERE checkin = '$checkin' AND checkout = '$checkout' AND dewasa = '$dewasa' AND nama_users = '$nama_users'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Jika entri sudah ada, tampilkan pesan kesalahan menggunakan alert JavaScript
        echo '<script type="text/javascript">';
        echo 'alert("Tanggal Sudah Terdaftar!!!");';
        echo 'window.location = "#rooms";'; // #pesan_error adalah anchor di halaman yang ingin Anda arahkan
        echo '</script>';
    } else {
        // Jika tidak ada entri yang sama, masukkan data baru ke dalam database
        $sql = "INSERT INTO checkin (checkin, checkout, dewasa, nama_users)
                VALUES ('$checkin', '$checkout', '$dewasa', '$nama_users')";

        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">';
            echo 'alert("Booking Berhasil Ditambahkan");';
            echo 'window.location = "#rooms";'; // #pesan_sukses adalah anchor di halaman yang ingin Anda arahkan
            echo '</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<section class="book">
    <div class="container flex" id="booking">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="input grid">
                <div class="box">
                    <label>Check-in:</label>
                    <input type="date" name="checkin" placeholder="Tanggal Check-in" required>
                </div>
                <div class="box">
                    <label>Check-out:</label>
                    <input type="date" name="checkout" placeholder="Tanggal Check-out" required>
                </div>
                <div class="box">
                    <label>Jumlah Orang:</label> <br>
                    <input type="number" name="dewasa" placeholder="0" required>
                </div>
                <div class="box">
                <label for="nama_users">NAMA PEMESAN:</label><br>
<input type="text" id="nama_users" name="nama_users" placeholder="nama anda" required><br><br>

            </div>
            <a href="#rooms">
            <div class="search">
                <input type="submit" value="PESAN">
            </div>
            </a>
        </form>
    </div>
</section>


  <section class="about top" id="about">
    <div class="container flex">
      <div class="left">
        <div class="img">
          <img src="image/pura.jpg" alt="" class="image1">
        </div>
      </div>
      <div class="right">
        <div class="heading">
          <h5>RAISING COMFORT TO THE HIGHEST LEVEL</h5>
          <h2>CULTURE BALI</h2>
          <p>Budaya Bali adalah perpaduan yang unik dari beragam elemen yang mencerminkan kekayaan sejarah dan tradisi pulau ini. Didukung oleh agama Hindu Bali, budaya ini dikenal dengan upacara-upacara agama yang megah dan berwarna, seperti perayaan Hari Raya Nyepi yang merupakan hari raya Hindu Bali yang paling penting. Seni dan tari juga memegang peranan sentral dalam kehidupan sehari-hari, dengan tarian seperti Legong, Barong, dan Kecak yang tidak hanya menghibur tetapi juga menggambarkan mitologi dan cerita tradisional. Selain itu, seni ukir, pahat, dan lukis yang rumit menjadi saksi bisu dari keahlian dan kreativitas yang melimpah dari masyarakat Bali. </p>
          <p>Di samping itu, filosofi Tri Hita Karana memainkan peranan penting dalam membentuk budaya Bali. Konsep ini menekankan harmoni antara manusia dengan Tuhan, alam, dan sesama manusia, menjadi panduan bagi kehidupan sehari-hari dan tata cara sosial. Budaya Bali tidak hanya mempertahankan warisan leluhur, tetapi juga terbuka terhadap pengaruh-pengaruh baru, menjadikannya sebagai destinasi yang menarik bagi wisatawan yang mencari pengalaman yang mendalam dan kaya akan budaya serta spiritualitas.</p>
        </div>
      </div>
    </div>
  </section>
  <style>
    .about {
        margin-top: 250px; /* Atau nilai yang Anda inginkan */
    }
</style>

  <section class="wrapper top">
    <div class="container">
      <div class="text">
        <h2>Fasilitas Hotel</h2>
        <p>Fasilitas hotel di Bali menawarkan kenyamanan modern dan sentuhan budaya lokal. Dari kolam renang infinity hingga spa tradisional, serta restoran yang menyajikan hidangan lokal dan internasional, setiap aspek dirancang untuk memanjakan tamu. </p>

        <div class="content">
          <div class="box flex">
            <i class="fas fa-swimming-pool"></i>
            <span>Swimming pool</span>
          </div>
          <div class="box flex">
            <i class="fas fa-dumbbell"></i>
            <span>Gym & yogo</span>
          </div>
          <div class="box flex">
            <i class="fas fa-spa"></i>
            <span>Spa & massage</span>
          </div>
          <div class="box flex">
            <i class="fas fa-ship"></i>
            <span>Boat Tours</span>
          </div>
          <div class="box flex">
            <i class="fas fa-swimmer"></i>
            <span>Surfing Lessons</span>
          </div>
          <div class="box flex">
            <i class="fas fa-microphone"></i>
            <span>Conference room</span>
          </div>
          <div class="box flex">
            <i class="fas fa-water"></i>
            <span>Diving & smorking</span>
          </div>
          <div class="box flex">
            <i class="fas fa-umbrella-beach"></i>
            <span>Private Beach</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  
  <section class="room top" id="rooms">
  <div class="container">
    <div class="heading_top flex1">
      <div class="heading">
        <h5>MENINGKATKAN KENYAMANAN KE TINGKAT TERTINGGI</h5>
        <h2>Kamar Hotel</h2>
      </div>
    </div>
    <div class="content grid" id="rooms-container">
      <!-- Kotak kamar akan dimasukkan di sini oleh JavaScript -->
    </div>
  </div>
</section>

<!-- Modal -->
<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <p id="modal-text"></p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    fetch('getRooms.php')
      .then(response => response.json())
      .then(data => {
        const roomsContainer = document.getElementById('rooms-container');
        data.forEach(room => {
          const roomBox = document.createElement('div');
          roomBox.classList.add('box');
          roomBox.innerHTML = `
                <div class="img">
        <img src="../admin/uploads/${room.image}" alt="">
      </div>
            <div class="text">
              <h3>${room.category} Rooms</h3>
              <p> <span>Rp.</span>${room.price} <span>/malam</span> </p>
              <button class="button" style="vertical-align:middle" onclick="bookNow('${room.category} Rooms', ${room.price})"><span>Booking</span></button>
            </div>
          `;
          roomsContainer.appendChild(roomBox);
        });
      });
  });

  function bookNow(roomType, price) {
    const modalText = document.getElementById('modal-text');
    modalText.innerText = `Anda telah memilih ${roomType} dengan harga Rp.${price}/malam.`;
    const modal = document.getElementById('modal');
    modal.style.display = 'block';
  }

  function closeModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';
  }
</script>

  <section class="wrapper wrapper2 top">
    <div class="container">
      <div class="text">
        <div class="heading">
          <h5>AT THE HEART OF COMMUNICATION</h5>
          <h2>People Say</h2>
        </div>

        <div class="para">
          <p>Secara singkat, latar belakang pembuatan sistem reservasi hotel adalah untuk mengakomodasi perubahan perilaku konsumen yang lebih cenderung menggunakan teknologi dalam memesan akomodasi, serta untuk menjawab persaingan yang ketat di industri perhotelan dengan menyediakan layanan yang lebih baik dan meningkatkan jangkauan pemasaran.</p>

          <div class="box flex">
            <div class="img">
              <img src="image/logo.jpg" alt="">
            </div>
            <div class="name">
              <h5>Rimberio Hotel</h5>
              <h5>Kelompok 3</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  


  <section class="restaurant top" id="restaurant">
    <div class="container flex">
      <div class="left">
        <img src="image/resto3.jpg" alt="">
      </div>
      <div class="right">
        <div class="text">
          <h2>Rimberio Restaurant</h2>
          <p> Restoran Bali menawarkan pengalaman kuliner yang menggabungkan rasa autentik dengan keindahan budaya Pulau Dewata. Dengan menu yang beragam, mulai dari hidangan laut segar hingga sate lilit khas Bali, setiap sajian disiapkan dengan bumbu tradisional yang kaya akan rempah. </p>
        </div>
        <div class="accordionWrapper">
          <div class="accordionItem open">
            <h2 class="accordionIHeading">Appetizer</h2>
            <div class="accordionItemContent">Appetizer adalah makanan ringan atau hidangan pembuka yang biasanya disajikan sebelum hidangan utama dalam sebuah makanan. 
            Salad, Canape, Fritters, Shrimp cocktail</div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">Balinesse Menu</h2>
            <div class="accordionItemContent">Menu Bali terkenal dengan kekayaan rasa rempah-rempahnya dan penggunaan bahan-bahan lokal yang segar.
            Sate lilit, Babi guling, Ayam betutu, Nasi campur, Lawar</div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">Balinesse Drink</h2>
            <div class="accordionItemContent">Minuman tradisional Bali juga memiliki keunikannya sendiri, sering kali terbuat dari bahan-bahan alami yang segar dan rempah-rempah.
            Arak bali, Tuak manis, Es tambring, Es daluman, Kopi bali</div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">Dessert</h2>
            <div class="accordionItemContent">Dessert atau hidangan penutup dalam budaya Bali juga memiliki variasi yang menarik, sering kali menggunakan bahan-bahan lokal dan rempah-rempah untuk menciptakan rasa yang khas.
            Pie susu, Pisang rai, Jagung urap, Jaje klepon, Laklak</div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    var accItem = document.getElementsByClassName('accordionItem');
    var accHD = document.getElementsByClassName('accordionIHeading');

    for (i = 0; i < accHD.length; i++) {
      accHD[i].addEventListener('click', toggleItem, false);
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;
      for (var i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
      }
      if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
      }
    }
  </script>



<section class="gallary mtop" id="gallary">
        <div class="container">
            <div class="heading_top flex1">
                <div class="heading">
                    <h5>SELAMAT DATANG DI GALERI FOTO KAMI</h5>
                    <h2>Galeri Foto Hotel Kami</h2>
                </div>
            </div>

            <div class="owl-carousel owl-theme">
                <?php
                // Koneksi database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "hotel";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Mengambil data
                $sql = "SELECT * FROM galeri";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="item">';
                        echo '<img src="../admin/uploads/' . $row['galeri_foto'] . '" alt="' . $row['nama_tempat'] . '">';
                        echo '</div>';
                    }
                } else {
                    echo "Tidak ada gambar di galeri.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                items: 3,
                loop: true,
                margin: 10,
                nav: true, // Mengaktifkan navigasi panah
                navText: ["<span class='nav-prev'>&#9664;</span>","<span class='nav-next'>&#9654;</span>"], // Teks untuk panah navigasi
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
        });
    </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
    <div class="owl-carousel owl-theme">
    <!-- Tambahkan item carousel di sini -->
</div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $price = $_POST['price'];
    $nama_users = $_POST['nama_users'];
    $email_users = $_POST['email_users'];
    $no_kartus = $_POST['no_kartus'];
    $no_atm = $_POST['no_atm'];
    $tanggal_kdl = $_POST['tanggal_kdl'];
    $cvv = $_POST['cvv'];

    $sql = "INSERT INTO bookings (category, price, nama_users, email_users, no_kartus, no_atm, tanggal_kdl, cvv)
    VALUES ('$category', '$price', '$nama_users', '$email_users', '$no_kartus', '$no_atm', '$tanggal_kdl', '$cvv')";

 

    $conn->close();

}
?>

<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close-form" onclick="closeForm()" style="float: right; cursor: pointer;">&times;</span>
        <h2>Form Pembayaran</h2>
        <form id="paymentForm" onsubmit="event.preventDefault(); openPaymentMenu();">
            <label for="category">Tipe Kamar:</label>
            <input type="text" id="category" name="category" readonly><br><br>
            <label for="price">Harga:</label>
            <input type="text" id="price" name="price" readonly><br><br>
            <label for="nama_users">Nama:</label>
            <input type="text" id="nama_users" name="nama_users" placeholder="nama sesuai isi data checkin" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email_users" name="email_users" placeholder="E-Mail" required><br><br>
            <label for="cardNumber">No. Handphone:</label>
            <input type="text" id="no_kartus" name="no_kartus" placeholder="nomor hp" required><br><br>
            <button type="button" onclick="openPaymentMenu()" style="background-color: #000000; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">LANJUT KE MENU PEMBAYARAN</button>
        </form>
    </div>
</div>

<!-- Payment Menu Modal -->
<div id="paymentMenuModal" class="modal">
    <div class="modal-content">
        <span class="close-form" onclick="closePaymentMenu()" style="float: right; cursor: pointer;">&times;</span>
        <h2>Menu Pembayaran</h2>
        <form id="paymentMenuForm" onsubmit="submitPaymentForm(event)">
            <label for="cardNumber">Nomor Kartu:</label>
            <input type="text" id="no_atm" name="no_atm" placeholder="Nomor Kartu" required><br><br>
            <label for="expiryDate">Tanggal Kedaluwarsa:</label>
            <input type="text" id="tanggal_kdl" name="tanggal_kdl" placeholder="MM/YY" required><br><br>
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" placeholder="CVV" required><br><br>
            <button type="submit" style="background-color: #000000; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">BAYAR</button>
        </form>
    </div>
</div>


<script>
function closeForm() {
    var modal = document.getElementById('paymentModal');
    modal.style.display = "none";
}

function bookNow(category, price) {
    document.getElementById('category').value = category;
    document.getElementById('price').value = price;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var responseData = JSON.parse(this.responseText);
            if (responseData.success) {
                document.getElementById('nama_users').value = responseData.nama;
            } else {
                console.error('Gagal mengambil nama dari database.');
            }
        }
    };
    xhr.open("GET", "get_name.php", true);
    xhr.send();

    var modal = document.getElementById('paymentModal');
    modal.style.display = "block";
}

function closePaymentMenu() {
    var modal = document.getElementById('paymentMenuModal');
    modal.style.display = "none";
}

function openPaymentMenu() {
    var paymentModal = document.getElementById('paymentMenuModal');
    paymentModal.style.display = "block";
}

window.onclick = function(event) {
    var paymentModal = document.getElementById('paymentMenuModal');
    if (event.target == paymentModal) {
        closePaymentMenu();
    }
}

function submitPaymentForm(event) {
    event.preventDefault();

    var paymentForm = document.getElementById('paymentForm');
    var paymentMenuForm = document.getElementById('paymentMenuForm');
    var formData = new FormData(paymentForm);

    for (var [key, value] of new FormData(paymentMenuForm).entries()) {
        formData.append(key, value);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin/complete_payment.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert('Pembayaran berhasil!');
                closePaymentMenu();
                closeForm();
                
                // Redirect to konfirmasi_bayar.php
                window.location.href = 'konfirmasi_bayar.php';
            } else {
                alert('Pembayaran gagal: ' + response.message);
            }
        }
    };
    xhr.send(formData);
}
</script>


<section class="map top">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.649735733686!2d115.16732731477265!3d-8.691107693716447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23f0c9234bdab%3A0x13d42a1de8f6f7bf!2sExample%20Hotel%2C%20Bali!5e0!3m2!1sen!2sid!4v1637755481449!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>



  <footer>
    <div class="container grid top" id="contact">
      <div class="box">
        <img src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/48/000000/external-hotel-hotel-services-and-city-elements-flatart-icons-flat-flatarticons-1.png" />
        <p> Pembayaran bisa lewat dimana aja secara langsung maupun online, bisa melalui transfer, debit, paypal, dan kartu kredit serta bisa dilayani secara langsung tetapi pemesanan harus tetap lewat online.</p>

        <p>Beberapa metode pembayaran:</p>
        <div class="payment grid">
          <img src="https://img.icons8.com/color/48/000000/visa.png" />
          <img src="https://img.icons8.com/color/48/000000/mastercard.png" />
          <img src="https://img.icons8.com/color-glass/48/000000/paypal.png" />
          <img src="https://img.icons8.com/fluency/48/000000/amex.png" />
        </div>
      </div>

      <div class="box">
        <h3>Berita Terbaru</h3>

        <ul>
          <li>Wisata menarik di Nusa  Penida</li>
          <li>Pertunjukan tari kecak di Uluwatu</li>
          <li>Taman budaya GWK</li>
          <li>Beach club ATLAS</li>
        </ul>
      </div>

      <div class="box">
        <h3>Untuk pelanggan</h3>
        <ul>
          <li>About Luviana</li>
          <li>Customer Care/Help</li>
          <li>Corporate Accounts</li>
          <li>Financial Information</li>
          <li>Terms & Conditions</li>
        </ul>
      </div>

      <div class="box">
        <h3>Kontak kami</h3>

        <ul>
          <li>Banjar, Kecamatan Payangan, Kabupaten Gianyar, Bali 80561</li>
          <li><i class="far fa-envelope"></i>RimberioLuxuryhotel@gmail.com </li>
          <li><i class="far fa-phone-alt"></i>08956743222</li>
          <li><i class="far fa-phone-alt"></i>08923476511</li>
          <li><i class="far fa-comments"></i>24/ 7 Customer Services </li>
        </ul>
      </div>
    </div>
  </footer>
</body>

</html>