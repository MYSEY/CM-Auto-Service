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
        localStorage.setItem(THEME_KEY, theme);
        updateUI(theme, getBlur());
    }

    function applyBlur(enabled) {
        document.body.classList.toggle('pwa-blur', enabled);
        localStorage.setItem(BLUR_KEY, enabled);
        updateUI(getTheme(), enabled);
    }

    function updateUI(theme, blur) {
        // Account page buttons
        var themeBtn = document.getElementById('themeToggle');
        var blurBtn = document.getElementById('blurToggle');
        if (themeBtn) {
            themeBtn.querySelector('.theme-label').textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
            themeBtn.querySelector('.theme-icon').textContent = theme === 'dark' ? '\u2600' : '\u263E';
        }
        if (blurBtn) {
            blurBtn.querySelector('.theme-label').textContent = blur ? 'Blur Off' : 'Blur On';
            blurBtn.querySelector('.blur-dot').style.background = blur ? '#27ae60' : '#7a8299';
        }
        // Floating panel
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

    // Close panel on outside click
    document.addEventListener('click', function(e) {
        var panel = document.getElementById('themePanel');
        var btn = document.getElementById('floatThemeBtn');
        if (panel && !panel.contains(e.target) && btn && !btn.contains(e.target)) {
            panel.classList.remove('show');
        }
    });

    // Apply on load
    applyTheme(getTheme());
    applyBlur(getBlur());
})();
