<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">
                            Kelola daftar pelamar yang tersedia.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Nama Pelamar
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Lowongan
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        CV
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($applications as $app)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $app->user->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $app->job->title }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <a href="{{ asset('storage/' . $app->cv) }}" 
                                               target="_blank" 
                                               class="text-blue-600 hover:underline">
                                                Lihat CV
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ strtolower($app->status) == 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ strtolower($app->status) == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ strtolower($app->status) == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Accepted">
                                                    <button type="submit" 
                                                            class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" 
                                                            class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada pelamar yang daftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 