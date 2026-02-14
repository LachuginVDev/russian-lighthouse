const STORAGE_KEY = 'theme';

function init(): void {
    const v = localStorage.getItem(STORAGE_KEY);
    const theme = v === 'dark' || v === 'light' ? v : 'light';
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

init();
