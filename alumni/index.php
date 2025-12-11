<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Portal Alumni</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Header -->
  <header class="bg-blue-600 text-white p-4 text-center shadow">
    <h1 class="text-lg font-semibold">Portal Alumni</h1>
  </header>

  <!-- Konten -->
  <main class="p-4 pb-28">
    <!-- Pengajuan -->
    <section class="mb-6">
      <h2 class="text-sm text-gray-500 uppercase mb-2">Pengajuan</h2>
      <div class="grid grid-cols-3 gap-3 text-center">
        <button onclick="openModal('Ijazah')" class="bg-white rounded-xl p-4 shadow hover:bg-blue-50">
          <svg class="w-6 h-6 mx-auto mb-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
          <p class="text-xs font-medium">Ijazah</p>
        </button>
        <button onclick="openModal('Legalisir')" class="bg-white rounded-xl p-4 shadow hover:bg-blue-50">
          <svg class="w-6 h-6 mx-auto mb-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h8M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6"/></svg>
          <p class="text-xs font-medium">Legalisir</p>
        </button>
        <button onclick="openModal('Lain-lain')" class="bg-white rounded-xl p-4 shadow hover:bg-blue-50">
          <svg class="w-6 h-6 mx-auto mb-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          <p class="text-xs font-medium">Lain-lain</p>
        </button>
      </div>
    </section>

    <!-- Jenjang Karir -->
    <section class="mb-6">
      <h2 class="text-sm text-gray-500 uppercase mb-2">Jenjang Karir Alumni</h2>
      <div class="bg-white rounded-xl p-4 shadow">
        <p class="text-sm leading-relaxed">Update karirmu setelah lulus! Beritahu kami jika kamu bekerja, kuliah, atau berwirausaha.</p>
        <button onclick="openKarirModal()" class="mt-3 inline-block text-sm text-blue-600 font-medium">Isi Karir &rarr;</button>
      </div>
    </section>

    <!-- Riwayat -->
    <section id="riwayat">
    <h2 class="text-sm text-gray-500 uppercase mb-2">Riwayat Pengajuan & Karir</h2>
    <div class="bg-white rounded-xl p-4 shadow space-y-4 text-sm text-gray-700" id="riwayatContainer">
        <p class="text-sm leading-relaxed">Lihat riwayat semua pengajuan dan status karirmu.</p>
        <button onclick="openRiwayatModal()" class="mt-3 inline-block text-sm text-blue-600 font-medium">Lihat Riwayat &rarr;</button>
    </div>
    </section>

  </main>

  <!-- Modal -->
  <div id="pengajuanModal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden justify-center items-center z-50">
    <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-6">
      <h3 class="text-lg font-semibold text-blue-600 mb-4">Form Pengajuan</h3>
      <form id="formPengajuan">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
          <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengambilan</label>
          <input type="date" name="tanggal_keperluan" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
          <input type="text" id="inputKeperluan" name="keperluan" readonly class="w-full border bg-gray-100 border-gray-300 rounded px-3 py-2">
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:text-red-500">Batal</button>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
        </div>
      </form>
    </div>
  </div>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-md z-40">
  <div class="flex justify-around items-center py-2 text-xs">
    <button onclick="openModal('Ijazah')" class="flex flex-col items-center text-blue-600 focus:outline-none">
      <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="1.5"
        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
        d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"/></svg>
      Pengajuan
    </button>
    <button onclick="openKarirModal()" class="flex flex-col items-center text-gray-500 focus:outline-none">
      <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="1.5"
        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
        d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3zM16.5 21v-2a4.5 4.5 0 00-9 0v2"/></svg>
      Karir
    </button>
    <button onclick="openRiwayatModal()" class="flex flex-col items-center text-gray-500 focus:outline-none">
      <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="1.5"
        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Riwayat
    </button>
  </div>
</nav>

<!-- Modal Karir -->
<div id="karirModal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden justify-center items-center z-50">
  <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold text-blue-600 mb-4">Form Karir Alumni</h3>
    <form id="formKarir">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
        <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2" required>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Karir</label>
        <select name="karir" id="karirSelect" onchange="updateKeterangan()" class="w-full border border-gray-300 rounded px-3 py-2" required>
          <option value="">-- Pilih Karir --</option>
          <option value="Kuliah">Kuliah</option>
          <option value="Bekerja">Bekerja</option>
          <option value="Wiraswasta">Wiraswasta</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
        <textarea name="keterangan" id="keteranganInput" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Keterangan lengkap sesuai pilihan karir..." required></textarea>
      </div>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeKarirModal()" class="px-4 py-2 text-gray-600 hover:text-red-500">Batal</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal Riwayat -->
<div id="riwayatModal" class="fixed inset-0 bg-black bg-opacity-50 flex hidden justify-center items-center z-50">
  <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold text-blue-600 mb-4">Masukkan NIS</h3>
    <form id="formRiwayat">
      <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2 mb-4" placeholder="Masukkan NIS Anda" required>
      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeRiwayatModal()" class="px-4 py-2 text-gray-600 hover:text-red-500">Batal</button>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat</button>
      </div>
    </form>
  </div>
</div>

  <!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function openModal(keperluan) {
    document.getElementById('pengajuanModal').classList.remove('hidden');
    document.getElementById('inputKeperluan').value = keperluan;
  }

  function closeModal() {
    document.getElementById('pengajuanModal').classList.add('hidden');
    document.getElementById('formPengajuan').reset();
  }

  document.getElementById('formPengajuan').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = {
      username: form.username.value.trim(),
      keperluan: form.keperluan.value.trim(),
      tanggal_keperluan: form.tanggal_keperluan.value.trim()
    };

    // Validasi sederhana
    if (!formData.username || !formData.keperluan || !formData.tanggal_keperluan) {
      Swal.fire('Gagal', 'Semua kolom wajib diisi.', 'warning');
      return;
    }

    try {
      const response = await fetch('https://presensi.pipapip.web.id/api/pengajuan', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      });

      const result = await response.json();

      if (response.ok) {
        Swal.fire('Berhasil', result.message || 'Pengajuan berhasil.', 'success');
        closeModal();
      } else {
        Swal.fire('Gagal', result.message || 'Terjadi kesalahan.', 'error');
      }
    } catch (error) {
      Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
    }
  });
</script>
<script>
  function openKarirModal() {
    document.getElementById('karirModal').classList.remove('hidden');
  }

  function closeKarirModal() {
    document.getElementById('karirModal').classList.add('hidden');
    document.getElementById('formKarir').reset();
  }

  function updateKeterangan() {
    const select = document.getElementById('karirSelect');
    const input = document.getElementById('keteranganInput');

    const val = select.value;
    if (val === "Kuliah") {
      input.placeholder = "Contoh: Universitas Gadjah Mada, Prodi Teknik Informatika";
    } else if (val === "Bekerja") {
      input.placeholder = "Contoh: PT Astra, Posisi sebagai Frontend Developer";
    } else if (val === "Wiraswasta") {
      input.placeholder = "Contoh: Bidang Kuliner, CV Makanan Sehat";
    } else {
      input.placeholder = "Keterangan lengkap sesuai pilihan karir...";
    }
  }

  document.getElementById('formKarir').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = {
      username: form.username.value.trim(),
      karir: form.karir.value.trim(),
      keterangan: form.keterangan.value.trim()
    };

    if (!formData.username || !formData.karir || !formData.keterangan) {
      Swal.fire('Gagal', 'Semua kolom wajib diisi.', 'warning');
      return;
    }

    try {
      const response = await fetch('https://presensi.pipapip.web.id/api/tracking', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
      });

      const result = await response.json();

      if (response.ok) {
        Swal.fire('Berhasil', result.message || 'Data karir berhasil disimpan.', 'success');
        closeKarirModal();
      } else {
        Swal.fire('Gagal', result.message || 'Terjadi kesalahan saat menyimpan.', 'error');
      }
    } catch (error) {
      Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
    }
  });
</script>
<script>
  function openRiwayatModal() {
    document.getElementById('riwayatModal').classList.remove('hidden');
  }

  function closeRiwayatModal() {
    document.getElementById('riwayatModal').classList.add('hidden');
    document.getElementById('formRiwayat').reset();
  }

  document.getElementById('formRiwayat').addEventListener('submit', async function (e) {
    e.preventDefault();
    const username = e.target.username.value.trim();
    if (!username) {
      Swal.fire('Peringatan', 'NIS wajib diisi', 'warning');
      return;
    }

    try {
      const response = await fetch(`https://presensi.pipapip.web.id/api/riwayat/${username}`);
      const result = await response.json();

      if (!result.status) {
        Swal.fire('Gagal', 'Data tidak ditemukan.', 'error');
        return;
      }

      closeRiwayatModal();
      renderRiwayat(result);
    } catch (error) {
      Swal.fire('Error', 'Tidak dapat menghubungi server.', 'error');
    }
  });
    function formatTanggal(dateStr) {
    const tanggal = new Date(dateStr);
    return tanggal.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
    }

function renderRiwayat(data) {
  const container = document.getElementById('riwayatContainer');
  container.innerHTML = `
    <div class="mb-4">
    <h2 class="text-lg font-semibold text-green-700 mb-3">Nama: ${data.user.nama}</h2>

      <h3 class="font-bold text-blue-600 mb-2">Pengajuan</h3>
      ${data.pengajuan.map(item => `
        <div class="border border-gray-200 rounded-lg p-3 mb-2">
          <p><strong>Keperluan:</strong> ${item.keperluan}</p>
          <p><strong>Tanggal Keperluan:</strong> ${formatTanggal(item.tanggal_keperluan)}</p>
          <p><strong>Submit:</strong> ${formatTanggal(item.tanggal_submit)}</p>
        </div>
      `).join('')}
    </div>
    <div>
      <h3 class="font-bold text-blue-600 mb-2">Karir</h3>
      ${data.tracking.map(item => `
        <div class="border border-gray-200 rounded-lg p-3 mb-2">
          <p><strong>Karir:</strong> ${item.karir}</p>
          <p><strong>Keterangan:</strong> ${item.keterangan}</p>
          <p><strong>Tanggal:</strong> ${formatTanggal(item.tanggal)}</p>
        </div>
      `).join('')}
    </div>
  `;
}

</script>


</body>
</html>
