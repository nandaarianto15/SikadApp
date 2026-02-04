@extends('layouts.dashboard')

@section('title', 'Tambah Berita')

@section('content')
<div class="p-4 lg:p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.news.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <i data-lucide="arrow-left" size="20" class="text-gray-600"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Berita Baru</h1>
    </div>
    
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="news-form" class="bg-white rounded-xl shadow-sm p-6">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Berita</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('title') }}">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        <option value="Utama" {{ old('category') == 'Utama' ? 'selected' : '' }}>Utama</option>
                        <option value="Kegiatan" {{ old('category') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Pengumuman" {{ old('category') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="Pelatihan" {{ old('category') == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tag</label>
                    <input type="text" name="tag" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('tag') }}">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal: 2MB</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita</label>
                <textarea name="content" rows="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg" id="editor">
                    {{ old('content') }}
                </textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publikasi</label>
                    <input type="text" name="published_at_display" id="published_at_display" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="dd/mm/yyyy" value="{{ old('published_at_display', now()->format('d/m/Y')) }}">
                    <input type="hidden" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" {{ old('is_published') ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-gray-700">Terbitkan sekarang</label>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.news.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                Simpan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<!-- Tambahkan CSS dan JS Flatpickr dari CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'heading',
                '|',
                'bold', 'italic', 'underline', 'strikethrough',
                '|',
                'link', 'bulletedList', 'numberedList',
                '|',
                'blockQuote', 'insertTable',
                '|',
                'undo', 'redo'
            ],
        })
        .catch(error => {
            console.error(error);
        });

    // Inisialisasi Flatpickr untuk tanggal publikasi
    flatpickr("#published_at_display", {
        dateFormat: "d/m/Y", // Format tampilan dd/mm/yyyy
        altInput: true,
        altFormat: "j F Y", // Format alternatif untuk aksesibilitas
        locale: {
            firstDayOfWeek: 1, // Minggu dimulai dari Senin
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            },
        },
        // Tambahkan konfigurasi untuk memastikan format hari-bulan-tahun
        disableMobile: "true",
        defaultDate: "{{ old('published_at_display', now()->format('d/m/Y')) }}",
        // BATASI TANGGAL MAKSIMAL HARI INI
        maxDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            // Update input hidden dengan format Y-m-d untuk keperluan submit
            const dateInput = document.getElementById('published_at');
            if (selectedDates[0]) {
                const date = selectedDates[0];
                const year = date.getFullYear();
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const day = date.getDate().toString().padStart(2, '0');
                dateInput.value = `${year}-${month}-${day}`;
            }
        }
    });

    // Form submission handler
    document.getElementById('news-form').addEventListener('submit', function(e) {
        // Pastikan tanggal sudah dalam format yang benar sebelum submit
        const displayInput = document.getElementById('published_at_display');
        const hiddenInput = document.getElementById('published_at');
        
        if (displayInput.value && !hiddenInput.value) {
            // Jika hanya display input yang ada nilai, konversi ke format Y-m-d
            const parts = displayInput.value.split('/');
            if (parts.length === 3) {
                hiddenInput.value = `${parts[2]}-${parts[1]}-${parts[0]}`;
            }
        }
    });
});
</script>
@endpush
@endsection