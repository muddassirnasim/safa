document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.swc-tab');
    const panels = document.querySelectorAll('.swc-panel');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const target = document.getElementById(tab.dataset.target);
            if (target) {
                target.classList.add('active');
            }
        });
    });

    const numberInput = document.getElementById('swc-number');
    const messageInput = document.getElementById('swc-message');
    const enabledToggle = document.getElementById('swc-enabled');
    const statusBox = document.querySelector('.swc-status');
    const saveButton = document.querySelector('.swc-save');
    const colorInput = document.getElementById('swc-color');
    const textColorInput = document.getElementById('swc-text-color');
    const labelInput = document.getElementById('swc-label');
    const desktopMargin = document.getElementById('swc-desktop-margin');
    const mobileMargin = document.getElementById('swc-mobile-margin');
    const positionSelect = document.getElementById('swc-position');
    const showMobile = document.getElementById('swc-show-mobile');
    const showDesktop = document.getElementById('swc-show-desktop');
    const agentsWrapper = document.getElementById('swc-agents-list');

    const preloadAgents = () => {
        if (!agentsWrapper || !window.SWC_ADMIN) return;
        agentsWrapper.innerHTML = '';
        window.SWC_ADMIN.agents.forEach((agent, index) => renderAgent(agent, index));
    };

    const renderAgent = (agent = {}, index = Date.now()) => {
        const div = document.createElement('div');
        div.className = 'swc-agent';
        div.dataset.index = index;
        div.innerHTML = `
            <div class="swc-inline">
                <label>${wp.i18n.__('Name', 'smart-whatsapp-chat')}</label>
                <input type="text" value="${agent.name || ''}" class="swc-agent-name" />
            </div>
            <div class="swc-inline">
                <label>${wp.i18n.__('Role', 'smart-whatsapp-chat')}</label>
                <input type="text" value="${agent.role || ''}" class="swc-agent-role" />
            </div>
            <div class="swc-inline">
                <label>${wp.i18n.__('Number', 'smart-whatsapp-chat')}</label>
                <input type="tel" value="${agent.number || ''}" class="swc-agent-number" />
            </div>
            <label class="swc-toggle"><input type="checkbox" class="swc-agent-active" ${agent.active ? 'checked' : ''}/> ${wp.i18n.__('Active', 'smart-whatsapp-chat')}</label>
            <button class="button-link swc-remove-agent">${wp.i18n.__('Remove', 'smart-whatsapp-chat')}</button>
        `;
        agentsWrapper.appendChild(div);
        div.querySelector('.swc-remove-agent').addEventListener('click', () => div.remove());
    };

    const addAgentBtn = document.querySelector('.swc-add-agent');
    if (addAgentBtn && agentsWrapper) {
        addAgentBtn.addEventListener('click', () => renderAgent());
        preloadAgents();
    }

    const validateNumber = (value) => value.replace(/\D+/g, '');

    if (numberInput) {
        numberInput.addEventListener('input', () => {
            numberInput.value = validateNumber(numberInput.value);
        });
    }

    const getAgentsData = () => {
        if (!agentsWrapper) return [];
        return Array.from(agentsWrapper.querySelectorAll('.swc-agent')).map(row => ({
            name: row.querySelector('.swc-agent-name').value.trim(),
            role: row.querySelector('.swc-agent-role').value.trim(),
            number: validateNumber(row.querySelector('.swc-agent-number').value),
            active: row.querySelector('.swc-agent-active').checked,
        })).filter(a => a.name && a.number && a.active);
    };

    const save = () => {
        if (!saveButton) return;
        const payload = {
            number: validateNumber(numberInput ? numberInput.value : ''),
            message: messageInput ? messageInput.value : '',
            enabled: enabledToggle ? enabledToggle.checked : false,
            design: {
                color: colorInput ? colorInput.value : '#25D366',
                text_color: textColorInput ? textColorInput.value : '#ffffff',
                label: labelInput ? labelInput.value : 'Chat with us',
                desktop_margin: desktopMargin ? parseInt(desktopMargin.value, 10) || 0 : 20,
                mobile_margin: mobileMargin ? parseInt(mobileMargin.value, 10) || 0 : 15,
                position: positionSelect ? positionSelect.value : 'right'
            },
            triggers: {
                show_on_mobile: showMobile ? showMobile.checked : true,
                show_on_desktop: showDesktop ? showDesktop.checked : true
            },
            agents: getAgentsData()
        };
        saveButton.disabled = true;
        statusBox.textContent = wp.i18n.__('Saving...', 'smart-whatsapp-chat');
        fetch(SWC_ADMIN.rest.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': SWC_ADMIN.rest.nonce
            },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(res => {
                statusBox.textContent = res.message || '';
            })
            .catch(() => {
                statusBox.textContent = wp.i18n.__('Error saving settings', 'smart-whatsapp-chat');
            })
            .finally(() => {
                saveButton.disabled = false;
            });
    };

    if (saveButton) {
        saveButton.addEventListener('click', save);
    }

    const analyticsBtn = document.querySelector('.swc-refresh-analytics');
    if (analyticsBtn) {
        analyticsBtn.addEventListener('click', () => {
            const start = document.getElementById('swc-date-start').value;
            const end = document.getElementById('swc-date-end').value;
            fetch(`${SWC_ADMIN.rest.url.replace('settings', 'analytics')}?start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}`, {
                headers: { 'X-WP-Nonce': SWC_ADMIN.rest.nonce }
            })
                .then(res => res.json())
                .then(rows => {
                    const tbody = document.getElementById('swc-analytics-rows');
                    if (!tbody) return;
                    tbody.innerHTML = '';
                    rows.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td>${row.agent || wp.i18n.__('Default', 'smart-whatsapp-chat')}</td><td>${row.page_title}</td><td>${row.device}</td><td>${row.created_at}</td>`;
                        tbody.appendChild(tr);
                    });
                });
        });
    }
});
