import { ref, watch } from 'vue';

const STORAGE_KEY = 'theme';
type Theme = 'light' | 'dark';

function getStored(): Theme {
    if (typeof document === 'undefined') return 'light';
    const v = localStorage.getItem(STORAGE_KEY);
    return (v === 'dark' || v === 'light') ? v : 'light';
}

function apply(theme: Theme): void {
    if (typeof document === 'undefined') return;
    const root = document.documentElement;
    if (theme === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }
}

const theme = ref<Theme>(getStored());

export function useTheme() {
    const current = theme;

    function setTheme(value: Theme): void {
        theme.value = value;
        localStorage.setItem(STORAGE_KEY, value);
        apply(value);
    }

    function toggle(): void {
        setTheme(theme.value === 'dark' ? 'light' : 'dark');
    }

    return { theme: current, setTheme, toggle };
}

// При первой загрузке применить сохранённую тему
apply(getStored());

watch(theme, apply);
