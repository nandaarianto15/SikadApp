window.addEventListener('scroll', () => {
    const nav = document.getElementById('landing-navbar');
    if (!nav) return;

    const logoBox = document.getElementById('nav-logo-box');
    const textBox = document.getElementById('nav-text-box');
    const subText = document.getElementById('nav-subtext');
    const loginBtn = document.getElementById('nav-login-btn');
    const menuBtn = document.getElementById('mobile-menu-btn');
    const links = document.querySelectorAll('.nav-link');

    if (window.scrollY > 20) {
        nav.classList.add('bg-white', 'shadow-md', 'py-3');
        nav.classList.remove('bg-transparent', 'py-4', 'lg:py-6');

        logoBox?.classList.replace('bg-white', 'bg-[#00A651]');
        logoBox?.classList.replace('text-[#00A651]', 'text-white');

        textBox?.classList.replace('text-white', 'text-[#1F2937]');
        subText?.classList.replace('text-white', 'text-[#00A651]');

        loginBtn?.classList.remove('bg-white', 'text-[#00A651]');
        loginBtn?.classList.add('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');

        menuBtn?.classList.remove('text-white', 'hover:bg-white/10');
        menuBtn?.classList.add('text-gray-800', 'hover:bg-gray-100');

        links.forEach(l => {
            l.classList.remove('text-white/90');
            l.classList.add('text-gray-600');
        });
    } else {
        nav.classList.remove('bg-white', 'shadow-md', 'py-3');
        nav.classList.add('bg-transparent', 'py-4', 'lg:py-6');

        logoBox?.classList.add('bg-white', 'text-[#00A651]');
        logoBox?.classList.remove('bg-[#00A651]', 'text-white');

        textBox?.classList.add('text-white');
        textBox?.classList.remove('text-[#1F2937]');

        subText?.classList.add('text-white');
        subText?.classList.remove('text-[#00A651]');

        loginBtn?.classList.add('bg-white', 'text-[#00A651]');
        loginBtn?.classList.remove('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');

        menuBtn?.classList.add('text-white', 'hover:bg-white/10');
        menuBtn?.classList.remove('text-gray-800', 'hover:bg-gray-100');

        links.forEach(l => {
            l.classList.add('text-white/90');
            l.classList.remove('text-gray-600');
        });
    }
});

let NEWS_DATA = [];
let SERVICES_DATA = [];
let currentSubmission = null;
let selectedType = null;
let trackingStatus = 'process';

document.addEventListener('DOMContentLoaded', async () => {
    lucide.createIcons();
    await loadLandingData();
    
    if (document.getElementById('select-type-grid')) {
        await loadSelectData();
        renderSelectGrid();
    }
    
    if (document.getElementById('wizard-reqs-container')) {
        await loadWizardData();
    }
    
    if (document.getElementById('tracking-timeline')) {
        const dateSpan = document.getElementById('preview-date');
        if(dateSpan) dateSpan.innerText = new Date().toLocaleDateString('id-ID');
        
        const submissionData = localStorage.getItem('currentSubmission');
        if (submissionData) {
            currentSubmission = JSON.parse(submissionData);
            trackingStatus = currentSubmission.status || 'process';
        }
        
        updateTrackingView();
    }
    
    if (document.getElementById('recent-activity-container')) {
        const submissionData = localStorage.getItem('currentSubmission');
        if (submissionData) {
            currentSubmission = JSON.parse(submissionData);
        }
        
        renderRecentActivity();
    }
});

async function loadLandingData() {
    try {
        const [newsRes, servicesRes] = await Promise.all([
            fetch('/api/landing/news'),
            fetch('/api/landing/services')
        ]);

        NEWS_DATA = await newsRes.json();
        SERVICES_DATA = await servicesRes.json();

        renderArticles();
        renderServices('');
    } catch (e) {
        console.error('Failed loading landing data', e);
    }
}

async function loadSelectData() {
    try {
        const servicesRes = await fetch('/api/landing/services');
        SERVICES_DATA = await servicesRes.json();
    } catch (e) {
        console.error('Failed loading select data', e);
    }
}

async function loadWizardData() {
    try {
        // Ambil service slug dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const serviceSlug = urlParams.get('service');
        
        if (!serviceSlug) {
            console.error('Service slug not found in URL');
            return;
        }
        
        // Ambil data service berdasarkan slug
        const serviceRes = await fetch(`/api/services/${serviceSlug}`);
        const serviceData = await serviceRes.json();
        
        // Set selectedType dan render form
        selectedType = serviceData;
        document.getElementById('wizard-title').innerText = selectedType.name;
        renderWizardRequirements();
    } catch (e) {
        console.error('Failed loading wizard data', e);
    }
}

function renderWizardRequirements() {
    const reqContainer = document.getElementById('wizard-reqs-container');
    if (!reqContainer || !selectedType) return;
    
    reqContainer.innerHTML = selectedType.reqs.map(req => `
    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-emerald-50/50 hover:border-[#00A651] transition-all group gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-white rounded-full border border-gray-200 flex items-center justify-center text-gray-400 group-hover:text-[#00A651] group-hover:border-[#00A651] transition-all shadow-sm shrink-0">
                <i data-lucide="file" size="18"></i>
            </div>
            <div>
                <p class="font-bold text-gray-700 text-sm">${req.name}</p>
                <p class="text-xs text-gray-400 mt-0.5">${req.description || 'Wajib • PDF Max 5MB'}</p>
                ${req.required ? '<span class="text-xs text-red-500 font-medium">Wajib</span>' : '<span class="text-xs text-gray-500">Opsional</span>'}
            </div>
        </div>
        <label class="cursor-pointer">
            <span class="text-xs font-bold bg-white border border-gray-300 px-4 py-2 rounded-lg shadow-sm group-hover:text-[#00A651] group-hover:border-[#00A651] hover:bg-[#00A651] hover:text-white group-hover:hover:text-white transition-all inline-block text-center w-full sm:w-auto">
                Pilih File
            </span>
            <input type="file" class="hidden" ${req.required ? 'required' : ''}>
        </label>
    </div>`).join('');
    
    lucide.createIcons();
}

function scrollToId(id) {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
}

function navigateTo(viewId) {
    window.location.href = `/${viewId}`;
}

function toggleMobileMenu() {
    document.getElementById('mobile-menu')?.classList.toggle('hidden');
}

function mobileNav(id) {
    scrollToId(id);
    toggleMobileMenu();
}

function logout() {
    currentSubmission = null;
    localStorage.removeItem('currentSubmission');
    navigateTo('');
}

function renderArticles() {
    const container = document.getElementById('articles-container');
    if (!container) return;

    container.innerHTML = NEWS_DATA.map((a, i) => {
        const isLatest = a.tag?.toLowerCase() === 'terbaru';

        return `
        <div class="group min-w-[280px] max-w-[280px] h-[380px] snap-center rounded-2xl overflow-hidden border shadow-lg flex flex-col
            ${isLatest ? 'bg-gradient-to-br from-yellow-50 to-orange-50 border-yellow-200' : 'bg-white border-gray-100'}"
            style="animation: slideUp .5s forwards ${i * 80}ms; opacity:0">

            <div class="relative h-40 bg-gray-200 overflow-hidden">
                <img src="${a.image}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                <span class="absolute top-3 left-3 px-2 py-1 text-[10px] rounded-full text-white
                    ${isLatest ? 'bg-orange-500' : 'bg-emerald-600'}">
                    ${a.category ?? 'Info'}
                </span>
            </div>

            <div class="p-5 flex flex-col flex-1">
                <div class="text-[10px] text-gray-500 flex items-center gap-1 mb-2">
                    <i data-lucide="calendar" size="12"></i>${a.date}
                </div>

                <h3 class="font-bold text-sm mb-2 line-clamp-2">${a.title}</h3>
                <p class="text-xs text-gray-600 line-clamp-3 mb-auto">${a.desc}</p>

                <a href="/news/${a.slug}" class="mt-4 text-xs font-bold text-[#00A651] flex items-center gap-1">
                    Selengkapnya <i data-lucide="arrow-right" size="12"></i>
                </a>
            </div>
        </div>`;
    }).join('');

    lucide.createIcons();
}

function renderServices(keyword) {
    const container = document.getElementById('services-container');
    const empty = document.getElementById('services-empty');
    if (!container) return;

    const filtered = SERVICES_DATA.filter(s =>
        s.name.toLowerCase().includes(keyword.toLowerCase()) ||
        s.desc.toLowerCase().includes(keyword.toLowerCase())
    );

    if (!filtered.length) {
        container.innerHTML = '';
        empty?.classList.remove('hidden');
        return;
    }

    empty?.classList.add('hidden');

    container.innerHTML = filtered.map((s, i) => `
        <button onclick="openServiceModal(${s.id})"
            class="bg-white p-6 rounded-2xl border border-gray-100 hover:shadow-xl hover:border-emerald-200 transition-all text-left"
            style="animation: slideUp .4s forwards ${i * 50}ms; opacity:0">

            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-[#00A651] mb-4">
                <i data-lucide="${s.icon}"></i>
            </div>

            <h4 class="font-bold text-lg mb-2">${s.name}</h4>
            <p class="text-xs text-gray-500 line-clamp-3">${s.desc}</p>
        </button>
    `).join('');

    lucide.createIcons();
}

function renderSelectGrid() {
    const grid = document.getElementById('select-type-grid');
    if (!grid) return;

    grid.innerHTML = '';

    SERVICES_DATA.forEach((s, i) => {
        const card = document.createElement('a');
        card.href = `/wizard?service=${s.slug}`;
        card.className = `
            bg-white rounded-2xl p-6 border border-gray-100
            hover:shadow-xl hover:-translate-y-1
            transition-all group
        `;
        card.style.animation = `slideUp .4s forwards ${i * 60}ms`;
        card.style.opacity = 0;

        card.innerHTML = `
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl
                    flex items-center justify-center text-[#00A651]">
                    <i data-lucide="${s.icon}"></i>
                </div>
                <h3 class="font-bold text-gray-800 group-hover:text-[#00A651]">
                    ${s.name}
                </h3>
            </div>

            <p class="text-sm text-gray-500 line-clamp-3 mb-4">
                ${s.desc ?? 'Tidak ada deskripsi'}
            </p>

            <span class="text-xs text-gray-400">
                ${s.reqs.length} persyaratan
            </span>
        `;

        grid.appendChild(card);
    });

    lucide.createIcons();
}

function openServiceModal(id) {
    const service = SERVICES_DATA.find(s => s.id === id);
    const modal = document.getElementById('service-modal');
    if (!service || !modal) return;

    modal.innerHTML = `
    <div class="bg-white max-w-lg w-full rounded-2xl shadow-xl animate-slide-up">
        <div class="bg-[#00A651] p-6 text-white relative">
            <button onclick="closeModal()" class="absolute top-4 right-4">✕</button>
            <h3 class="text-xl font-bold">${service.name}</h3>
            <p class="text-sm opacity-90 mt-1">${service.desc}</p>
        </div>

        <div class="p-6">
            <h4 class="text-xs font-bold uppercase text-gray-400 mb-3">Persyaratan</h4>
            <ul class="space-y-3">
                ${service.reqs.map(r => `
                    <li class="flex gap-3 text-sm text-gray-700">
                        <i data-lucide="check-circle" class="text-[#00A651]" size="16"></i>
                        <span>${r.name}</span>
                    </li>
                `).join('')}
            </ul>
        </div>
    </div>
    `;

    modal.classList.remove('hidden');
    lucide.createIcons();
}

function closeModal() {
    document.getElementById('service-modal')?.classList.add('hidden');
}

function submitForm() {
    const perihal = document.getElementById('input-perihal').value;
    
    // if (!perihal) {
    //     alert('Mohon lengkapi perihal/judul sebelum mengajukan.');
    //     return;
    // }
    
    currentSubmission = {
        id: 'REG-' + Math.floor(Math.random() * 10000),
        type: selectedType,
        perihal: perihal || 'Tanpa Perihal',
        status: 'process',
        submittedAt: new Date().toISOString()
    };
    trackingStatus = 'process';
    
    // Simpan ke localStorage
    localStorage.setItem('currentSubmission', JSON.stringify(currentSubmission));
    
    // Navigasi ke tracking
    navigateTo('tracking');
}

// Fungsi untuk update tracking status
function updateTrackingStatus(status) {
    trackingStatus = status;
    if(currentSubmission) {
        currentSubmission.status = status;
        localStorage.setItem('currentSubmission', JSON.stringify(currentSubmission));
    }
    updateTrackingView();
}

// Fungsi untuk update tracking view
function updateTrackingView() {
    if (!currentSubmission) {
        // Jika tidak ada currentSubmission, buat data dummy untuk testing
        currentSubmission = {
            id: 'REG-12345',
            type: {
                name: 'Izin LN: Ibadah Agama',
                icon: 'plane',
                reqs: [
                    { name: 'Surat Permohonan', description: 'Surat permohonan resmi dari instansi' },
                    { name: 'Jadwal Perjalanan', description: 'Jadwal keberangkatan dan kepulangan' },
                    { name: 'Jaminan Travel', description: 'Bukti pembayaran travel' },
                    { name: 'KTP', description: 'Fotokopi KTP yang masih berlaku' }
                ]
            },
            perihal: 'Permohonan Izin Perjalanan Ibadah',
            status: trackingStatus
        };
    }
    
    document.getElementById('tracking-id').innerText = `ID: ${currentSubmission.id}`;
    document.getElementById('preview-perihal').innerText = currentSubmission.perihal;
    const nomerElem = document.getElementById('preview-nomor');
    if(nomerElem) nomerElem.innerText = trackingStatus === 'signed' ? ': 800/123/KOMINFO-2024' : ': ___/___/____';

    // 1. Status Messages
    const msgContainer = document.getElementById('tracking-status-message');
    msgContainer.innerHTML = '';
    if (trackingStatus === 'revision') {
        msgContainer.innerHTML = `
        <div class="bg-red-50 border border-red-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
            <div class="bg-red-100 p-3 rounded-full w-fit h-fit text-red-600"><i data-lucide="alert-circle" size="24"></i></div>
            <div>
                <h4 class="font-bold text-red-700 text-lg">Dokumen Perlu Revisi</h4>
                <p class="text-sm text-red-600 mt-1 leading-relaxed">Verifikator telah memeriksa dokumen Anda dan menemukan ketidaksesuaian.</p>
                <button onclick="updateTrackingStatus('process')" class="mt-4 bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition-all">Perbaiki Sekarang</button>
            </div>
        </div>`;
    } else if (trackingStatus === 'signed') {
        msgContainer.innerHTML = `
        <div class="bg-green-50 border border-green-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-4 shadow-sm animate-fade-in">
            <div class="bg-green-100 p-3 rounded-full w-fit h-fit text-green-600"><i data-lucide="check-circle" size="24"></i></div>
            <div>
                <h4 class="font-bold text-green-700 text-lg">Dokumen Telah Terbit</h4>
                <p class="text-sm text-green-600 mt-1">Dokumen telah ditandatangani secara elektronik (BSrE).</p>
                <button class="mt-4 flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition-all"><i data-lucide="download" size="16"></i> Unduh PDF</button>
            </div>
        </div>`;
    }

    // 2. Requirements List - Menampilkan persyaratan sesuai service yang diajukan
    const reqList = document.getElementById('tracking-reqs-list');
    if (reqList && currentSubmission.type.reqs) {
        reqList.innerHTML = currentSubmission.type.reqs.map(req => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 shrink-0">
                    <i data-lucide="check" size="14"></i>
                </div>
                <div>
                    <span class="text-sm text-gray-700 font-medium">${req.name}</span>
                    ${req.description ? `<p class="text-xs text-gray-500 mt-0.5">${req.description}</p>` : ''}
                </div>
            </div>
            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">Terupload</span>
        </div>`).join('');
    }

    // 3. Timeline
    const timeline = document.getElementById('tracking-timeline');
    if (timeline) {
        timeline.innerHTML = `
            <div class="flex gap-4 relative pb-8">
                <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="relative z-10 w-10 h-10 bg-green-100 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0">
                    <i data-lucide="check-circle" size="18" class="text-green-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium mb-0.5">${new Date(currentSubmission.submittedAt || Date.now()).toLocaleDateString('id-ID')} 10:00</p>
                    <p class="font-bold text-gray-800 text-sm">Pengajuan Draf</p>
                    <p class="text-xs text-gray-500">Oleh: Anda (Konseptor)</p>
                </div>
            </div>
            <div class="flex gap-4 relative pb-8">
                <div class="absolute left-[19px] top-8 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 ${trackingStatus === 'draft' ? 'bg-gray-100 text-gray-400' : trackingStatus === 'revision' ? 'bg-red-100 text-red-600' : trackingStatus === 'signed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'}">
                    <i data-lucide="${trackingStatus === 'revision' ? 'x' : trackingStatus === 'signed' ? 'check-circle' : 'clock'}" size="18"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium mb-0.5">${new Date(currentSubmission.submittedAt || Date.now()).toLocaleDateString('id-ID')} 10:15</p>
                    <p class="font-bold text-gray-800 text-sm">Verifikasi Berjenjang</p>
                    <p class="text-xs text-gray-500">Posisi: Kasubag Umum</p>
                    ${trackingStatus === 'revision' ? '<div class="mt-2 bg-red-50 p-2 rounded text-xs text-red-600 border border-red-100">"Mohon perbaiki lampiran."</div>' : ''}
                </div>
            </div>
            <div class="flex gap-4 relative">
                <div class="relative z-10 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center shadow-sm shrink-0 ${trackingStatus === 'signed' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-300'}">
                    <i data-lucide="pen-tool" size="18"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm mt-2">TTE Kepala Dinas</p>
                    <p class="text-xs text-gray-500">${trackingStatus === 'signed' ? 'Selesai' : 'Menunggu'}</p>
                </div>
            </div>
        `;
    }
    
    lucide.createIcons();
}

// Fungsi untuk render recent activity
function renderRecentActivity() {
    const container = document.getElementById('recent-activity-container');
    if (!container) return;
    
    if (!currentSubmission) {
        container.innerHTML = `<div class="flex flex-col items-center justify-center h-48 text-gray-300"><div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3"><i data-lucide="file-text" size="32" class="opacity-50"></i></div><p>Belum ada pengajuan baru sesi ini.</p></div>`;
    } else {
        const statusColor = currentSubmission.status === 'process' ? 'blue' : currentSubmission.status === 'revision' ? 'red' : 'green';
        const statusLabel = currentSubmission.status === 'process' ? 'Verifikasi' : currentSubmission.status === 'revision' ? 'Revisi' : 'Terbit';
        
        container.innerHTML = `
        <div onclick="navigateTo('tracking')" class="p-6 border-b border-gray-100 hover:bg-gray-50 cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between group transition-colors gap-4">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-[#00A651] group-hover:bg-[#00A651] group-hover:text-white transition-colors shadow-sm shrink-0">
                    <i data-lucide="${currentSubmission.type.icon}" size="28"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-lg group-hover:text-[#00A651] transition-colors line-clamp-1">${currentSubmission.type.name || currentSubmission.type.label}</p>
                    <p class="text-sm text-gray-500 mt-0.5 line-clamp-1">${currentSubmission.perihal || 'Tanpa Perihal'}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded border border-gray-200 font-mono">${currentSubmission.id}</span>
                        <span class="text-xs text-gray-400 flex items-center gap-1"><i data-lucide="clock" size="10"></i> Baru Saja</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4 self-end sm:self-center">
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-${statusColor}-50 text-${statusColor}-600 border border-${statusColor}-100">${statusLabel}</span>
                <i data-lucide="chevron-right" size="20" class="text-gray-300 group-hover:text-[#00A651] group-hover:translate-x-1 transition-all"></i>
            </div>
        </div>`;
    }
    lucide.createIcons();
}