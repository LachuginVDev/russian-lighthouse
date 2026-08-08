export function formatNumber(value) {
  return new Intl.NumberFormat('ru-RU').format(Math.round(value));
}

export function formatTime(seconds) {
  const total = Number.isFinite(seconds) ? Math.max(0, seconds) : 0;
  const minutes = Math.floor(total / 60);
  const secs = Math.floor(total % 60);
  return `${minutes}:${String(secs).padStart(2, '0')}`;
}
