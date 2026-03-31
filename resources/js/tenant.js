if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
document.addEventListener('DOMContentLoaded', function () {
    const localModal = document.getElementById('local-modal');
    const openLocalBtn = document.getElementById('open-local-modal-btn');
    const closeLocalBtn = document.getElementById('close-local-modal-btn');

    openLocalBtn.addEventListener('click', function () {
        localModal.style.display = 'flex';
    });
    closeLocalBtn.addEventListener('click', function () {
        localModal.style.display = 'none';
    });

    const modal = document.getElementById('offer-modal');
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.getElementById('close-modal-btn');

    if (openBtn) openBtn.addEventListener('click', function () {
        modal.style.display = 'flex';
    });
    if (closeBtn) closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    document.getElementById('offer-form').addEventListener('submit', function () {
        this.action = '/tenant/locals/' + document.getElementById('local-select').value + '/offers';
    });

    @if ($errors -> any())
        modal.style.display = 'flex';
    @endif
});

function toggleViewAll() {
    const top = document.getElementById('locals-view-time');
    const all = document.getElementById('locals-view-all');
    const btn = document.getElementById('toggle-view-btn');
    const isShowingAll = !all.classList.contains('hidden');
    top.classList.toggle('hidden', !isShowingAll);
    all.classList.toggle('hidden', isShowingAll);
    btn.textContent = isShowingAll ? 'View All' : 'Show Less';
}