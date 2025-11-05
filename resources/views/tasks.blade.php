<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ظ…ظ‡ط§ظ…ظٹ</title>
    <style>
        :root { color-scheme: light dark; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Noto Naskh Arabic", "Noto Sans"; background: #f6f7fb; color: #222; }
        .container { max-width: 860px; margin: 32px auto; padding: 0 16px; }
        h1 { margin: 0 0 16px; font-size: 24px; }
        .grid { display: grid; gap: 16px; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.04); padding: 16px; }
        label { font-size: 13px; color: #555; display:block; margin-bottom: 6px; }
        input, textarea { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; }
        input:focus, textarea:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
        textarea { min-height: 80px; resize: vertical; }
        .row { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        button { padding: 10px 14px; border: 1px solid #2563eb; background: #2563eb; color: #fff; border-radius: 8px; cursor: pointer; font-weight: 600; }
        button.secondary { border-color: #6b7280; background: #6b7280; }
        button.danger { border-color: #b91c1c; background: #b91c1c; }
        button.outline { background: transparent; color: #2563eb; }
        button:disabled { opacity: 0.6; cursor: not-allowed; }
        .status { font-size: 13px; color: #2563eb; }
        .status.error { color: #b91c1c; }
        .empty { padding: 16px; text-align: center; color: #6b7280; }
        ul.tasks { list-style: none; padding: 0; margin: 12px 0 0; }
        .task { display: grid; gap: 8px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; margin-bottom: 10px; background: #fafafa; }
        .task.done { opacity: 0.8; background: #f0fdf4; border-color: #dcfce7; }
        .task .title { font-weight: 700; }
        .task .desc { font-size: 14px; color: #444; white-space: pre-wrap; }
        .meta { display: flex; gap: 8px; align-items: center; }
        .small { font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
<div class="container">
    <h1>ظ…ظ‡ط§ظ…ظٹ</h1>
    <div class="grid">
        <div class="card">
            <h2 style="margin-top:0">ط¥ظ†ط´ط§ط، ط­ط³ط§ط¨</h2>
            <div class="row">
                <div>
                    <label for="reg-email">ط§ظ„ط¨ط±ظٹط¯ ط§ظ„ط¥ظ„ظƒطھط±ظˆظ†ظٹ</label>
                    <input id="reg-email" type="email" placeholder="user@example.com">
                </div>
                <div>
                    <label for="reg-password">ظƒظ„ظ…ط© ط§ظ„ظ…ط±ظˆط±</label>
                    <input id="reg-password" type="password" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢">
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="register-btn">ط¥ظ†ط´ط§ط، ط­ط³ط§ط¨</button>
                <span id="register-msg" class="status"></span>
            </div>
        </div>
        <div class="card">
            <h2 style="margin-top:0">ط§ظ„ط¯ط®ظˆظ„</h2>
            <div class="row">
                <div>
                    <label for="email">ط§ظ„ط¨ط±ظٹط¯ ط§ظ„ط¥ظ„ظƒطھط±ظˆظ†ظٹ</label>
                    <input id="email" type="email" placeholder="you@example.com">
                </div>
                <div>
                    <label for="password">ظƒظ„ظ…ط© ط§ظ„ظ…ط±ظˆط±</label>
                    <input id="password" type="password" placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢">
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="login">طھط³ط¬ظٹظ„ ط§ظ„ط¯ط®ظˆظ„</button>
                <button id="logout" class="secondary" disabled>طھط³ط¬ظٹظ„ ط§ظ„ط®ط±ظˆط¬</button>
                <span id="authStatus" class="status"></span>
            </div>
            <div id="userInfo" class="small" style="margin-top:8px"></div>
        </div>

        <div class="card">
            <h2 style="margin-top:0">ط¥ظ†ط´ط§ط، ظ…ظ‡ظ…ط©</h2>
            <div class="row">
                <div>
                    <label for="newTitle">ط§ظ„ط¹ظ†ظˆط§ظ†</label>
                    <input id="newTitle" type="text" placeholder="ط¹ظ†ظˆط§ظ† ط§ظ„ظ…ظ‡ظ…ط©" />
                </div>
                <div>
                    <label for="newDesc">ط§ظ„ظˆطµظپ</label>
                    <input id="newDesc" type="text" placeholder="ظˆطµظپ ظ…ط®طھطµط± (ط§ط®طھظٹط§ط±ظٹ)" />
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="createTask">ط¥ط¶ط§ظپط© ظ…ظ‡ظ…ط©</button>
                <span id="createStatus" class="status"></span>
            </div>
        </div>

        <div class="card">
            <h2 style="margin-top:0">ظ‚ط§ط¦ظ…ط© ط§ظ„ظ…ظ‡ط§ظ…</h2>
            <div class="actions" style="margin-bottom:8px">
                <button id="refresh" class="outline">طھط­ط¯ظٹط« ط§ظ„ظ‚ط§ط¦ظ…ط©</button>
                <span id="listStatus" class="status"></span>
            </div>
            <ul id="tasks" class="tasks"></ul>
        </div>
    </div>
</div>

<script>
(() => {
    const emailEl = document.getElementById('email');
    const passEl = document.getElementById('password');
    const regEmail = document.getElementById('reg-email');
    const regPass = document.getElementById('reg-password');
    const regBtn = document.getElementById('register-btn');
    const regMsg = document.getElementById('register-msg');
    const loginBtn = document.getElementById('login');
    const logoutBtn = document.getElementById('logout');
    const authStatus = document.getElementById('authStatus');
    const userInfo = document.getElementById('userInfo');

    const createBtn = document.getElementById('createTask');
    const createStatus = document.getElementById('createStatus');
    const newTitle = document.getElementById('newTitle');
    const newDesc = document.getElementById('newDesc');

    const refreshBtn = document.getElementById('refresh');
    const listStatus = document.getElementById('listStatus');
    const tasksEl = document.getElementById('tasks');

    let csrfToken = null;

    function setStatus(el, msg, ok = true) {
        el.textContent = msg || '';
        el.classList.toggle('error', !ok);
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function getCookie(name) {
        return document.cookie
            .split(';')
            .map(c => c.trim())
            .filter(c => c.startsWith(name + '='))
            .map(c => decodeURIComponent(c.split('=')[1]))[0] || null;
    }

    async function ensureCsrf() {
        try {
            await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });
            csrfToken = getCookie('XSRF-TOKEN');
        } catch (e) {
            console.error(e);
        }
    }

    async function login() {
        setStatus(authStatus, 'ط¬ط§ط±ظٹ طھط³ط¬ظٹظ„ ط§ظ„ط¯ط®ظˆظ„...');
        await ensureCsrf();
        try {
            const res = await fetch('/api/session/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin',
                body: JSON.stringify({ email: emailEl.value.trim(), password: passEl.value })
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„ط¯ط®ظˆظ„: ' + res.status + ' ' + text);
            }
            const data = await res.json();
            setStatus(authStatus, 'طھظ… ط§ظ„ط¯ط®ظˆظ„.');
            logoutBtn.disabled = false;
            await loadUser();
            await loadTasks();
        } catch (e) {
            console.error(e);
            setStatus(authStatus, e.message, false);
        }
    }

    async function logout() {
        setStatus(authStatus, 'ط¬ط§ط±ظٹ طھط³ط¬ظٹظ„ ط§ظ„ط®ط±ظˆط¬...');
        await ensureCsrf();
        try {
            const res = await fetch('/api/session/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„ط®ط±ظˆط¬: ' + res.status + ' ' + text);
            }
            setStatus(authStatus, 'طھظ… ط§ظ„ط®ط±ظˆط¬.');
            userInfo.textContent = '';
            logoutBtn.disabled = true;
            tasksEl.innerHTML = '';
        } catch (e) {
            console.error(e);
            setStatus(authStatus, e.message, false);
        }
    }

    async function register() {
        setStatus(regMsg, 'ط¬ط§ط±ظٹ ط¥ظ†ط´ط§ط، ط§ظ„ط­ط³ط§ط¨...');
        await ensureCsrf();
        try {
            const res = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    name: regEmail.value.trim(),
                    email: regEmail.value.trim(),
                    password: regPass.value
                })
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„طھط³ط¬ظٹظ„: ' + res.status + ' ' + text);
            }
            setStatus(regMsg, 'طھظ… ط¥ظ†ط´ط§ط، ط§ظ„ط­ط³ط§ط¨. ظٹظ…ظƒظ†ظƒ طھط³ط¬ظٹظ„ ط§ظ„ط¯ط®ظˆظ„ ط§ظ„ط¢ظ†.');
        } catch (e) {
            console.error(e);
            setStatus(regMsg, e.message, false);
        }
    }

    async function loadUser() {
        try {
            const res = await fetch('/api/session/user', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!res.ok) return;
            const user = await res.json();
            userInfo.textContent = `ظ…ط³ط¬ظ„ ط¨ط§ط³ظ…: ${escapeHtml(user.name || '')} â€” ${escapeHtml(user.email || '')}`;
            logoutBtn.disabled = false;
        } catch (e) { console.error(e); }
    }

    async function loadTasks() {
        setStatus(listStatus, 'ط¬ط§ط±ظچ طھط­ظ…ظٹظ„ ط§ظ„ظ…ظ‡ط§ظ…...');
        tasksEl.innerHTML = '';
        try {
            const res = await fetch('/api/tasks', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„طھط­ظ…ظٹظ„: ' + res.status + ' ' + text);
            }
            const tasks = await res.json();
            if (!Array.isArray(tasks) || tasks.length === 0) {
                tasksEl.innerHTML = '<li class="empty">ظ„ط§ طھظˆط¬ط¯ ظ…ظ‡ط§ظ… ط¨ط¹ط¯</li>';
                setStatus(listStatus, 'طھظ… ط§ظ„طھط­ظ…ظٹظ„.');
                return;
            }
            for (const t of tasks) {
                tasksEl.appendChild(renderTaskItem(t));
            }
            setStatus(listStatus, 'طھظ… ط§ظ„طھط­ظ…ظٹظ„.');
        } catch (e) { console.error(e); setStatus(listStatus, e.message, false); }
    }

    function renderTaskItem(t) {
        const li = document.createElement('li');
        li.className = 'task' + (t.completed ? ' done' : '');
        li.dataset.id = t.id;
        li.innerHTML = `
            <div class="title">${escapeHtml(t.title || '(ط¨ط¯ظˆظ† ط¹ظ†ظˆط§ظ†)')}</div>
            ${t.description ? `<div class="desc">${escapeHtml(t.description)}</div>` : ''}
            <div class="meta small">${t.completed ? 'ظ…ظƒطھظ…ظ„ط©' : 'ط؛ظٹط± ظ…ظƒطھظ…ظ„ط©'}</div>
            <div class="actions">
                <button class="toggle">${t.completed ? 'ط¥ظ„ط؛ط§ط، ط§ظ„ط¥ظƒظ…ط§ظ„' : 'طھط­ط¯ظٹط¯ ظƒظ…ظƒطھظ…ظ„'}</button>
                <button class="edit secondary">طھط¹ط¯ظٹظ„</button>
                <button class="delete danger">ط­ط°ظپ</button>
            </div>
        `;
        li.querySelector('.toggle').addEventListener('click', () => toggleTask(t.id, li));
        li.querySelector('.edit').addEventListener('click', () => showEditForm(t, li));
        li.querySelector('.delete').addEventListener('click', () => deleteTask(t.id, li));
        return li;
    }

    function showEditForm(t, li) {
        const form = document.createElement('div');
        form.className = 'row';
        form.style.marginTop = '8px';
        form.innerHTML = `
            <div>
                <label>ط§ظ„ط¹ظ†ظˆط§ظ†</label>
                <input class="edit-title" type="text" value="${escapeHtml(t.title || '')}">
            </div>
            <div>
                <label>ط§ظ„ظˆطµظپ</label>
                <input class="edit-desc" type="text" value="${escapeHtml(t.description || '')}">
            </div>
            <div class="actions" style="grid-column: 1 / -1; margin-top:8px">
                <button class="save">ط­ظپط¸</button>
                <button class="cancel secondary">ط¥ظ„ط؛ط§ط،</button>
                <span class="status small"></span>
            </div>
        `;
        const statusEl = form.querySelector('.status');
        const saveBtn = form.querySelector('.save');
        const cancelBtn = form.querySelector('.cancel');
        const titleEl = form.querySelector('.edit-title');
        const descEl = form.querySelector('.edit-desc');
        cancelBtn.addEventListener('click', () => form.remove());
        saveBtn.addEventListener('click', async () => {
            setStatus(statusEl, 'ط­ظپط¸ ط§ظ„طھط¹ط¯ظٹظ„ط§طھ...');
            await ensureCsrf();
            try {
                const res = await fetch(`/api/tasks/${encodeURIComponent(t.id)}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': csrfToken || ''
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ title: titleEl.value.trim(), description: descEl.value.trim() })
                });
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error('ظپط´ظ„ ط§ظ„ط­ظپط¸: ' + res.status + ' ' + text);
                }
                const updated = await res.json();
                // طھط­ط¯ظٹط« ط§ظ„ط¹ط±ط¶
                li.querySelector('.title').textContent = updated.title || '';
                const descDiv = li.querySelector('.desc');
                if (updated.description) {
                    if (!descDiv) {
                        const d = document.createElement('div');
                        d.className = 'desc';
                        d.textContent = updated.description;
                        li.insertBefore(d, li.querySelector('.meta'));
                    } else {
                        descDiv.textContent = updated.description;
                    }
                } else if (descDiv) {
                    descDiv.remove();
                }
                setStatus(statusEl, 'طھظ… ط§ظ„ط­ظپط¸.');
                form.remove();
            } catch (e) { console.error(e); setStatus(statusEl, e.message, false); }
        });
        li.appendChild(form);
    }

    async function deleteTask(id, li) {
        await ensureCsrf();
        try {
            const res = await fetch(`/api/tasks/${encodeURIComponent(id)}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': csrfToken || '' },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„ط­ط°ظپ: ' + res.status + ' ' + text);
            }
            li.remove();
        } catch (e) { console.error(e); alert(e.message); }
    }

    async function toggleTask(id, li) {
        await ensureCsrf();
        try {
            const res = await fetch(`/api/tasks/${encodeURIComponent(id)}/toggle`, {
                method: 'PATCH',
                headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': csrfToken || '' },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„طھط¨ط¯ظٹظ„: ' + res.status + ' ' + text);
            }
            const updated = await res.json();
            li.classList.toggle('done', !!updated.completed);
            li.querySelector('.meta').textContent = updated.completed ? 'ظ…ظƒطھظ…ظ„ط©' : 'ط؛ظٹط± ظ…ظƒطھظ…ظ„ط©';
            li.querySelector('.toggle').textContent = updated.completed ? 'ط¥ظ„ط؛ط§ط، ط§ظ„ط¥ظƒظ…ط§ظ„' : 'طھط­ط¯ظٹط¯ ظƒظ…ظƒطھظ…ظ„';
        } catch (e) { console.error(e); alert(e.message); }
    }

    async function createTask() {
        setStatus(createStatus, 'ط¬ط§ط±ظٹ ط§ظ„ط¥ط¶ط§ظپط©...');
        await ensureCsrf();
        try {
            const res = await fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': csrfToken || ''
                },
                credentials: 'same-origin',
                body: JSON.stringify({ title: newTitle.value.trim(), description: newDesc.value.trim() })
            });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('ظپط´ظ„ ط§ظ„ط¥ظ†ط´ط§ط،: ' + res.status + ' ' + text);
            }
            const created = await res.json();
            tasksEl.prepend(renderTaskItem(created));
            newTitle.value = '';
            newDesc.value = '';
            setStatus(createStatus, 'طھظ…طھ ط§ظ„ط¥ط¶ط§ظپط©.');
        } catch (e) { console.error(e); setStatus(createStatus, e.message, false); }
    }

    // Events
    loginBtn.addEventListener('click', login);
    logoutBtn.addEventListener('click', logout);
    refreshBtn.addEventListener('click', loadTasks);
    createBtn.addEventListener('click', createTask);
    regBtn.addEventListener('click', register);

    // Boot
    window.addEventListener('DOMContentLoaded', async () => {
        await loadUser();
        if (userInfo.textContent) {
            await loadTasks();
        }
    });
})();
</script>
</body>
</html>

