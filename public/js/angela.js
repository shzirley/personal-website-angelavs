(() => {
    const root = document.documentElement;
    const reduced = matchMedia('(prefers-reduced-motion: reduce)');
    const toggle = document.querySelector('[data-motion-toggle]');
    const progress = document.querySelector('.scroll-progress');
    const animations = new Set();
    const seen = new WeakSet();
    let observer;
    let preference = 'on';
    let enabled = true;
    let queued = false;
    let themeTimer;
    try { preference = localStorage.getItem('angelaos-motion') || 'on'; } catch { /* Optional. */ }

    const themeToggle = document.querySelector('[data-theme-toggle]');
    const themeBoot = document.querySelector('[data-theme-boot]');
    const themeColor = document.querySelector('[data-theme-color]');
    const updateThemeControl = () => {
        const terminal = root.dataset.theme === 'terminal';
        if (themeToggle) {
            themeToggle.setAttribute('aria-pressed', String(terminal));
            themeToggle.setAttribute('aria-label', terminal ? 'Switch to pink desktop' : 'Switch to midnight terminal');
            themeToggle.querySelector('[data-theme-icon]').textContent = terminal ? '☼' : '>_';
            themeToggle.querySelector('[data-theme-label]').textContent = terminal ? 'Pink mode' : 'Midnight';
        }
        if (themeColor) themeColor.content = terminal ? '#09050f' : '#f6b8cf';
    };
    const applyTheme = (theme, announce = false) => {
        if (theme === 'terminal') root.dataset.theme = 'terminal';
        else delete root.dataset.theme;
        try { localStorage.setItem('angelaos-theme', theme); } catch { /* Optional. */ }
        updateThemeControl();
        if (!announce || !themeBoot) return;
        window.clearTimeout(themeTimer);
        themeBoot.hidden = false;
        themeBoot.querySelector('[data-theme-boot-status]').textContent = theme === 'terminal' ? '> midnight mode ready_' : '> pink desktop restored_';
        requestAnimationFrame(() => themeBoot.classList.add('is-visible'));
        themeTimer = window.setTimeout(() => {
            themeBoot.classList.remove('is-visible');
            window.setTimeout(() => { themeBoot.hidden = true; }, enabled ? 260 : 0);
        }, enabled ? 1050 : 350);
    };
    updateThemeControl();
    themeToggle?.addEventListener('click', () => applyTheme(root.dataset.theme === 'terminal' ? 'pink' : 'terminal', true));

    const animate = (element, keyframes, options = {}) => {
        if (!enabled || !element?.animate) return null;
        const animation = element.animate(keyframes, { duration: 560, easing: 'cubic-bezier(.2,.7,.2,1)', ...options });
        animations.add(animation);
        const clean = () => animations.delete(animation);
        animation.onfinish = clean;
        animation.oncancel = clean;
        return animation;
    };
    const reveal = (element, delay = 0) => animate(element, [
        { opacity: 0, transform: 'translateY(22px)' },
        { opacity: 1, transform: 'translateY(0)' },
    ], { delay, fill: 'backwards' });
    const updateProgress = () => {
        queued = false;
        const height = root.scrollHeight - innerHeight;
        if (progress) progress.style.transform = `scaleX(${height > 0 ? Math.min(1, Math.max(0, scrollY / height)) : 0})`;
        if (enabled) document.querySelectorAll('.float-bubble').forEach((bubble, index) => {
            bubble.style.setProperty('--drift-y', `${Math.sin(scrollY / 180 + index) * 12}px`);
        });
    };
    const configure = () => {
        enabled = preference !== 'off' && !reduced.matches;
        root.classList.toggle('motion-off', !enabled);
        if (toggle) {
            toggle.hidden = false;
            toggle.disabled = reduced.matches;
            toggle.textContent = reduced.matches ? 'Reduced motion' : `Motion: ${enabled ? 'on' : 'off'}`;
            toggle.setAttribute('aria-pressed', String(enabled));
        }
        observer?.disconnect();
        if (!enabled) { animations.forEach(animation => animation.cancel()); return; }
        observer = new IntersectionObserver(entries => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting && !seen.has(entry.target)) {
                    seen.add(entry.target);
                    reveal(entry.target, (index % 3) * 70);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: .08 });
        document.querySelectorAll('.reveal').forEach(element => observer.observe(element));
    };

    toggle?.addEventListener('click', () => {
        preference = enabled ? 'off' : 'on';
        try { localStorage.setItem('angelaos-motion', preference); } catch { /* Optional. */ }
        configure();
    });
    reduced.addEventListener('change', configure);
    configure();
    document.querySelectorAll('.hero-copy > *, .page-heading > *, [data-result]').forEach((element, index) => reveal(element, index * 65));
    window.addEventListener('scroll', () => { if (!queued) { queued = true; requestAnimationFrame(updateProgress); } }, { passive: true });
    window.addEventListener('resize', updateProgress);
    updateProgress();

    document.querySelectorAll('[data-typewriter]').forEach(element => {
        const text = element.dataset.typewriter;
        if (!enabled || !text) return;
        element.textContent = '';
        let index = 0;
        const type = () => {
            element.textContent = text.slice(0, index++);
            if (index <= text.length) setTimeout(type, 78 + Math.random() * 55);
            else setTimeout(() => { element.classList.add('typing-done'); }, 350);
        };
        setTimeout(type, 550);
    });

    document.querySelectorAll('[data-flip-trigger]').forEach(button => button.addEventListener('click', () => {
        const scene = button.closest('[data-flip-card]');
        const flipped = scene.classList.toggle('is-flipped');
        scene.querySelector('.flip-front').setAttribute('aria-hidden', String(flipped));
        scene.querySelector('.flip-back').setAttribute('aria-hidden', String(!flipped));
    }));
    document.querySelectorAll('[data-window-minimize]').forEach(button => button.addEventListener('click', () => {
        const windowElement = button.closest('.window');
        windowElement.classList.toggle('is-minimized');
        button.setAttribute('aria-label', windowElement.classList.contains('is-minimized') ? 'Restore window' : 'Minimize window');
    }));
    document.querySelectorAll('[data-window-maximize]').forEach(button => button.addEventListener('click', () => {
        button.closest('.window').classList.toggle('is-maximized');
    }));
    document.querySelectorAll('[data-window-close]').forEach(button => button.addEventListener('click', () => {
        const windowElement = button.closest('[data-closable-window]');
        animate(windowElement, [{ opacity: 1, transform: 'scale(1)' }, { opacity: 0, transform: 'scale(.92) translateY(14px)' }], { duration: 260 })?.finished.then(() => {
            windowElement.hidden = true;
            document.querySelector('[data-window-closed-message]')?.removeAttribute('hidden');
        });
        if (!enabled) { windowElement.hidden = true; document.querySelector('[data-window-closed-message]')?.removeAttribute('hidden'); }
    }));
    document.querySelector('[data-window-restore]')?.addEventListener('click', () => {
        const windowElement = document.querySelector('[data-closable-window]');
        windowElement.hidden = false;
        document.querySelector('[data-window-closed-message]').hidden = true;
        animate(windowElement, [{ opacity: 0, transform: 'translateY(14px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 300 });
    });

    const cat = document.querySelector('[data-pixel-cat]');
    const speech = document.querySelector('[data-cat-speech]');
    const catLines = ['mrrp! ♡', 'compile successful!', 'tiny paws, big plans.', 'you found the secret cat!', 'more playlists, please.'];
    let catLine = 0;
    cat?.addEventListener('click', () => {
        cat.classList.add('is-petted');
        speech.textContent = catLines[catLine++ % catLines.length];
        speech.classList.add('is-talking');
        animate(cat.querySelector('img'), [{ transform: 'translateY(0) rotate(0)' }, { transform: 'translateY(-12px) rotate(-4deg)' }, { transform: 'translateY(0) rotate(0)' }], { duration: 380 });
        setTimeout(() => {
            speech.classList.remove('is-talking');
            cat.classList.remove('is-petted');
        }, 1700);
    });

    const balloons = [...document.querySelectorAll('[data-pop-balloon]')];
    const balloonCount = document.querySelector('[data-bubble-count]');
    const balloonMessage = document.querySelector('[data-bubble-message]');
    const balloonReset = document.querySelector('[data-bubble-reset]');
    const popMessages = ['nice catch! ♡', 'tiny joy collected.', 'pop! one less bug.', 'the cat approves.', 'sparkles successfully compiled.', 'almost a tiny party.'];
    let poppedBalloons = 0;
    const resetBalloons = () => {
        poppedBalloons = 0;
        balloons.forEach(balloon => {
            balloon.disabled = false;
            balloon.classList.remove('is-popped');
        });
        if (balloonCount) balloonCount.textContent = '0';
        if (balloonMessage) balloonMessage.textContent = 'Choose a balloon to begin.';
        if (balloonReset) balloonReset.hidden = true;
    };
    balloons.forEach((balloon, index) => balloon.addEventListener('click', () => {
        if (balloon.classList.contains('is-popped')) return;
        balloon.classList.add('is-popped');
        balloon.disabled = true;
        poppedBalloons += 1;
        if (balloonCount) balloonCount.textContent = String(poppedBalloons);
        const complete = poppedBalloons === balloons.length;
        if (balloonMessage) balloonMessage.textContent = complete ? 'Secret unlocked: joy.exe completed! ✦' : popMessages[index % popMessages.length];
        if (complete && balloonReset) balloonReset.hidden = false;
        if (complete && cat) {
            cat.classList.add('cat-celebrate');
            if (speech) {
                speech.textContent = 'achievement unlocked! ✦';
                speech.classList.add('is-talking');
            }
            window.setTimeout(() => {
                cat.classList.remove('cat-celebrate');
                speech?.classList.remove('is-talking');
            }, 1900);
        }
    }));
    balloonReset?.addEventListener('click', resetBalloons);

    const musicToggle = document.querySelector('[data-music-toggle]');
    const setMusicPlaying = (playing) => {
        if (!musicToggle) return;
        const player = musicToggle.closest('[data-music-player]');
        const embed = player.querySelector('[data-music-embed]');
        const iframe = embed.querySelector('iframe');
        player.classList.toggle('is-playing', playing);
        player.closest('.music-section')?.classList.toggle('is-playing', playing);
        embed.hidden = !playing;
        musicToggle.setAttribute('aria-expanded', String(playing));
        player.querySelector('[data-music-icon]').textContent = playing ? '■' : '▶';
        player.querySelector('[data-music-label]').textContent = playing ? 'Stop' : 'Play';
        const playerStatus = document.querySelector('[data-player-status]');
        if (playerStatus) playerStatus.textContent = playing ? 'NOW PLAYING' : 'CURRENT FAVOURITE';
        iframe.src = playing ? iframe.dataset.src : '';
    };
    musicToggle?.addEventListener('click', () => setMusicPlaying(!musicToggle.closest('[data-music-player]').classList.contains('is-playing')));
    document.querySelector('[data-music-close]')?.addEventListener('click', () => setMusicPlaying(false));

    const printButton = document.querySelector('[data-print]');
    if (printButton) { printButton.hidden = false; printButton.addEventListener('click', () => window.print()); }
})();
