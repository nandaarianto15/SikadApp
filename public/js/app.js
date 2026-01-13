// ==============================
// NAVBAR SCROLL EFFECT (ASLI – JANGAN DIUBAH)
// ==============================
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
        
        if (logoBox) {
            logoBox.classList.remove('bg-white', 'text-[#00A651]');
            logoBox.classList.add('bg-[#00A651]', 'text-white');
        }
        
        if (textBox) {
            textBox.classList.remove('text-white');
            textBox.classList.add('text-[#1F2937]');
        }
        
        if (subText) {
            subText.classList.remove('text-white');
            subText.classList.add('text-[#00A651]');
        }

        if (loginBtn) {
            loginBtn.classList.remove('bg-white', 'text-[#00A651]');
            loginBtn.classList.add('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');
        }

        if (menuBtn) {
            menuBtn.classList.remove('text-white', 'hover:bg-white/10');
            menuBtn.classList.add('text-gray-800', 'hover:bg-gray-100');
        }

        links.forEach(l => {
            l.classList.remove('text-white/90');
            l.classList.add('text-gray-600');
        });
    } else {
        nav.classList.remove('bg-white', 'shadow-md', 'py-3');
        nav.classList.add('bg-transparent', 'py-4', 'lg:py-6');

        if (logoBox) {
            logoBox.classList.add('bg-white', 'text-[#00A651]');
            logoBox.classList.remove('bg-[#00A651]', 'text-white');
        }

        if (textBox) {
            textBox.classList.add('text-white');
            textBox.classList.remove('text-[#1F2937]');
        }

        if (subText) {
            subText.classList.add('text-white');
            subText.classList.remove('text-[#00A651]');
        }

        if (loginBtn) {
            loginBtn.classList.add('bg-white', 'text-[#00A651]');
            loginBtn.classList.remove('bg-[#00A651]', 'text-white', 'hover:bg-emerald-700');
        }

        if (menuBtn) {
            menuBtn.classList.add('text-white', 'hover:bg-white/10');
            menuBtn.classList.remove('text-gray-800', 'hover:bg-gray-100');
        }

        links.forEach(l => {
            l.classList.add('text-white/90');
            l.classList.remove('text-gray-600');
        });
    }
});

// ==============================
// GLOBAL STATE (DB)
// ==============================
let NEWS_DATA = [];
let SERVICES_DATA = [];

// ==============================
// INIT
// ==============================
document.addEventListener('DOMContentLoaded', async () => {
    lucide.createIcons();
    await loadLandingData();
});

// ==============================
// FETCH LANDING DATA
// ==============================
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

// ==============================
// SMOOTH SCROLL
// ==============================
function scrollToId(id) {
    const el = document.getElementById(id);
    if (el) el.scrollIntoView({ behavior: 'smooth' });
}

// ==============================
// NEWS / ARTICLES
// ==============================
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

// ==============================
// SERVICES
// ==============================
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

// ==============================
// SERVICE MODAL
// ==============================
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
