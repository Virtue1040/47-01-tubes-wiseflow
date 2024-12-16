const html = $('html');

const applySystemMode = () => {
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.addClass('dark');
    } else {
        html.removeClass('dark');
    }
};

const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
    html.addClass('dark');
} else if (savedTheme === 'light') {
    html.removeClass('dark');
} else {
    applySystemMode();
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applySystemMode);