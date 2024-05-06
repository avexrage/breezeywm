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