# Web Gallery Foto

Ini adalah proyek galeri foto web yang dibuat oleh Muhammad Shidiq. Proyek ini bertujuan untuk memungkinkan pengguna untuk memperlihatkan dan mengelola koleksi foto mereka secara online.

## Fitur

- Tampilan galeri foto yang menarik dan responsif.
- Kemampuan untuk mengunggah foto baru.
- Pilihan untuk membuat album foto dan mengatur koleksi foto.
- Berisi Fitur Like dan Komentar

## Instalasi

1. **Clone repositori ini:**

    ```bash
    git clone https://github.com/muhammadshidiq/galery_foto.git
    ```

2. **Pindahkan Project Ke Localhost Server:**

## Kontribusi

Saya sangat terbuka terhadap kontribusi! Jika Anda ingin memperbaiki bug, menambahkan fitur baru, atau meningkatkan dokumentasi, jangan ragu untuk melakukan pull request.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT. Lihat [LICENSE](LICENSE) untuk informasi lebih lanjut.

## Kontak

Jika Anda memiliki pertanyaan atau saran, jangan ragu untuk menghubungi saya di (email saya:mshidiq011@gmail.com).

Terima kasih telah mengunjungi proyek ini!

## Demo Animasi

Klik [di sini](#) untuk melihat demo animasi.

<details>
  <summary>Klik untuk melihat animasi</summary>
  
  <div id="animation" style="width: 100px; height: 100px; background-color: red;"></div>

  <script>
    // Animasi sederhana dengan JavaScript
    const element = document.getElementById("animation");
    let position = 0;
    setInterval(() => {
      position += 10;
      if (position > 200) position = 0;
      element.style.left = `${position}px`;
    }, 100);
  </script>
</details>


