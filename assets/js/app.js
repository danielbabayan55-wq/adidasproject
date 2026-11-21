// "Add to cart" без перезагрузки страницы (fetch -> api/cart.php)
const toast = document.getElementById('toast');
let toastTimer;

function showToast(text) {
  toast.textContent = text;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
}

document.addEventListener('click', async (ev) => {
  const btn = ev.target.closest('.add-to-cart');
  if (!btn) return;

  btn.disabled = true;
  try {
    const res = await fetch('api/cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ id: btn.dataset.id })
    });
    const data = await res.json();
    if (!data.ok) throw new Error(data.error || 'Error');
    document.getElementById('cart-count').textContent = data.count;
    showToast('Added to cart');
  } catch (err) {
    showToast('Could not add to cart. Try again.');
  } finally {
    btn.disabled = false;
  }
});
