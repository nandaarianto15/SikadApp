<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left p-4 font-medium text-gray-700">ID</th>
                <th class="text-left p-4 font-medium text-gray-700">Layanan</th>
                <th class="text-left p-4 font-medium text-gray-700">Perihal</th>
                <th class="text-left p-4 font-medium text-gray-700">Tanggal</th>
                <th class="text-left p-4 font-medium text-gray-700">Status</th>
                <th class="text-left p-4 font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($submissions as $submission)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm font-mono">{{ $submission->tracking_id }}</td>
                <td class="p-4 text-sm">{{ $submission->service->name }}</td>
                <td class="p-4 text-sm">{{ $submission->perihal }}</td>
                <td class="p-4 text-sm">{{ $submission->created_at->format('d M Y') }}</td>
                <td class="p-4">
                    <div class="flex items-center">
                        @if ($submission->status === 'process')
                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full min-w-[80px]">Masuk Antrian</span>
                        @elseif ($submission->status === 'revision')
                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full min-w-[90px]">Revisi</span>
                        @elseif ($submission->status === 'rejected')
                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full min-w-[90px]">Ditolak</span>
                        @elseif ($submission->status === 'signed')
                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full min-w-[90px]">Selesai</span>
                        @endif
                    </div>
                </td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('pemohon.tracking', $submission->tracking_id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#00A651] text-white rounded-lg text-xs font-medium hover:bg-emerald-600 transition-colors">
                            <i data-lucide="eye" size="12"></i>
                            Detail
                        </a>
                        {{-- @if ($submission->status === 'rejected' || $submission->status === 'revision')
                            <a href="{{ route('pemohon.tracking', $submission->tracking_id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-200 transition-colors">
                                <i data-lucide="edit" size="12"></i>
                                Edit
                            </a>
                        @endif --}}
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-500">
                    <i data-lucide="inbox" size="32" class="mx-auto mb-2 text-gray-300"></i>
                    <p>Tidak ada pengajuan dengan filter ini</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if ($submissions->hasPages())
    <div id="pagination-container" class="p-4 border-t border-gray-100 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Menampilkan {{ $submissions->firstItem() }} hingga {{ $submissions->lastItem() }} dari {{ $submissions->total() }} data
        </div>
        <div>
            {{ $submissions->links() }}
        </div>
    </div>
    @endif
</div>