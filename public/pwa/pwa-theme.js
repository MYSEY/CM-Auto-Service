(function() {
    'use strict';

    var THEME_KEY = 'pwa_theme';
    var BLUR_KEY = 'pwa_blur';

    function getTheme() {
        return localStorage.getItem(THEME_KEY) || 'light';
    }

    function getBlur() {
        return localStorage.getItem(BLUR_KEY) === 'true';
    }

    function applyTheme(theme) {
        document.body.classList.remove('pwa-light', 'pwa-dark');
        document.body.classList.add('pwa-' + theme);

        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        localStorage.setItem(THEME_KEY, theme);
        updateUI(theme, getBlur());
    }

    function applyBlur(enabled) {
        document.body.classList.toggle('pwa-blur', enabled);
        localStorage.setItem(BLUR_KEY, enabled);
        updateUI(getTheme(), enabled);
    }

    function updateUI(theme, blur) {
        var themeBtn = document.getElementById('themeToggle');
        var blurBtn = document.getElementById('blurToggle');
        if (themeBtn) {
            var label = themeBtn.querySelector('.theme-label');
            var icon = themeBtn.querySelector('.theme-icon');
            if (label) label.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
            if (icon) icon.textContent = theme === 'dark' ? '\u2600' : '\u263E';
        }
        if (blurBtn) {
            var bLabel = blurBtn.querySelector('.theme-label');
            var dot = blurBtn.querySelector('.blur-dot');
            if (bLabel) bLabel.textContent = blur ? 'Blur Off' : 'Blur On';
            if (dot) dot.style.background = blur ? '#27ae60' : '#7a8299';
        }
        var panelIcon = document.getElementById('panelThemeIcon');
        var panelLabel = document.getElementById('panelThemeLabel');
        var panelBlurLabel = document.getElementById('panelBlurLabel');
        if (panelIcon) panelIcon.textContent = theme === 'dark' ? '\u2600' : '\u263E';
        if (panelLabel) panelLabel.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
        if (panelBlurLabel) panelBlurLabel.textContent = blur ? 'Blur Off' : 'Blur On';
    }

    window.pwaToggleTheme = function() {
        var current = getTheme();
        applyTheme(current === 'dark' ? 'light' : 'dark');
    };

    window.pwaToggleBlur = function() {
        applyBlur(!getBlur());
    };

    window.pwaTogglePanel = function() {
        var panel = document.getElementById('themePanel');
        if (panel) panel.classList.toggle('show');
    };

    document.addEventListener('click', function(e) {
        var panel = document.getElementById('themePanel');
        var btn = document.getElementById('floatThemeBtn');
        if (panel && !panel.contains(e.target) && btn && !btn.contains(e.target)) {
            panel.classList.remove('show');
        }
    });

    applyTheme(getTheme());
    applyBlur(getBlur());
})();
