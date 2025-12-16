(() => {
    const dataScript = document.getElementById('swc-data');
    const data = window.SWC_DATA || (dataScript ? JSON.parse(dataScript.textContent) : {});
    if (!data || !data.enabled) {
        return;
    }

    const target = document.getElementById('swc-button');
    if (!target) return;

    const design = data.design || {};
    const label = design.label || 'Chat with us';
    target.classList.add(design.position === 'left' ? 'swc-left' : 'swc-right');
    target.innerHTML = `<div class="swc-bubble" role="button" aria-label="WhatsApp chat"> <span class="swc-dot"></span> <span>${label}</span></div>`;

    const pickAgent = () => {
        const agents = Array.isArray(data.agents) ? data.agents.filter(a => a.active) : [];
        if (agents.length === 0) return { number: data.number, name: '' };
        const selected = agents[Math.floor(Math.random() * agents.length)];
        return { number: selected.number, name: selected.name };
    };

    const buildUrl = (number) => {
        const msg = encodeURIComponent(data.message || '');
        return `https://wa.me/${number}?text=${msg}`;
    };

    const logClick = (agentName) => {
        if (!data.rest || !data.rest.url) return;
        const payload = {
            agent: agentName || '',
            pageId: data.pageId || (window.wp && wp.data && wp.data.select('core/editor') ? wp.data.select('core/editor').getCurrentPostId() : 0),
            pageTitle: document.title,
            pageUrl: window.location.href,
            device: window.matchMedia('(max-width: 768px)').matches ? 'mobile' : 'desktop'
        };
        fetch(data.rest.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': data.rest.nonce || ''
            },
            body: JSON.stringify(payload)
        });
    };

    target.addEventListener('click', () => {
        const agent = pickAgent();
        logClick(agent.name);
        window.location.href = buildUrl(agent.number || data.number);
    });
})();
