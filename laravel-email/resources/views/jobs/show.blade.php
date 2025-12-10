<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Lowongan Pekerjaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Tombol Kembali -->
                    <div class="mb-6">
                        <a href="{{ route('jobs.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Kembali ke Daftar Lowongan
                        </a>
                    </div>

                    <!-- Header Lowongan -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                        <div class="flex flex-wrap gap-4 text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="font-semibold">{{ $job->company }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $job->location }}</span>
                            </div>
                            @if($job->salary)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-green-600">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Deskripsi Pekerjaan -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Pekerjaan</h2>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $job->description }}
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Lowongan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Diposting pada</p>
                                <p class="font-semibold">{{ $job->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Terakhir diperbarui</p>
                                <p class="font-semibold">{{ $job->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Lamar -->
                    @auth
                        @if(auth()->user()->role !== 'admin')
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Tertarik dengan lowongan ini?</h2>
                            <p class="text-gray-700 mb-6">Kirimkan lamaran Anda sekarang dengan mengunggah CV terbaru.</p>
                            
                            <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="cv" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload CV (PDF, DOC, DOCX - Max 2MB)
                                    </label>
                                    <input type="file" 
                                           name="cv" 
                                           id="cv" 
                                           accept=".pdf,.doc,.docx"
                                           required
                                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('cv')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                        Cover Letter (Opsional)
                                    </label>
                                    <textarea name="cover_letter" 
                                              id="cover_letter" 
                                              rows="5"
                                              placeholder="Ceritakan mengapa Anda cocok untuk posisi ini..."
                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>

                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Kirim Lamaran
                                </button>
                            </form>
                        </div>
                        @endif
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-lg">
                            <p class="text-gray-700 mb-4">Anda harus login terlebih dahulu untuk melamar pekerjaan ini.</p>
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
