@extends('layouts.dashboard')

@section('title', 'Form Pengajuan')

@section('content')
<div class="flex flex-col h-screen bg-[#F3F4F6] font-sans">
    <div class="bg-white px-4 lg:px-6 py-7 border-b flex items-center justify-between shadow-sm sticky top-0 z-40 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('pemohon.select') }}" class="hover:bg-gray-100 p-2 rounded-full transition-colors">
                <i data-lucide="chevron-left" size="24" class="text-gray-500"></i>
            </a>
            <div>
                <h2 class="font-bold text-lg text-gray-800 flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <span>Pengajuan</span>
                    <span id="wizard-title" class="text-[#00A651] truncate max-w-[200px] sm:max-w-none">{{ $service->name }}</span>
                </h2>
                <p class="text-xs text-gray-500 hidden sm:block">Lengkapi data dan dokumen persyaratan</p>
            </div>
        </div>
    </div>
    
    <form id="submission-form" method="POST" action="{{ route('pemohon.submissions.store') }}" class="flex-1 overflow-y-auto p-4 lg:p-8">
        @csrf
        <input type="hidden" name="service_id" value="{{ $service->id }}">
        <div class="max-w-4xl mx-auto space-y-6 lg:space-y-8 animate-[slideUp_0.5s_ease-out]">
            <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                    <i data-lucide="file-text" size="20" class="text-[#00A651]"></i> Data Utama Naskah
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2 group">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Perihal / Judul</label>
                        <input type="text" name="perihal" id="input-perihal" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Contoh: Permohonan Izin..." required>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Tujuan Surat</label>
                        <input type="text" name="tujuan" id="input-tujuan" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="Kepada Yth...">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Tanggal Surat</label>
                        <input type="text" name="tanggal_surat" id="input-tanggal_surat" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="dd/mm/yyyy">
                        <p class="text-xs text-gray-500 mt-1">Tanggal tidak bisa lebih awal dari hari ini</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Isi Ringkas</label>
                        <textarea name="isi_ringkas" id="input-isi_ringkas" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" rows="4" placeholder="Jelaskan isi surat secara singkat..."></textarea>
                    </div>
                </div>
            </div>

            @if($service->form_fields)
            <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                    <i data-lucide="edit-3" size="20" class="text-[#00A651]"></i> Data Formulir
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($service->form_fields as $field)
                        <div class="@if($field['type'] === 'textarea') col-span-2 @endif group">
                            <label for="form_{{ $field['name'] }}" class="text-sm font-bold text-gray-700 mb-1 block">
                                {{ $field['label'] }}
                                @if($field['is_required']) <span class="text-red-500">*</span> @endif
                            </label>
                            @switch($field['type'])
                                @case('text')
                                    <input type="text" id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['is_required']) required @endif>
                                    @break
                                @case('number')
                                    <input type="number" id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['is_required']) required @endif>
                                    @break
                                @case('email')
                                    <input type="email" id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['is_required']) required @endif>
                                    @break
                                @case('date')
                                    <input type="date" id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" @if($field['is_required']) required @endif>
                                    @break
                                @case('textarea')
                                    <textarea id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" rows="4" placeholder="{{ $field['placeholder'] ?? '' }}" @if($field['is_required']) required @endif></textarea>
                                    @break
                                @case('select')
                                    <select id="form_{{ $field['name'] }}" name="form_data[{{ $field['name'] }}]" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#00A651]/10 focus:border-[#00A651] outline-none" @if($field['is_required']) required @endif>
                                        <option value="" disabled selected>-- Pilih {{ $field['label'] }} --</option>
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach($field['options'] as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @break
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <div class="bg-white p-6 lg:p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b pb-4 mb-6 flex items-center gap-3 text-lg">
                    <i data-lucide="upload-cloud" size="20" class="text-[#00A651]"></i> Upload Persyaratan
                </h3>
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <i data-lucide="info" size="16" class="inline mr-2"></i>
                        <strong>Informasi Penting:</strong> Setiap dokumen akan diverifikasi secara terpisah. Jika ada dokumen yang ditolak, Anda hanya perlu mengganti dokumen tersebut saat revisi.
                    </p>
                </div>
                <div id="wizard-reqs-container" class="space-y-4">
                    @foreach($service->requirements->sortBy('order') as $req)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-emerald-50/50 hover:border-[#00A651] transition-all group gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-white rounded-full border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-[#00A651] group-hover:border-[#00A651] transition-all shadow-sm shrink-0 mt-1">
                                <i data-lucide="file" size="18"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-700 text-sm">{{ $req->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $req->description ?? 'Wajib • PDF Max 5MB' }}</p>
                                <span class="text-xs {{ $req->is_required ? 'text-red-500 font-medium' : 'text-gray-500' }}">{{ $req->is_required ? 'Wajib' : 'Opsional' }}</span>
                                
                                <div id="preview-{{ $req->id }}" class="mt-2 text-xs text-gray-500"></div>
                            </div>
                        </div>
                        <label class="cursor-pointer sm:ml-4">
                            <span class="text-xs font-bold bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm group-hover:text-[#00A651] group-hover:border-[#00A651] hover:bg-[#00A651] hover:text-white group-hover:hover:text-white transition-all inline-block text-center w-full sm:w-auto">
                                Pilih File
                            </span>
                            <input type="file" name="documents[{{ $req->id }}]" class="hidden" accept=".pdf" {{ $req->is_required ? 'required' : '' }} onchange="handleFileUpload(event, {{ $req->id }})">
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    
    <div class="p-4 lg:p-5 border-t bg-white flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40 shrink-0">
        <button type="button" id="submit-btn" onclick="submitWizardForm()" class="px-8 py-3 bg-[#00A651] text-white rounded-xl font-bold hover:bg-emerald-600 shadow-lg flex items-center justify-center gap-2 w-full sm:w-auto">
            <i data-lucide="send" size="18"></i> Ajukan Verifikasi
        </button>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();

    flatpickr("#input-tanggal_surat", {
        dateFormat: "d/m/Y",
        altInput: true,
        altFormat: "j F Y",
        locale: {
            firstDayOfWeek: 1,
            weekdays: { shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], },
            months: { shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'], },
        },
        disableMobile: "true",
        minDate: "today",
        defaultDate: "today",
    });

    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewDiv = document.getElementById(`preview-${event.target.name.match(/\d+/)[0]}`);
            
            previewDiv.innerHTML = '';
            
            if (file) {
                if (file.type !== 'application/pdf') {
                    previewDiv.innerHTML = `<span class="text-red-500 font-medium">Error: File harus berformat PDF.</span>`;
                    event.target.value = '';
                    return;
                }
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    previewDiv.innerHTML = `<span class="text-red-500 font-medium">Error: Ukuran file maksimal 5MB.</span>`;
                    event.target.value = '';
                    return;
                }
                
                const fileSizeKB = (file.size / 1024).toFixed(2);
                previewDiv.innerHTML = `<span class="text-green-600 font-medium">✓ ${file.name} (${fileSizeKB} KB)</span>`;
            }
        });
    });

    window.submitWizardForm = function() {
        const form = document.getElementById('submission-form');
        const formData = new FormData(form);
        
        const dateInput = document.getElementById('input-tanggal_surat');
        const dateValue = dateInput.value;
        
        if (dateValue) {
            const parts = dateValue.split('/');
            if (parts.length === 3) {
                const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                formData.set('tanggal_surat', formattedDate);
            }
        }
        
        const submitBtn = document.getElementById('submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="animate-spin" size="18"></i> Mengajukan...';
        lucide.createIcons();
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = `/pemohon/tracking/${data.tracking_id}`;
            } else {
                alert('Terjadi kesalahan: ' + data.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim pengajuan. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            lucide.createIcons();
        });
    };
});
</script>
@endpush