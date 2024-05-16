import './custom.js';

document.addEventListener("DOMContentLoaded", function() {
    // Fungsi untuk menampilkan notifikasi
    function showNotification() {
        var notification = document.getElementById("notification");
        notification.style.display = "block"; // Menampilkan notifikasi
        notification.style.opacity = "1"; // Pastikan notifikasi terlihat
        notification.style.top = "70px";
        setTimeout(function() {
            notification.style.opacity = "0";
            setTimeout(function() { notification.style.display = "none"; }, 600); // Menghilangkan notifikasi setelah fade out
        }, 3000); // Notifikasi akan hilang setelah 3 detik
    }

    // Fungsi untuk menyalin email ke clipboard
    function copyEmailToClipboard(email) {
        navigator.clipboard.writeText(email).then(function() {
            console.log('Email berhasil dicopy!');
            showNotification(); // Menampilkan notifikasi setelah email berhasil dicopy
        }, function(err) {
            console.error('Gagal menyalin email: ', err);
        });
    }

    // Menangani klik pada ikon amplop
    document.getElementById("copy-email").addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah scroll ke atas
        var email = event.currentTarget.getAttribute("data-email"); // Mendapatkan email dari atribut data-email
        copyEmailToClipboard(email); // Menyalin email ke clipboard
    });
});


// Menggunakan event listener untuk semua klik pada tautan dengan href yang dimulai dengan '#'
document.querySelectorAll('a[href^="#"], a[href^="/#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId.startsWith("/#")) {
            // Navigasi ke halaman utama dan scroll ke elemen
            window.location.href = targetId;
        } else {
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const topOffset = 60;
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - topOffset;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        }
    });
});



  document.addEventListener('DOMContentLoaded', function() {
    const daftarButtons = document.querySelectorAll('.daftar-btn');

    daftarButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default button click

        if (!isAuthenticated()) { // Check if user is logged in
          displayLoginMessage(this); // Display login message
        } else {
          // Allow button's default behavior if user is logged in
          // (e.g., submit form, redirect to URL)
        }
      });
    });
  });

  function isAuthenticated() {
    // Check if user is authenticated (you can use Laravel's `@auth` directive or JavaScript logic)
    return true; // Replace with your authentication check logic
  }

  function displayLoginMessage(button) {
    const loginMessage = document.createElement('span');
    loginMessage.classList.add('text-danger', 'd-flex', 'justify-content-center');
    loginMessage.textContent = 'Silahkan login dahulu untuk mendaftar program.';

    button.parentNode.insertBefore(loginMessage, button.nextSibling); // Insert login message after button
  }



