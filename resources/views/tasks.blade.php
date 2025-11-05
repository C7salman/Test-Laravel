<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To Do List</title>
    <style>
        :root { color-scheme: light dark; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Noto Naskh Arabic", "Noto Sans"; background: #f6f7fb; color: #222; }
        .container { max-width: 860px; margin: 32px auto; padding: 0 16px; }
        h1 { margin: 0 0 16px; font-size: 24px; }
        .grid { display: grid; gap: 16px; grid-template-columns: 1fr; }
        @media (min-width: 768px) { .grid { grid-template-columns: 1fr 1fr; align-items: start; } #welcomeCard { grid-column: 1 / -1; } }
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
    <h1>To Do List</h1>
    <div class="grid">
        <div class="card" id="registerCard">
            <h2 style="margin-top:0">إنشاء حساب</h2>
            <div class="row">
                <div>
                    <label for="reg-email">البريد الإلكتروني</label>
                    <input id="reg-email" type="email" placeholder="user@example.com">
                </div>
                <div>
                    <label for="reg-password">كلمة المرور</label>
                    <input id="reg-password" type="password" placeholder="••••••••">
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="register-btn">إنشاء حساب</button>
                <span id="register-msg" class="status"></span>
            </div>
        </div>
        <div class="card" id="loginCard">
            <h2 style="margin-top:0">تسجيل الدخول</h2>
            <div class="row">
                <div>
                    <label for="email">البريد الإلكتروني</label>
                    <input id="email" type="email" placeholder="you@example.com">
                </div>
                <div>
                    <label for="password">كلمة المرور</label>
                    <input id="password" type="password" placeholder="••••••••">
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="login">تسجيل الدخول</button>
                <button id="logout" class="secondary" disabled>تسجيل الخروج</button>    
                <span id="authStatus" class="status"></span>
            </div>
            <div id="userInfo" class="small" style="margin-top:8px"></div>
        </div>

        <!-- بطاقة ترحيب بعد تسجيل الدخول -->
        <div class="card" id="welcomeCard" hidden>
            <h2 style="margin-top:0">مرحبًا</h2>
            <div id="welcomeText" class="small" style="margin-top:8px"></div>
            <div class="actions" style="margin-top:10px">
                <button id="welcomeLogout" class="secondary">تسجيل الخروج</button>
            </div>
        </div>

        <div class="card" id="createCard" hidden>
            <h2 style="margin-top:0">إنشاء مهمة جديدة</h2>
            <div class="row">
                <div>
                    <label for="newTitle">عنوان المهمة</label>
                    <input id="newTitle" type="text" placeholder="عنوان المهمة" />
                </div>
                <div>
                    <label for="newDesc">وصف المهمة</label>
                    <input id="newDesc" type="text" placeholder="وصف المهمة (اختياري)" />
                </div>
            </div>
            <div class="actions" style="margin-top:10px">
                <button id="createTask">إنشاء مهمة</button>
                <span id="createStatus" class="status"></span>
            </div>
        </div>

        <div class="card" id="listCard" hidden>
            <h2 style="margin-top:0">عرض المهام</h2>
            <div class="actions" style="margin-bottom:8px">
                <button id="refresh" class="outline">تحديث المهام</button>
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
    const createCard = document.getElementById('createCard');
    const listCard = document.getElementById('listCard');
    const registerCard = document.getElementById('registerCard');
    const loginCard = document.getElementById('loginCard');
    const welcomeCard = document.getElementById('welcomeCard');
    const welcomeText = document.getElementById('welcomeText');

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

    // Parse JSON responses robustly: strip BOM if present before JSON.parse
    async function safeJson(res) {
        const text = await res.text();
        const clean = text.replace(/^\uFEFF/, '');
        try {
            return JSON.parse(clean);
        } catch (e) {
            throw new Error('Invalid JSON: ' + e.message + '\nResponse: ' + clean.slice(0, 200));
        }
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
        setStatus(authStatus, 'جاري تسجيل الدخول...');
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
                throw new Error('فشل تسجيل الدخول: ' + res.status + ' ' + text);
            }
            const data = await safeJson(res);
            setStatus(authStatus, 'تم تسجيل الدخول بنجاح.');
            logoutBtn.disabled = false;
            createCard.hidden = false;
            listCard.hidden = false;
            registerCard.hidden = true;
            loginCard.hidden = true;
            welcomeCard.hidden = false;
            await loadUser();
            await loadTasks();
        } catch (e) {
            console.error(e);
            setStatus(authStatus, e.message, false);
        }
    }

    async function logout() {
        setStatus(authStatus, 'جاري تسجيل الخروج...');
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
                throw new Error('فشل تسجيل الخروج: ' + res.status + ' ' + text);
            }
            setStatus(authStatus, 'تم تسجيل الخروج بنجاح.');
            userInfo.textContent = '';
            logoutBtn.disabled = true;
            createCard.hidden = true;
            listCard.hidden = true;
            welcomeCard.hidden = true;
            registerCard.hidden = false;
            loginCard.hidden = false;
            tasksEl.innerHTML = '';
        } catch (e) {
            console.error(e);
            setStatus(authStatus, e.message, false);
        }
    }

    async function register() {
        setStatus(regMsg, 'جاري إنشاء الحساب...');
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
                throw new Error('فشل إنشاء الحساب: ' + res.status + ' ' + text);
            }
            setStatus(regMsg, 'تم إنشاء الحساب بنجاح. يمكنك الآن تسجيل الدخول.');
        } catch (e) {
            console.error(e);
            setStatus(regMsg, e.message, false);
        }
    }

    async function loadUser() {
        try {
            const res = await fetch('/api/session/user', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!res.ok) {
                createCard.hidden = true;
                listCard.hidden = true;
                welcomeCard.hidden = true;
                registerCard.hidden = false;
                loginCard.hidden = false;
                userInfo.textContent = '';
                return false;
            }
            const user = await safeJson(res);
            if (!user || (!user.id && !user.email)) {
                createCard.hidden = true;
                listCard.hidden = true;
                welcomeCard.hidden = true;
                registerCard.hidden = false;
                loginCard.hidden = false;
                userInfo.textContent = '';
                return false;
            }
            userInfo.textContent = `مسجل بإسم: ${escapeHtml(user.name || '')} (${escapeHtml(user.email || '')})`;
            welcomeText.textContent = `مرحبًا، ${escapeHtml(user.name || '')} (${escapeHtml(user.email || '')})`;
            logoutBtn.disabled = false;
            createCard.hidden = false;
            listCard.hidden = false;
            welcomeCard.hidden = false;
            registerCard.hidden = true;
            loginCard.hidden = true;
            return true;
        } catch (e) { console.error(e); userInfo.textContent = ''; return false; }
    }

    async function loadTasks() {
        setStatus(listStatus, 'جاري تحميل المهام...');
        tasksEl.innerHTML = '';
        try {
            const res = await fetch('/api/tasks', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
            if (!res.ok) {
                const text = await res.text();
                throw new Error('فشل تحميل المهام: ' + res.status + ' ' + text);
            }
            const tasks = await safeJson(res);
            if (!Array.isArray(tasks) || tasks.length === 0) {
                tasksEl.innerHTML = '<li class="empty">لا توجد مهام حالياً.</li>';
                setStatus(listStatus, 'لا توجد مهام حالياً.');
                return;
            }
            for (const t of tasks) {
                tasksEl.appendChild(renderTaskItem(t));
            }
            setStatus(listStatus, 'تم التحميل.');
        } catch (e) { console.error(e); setStatus(listStatus, e.message, false); }
    }

    function renderTaskItem(t) {
        const li = document.createElement('li');
        li.className = 'task' + (t.completed ? ' done' : '');
        li.dataset.id = t.id;
        li.innerHTML = `
            <div class="title">${escapeHtml(t.title || '(بدون عنوان)')}</div>
            ${t.description ? `<div class="desc">${escapeHtml(t.description)}</div>` : ''}
            <div class="meta small">${t.completed ? 'مكتملة' : 'غير مكتملة'}</div>
            <div class="actions">
                <button class="toggle">${t.completed ? 'إلغاء الإكمال' : 'تحديد كمكتملة'}</button>
                <button class="edit secondary">تعديل</button>
                <button class="delete danger">حذف</button>
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
                <label>العنوان</label>
                <input class="edit-title" type="text" value="${escapeHtml(t.title || '')}">
            </div>
            <div>
                <label>الوصف</label>
                <input class="edit-desc" type="text" value="${escapeHtml(t.description || '')}">
            </div>
            <div class="actions" style="grid-column: 1 / -1; margin-top:8px">
                <button class="save">حفظ</button>
                <button class="cancel secondary">إلغاء</button>
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
            setStatus(statusEl, 'حفظ التعديلات...');
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
                    throw new Error('فشل حفظ التعديلات: ' + res.status + ' ' + text);
                }
                const updated = await safeJson(res);
                // تحديث العناصر في DOM
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
                setStatus(statusEl, 'تم حفظ التعديلات.');
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
                throw new Error('فشل حذف المهمة: ' + res.status + ' ' + text);
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
                throw new Error('فشل تبديل حالة المهمة: ' + res.status + ' ' + text);
            }
            const updated = await safeJson(res);
            li.classList.toggle('done', !!updated.completed);
            li.querySelector('.meta').textContent = updated.completed ? 'مكتملة' : 'غير مكتملة';
            li.querySelector('.toggle').textContent = updated.completed ? 'إلغاء الإكمال' : 'تحديد كمكتملة';
        } catch (e) { console.error(e); alert(e.message); }
    }

    async function createTask() {
        setStatus(createStatus, 'جاري الإضافة...');
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
                throw new Error('فشل إنشاء المهمة: ' + res.status + ' ' + text);
            }
            const created = await safeJson(res);
            tasksEl.prepend(renderTaskItem(created));
            newTitle.value = '';
            newDesc.value = '';
            setStatus(createStatus, 'تم إضافة المهمة.');
        } catch (e) { console.error(e); setStatus(createStatus, e.message, false); }
    }

    // Events
    loginBtn.addEventListener('click', login);
    logoutBtn.addEventListener('click', logout);
    refreshBtn.addEventListener('click', loadTasks);
    createBtn.addEventListener('click', createTask);
    document.getElementById('welcomeLogout').addEventListener('click', logout);
    regBtn.addEventListener('click', register);

    // Boot
    window.addEventListener('DOMContentLoaded', async () => {
        const ok = await loadUser();
        if (ok) {
            await loadTasks();
        }
    });
})();
</script>
</body>
</html>