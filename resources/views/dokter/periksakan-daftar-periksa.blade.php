<!DOCTYPE html>
<html>
  @extends('layout.head')
  
  <body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    
    {{-- Navbar --}}
    @extends('layout.sidebar')
    
    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="opacity-50 text-slate-700" href="">Halaman</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">Hai, {{Auth::user()->nama}}</h6>
          </nav>
  
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
              <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                  <i class="fas fa-search"></i>
                </span>
                <input type="text" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Type here..." />
              </div>
            </div>
          </div>
        </div>
      </nav>
      
      <!-- end Navbar -->
      
      <!-- cards -->
      <div class="w-full px-6 py-6 mx-auto">
        
        {{-- Table --}}
        <div class="flex flex-wrap my-6 -mx-3">
          
            <!-- Daftar Jadwal Periksa -->
            <div class="w-full max-w-full px-3 mt-0 mb-6">
              <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                  <div class="flex flex-wrap mt-0 -mx-3">
                    <div class="flex-none w-7/12 max-w-full px-3 mt-0 lg:w-1/2 lg:flex-none">
                      <h6>Periksakan Pasien</h6>
                    </div>
                  </div>
                </div>
                @if(session('success'))
                  <div style="color:blue">
                    <center>{{ session('success') }}</center>
                  </div>
                @endif
                <div class="flex-auto p-6 px-0 pb-2">
                  <div class="overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                      <thead class="align-bottom">
                        <tr>
                          <th class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Nama Pasien</th>
                          <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Jadwal Periksa Pasien</th>
                          <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">Keluhan</th>
                          <th class="px-6 py-3 pl-2 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">No. Antrian</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                              <div class="flex px-2 py-1">
                                <div class="flex flex-col justify-center">
                                  <center><h6 class="mb-0 text-sm leading-normal">{{ $pasienIni->pasien->nama }}</h6></center>
                                </div>
                              </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">{{ $pasienIni->jadwalPeriksa->hari }},{{$pasienIni->jadwalPeriksa->jam_mulai}}-{{$pasienIni->jadwalPeriksa->jam_selesai}}</td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">{{ $pasienIni->keluhan }}</td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">{{ $pasienIni->no_antrian }}</td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="overflow-x-auto">
                    <form action="{{ route('dokter-simpan-Periksakan-Daftar-Periksa', ['id' => $pasienIni->id]) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
                      @csrf
                      <div class="mb-4">
                          <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Catatan:</label>
                          <input type="text" name="catatan" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;">
                      </div>
                      <div class="mb-4" hidden>
                          <label for="biaya_periksa" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Biaya Periksa:</label>
                          <input type="text" name="biaya_periksa" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;" readonly value="150000">
                      </div>
                      <div class="mb-4">
                        <label for="obat" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Obat:</label>
                        <div id="obatContainer">
                            <select id="obatSelect" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;">
                                <!-- Loop through your list of obat from the database and create options -->
                                <option value="" disabled selected>~~ Pilih Obat ~~</option>
                                @foreach($daftar_obat as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>

                      <div id="obatInputs" class="mb-4">
                          <!-- Input jumlah dan nama obat untuk setiap obat akan ditambahkan secara dinamis di sini oleh JavaScript -->
                      </div>
                          
                      <!-- Script JavaScript -->
                      <script>
                        document.getElementById('obatSelect').addEventListener('change', function() {
    // Mendapatkan elemen select dan jumlah obat yang dipilih
    var select = document.getElementById('obatSelect');
    var selectedObat = select.options[select.selectedIndex].text;

    // Mendapatkan id_obat
    var id_obat = select.value;

    // Mendapatkan harga_obat (gantilah ini dengan cara mendapatkan harga yang sesuai dari data obat)
    var harga_obat = getHargaById(id_obat); // Fungsi getHargaById perlu Anda buat

    // Mengecek apakah input jumlah untuk obat tersebut sudah ada atau belum
    if (!document.querySelector('input[name="jumlah_obat[' + selectedObat + ']"]')) {
        // Menambahkan div untuk menampilkan nama obat
        var obatInputs = document.getElementById('obatInputs');
        var obatDiv = document.createElement('div');
        var boldText = document.createElement('strong');
        boldText.innerText = selectedObat;
        obatDiv.appendChild(document.createTextNode('Nama Obat = '));
        obatDiv.appendChild(boldText);
        obatDiv.style.marginBottom = '0.5rem';
        obatDiv.style.marginLeft = '0.5rem';

        // Hidden input id_obat
        var hiddenInputIdObat = document.createElement('input');
        hiddenInputIdObat.type = 'hidden';
        hiddenInputIdObat.value = id_obat;
        hiddenInputIdObat.name = 'id_obat[]';

        // Hidden input harga_obat
        var hiddenInputHargaObat = document.createElement('input');
        hiddenInputHargaObat.type = 'hidden';
        hiddenInputHargaObat.value = harga_obat;
        hiddenInputHargaObat.name = 'harga_obat[]';

        // Menambahkan tombol "Batal" untuk membatalkan pemilihan obat
        var batalButton = document.createElement('button');
        batalButton.type = 'button';
        batalButton.innerText = 'Hapus ' + selectedObat;
        batalButton.classList.add('btn', 'btn-danger', 'shadow-soft-2xl', 'rounded-lg', 'bg-dark', 'stroke-0', 'text-center', 'p-1');
        batalButton.style.backgroundImage = 'linear-gradient(to bottom right, #ef0488, #8624c2)';
        batalButton.style.color = 'white';
        batalButton.addEventListener('click', function() {
            obatInputs.removeChild(obatDiv);
            resetObatSelect();
        });

        // Menambahkan nama obat, input jumlah, dan tombol "Batal" ke dalam div
        obatDiv.appendChild(document.createElement('br'));
        obatDiv.appendChild(hiddenInputIdObat);
        obatDiv.appendChild(hiddenInputHargaObat);
        obatDiv.appendChild(batalButton);
        obatInputs.appendChild(obatDiv);

        // Mengganti teks pada elemen select
        resetObatSelect();
    }
});

// Fungsi untuk mendapatkan harga obat berdasarkan ID (sesuaikan dengan struktur data Anda)
function getHargaById(id_obat) {
    // Gantilah ini dengan cara mendapatkan harga berdasarkan ID dari data obat
    var obatData = <?php echo json_encode($daftar_obat); ?>;
    var obat = obatData.find(function(item) {
        return item.id == id_obat;
    });

    return obat ? obat.harga : 0; // Jika obat ditemukan, kembalikan harga; jika tidak, kembalikan 0
}


                        function resetObatSelect() {
                            // Mengganti teks pada elemen select menjadi "~~ pilih obat ~~"
                            var select = document.getElementById('obatSelect');
                            select.selectedIndex = 0; // Mengatur kembali ke indeks pertama
                        }
                      </script>
                      <div class="mb-4 flex justify-center">
                          <button type="submit" class="btn btn-success shadow-soft-2xl rounded-lg bg-dark stroke-0 text-center xl:p-2.5" style="background-image: linear-gradient(to bottom right, #ef0488, #8624c2); color:white;">Tambah pasien</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        </div>
  
        <footer class="pt-4">
          <div class="w-full px-6 mx-auto">
            <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
              <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                  ©
                  <script>
                    document.write(new Date().getFullYear() + ",");
                  </script>
                  dibuat oleh
                  <a href="" class="font-semibold text-slate-700" target="_blank">Naufal Iksham</a>
                  untuk website yang lebih baik.
                </div>
              </div>
              <div class="w-full max-w-full px-3 mt-0 shrink-0 lg:w-1/2 lg:flex-none">
                <ul class="flex flex-wrap justify-center pl-0 mb-0 list-none lg:justify-end">
                  <li class="nav-item">
                    <a href="mailto:naufal.iksham@gmail.com" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">Email</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://www.instagram.com/naufal_iksham/" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">Instagram</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://www.facebook.com/naufaliksham/" class="block px-4 pt-0 pb-1 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">Facebook</a>
                  </li>
                  <li class="nav-item">
                    <a href="https://api.whatsapp.com/send/?phone=6282243090750&text&type=phone_number&app_absent=0" class="block px-4 pt-0 pb-1 pr-0 text-sm font-normal transition-colors ease-soft-in-out text-slate-500" target="_blank">WhatsApp</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
      <!-- end cards -->
    </main>
  </body>
  <!-- plugin for charts  -->
  <script src="./assets/js/plugins/chartjs.min.js" async></script>
  <!-- plugin for scrollbar  -->
  <script src="./assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <!-- github button -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- main script file  -->
  <script src="./assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>
</html>
