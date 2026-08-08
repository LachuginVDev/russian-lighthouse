export function initLoadMore() {
  document.querySelectorAll('[data-load-more]').forEach((button) => {
    const container = document.querySelector(button.dataset.target);
    if (!container) return;

    const step = Number(button.dataset.step) || 6;
    const items = Array.from(container.children);
    let visibleCount = Number(button.dataset.visible) || step;

    const render = () => {
      items.forEach((item, index) => {
        item.style.display = index < visibleCount ? '' : 'none';
      });
      button.hidden = visibleCount >= items.length;
    };

    button.addEventListener('click', () => {
      visibleCount += step;
      render();
    });

    render();
  });
}
