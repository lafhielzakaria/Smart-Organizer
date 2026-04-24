let selPts = 0,
    selPrice = 0;

window.selectPack = function(el, pts, price, name, ptsLabel) {
    document.querySelectorAll('.pack').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    selPts = pts;
    selPrice = price;

    document.getElementById('sumPack').textContent = name + ' Pack';
    document.getElementById('sumPack').style.color = '#fff';
    document.getElementById('sumPts').textContent = ptsLabel + ' PTS';
    document.getElementById('sumPrice').textContent = '$' + price.toFixed(2);
    document.getElementById('fPts').value = pts;
    document.getElementById('fPrice').value = price;
    document.getElementById('fLabel').value = name;

    document.getElementById('buyBtn').disabled = false;
    showToast(name + ' Pack selected');
};

window.selectMethod = function(el) {
    document.querySelectorAll('.method').forEach(m => m.classList.remove('sel'));
    el.classList.add('sel');
};

window.checkPack = function(e) {
    e.preventDefault();
    if (!selPts) {
        showToast('Select a pack first');
        return false;
    }
    const btn = document.getElementById('buyBtn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Processing...';
    
    $.ajax({
        url: window.purchaseRoute,
        type: 'POST',
        data: {
            pack_points: selPts,
            pack_price: selPrice,
            pack_label: document.getElementById('fLabel').value,
            _token: window.csrfToken
        },
        success: function(response) {
            showToast('Purchase successful! Balance updated.');
            setTimeout(() => {
                window.location.href = window.dashboardRoute;
            }, 1500);
        },
        error: function(xhr) {
            showToast('Purchase failed. Please try again.');
            btn.disabled = false;
            btn.textContent = originalText;
        }
    });
    return false;
};

function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 2800);
}
