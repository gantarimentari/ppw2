{{-- Halaman Index Pelamar (Daftar Pelamar) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelamar') }}
            @if($applications->count() > 0)
                <span class="text-gray-500 font-normal">
                    untuk {{ $applications->first()->job->title }}
                </span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pesan Sukses -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($applications->count() > 0)
                        <!-- Tombol Aksi (Export) -->
                        <div class="flex justify-between items-center mb-6">
                            <p class="text-lg font-medium text-gray-700">
                                Kelola daftar pelamar yang tersedia.
                            </p>
                            <!-- [LATIHAN 7] Tombol Export -->
                            <a href="{{ route('jobs.applications.export', $applications->first()->job_id) }}"
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Export ke Excel
                            </a>
                        </div>
                    @endif

                    <!-- Tabel Daftar Pelamar -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelamar</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CV</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($applications as $app)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div>{{ $app->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $app->user->email }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <!-- Tombol Lihat CV (dari PDF) -->
                                            <a href="{{ asset('storage/' . $app->cv) }}" target="_blank"
                                               class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                                Lihat CV
                                            </a>
                                            <!-- [LATIHAN 6] Tombol Download CV -->
                                            <a href="{{ route('applications.download', $app->id) }}"
                                               class="ml-2 inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                                Download
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <!-- [LATIHAN 1] Status Pelamar -->
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                                {{ strtolower($app->status) === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                                   (strtolower($app->status) === 'accepted' ? 'bg-green-100 text-green-700' : 
                                                   'bg-red-100 text-red-700') }}">
                                                {{ ucfirst(strtolower($app->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <!-- [LATIHAN 5] Form Aksi Terima/Tolak -->
                                            <div class="flex items-center gap-2">
                                                <!-- Form Terima -->
                                                <form action="{{ route('applications.updateStatus', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" 
                                                            class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
                                                            {{ strtolower($app->status) === 'accepted' ? 'disabled' : '' }}>
                                                        Terima
                                                    </button>
                                                </form>
                                                <!-- Form Tolak -->
                                                <form action="{{ route('applications.updateStatus', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" 
                                                            class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2"
                                                            {{ strtolower($app->status) === 'rejected' ? 'disabled' : '' }}>
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada pelamar untuk lowongan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $applications->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>