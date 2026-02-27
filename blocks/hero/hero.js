
(function () {
        function init() {
            const el = document.querySelector('.left.hero--gap');
            if (!el) return;

            const apply = (h) => {
                el.classList.toggle('is-tall', h > 332);
            };

            if (!('ResizeObserver' in window)) {
                apply(el.offsetHeight);
                return;
            }

            const ro = new ResizeObserver(entries => {
                apply(entries[0].contentRect.height);
            });
            ro.observe(el);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
