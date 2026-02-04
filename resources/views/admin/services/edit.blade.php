@extends('layouts.dashboard')

@section('title', 'Edit Layanan: ' . $service->name)

@section('content')
<div class="p-4 lg:p-8 max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.services.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <i data-lucide="arrow-left" size="20" class="text-gray-600"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Layanan: {{ $service->name }}</h1>
    </div>
    
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" id="service-form" class="bg-white rounded-xl shadow-sm p-6">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('name', $service->name) }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select name="icon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="file-text" {{ old('icon', $service->icon) == 'file-text' ? 'selected' : '' }}>Dokumen</option>
                        <option value="plane" {{ old('icon', $service->icon) == 'plane' ? 'selected' : '' }}>Pesawat</option>
                        <option value="stethoscope" {{ old('icon', $service->icon) == 'stethoscope' ? 'selected' : '' }}>Stetoskop</option>
                        <option value="shield-check" {{ old('icon', $service->icon) == 'shield-check' ? 'selected' : '' }}>Perisai</option>
                        <option value="users" {{ old('icon', $service->icon) == 'users' ? 'selected' : '' }}>Pengguna</option>
                        <option value="globe" {{ old('icon', $service->icon) == 'globe' ? 'selected' : '' }}>Globe</option>
                        <option value="briefcase" {{ old('icon', $service->icon) == 'briefcase' ? 'selected' : '' }}>Koper</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('description', $service->description) }}</textarea>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
            </div>
            
            <!-- FORM FIELDS SECTION -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-4">Formulir Isian Dokumen</h3>
                <p class="text-sm text-gray-600 mb-4">Tambahkan field-field yang akan diisi oleh pemohon pada dokumen ini.</p>
                
                <div id="form-fields-container" class="space-y-4">
                    @if($service->form_fields)
                        @foreach($service->form_fields as $index => $field)
                            <div class="form-field-item border border-gray-200 rounded-lg p-4" data-field-id="{{ $index }}">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">Field #{{ $index + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-form-field">
                                        <i data-lucide="trash-2" size="16"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Field (unik, tanpa spasi)</label>
                                        <input type="text" name="form_fields[{{ $index }}][name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" value="{{ old('form_fields.'.$index.'.name', $field['name']) }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                                        <input type="text" name="form_fields[{{ $index }}][label]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" value="{{ old('form_fields.'.$index.'.label', $field['label']) }}">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Input</label>
                                        <select name="form_fields[{{ $index }}][type]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 field-type-select">
                                            <option value="text" {{ $field['type'] == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="number" {{ $field['type'] == 'number' ? 'selected' : '' }}>Number</option>
                                            <option value="email" {{ $field['type'] == 'email' ? 'selected' : '' }}>Email</option>
                                            <option value="date" {{ $field['type'] == 'date' ? 'selected' : '' }}>Date</option>
                                            <option value="textarea" {{ $field['type'] == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                            <option value="select" {{ $field['type'] == 'select' ? 'selected' : '' }}>Select Dropdown</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Placeholder (opsional)</label>
                                        <input type="text" name="form_fields[{{ $index }}][placeholder]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" value="{{ old('form_fields.'.$index.'.placeholder', $field['placeholder'] ?? '') }}">
                                    </div>
                                </div>
                                <div class="field-options-container mt-4 {{ $field['type'] != 'select' ? 'hidden' : '' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Opsi untuk Select (pisahkan dengan koma)</label>
                                    <input type="text" name="form_fields[{{ $index }}][options_text]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" value="{{ old('form_fields.'.$index.'.options_text', implode(', ', $field['options'] ?? [])) }}">
                                </div>
                                <div class="mt-4 flex items-center">
                                    <input type="checkbox" name="form_fields[{{ $index }}][is_required]" id="field-{{ $index }}-required" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" {{ old('form_fields.'.$index.'.is_required', $field['is_required']) ? 'checked' : '' }}>
                                    <label for="field-{{ $index }}-required" class="ml-2 block text-sm text-gray-700">Wajib</label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button type="button" id="add-form-field" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-lg hover:bg-blue-200 transition-colors">
                        <i data-lucide="plus" size="14" class="inline mr-1"></i> Tambah Field
                    </button>
                </div>
            </div>

            <!-- REQUIREMENTS SECTION -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-4">Persyaratan Dokumen</h3>
                
                <div id="requirements-container" class="space-y-4">
                    @foreach($service->requirements->sortBy('sort_order') as $index => $requirement)
                    <div class="requirement-item border border-gray-200 rounded-lg p-4" data-req-id="{{ $index }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-sm font-medium text-gray-700">Persyaratan #{{ $index + 1 }}</h4>
                            <button type="button" class="text-red-600 hover:text-red-800 remove-requirement">
                                <i data-lucide="trash-2" size="16"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Persyaratan</label>
                                <input type="text" name="requirements[{{ $index }}][name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" value="{{ old('requirements.'.$index.'.name', $requirement->name) }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                <input type="number" name="requirements[{{ $index }}][sort_order]" value="{{ old('requirements.'.$index.'.sort_order', $requirement->sort_order) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" readonly>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="requirements[{{ $index }}][description]" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('requirements.'.$index.'.description', $requirement->description) }}</textarea>
                        </div>
                        <div class="mt-4 flex items-center">
                            <input type="checkbox" name="requirements[{{ $index }}][is_required]" id="req-{{ $index }}-required" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" {{ old('requirements.'.$index.'.is_required', $requirement->is_required) ? 'checked' : '' }}>
                            <label for="req-{{ $index }}-required" class="ml-2 block text-sm text-gray-700">Wajib</label>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button type="button" id="add-requirement" class="text-sm bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg hover:bg-emerald-200 transition-colors">
                        <i data-lucide="plus" size="14" class="inline mr-1"></i> Tambah Persyaratan
                    </button>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize counts based on existing data
    let requirementCount = document.querySelectorAll('.requirement-item').length;
    let formFieldCount = {{ $service->form_fields ? count($service->form_fields) : 0 }};

    const requirementsContainer = document.getElementById('requirements-container');
    const addRequirementBtn = document.getElementById('add-requirement');

    // --- REQUIREMENTS LOGIC ---
    addRequirementBtn.addEventListener('click', function () {
        const index = requirementCount;
        const div = createRequirementElement(index);
        requirementsContainer.appendChild(div);
        lucide.createIcons();
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
        requirementCount++;
    });

    function createRequirementElement(index) {
        const div = document.createElement('div');
        div.className = 'requirement-item border border-gray-200 rounded-lg p-4';
        div.setAttribute('data-req-id', index);
        div.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-sm font-medium text-gray-700">Persyaratan #${index + 1}</h4>
                <button type="button" class="text-red-600 hover:text-red-800 remove-requirement">
                    <i data-lucide="trash-2" size="16"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Persyaratan</label>
                    <input type="text" name="requirements[${index}][name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="requirements[${index}][sort_order]" value="${index + 1}" min="1" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="requirements[${index}][description]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
            <div class="mt-4 flex items-center">
                <input type="checkbox" name="requirements[${index}][is_required]" id="req-${index}-required" value="1" checked class="h-4 w-4 text-emerald-600 border-gray-300 rounded">
                <label for="req-${index}-required" class="ml-2 text-sm text-gray-700">Wajib</label>
            </div>
        `;
        div.querySelector('.remove-requirement').addEventListener('click', () => removeRequirement(div));
        return div;
    }

    document.querySelectorAll('.remove-requirement').forEach(btn => {
        btn.addEventListener('click', function () {
            removeRequirement(this.closest('.requirement-item'));
        });
    });

    function removeRequirement(item) {
        item.remove();
        reindexRequirements();
    }

    function reindexRequirements() {
        const items = document.querySelectorAll('.requirement-item');
        items.forEach((item, index) => {
            item.setAttribute('data-req-id', index);
            item.querySelector('h4').textContent = `Persyaratan #${index + 1}`;
            const nameInput = item.querySelector('input[name*="[name]"]'); if (nameInput) nameInput.name = `requirements[${index}][name]`;
            const descTextarea = item.querySelector('textarea[name*="[description]"]'); if (descTextarea) descTextarea.name = `requirements[${index}][description]`;
            const orderInput = item.querySelector('input[name*="[sort_order]"]'); if (orderInput) { orderInput.name = `requirements[${index}][sort_order]`; orderInput.value = index + 1; }
            const checkbox = item.querySelector('input[type="checkbox"]'); const label = item.querySelector('label[for^="req-"]');
            if (checkbox && label) { checkbox.name = `requirements[${index}][is_required]`; checkbox.id = `req-${index}-required`; label.setAttribute('for', `req-${index}-required`); }
        });
        requirementCount = items.length;
    }

    // --- FORM FIELDS LOGIC ---
    const formFieldsContainer = document.getElementById('form-fields-container');
    const addFormFieldBtn = document.getElementById('add-form-field');

    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-form-field').forEach(btn => {
        btn.addEventListener('click', function () {
            removeFormField(this.closest('.form-field-item'));
        });
    });

    // --- PERBAIKAN: Tambahkan event listener untuk field select yang sudah ada dari awal ---
    document.querySelectorAll('.form-field-item .field-type-select').forEach(select => {
        select.addEventListener('change', (e) => {
            const optionsContainer = e.target.closest('.form-field-item').querySelector('.field-options-container');
            if (e.target.value === 'select') {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }
        });
    });

    addFormFieldBtn.addEventListener('click', function () {
        const index = formFieldCount;
        const div = createFormFieldElement(index);
        formFieldsContainer.appendChild(div);
        lucide.createIcons();
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
        formFieldCount++;
    });

    function createFormFieldElement(index) {
        const div = document.createElement('div');
        div.className = 'form-field-item border border-gray-200 rounded-lg p-4';
        div.setAttribute('data-field-id', index);
        div.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-sm font-medium text-gray-700">Field #${index + 1}</h4>
                <button type="button" class="text-red-600 hover:text-red-800 remove-form-field">
                    <i data-lucide="trash-2" size="16"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Field (unik, tanpa spasi)</label>
                    <input type="text" name="form_fields[${index}][name]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="contoh: nama_lengkap">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                    <input type="text" name="form_fields[${index}][label]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="contoh: Nama Lengkap">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Input</label>
                    <select name="form_fields[${index}][type]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 field-type-select">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="date">Date</option>
                        <option value="textarea">Textarea</option>
                        <option value="select">Select Dropdown</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Placeholder (opsional)</label>
                    <input type="text" name="form_fields[${index}][placeholder]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="contoh: Masukkan nama lengkap">
                </div>
            </div>
            <div class="field-options-container mt-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Opsi untuk Select (pisahkan dengan koma)</label>
                <input type="text" name="form_fields[${index}][options_text]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Opsi 1, Opsi 2, Opsi 3">
            </div>
            <div class="mt-4 flex items-center">
                <input type="checkbox" name="form_fields[${index}][is_required]" id="field-${index}-required" value="1" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded" checked>
                <label for="field-${index}-required" class="ml-2 block text-sm text-gray-700">Wajib</label>
            </div>
        `;
        div.querySelector('.remove-form-field').addEventListener('click', () => removeFormField(div));
        div.querySelector('.field-type-select').addEventListener('change', (e) => {
            const optionsContainer = div.querySelector('.field-options-container');
            if (e.target.value === 'select') {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }
        });
        return div;
    }

    function removeFormField(item) {
        item.remove();
        reindexFormFields();
    }

    function reindexFormFields() {
        const items = document.querySelectorAll('.form-field-item');
        items.forEach((item, index) => {
            item.setAttribute('data-field-id', index);
            item.querySelector('h4').textContent = `Field #${index + 1}`;
            item.querySelector('input[name*="[name]"]').name = `form_fields[${index}][name]`;
            item.querySelector('input[name*="[label]"]').name = `form_fields[${index}][label]`;
            item.querySelector('select[name*="[type]"]').name = `form_fields[${index}][type]`;
            item.querySelector('input[name*="[placeholder]"]').name = `form_fields[${index}][placeholder]`;
            
            const checkbox = item.querySelector('input[type="checkbox"]');
            const label = item.querySelector('label[for^="field-"]');
            if (checkbox && label) {
                checkbox.name = `form_fields[${index}][is_required]`;
                checkbox.id = `field-${index}-required`;
                label.setAttribute('for', `field-${index}-required`);
            }

            const optionsInput = item.querySelector('input[name*="[options_text]"]');
            if(optionsInput) optionsInput.name = `form_fields[${index}][options_text]`;
        });
        formFieldCount = items.length;
    }
    
    // --- Form Submission Logic ---
    document.getElementById('service-form').addEventListener('submit', function(e) {
        const formFields = document.querySelectorAll('.form-field-item');
        formFields.forEach((item, index) => {
            const typeSelect = item.querySelector(`select[name="form_fields[${index}][type]"]`);
            if (typeSelect && typeSelect.value === 'select') {
                const optionsText = item.querySelector(`input[name="form_fields[${index}][options_text]"]`).value;
                const optionsArray = optionsText.split(',').map(opt => opt.trim()).filter(opt => opt);

                optionsArray.forEach(option => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `form_fields[${index}][options][]`;
                    hiddenInput.value = option;
                    item.appendChild(hiddenInput);
                });
            }
        });
    });
});
</script>
@endpush
@endsection