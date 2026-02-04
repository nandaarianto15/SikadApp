<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left p-4 font-medium text-gray-700">ID</th>
                <th class="text-left p-4 font-medium text-gray-700">Pemohon</th>
                <th class="text-left p-4 font-medium text-gray-700">Layanan</th>
                <th class="text-left p-4 font-medium text-gray-700">Tanggal</th>
                <th class="text-left p-4 font-medium text-gray-700">Status</th>
                <th class="text-left p-4 font-medium text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($submissions as $submission)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm font-mono">{{ $submission->tracking_id }}</td>
                <td class="p-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white text-[#00A651] rounded-full flex items-center justify-center font-bold text-xs border-2 border-emerald-200">
                            {{ strtoupper(substr($submission->user->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium">{{ $submission->user->name }}</span>
                    </div>
                </td>
                <td class="p-4 text-sm">{{ $submission->service->name }}</td>
                <td class="p-4 text-sm">{{ $submission->created_at->format('d M Y') }}</td>
                <td class="p-4">
                    <div class="flex items-center">
                        @if ($submission->status === 'process')
                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full min-w-[80px]">Menunggu</span>
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
                    @if ($submission->status === 'signed' || $submission->status === 'rejected')
                        <div class="flex gap-2">
                            <a href="{{ route('verifikator.tracking', $submission) }}" class="inline-flex items-center gap-1 px-[22px] py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-200 transition-colors">
                                <i data-lucide="eye" size="12"></i>
                                Detail
                            </a>
                            <button onclick="showQuickView({{ $submission->id }})" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-medium hover:bg-emerald-200 transition-colors">
                                <i data-lucide="file-text" size="12"></i>
                                Lihat Cepat
                            </button>
                        </div>
                    @else
                        <div class="flex gap-2">
                            <a href="{{ route('verifikator.tracking', $submission) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#00A651] text-white rounded-lg text-xs font-medium hover:bg-emerald-600 transition-colors">
                                <i data-lucide="check-square" size="12"></i>
                                Verifikasi
                            </a>
                            <button onclick="showQuickView({{ $submission->id }})" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-200 transition-colors">
                                <i data-lucide="file-text" size="12"></i>
                                Lihat Cepat
                            </button>
                        </div>
                    @endif
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
    
    <!-- Pagination -->
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

<!-- Quick View Modal -->
<div id="quick-view-modal" class="fixed inset-0 z-50 bg-black/50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Quick View Pengajuan</h3>
            <button onclick="closeQuickView()" class="p-1 hover:bg-gray-100 rounded-full">
                <i data-lucide="x" size="20" class="text-gray-500"></i>
            </button>
        </div>
        
        <div id="quick-view-content">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div id="document-viewer-modal" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-white w-[92%] max-w-5xl h-[90vh] max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="p-4 border-b flex items-center justify-between shrink-0">
            <h3 id="modal-title" class="font-bold text-lg text-gray-800">Pratinjau Dokumen</h3>
            <div class="flex items-center gap-2">
                <a id="modal-download-btn" href="#" target="_blank" class="px-4 py-2 bg-[#00A651] text-white rounded-lg text-sm font-bold hover:bg-emerald-600 transition-colors flex items-center gap-2">
                    <i data-lucide="download" size="16"></i>Unduh
                </a>

                <button onclick="closeDocumentModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <i data-lucide="x" size="22" class="text-gray-500"></i>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 relative overflow-hidden p-4">
            <!-- Loading -->
            <div id="pdf-loading" class="absolute inset-0 flex items-center justify-center bg-white z-10">
                <div class="text-center">
                    <i data-lucide="loader-2" class="animate-spin text-[#00A651]" size="32"></i>
                    <p class="text-sm text-gray-500 mt-2">
                        Memuat dokumen...
                    </p>
                </div>
            </div>

            <!-- Error -->
            <div id="pdf-error" class="absolute inset-0 flex items-center justify-center bg-white z-10 hidden">
                <div class="text-center text-red-600">
                    <i data-lucide="alert-circle" size="32"></i>
                    <p class="text-sm mt-2">Gagal memuat dokumen.</p>
                    <button onclick="closeDocumentModal()"
                            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

            <!-- PDF Viewer -->
            <iframe id="document-frame" class="w-full h-full border-0 rounded-xl" style="display: none;"></iframe>
        </div>
    </div>
</div>

<script>
    // Function to show quick view
    function showQuickView(submissionId) {
        // Show loading
        document.getElementById('quick-view-content').innerHTML = `
            <div class="flex justify-center items-center p-8">
                <i data-lucide="loader-2" class="animate-spin text-[#00A651] mr-2" size="24"></i>
                <span class="text-gray-600">Memuat data...</span>
            </div>
        `;
        
        // Show modal
        document.getElementById('quick-view-modal').classList.remove('hidden');
        lucide.createIcons();
        
        // Fetch submission data
        fetch(`/verifikator/api/submission/${submissionId}`)
            .then(response => response.json())
            .then(data => {
                // Determine button based on status
                let actionButton = '';
                if (data.status === 'signed' || data.status === 'rejected') {
                    actionButton = `
                        <a href="/verifikator/tracking/${data.tracking_id}" class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center">
                            <i data-lucide="eye" size="16" class="inline mr-1"></i>
                            Lihat Detail
                        </a>
                    `;
                } else {
                    actionButton = `
                        <a href="/verifikator/tracking/${data.tracking_id}" class="flex-1 bg-[#00A651] text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-600 transition-colors text-center">
                            <i data-lucide="check-square" size="16" class="inline mr-1"></i>
                            Verifikasi
                        </a>
                    `;
                }
                
                // Update modal content
                document.getElementById('quick-view-content').innerHTML = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">ID Tracking</p>
                                <p class="font-medium">${data.tracking_id}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Status</p>
                                <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-medium ${
                                    data.status === 'process' ? 'bg-blue-100 text-blue-700' : 
                                    data.status === 'revision' ? 'bg-yellow-100 text-yellow-700' : 
                                    data.status === 'rejected' ? 'bg-red-100 text-red-700' :
                                    'bg-green-100 text-green-700'
                                } rounded-full min-w-[80px]">
                                    ${data.status === 'process' ? 'Menunggu' : 
                                      data.status === 'revision' ? 'Revisi' : 
                                      data.status === 'rejected' ? 'Ditolak' :
                                      'Selesai'}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Pemohon</p>
                                <p class="font-medium">${data.user.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Layanan</p>
                                <p class="font-medium">${data.service.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Tanggal Pengajuan</p>
                                <p class="font-medium">${new Date(data.created_at).toLocaleDateString('id-ID')}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Perihal</p>
                                <p class="font-medium">${data.perihal}</p>
                            </div>
                        </div>
                        
                        <!-- Detail Requirements -->
                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Detail Dokumen Persyaratan
                            </h3>
                            <div class="grid gap-3">
                                ${data.documents.map(doc => `
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 ${
                                                doc.status === 'approved' ? 'bg-green-100 text-green-600' : 
                                                doc.status === 'rejected' ? 'bg-red-100 text-red-600' : 
                                                'bg-blue-100 text-blue-600'
                                            } rounded-full flex items-center justify-center shrink-0">
                                                <i data-lucide="${
                                                    doc.status === 'approved' ? 'check' : 
                                                    doc.status === 'rejected' ? 'x' : 
                                                    'clock'
                                                }" size="14"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-700 font-medium">${doc.requirement.name}</span>
                                                <p class="text-xs text-gray-500 mt-0.5">${doc.file_name} (${(doc.file_size / 1024 / 1024).toFixed(2)} MB)</p>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" onclick="openDocumentModal(${doc.id}, '${doc.file_name}')" class="text-xs font-bold text-[#00A651] bg-[#00A651]/10 px-2 py-1 rounded border border-[#00A651]/20 hover:bg-[#00A651]/20 transition-colors">Lihat</a>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        
                        <div class="flex gap-2 pt-4">
                            ${actionButton}
                            <button onclick="closeQuickView()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                `;
                
                // Reinitialize Lucide icons
                lucide.createIcons();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('quick-view-content').innerHTML = `
                    <div class="text-center p-8 text-red-600">
                        <i data-lucide="alert-circle" size="32" class="mx-auto mb-2"></i>
                        <p>Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                `;
                lucide.createIcons();
            });
    }
    
    // Function to close quick view
    function closeQuickView() {
        document.getElementById('quick-view-modal').classList.add('hidden');
    }
    
    // Function to open document modal (same as in app.js)
    function openDocumentModal(docId, fileName) {
        const modal = document.getElementById('document-viewer-modal');
        const frame = document.getElementById('document-frame');
        const loadingEl = document.getElementById('pdf-loading');
        const errorEl = document.getElementById('pdf-error');
        const downloadBtn = document.getElementById('modal-download-btn');
        const titleEl = document.getElementById('modal-title');

        if (!modal || !frame || !downloadBtn) return;

        modal.classList.remove('hidden');
        loadingEl.classList.remove('hidden');
        errorEl.classList.add('hidden');
        titleEl.innerText = `Pratinjau: ${fileName}`;
        
        // Tentukan URL berdasarkan role user
        const userRole = document.querySelector('meta[name="user-role"]').getAttribute('content');
        const baseUrl = userRole === 'verifikator' ? '/verifikator' : '/pemohon';
        
        downloadBtn.href = `${baseUrl}/documents/${docId}`;
        downloadBtn.setAttribute('download', fileName);

        const url = `${baseUrl}/documents/${docId}/view`;
        
        frame.onload = function() {
            loadingEl.classList.add('hidden');
            frame.style.display = 'block';
            lucide.createIcons();
        };
        
        frame.onerror = function() {
            loadingEl.classList.add('hidden');
            errorEl.classList.remove('hidden');
            lucide.createIcons();
        };
        
        frame.src = url;
    }

    // Function to close document modal
    function closeDocumentModal() {
        const modal = document.getElementById('document-viewer-modal');
        const frame = document.getElementById('document-frame');

        if (!modal || !frame) return;
        
        modal.classList.add('hidden');
        frame.src = 'about:blank';
        frame.style.display = 'none';
    }
</script>