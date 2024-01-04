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
            <div class="w-full max-w-full px-3 mt-0 mb-6">
                <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                  <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0 mb-4">
                    <h6><center>Tambah Jadwal Periksa</center></h6>
                  </div>
                  <center>
                    @if($errors->any())
                      <div>
                        @foreach($errors->all() as $error)
                          <p style="color: red">{{ $error }}</p>
                        @endforeach
                      </div>
                    @endif
                    @if(session('success'))
                      <div>
                        <p style="color: blue">{{ session('success') }}</p>
                      </div>
                    @endif
                  </center>
                  <form action="{{ route('dokter-create-jadwal-periksa') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
                    @csrf
                    <div class="mb-4">
                        <label for="hari" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Hari:</label>
                        <select name="hari" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;">
                          <option value="" disabled selected>Pilih Hari</option>
                          <option value="senin">Senin</option>
                          <option value="selasa">Selasa</option>
                          <option value="rabu">Rabu</option>
                          <option value="kamis">Kamis</option>
                          <option value="jumat">Jumat</option>
                          <option value="sabtu">Sabtu</option>
                        </select>                     
                    </div>
                    <div class="mb-4">
                      <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Jam Mulai:</label>
                      <select name="jam_mulai" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;">
                          {{-- Loop untuk opsi jam mulai --}}
                          @for ($i = 0; $i < 24; $i++)
                              @for ($j = 0; $j < 60; $j += 15)
                                  {{-- Format jam --}}
                                  @php
                                      $formattedHour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                      $formattedMinute = str_pad($j, 2, '0', STR_PAD_LEFT);
                                      $formattedTime = $formattedHour . ':' . $formattedMinute;
                                  @endphp
                                  <option value="{{ $formattedTime }}">{{ $formattedTime }}</option>
                              @endfor
                          @endfor
                      </select>
                  </div>
                  
                  <div class="mb-4">
                      <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1" style="margin: 0.5rem;">Jam Selesai:</label>
                      <select name="jam_selesai" class="w-full p-2 border rounded-md" style="width: calc(100% - 1rem); padding: 0.5rem; border-radius: 0.375rem; margin: 0.5rem;">
                          {{-- Loop untuk opsi jam selesai --}}
                          @for ($i = 0; $i < 24; $i++)
                              @for ($j = 0; $j < 60; $j += 15)
                                  {{-- Format jam --}}
                                  @php
                                      $formattedHour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                      $formattedMinute = str_pad($j, 2, '0', STR_PAD_LEFT);
                                      $formattedTime = $formattedHour . ':' . $formattedMinute;
                                  @endphp
                                  <option value="{{ $formattedTime }}">{{ $formattedTime }}</option>
                              @endfor
                          @endfor
                      </select>
                  </div>                  
                  <div class="mb-4 flex justify-center">
                    <button type="submit" class="btn btn-success shadow-soft-2xl rounded-lg bg-dark stroke-0 text-center xl:p-2.5" style="background-image: linear-gradient(to bottom right, #ef0488, #8624c2); color:white;">Tambahkan Jadwal Periksa</button>
                  </div>
                </form>
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

    </html>
    