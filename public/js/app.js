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

        // logoBox?.classList.replace('bg-white', 'bg-[#00A651]');
        // logoBox?.classList.replace('text-[#00A651]', 'text-white');

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

        // logoBox?.classList.add('bg-white', 'text-[#00A651]');
        // logoBox?.classList.remove('bg-[#00A651]', 'text-white');

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
let uploadedFiles = {};

document.addEventListener('DOMContentLoaded', async () => {
    lucide.createIcons();
    await loadLandingData();
    
    if (document.getElementById('select-type-grid')) {
        await loadSelectData();
        renderSelectGrid();
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

function handleFileUpload(event, requirementId) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById(`preview-${requirementId}`);
    
    if (file) {
        uploadedFiles[requirementId] = file;
        
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        previewDiv.innerHTML = `<span class="text-green-600 font-medium">${file.name}</span> (${fileSize} MB)`;
    } else {
        delete uploadedFiles[requirementId];
        previewDiv.innerHTML = '';
    }
}

function submitLandingForm() {
    const form = document.getElementById('submission-form');
    const formData = new FormData(form);

    for (const id in uploadedFiles) {
        formData.append(`documents[${id}]`, uploadedFiles[id]);
    }

    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i data-lucide="loader-2" class="animate-spin" size="18"></i> Mengajukan...';

    fetch('/pemohon/submissions', {
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
    navigateTo('/logout');
}

function navigateToNews() {
    window.location.href = '/news';
}

// Perbarui fungsi renderArticles untuk menambahkan link ke detail
function renderArticles() {
    const container = document.getElementById('articles-container');
    if (!container) return;

    container.innerHTML = NEWS_DATA.map((a, i) => {
        const isLatest = i === 0;
        const imageUrl = a.image.startsWith('http') ? a.image : '/storage/' + a.image;
        const formattedDate = a.date ? a.date : 'Tanggal tidak tersedia';

        return `
        <a href="/news/${a.slug}" class="group min-w-[280px] max-w-[280px] rounded-2xl overflow-hidden shadow-lg transition-all duration-500 border snap-center flex flex-col cursor-pointer relative h-[380px] hover:-translate-y-2 hover:shadow-2xl ${isLatest ? 'bg-gradient-to-br from-yellow-50 to-orange-50 border-yellow-200 ring-1 ring-yellow-400/40' : 'bg-white border-gray-100 hover:border-emerald-200'}" style="animation: slideUp 0.5s forwards ${i * 100}ms; opacity: 0;">
            <div class="relative h-40 overflow-hidden shrink-0 bg-gray-200">
                ${a.image ? 
                    `<img src="${imageUrl}" alt="${a.title}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />` :
                    `<div class="image-container w-full h-full bg-gray-300 flex items-center justify-center">
                        <i data-lucide="image" size="24" class="text-gray-400"></i>
                    </div>`
                }
                <span class="absolute top-3 left-3 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm z-10 backdrop-blur-sm ${isLatest ? 'bg-[#F59E0B]/90' : 'bg-[#00A651]/90'}">${a.category ?? 'Info'}</span>
            </div>
            <div class="p-5 flex flex-col flex-1 relative">
                <div class="flex items-center gap-2 text-[10px] text-gray-500 mb-2 font-medium">
                    <span class="flex items-center gap-1"><i data-lucide="calendar" size="12" class="${isLatest ? "text-orange-600" : "text-[#00A651]"}"></i> ${formattedDate}</span>
                    ${isLatest ? '<span class="flex items-center gap-1 text-orange-700 bg-orange-100 px-1.5 py-0.5 rounded text-[8px] font-bold animate-pulse border border-orange-200 ml-auto shadow-sm"><i data-lucide="zap" size="8"></i> TERBARU</span>' : ''}
                </div>
                <h3 class="text-sm font-bold mb-2 leading-snug transition-colors line-clamp-2 ${isLatest ? 'text-gray-900 group-hover:text-orange-600' : 'text-gray-800 group-hover:text-[#00A651]'}">${a.title}</h3>
                <p class="text-gray-600 text-[11px] leading-relaxed mb-auto line-clamp-3">${a.desc}</p>
                <div class="pt-4 mt-2 border-t flex items-center font-bold text-[10px] text-[#00A651] group/btn">
                    Selengkapnya <i data-lucide="arrow-right" size="12" class="ml-1 transition-transform group-hover/btn:translate-x-1"></i>
                </div>
            </div>
        </a>`;
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
    const container = document.getElementById('select-type-grid');
    if (!container) return;

    container.innerHTML = SERVICES_DATA.map((service) => {
        return `
        <a href="/pemohon/wizard?service=${service.slug}" class="group bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center cursor-pointer">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 text-emerald-600">
                <i data-lucide="${service.icon}" size="32"></i>
            </div>
            <h4 class="font-bold text-lg text-gray-800 mb-2">${service.name}</h4>
            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">${service.desc}</p>
            <span class="mt-4 text-xs font-bold text-[#00A651] flex items-center gap-1">
                Ajukan <i data-lucide="arrow-right" size="12"></i>
            </span>
        </a>`;
    }).join('');

    lucide.createIcons();
}

function openServiceModal(id) {
    const service = SERVICES_DATA.find(s => s.id === id);
    const modal = document.getElementById('service-modal');
    if (!service || !modal) return;

    modal.innerHTML = `
    <div class="bg-white max-w-lg w-full rounded-2xl shadow-xl animate-slide-up">
        <div class="bg-[#00A651] p-6 text-white relative rounded-t-2xl">
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

function closeDocumentModal() {
    const modal = document.getElementById('document-viewer-modal');
    const frame = document.getElementById('document-frame');

    if (!modal || !frame) return;
    
    modal.classList.add('hidden');
    frame.src = 'about:blank';
    frame.style.display = 'none';
}