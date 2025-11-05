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
        .task { display: grid; gap: 8px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; margin-bottom: 10px; background: #fafafa; grid-auto-rows: minmax(min-content, auto); }
        .task.done { }
        .task.done .title, .task.done .desc { text-decoration: line-through; color: #6b7280; }
        .task .title { font-weight: 700; white-space: normal; overflow-wrap: anywhere; word-break: break-word; }
        .task .desc { font-size: 14px; color: #444; white-space: pre-wrap; overflow-wrap: anywhere; word-break: break-word; }
        .meta { display: flex; gap: 8px; align-items: center; }
        .small { font-size: 12px; color: #6b7280; }
        /* حذف: زر أيقونة بدون خلفية، يتلوّن بالأحمر عند المرور */
        .actions button.delete { background: transparent; border-color: transparent; color: #6b7280; }
        .actions button.delete.danger { background: transparent; border-color: transparent; }
        .actions button.delete:hover { color: #b91c1c; }
        /* تعديل: زر أيقونة بدون خلفية، يبقى رماديًا ثابتًا */
        .actions button.edit.secondary { background: transparent; border-color: transparent; color: #6b7280; }
        .actions button.edit:hover { color: #6b7280; }
        /* تحديد كمكتملة: زر أيقونة بدون خلفية، يبقى رماديًا ثابتًا */
        .actions button.toggle { background: transparent; border-color: transparent; color: #6b7280; }
        .actions button.toggle:hover { color: #6b7280; }
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
                    <textarea id="newDesc" placeholder="وصف المهمة (اختياري)"></textarea>
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
                <button id="refresh" class="outline" title="تحديث المهام" aria-label="تحديث المهام">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="Refresh-3-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                      <desc>Refresh 3 Line Streamline Icon: https://streamlinehq.com</desc>
                      <g fill="none" fill-rule="nonzero">
                        <path d="M16 0v16H0V0h16ZM8.395999999999999 15.505333333333333l-0.008 0.0013333333333333333 -0.047333333333333324 0.023333333333333334 -0.013333333333333332 0.0026666666666666666 -0.009333333333333332 -0.0026666666666666666 -0.047333333333333324 -0.023999999999999997c-0.006666666666666666 -0.002 -0.012666666666666666 0 -0.016 0.004l-0.0026666666666666666 0.006666666666666666 -0.011333333333333334 0.2853333333333333 0.003333333333333333 0.013333333333333332 0.006666666666666666 0.008666666666666666 0.06933333333333333 0.049333333333333326 0.009999999999999998 0.0026666666666666666 0.008 -0.0026666666666666666 0.06933333333333333 -0.049333333333333326 0.008 -0.010666666666666666 0.0026666666666666666 -0.011333333333333334 -0.011333333333333334 -0.2846666666666666c-0.0013333333333333333 -0.006666666666666666 -0.005999999999999999 -0.011333333333333334 -0.010666666666666666 -0.011999999999999999Zm0.176 -0.07533333333333334 -0.009333333333333332 0.0013333333333333333 -0.12266666666666666 0.062 -0.006666666666666666 0.006666666666666666 -0.002 0.007333333333333332 0.011999999999999999 0.2866666666666666 0.003333333333333333 0.008 0.005333333333333333 0.005333333333333333 0.134 0.06133333333333333c0.008 0.0026666666666666666 0.015333333333333332 0 0.019333333333333334 -0.005333333333333333l0.0026666666666666666 -0.009333333333333332 -0.02266666666666667 -0.4093333333333333c-0.002 -0.008 -0.006666666666666666 -0.013333333333333332 -0.013333333333333332 -0.014666666666666665Zm-0.4766666666666666 0.0013333333333333333a0.015333333333333332 0.015333333333333332 0 0 0 -0.018 0.004l-0.004 0.009333333333333332 -0.02266666666666667 0.4093333333333333c0 0.008 0.004666666666666666 0.013333333333333332 0.011333333333333334 0.016l0.009999999999999998 -0.0013333333333333333 0.134 -0.062 0.006666666666666666 -0.005333333333333333 0.002 -0.007333333333333332 0.011999999999999999 -0.2866666666666666 -0.002 -0.008 -0.006666666666666666 -0.006666666666666666 -0.12266666666666666 -0.06133333333333333Z" stroke-width="0.6667"></path>
                        <path fill="currentColor" d="M13.333333333333332 6a0.6666666666666666 0.6666666666666666 0 0 1 0.6666666666666666 0.6666666666666666v0.6666666666666666a5.333333333333333 5.333333333333333 0 0 1 -5.333333333333333 5.333333333333333H6.276l0.5286666666666666 0.5286666666666666a0.6666666666666666 0.6666666666666666 0 0 1 -0.9426666666666665 0.9426666666666665l-1.664 -1.664a0.6646666666666666 0.6646666666666666 0 0 1 -0.1913333333333333 -0.37799999999999995L4 11.994a0.6639999999999999 0.6639999999999999 0 0 1 0.15799999999999997 -0.42533333333333334l0.03733333333333333 -0.039999999999999994 1.6666666666666665 -1.6666666666666665a0.6666666666666666 0.6666666666666666 0 0 1 0.9426666666666665 0.9426666666666665L6.276 11.333333333333332H8.666666666666666a4 4 0 0 0 4 -4v-0.6666666666666666a0.6666666666666666 0.6666666666666666 0 0 1 0.6666666666666666 -0.6666666666666666Zm-3.195333333333333 -4.138 1.6666666666666665 1.6666666666666665a0.6666666666666666 0.6666666666666666 0 0 1 0 0.9426666666666665l-1.6666666666666665 1.6666666666666665a0.6666666666666666 0.6666666666666666 0 1 1 -0.9426666666666665 -0.9426666666666665L9.724 4.666666666666666H7.333333333333333a4 4 0 0 0 -4 4v0.6666666666666666a0.6666666666666666 0.6666666666666666 0 1 1 -1.3333333333333333 0v-0.6666666666666666a5.333333333333333 5.333333333333333 0 0 1 5.333333333333333 -5.333333333333333h2.3906666666666663l-0.5286666666666666 -0.5286666666666666a0.6666666666666666 0.6666666666666666 0 0 1 0.9426666666666665 -0.9426666666666665Z" stroke-width="0.6667"></path>
                      </g>
                    </svg>
                </button>
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
            if (logoutBtn) logoutBtn.disabled = false;
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
            if (logoutBtn) logoutBtn.disabled = true;
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
            if (logoutBtn) logoutBtn.disabled = false;
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
            <div class="actions">
                <button class="toggle" title="${t.completed ? 'إلغاء الإكمال' : 'تحديد كمكتملة'}" aria-label="${t.completed ? 'إلغاء الإكمال' : 'تحديد كمكتملة'}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="Task-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                      <desc>Task Line Streamline Icon: https://streamlinehq.com</desc>
                      <g fill="none" fill-rule="evenodd">
                        <path d="M24 0v24H0V0h24ZM12.594 23.258l-0.012 0.002 -0.071 0.035 -0.02 0.004 -0.014 -0.004 -0.071 -0.036c-0.01 -0.003 -0.019 0 -0.024 0.006l-0.004 0.01 -0.017 0.428 0.005 0.02 0.01 0.013 0.104 0.074 0.015 0.004 0.012 -0.004 0.104 -0.074 0.012 -0.016 0.004 -0.017 -0.017 -0.427c-0.002 -0.01 -0.009 -0.017 -0.016 -0.018Zm0.264 -0.113 -0.014 0.002 -0.184 0.093 -0.01 0.01 -0.003 0.011 0.018 0.43 0.005 0.012 0.008 0.008 0.201 0.092c0.012 0.004 0.023 0 0.029 -0.008l0.004 -0.014 -0.034 -0.614c-0.003 -0.012 -0.01 -0.02 -0.02 -0.022Zm-0.715 0.002a0.023 0.023 0 0 0 -0.027 0.006l-0.006 0.014 -0.034 0.614c0 0.012 0.007 0.02 0.017 0.024l0.015 -0.002 0.201 -0.093 0.01 -0.008 0.003 -0.011 0.018 -0.43 -0.003 -0.012 -0.01 -0.01 -0.184 -0.092Z" stroke-width="1"></path>
                        <path fill="currentColor" d="M15 2a2 2 0 0 1 1.732 1H18a2 2 0 0 1 2 2v12a5 5 0 0 1 -5 5H6a2 2 0 0 1 -2 -2V5a2 2 0 0 1 2 -2h1.268A2 2 0 0 1 9 2h6ZM7 5H6v15h9a3 3 0 0 0 3 -3V5h-1a2 2 0 0 1 -2 2H9a2 2 0 0 1 -2 -2Zm9.238 4.379a1 1 0 0 1 0 1.414l-4.95 4.95a1 1 0 0 1 -1.414 0l-2.12 -2.122a1 1 0 0 1 1.413 -1.414l1.415 1.414 4.242 -4.242a1 1 0 0 1 1.414 0ZM15 4H9v1h6V4Z" stroke-width="1"></path>
                      </g>
                    </svg>
                </button>
                <button class="edit secondary" style="${t.completed ? 'display:none' : ''}" title="تعديل" aria-label="تعديل">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="Edit-4-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                      <desc>Edit 4 Line Streamline Icon: https://streamlinehq.com</desc>
                      <g fill="none" fill-rule="evenodd">
                        <path d="M16 0v16H0V0h16ZM8.395999999999999 15.505333333333333l-0.008 0.0013333333333333333 -0.047333333333333324 0.023333333333333334 -0.013333333333333332 0.0026666666666666666 -0.009333333333333332 -0.0026666666666666666 -0.047333333333333324 -0.023999999999999997c-0.006666666666666666 -0.002 -0.012666666666666666 0 -0.016 0.004l-0.0026666666666666666 0.006666666666666666 -0.011333333333333334 0.2853333333333333 0.003333333333333333 0.013333333333333332 0.006666666666666666 0.008666666666666666 0.06933333333333333 0.049333333333333326 0.009999999999999998 0.0026666666666666666 0.008 -0.0026666666666666666 0.06933333333333333 -0.049333333333333326 0.008 -0.010666666666666666 0.0026666666666666666 -0.011333333333333334 -0.011333333333333334 -0.2846666666666666c-0.0013333333333333333 -0.006666666666666666 -0.005999999999999999 -0.011333333333333334 -0.010666666666666666 -0.011999999999999999Zm0.176 -0.07533333333333334 -0.009333333333333332 0.0013333333333333333 -0.12266666666666666 0.062 -0.006666666666666666 0.006666666666666666 -0.002 0.007333333333333332 0.011999999999999999 0.2866666666666666 0.003333333333333333 0.008 0.005333333333333333 0.005333333333333333 0.134 0.06133333333333333c0.008 0.0026666666666666666 0.015333333333333332 0 0.019333333333333334 -0.005333333333333333l0.0026666666666666666 -0.009333333333333332 -0.02266666666666667 -0.4093333333333333c-0.002 -0.008 -0.006666666666666666 -0.013333333333333332 -0.013333333333333332 -0.014666666666666665Zm-0.4766666666666666 0.0013333333333333333a0.015333333333333332 0.015333333333333332 0 0 0 -0.018 0.004l-0.004 0.009333333333333332 -0.02266666666666667 0.4093333333333333c0 0.008 0.004666666666666666 0.013333333333333332 0.011333333333333334 0.016l0.009999999999999998 -0.0013333333333333333 0.134 -0.062 0.006666666666666666 -0.005333333333333333 0.002 -0.007333333333333332 0.011999999999999999 -0.2866666666666666 -0.002 -0.008 -0.006666666666666666 -0.006666666666666666 -0.12266666666666666 -0.06133333333333333Z" stroke-width="0.6667"></path>
                        <path fill="currentColor" d="M3.333333333333333 1.3333333333333333a1.3333333333333333 1.3333333333333333 0 0 0 -1.3333333333333333 1.3333333333333333v10a1.3333333333333333 1.3333333333333333 0 0 0 1.3333333333333333 1.3333333333333333h2v-1.3333333333333333H3.333333333333333V2.6666666666666665h8v2.6666666666666665h1.3333333333333333V2.6666666666666665a1.3333333333333333 1.3333333333333333 0 0 0 -1.3333333333333333 -1.3333333333333333H3.333333333333333Zm2 3.333333333333333a0.6666666666666666 0.6666666666666666 0 0 0 0 1.3333333333333333h2.6666666666666665a0.6666666666666666 0.6666666666666666 0 1 0 0 -1.3333333333333333H5.333333333333333Zm5.299333333333333 2.5406666666666666a2 2 0 0 1 2.828 2.828666666666667l-3.770666666666666 3.771333333333333a0.6666666666666666 0.6666666666666666 0 0 1 -0.47133333333333327 0.1953333333333333h-1.8860000000000001a0.6666666666666666 0.6666666666666666 0 0 1 -0.6666666666666666 -0.6666666666666666v-1.8860000000000001a0.6666666666666666 0.6666666666666666 0 0 1 0.1953333333333333 -0.47133333333333327l3.771333333333333 -3.771333333333333Zm1.885333333333333 0.9426666666666665a0.6666666666666666 0.6666666666666666 0 0 0 -0.9426666666666665 0l0.9426666666666665 0.9433333333333334a0.6666666666666666 0 0 0 0 -0.9433333333333334Zm-0.9426666666666665 1.8860000000000001 -0.9426666666666665 -0.9426666666666665 -2.6333333333333333 2.6333333333333333v0.9426666666666665h0.9426666666666665l2.6333333333333333 -2.6333333333333333Z" stroke-width="0.6667"></path>
                      </g>
                    </svg>
                </button>
                <button class="delete danger" title="حذف" aria-label="حذف">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="Delete-2-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                      <g fill="none" fill-rule="nonzero">
                        <path d="M16 0v16H0V0h16ZM8.395333333333333 15.505333333333333l-0.007333333333333332 0.0013333333333333333 -0.047333333333333324 0.023333333333333334 -0.013333333333333332 0.0026666666666666666 -0.009333333333333332 -0.0026666666666666666 -0.047333333333333324 -0.023333333333333334c-0.006666666666666666 -0.0026666666666666666 -0.012666666666666666 -0.0006666666666666666 -0.016 0.003333333333333333l-0.0026666666666666666 0.006666666666666666 -0.011333333333333334 0.2853333333333333 0.003333333333333333 0.013333333333333332 0.006666666666666666 0.008666666666666666 0.06933333333333333 0.049333333333333326 0.009999999999999998 0.0026666666666666666 0.008 -0.0026666666666666666 0.06933333333333333 -0.049333333333333326 0.008 -0.010666666666666666 0.0026666666666666666 -0.011333333333333334 -0.011333333333333334 -0.2846666666666666c-0.0013333333333333333 -0.006666666666666666 -0.005999999999999999 -0.011333333333333334 -0.011333333333333334 -0.011999999999999999Zm0.17666666666666667 -0.07533333333333334 -0.008666666666666666 0.0013333333333333333 -0.12333333333333332 0.062 -0.006666666666666666 0.006666666666666666 -0.002 0.007333333333333332 0.011999999999999999 0.2866666666666666 0.003333333333333333 0.008 0.005333333333333333 0.004666666666666666 0.134 0.062c0.008 0.0026666666666666666 0.015333333333333332 0 0.019333333333333334 -0.005333333333333333l0.0026666666666666666 -0.009333333333333332 -0.02266666666666667 -0.4093333333333333c-0.002 -0.008 -0.006666666666666666 -0.013333333333333332 -0.013333333333333332 -0.014666666666666665Zm-0.4766666666666666 0.0013333333333333333a0.015333333333333332 0.015333333333333332 0 0 0 -0.018 0.004l-0.004 0.009333333333333332 -0.02266666666666667 0.4093333333333333c0 0.008 0.004666666666666666 0.013333333333333332 0.011333333333333334 0.016l0.009999999999999998 -0.0013333333333333333 0.134 -0.062 0.006666666666666666 -0.005333333333333333 0.0026666666666666666 -0.007333333333333332 0.011333333333333334 -0.2866666666666666 -0.002 -0.008 -0.006666666666666666 -0.006666666666666666 -0.12266666666666666 -0.06133333333333333Z" stroke-width="0.6667"></path>
                        <path fill="currentColor" d="M9.52 1.3333333333333333a1.3333333333333333 1.3333333333333333 0 0 1 1.2646666666666666 0.912L11.146666666666665 3.333333333333333H13.333333333333332a0.6666666666666666 0.6666666666666666 0 1 1 0 1.3333333333333333l-0.002 0.047333333333333324 -0.578 8.095333333333333A2 2 0 0 1 10.758666666666667 14.666666666666666H5.241333333333333a2 2 0 0 1 -1.9946666666666666 -1.8573333333333333L2.6686666666666667 4.713333333333333A0.6733333333333333 0.6733333333333333 0 0 1 2.6666666666666665 4.666666666666666a0.6666666666666666 0.6666666666666666 0 0 1 0 -1.3333333333333333h2.1866666666666665l0.362 -1.0879999999999999A1.3333333333333333 1.3333333333333333 0 0 1 6.480666666666666 1.3333333333333333h3.0386666666666664Zm2.4779999999999998 3.333333333333333H4.002l0.5746666666666667 8.047333333333333a0.6666666666666666 0.6666666666666666 0 0 0 0.6646666666666666 0.6193333333333333h5.517333333333333a0.6666666666666666 0.6666666666666666 0 0 0 0.6646666666666666 -0.6193333333333333L11.998 4.666666666666666ZM6.666666666666666 6.666666666666666a0.6666666666666666 0.6666666666666666 0 0 1 0.6619999999999999 0.5886666666666667L7.333333333333333 7.333333333333333v3.333333333333333a0.6666666666666666 0.6666666666666666 0 0 1 -1.3286666666666667 0.078L6 10.666666666666666v-3.333333333333333a0.6666666666666666 0.6666666666666666 0 0 1 0.6666666666666666 -0.6666666666666666Zm2.6666666666666665 0a0.6666666666666666 0.6666666666666666 0 0 1 0.6666666666666666 0.6666666666666666v3.333333333333333a0.6666666666666666 0.6666666666666666 0 1 1 -1.3333333333333333 0v-3.333333333333333a0.6666666666666666 0.6666666666666666 0 0 1 0.6666666666666666 -0.6666666666666666Zm0.18666666666666668 -4H6.48l-0.222 0.6666666666666666h3.484l-0.22266666666666668 -0.6666666666666666Z" stroke-width="0.6667"></path>
                      </g>
                    </svg>
                </button>
            </div>
        `;
        // ضبط الأيقونة الابتدائية حسب حالة المهمة
        const initToggleBtn = li.querySelector('.toggle');
        if (initToggleBtn && t.completed) {
            initToggleBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="Eraser-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                  <desc>Eraser Line Streamline Icon: https://streamlinehq.com</desc>
                  <g fill="none" fill-rule="evenodd">
                    <path d="M16 0v16H0V0h16ZM8.395333333333333 15.505333333333333l-0.007333333333333332 0.0013333333333333333 -0.047333333333333324 0.023333333333333334 -0.013333333333333332 0.0026666666666666666 -0.009333333333333332 -0.0026666666666666666 -0.047333333333333324 -0.023333333333333334c-0.006666666666666666 -0.0026666666666666666 -0.012666666666666666 -0.0006666666666666666 -0.016 0.003333333333333333l-0.0026666666666666666 0.006666666666666666 -0.011333333333333334 0.2853333333333333 0.003333333333333333 0.013333333333333332 0.006666666666666666 0.008666666666666666 0.06933333333333333 0.049333333333333326 0.009999999999999998 0.0026666666666666666 0.008 -0.0026666666666666666 0.06933333333333333 -0.049333333333333326 0.008 -0.010666666666666666 0.0026666666666666666 -0.011333333333333334 -0.011333333333333334 -0.2846666666666666c-0.0013333333333333333 -0.006666666666666666 -0.005999999999999999 -0.011333333333333334 -0.011333333333333334 -0.011999999999999999Zm0.17666666666666667 -0.07533333333333334 -0.008666666666666666 0.0013333333333333333 -0.12333333333333332 0.062 -0.006666666666666666 0.006666666666666666 -0.002 0.007333333333333332 0.011999999999999999 0.2866666666666666 0.003333333333333333 0.008 0.005333333333333333 0.004666666666666666 0.134 0.062c0.008 0.0026666666666666666 0.015333333333333332 0 0.019333333333333334 -0.005333333333333333l0.0026666666666666666 -0.009333333333333332 -0.02266666666666667 -0.4093333333333333c-0.002 -0.008 -0.006666666666666666 -0.013333333333333332 -0.013333333333333332 -0.014666666666666665Zm-0.4766666666666666 0.0013333333333333333a0.015333333333333332 0.015333333333333332 0 0 0 -0.018 0.004l-0.004 0.009333333333333332 -0.02266666666666667 0.4093333333333333c0 0.008 0.004666666666666666 0.013333333333333332 0.011333333333333334 0.016l0.009999999999999998 -0.0013333333333333333 0.134 -0.062 0.006666666666666666 -0.005333333333333333 0.0026666666666666666 -0.007333333333333332 0.011333333333333334 -0.2866666666666666 -0.002 -0.008 -0.006666666666666666 -0.006666666666666666 -0.12266666666666666 -0.06133333333333333Z" stroke-width="0.6667"></path>
                    <path fill="currentColor" d="m10.356666666666666 1.8719999999999999 3.771333333333333 3.770666666666666a1.3333333333333333 1.3333333333333333 0 0 1 0 1.8860000000000001l-2.348 2.3486666666666665 -0.008666666666666666 0.008 -0.008666666666666666 0.008666666666666666L8.989999999999998 12.666666666666666H13.333333333333332a0.6666666666666666 0.6666666666666666 0 1 1 0 1.3333333333333333H5.9286666666666665a1 1 0 0 1 -0.7066666666666667 -0.29333333333333333l-3.3506666666666662 -3.349333333333333a1.3333333333333333 1.3333333333333333 0 0 1 0 -1.8860000000000001l6.6 -6.6a1.3333333333333333 1.3333333333333333 0 0 1 1.885333333333333 0Zm0 7.542L7.104666666666667 12.666666666666666H6.066666666666666l-3.252 -3.2526666666666664 3.771333333333333 -3.771333333333333 3.770666666666666 3.771333333333333Zm0.9433333333333334 -0.9426666666666665L7.528666666666666 4.699999999999999l1.885333333333333 -1.885333333333333 3.771333333333333 3.771333333333333 -1.885333333333333 1.885333333333333Z" stroke-width="0.6667"></path>
                  </g>
                </svg>
            `;
        }
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
                <textarea class="edit-title">${escapeHtml(t.title || '')}</textarea>
            </div>
            <div>
                <label>الوصف</label>
                <textarea class="edit-desc">${escapeHtml(t.description || '')}</textarea>
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
                        const actionsEl = li.querySelector('.actions');
                        if (actionsEl) {
                            li.insertBefore(d, actionsEl);
                        } else {
                            li.appendChild(d);
                        }
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
            const toggleBtn = li.querySelector('.toggle');
            if (toggleBtn) {
                const label = updated.completed ? 'إلغاء الإكمال' : 'تحديد كمكتملة';
                toggleBtn.setAttribute('title', label);
                toggleBtn.setAttribute('aria-label', label);
                toggleBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="Task-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                      <desc>Task Line Streamline Icon: https://streamlinehq.com</desc>
                      <g fill="none" fill-rule="evenodd">
                        <path d="M24 0v24H0V0h24ZM12.594 23.258l-0.012 0.002 -0.071 0.035 -0.02 0.004 -0.014 -0.004 -0.071 -0.036c-0.01 -0.003 -0.019 0 -0.024 0.006l-0.004 0.01 -0.017 0.428 0.005 0.02 0.01 0.013 0.104 0.074 0.015 0.004 0.012 -0.004 0.104 -0.074 0.012 -0.016 0.004 -0.017 -0.017 -0.427c-0.002 -0.01 -0.009 -0.017 -0.016 -0.018Zm0.264 -0.113 -0.014 0.002 -0.184 0.093 -0.01 0.01 -0.003 0.011 0.018 0.43 0.005 0.012 0.008 0.008 0.201 0.092c0.012 0.004 0.023 0 0.029 -0.008l0.004 -0.014 -0.034 -0.614c-0.003 -0.012 -0.01 -0.02 -0.02 -0.022Zm-0.715 0.002a0.023 0.023 0 0 0 -0.027 0.006l-0.006 0.014 -0.034 0.614c0 0.012 0.007 0.02 0.017 0.024l0.015 -0.002 0.201 -0.093 0.01 -0.008 0.003 -0.011 0.018 -0.43 -0.003 -0.012 -0.01 -0.01 -0.184 -0.092Z" stroke-width="1"></path>
                        <path fill="currentColor" d="M15 2a2 2 0 0 1 1.732 1H18a2 2 0 0 1 2 2v12a5 5 0 0 1 -5 5H6a2 2 0 0 1 -2 -2V5a2 2 0 0 1 2 -2h1.268A2 2 0 0 1 9 2h6ZM7 5H6v15h9a3 3 0 0 0 3 -3V5h-1a2 2 0 0 1 -2 2H9a2 2 0 0 1 -2 -2Zm9.238 4.379a1 1 0 0 1 0 1.414l-4.95 4.95a1 1 0 0 1 -1.414 0l-2.12 -2.122a1 1 0 0 1 1.413 -1.414l1.415 1.414 4.242 -4.242a1 1 0 0 1 1.414 0ZM15 4H9v1h6V4Z" stroke-width="1"></path>
                      </g>
                    </svg>`;
            }
            // تحديث الأيقونة حسب الحالة: ممّاحة عند "إلغاء الإكمال" وأيقونة مهمة عند "تحديد كمكتملة"
            if (toggleBtn) {
                toggleBtn.innerHTML = updated.completed
                    ? `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="Eraser-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                          <desc>Eraser Line Streamline Icon: https://streamlinehq.com</desc>
                          <g fill="none" fill-rule="evenodd">
                            <path d="M16 0v16H0V0h16ZM8.395333333333333 15.505333333333333l-0.007333333333333332 0.0013333333333333333 -0.047333333333333324 0.023333333333333334 -0.013333333333333332 0.0026666666666666666 -0.009333333333333332 -0.0026666666666666666 -0.047333333333333324 -0.023333333333333334c-0.006666666666666666 -0.0026666666666666666 -0.012666666666666666 -0.0006666666666666666 -0.016 0.003333333333333333l-0.0026666666666666666 0.006666666666666666 -0.011333333333333334 0.2853333333333333 0.003333333333333333 0.013333333333333332 0.006666666666666666 0.008666666666666666 0.06933333333333333 0.049333333333333326 0.009999999999999998 0.0026666666666666666 0.008 -0.0026666666666666666 0.06933333333333333 -0.049333333333333326 0.008 -0.010666666666666666 0.0026666666666666666 -0.011333333333333334 -0.011333333333333334 -0.2846666666666666c-0.0013333333333333333 -0.006666666666666666 -0.005999999999999999 -0.011333333333333334 -0.011333333333333334 -0.011999999999999999Zm0.17666666666666667 -0.07533333333333334 -0.008666666666666666 0.0013333333333333333 -0.12333333333333332 0.062 -0.006666666666666666 0.006666666666666666 -0.002 0.007333333333333332 0.011999999999999999 0.2866666666666666 0.003333333333333333 0.008 0.005333333333333333 0.004666666666666666 0.134 0.062c0.008 0.0026666666666666666 0.015333333333333332 0 0.019333333333333334 -0.005333333333333333l0.0026666666666666666 -0.009333333333333332 -0.02266666666666667 -0.4093333333333333c-0.002 -0.008 -0.006666666666666666 -0.013333333333333332 -0.013333333333333332 -0.014666666666666665Zm-0.4766666666666666 0.0013333333333333333a0.015333333333333332 0.015333333333333332 0 0 0 -0.018 0.004l-0.004 0.009333333333333332 -0.02266666666666667 0.4093333333333333c0 0.008 0.004666666666666666 0.013333333333333332 0.011333333333333334 0.016l0.009999999999999998 -0.0013333333333333333 0.134 -0.062 0.006666666666666666 -0.005333333333333333 0.0026666666666666666 -0.007333333333333332 0.011333333333333334 -0.2866666666666666 -0.002 -0.008 -0.006666666666666666 -0.006666666666666666 -0.12266666666666666 -0.06133333333333333Z" stroke-width="0.6667"></path>
                            <path fill="currentColor" d="m10.356666666666666 1.8719999999999999 3.771333333333333 3.770666666666666a1.3333333333333333 1.3333333333333333 0 0 1 0 1.8860000000000001l-2.348 2.3486666666666665 -0.008666666666666666 0.008 -0.008666666666666666 0.008666666666666666L8.989999999999998 12.666666666666666H13.333333333333332a0.6666666666666666 0.6666666666666666 0 1 1 0 1.3333333333333333H5.9286666666666665a1 1 0 0 1 -0.7066666666666667 -0.29333333333333333l-3.3506666666666662 -3.349333333333333a1.3333333333333333 1.3333333333333333 0 0 1 0 -1.8860000000000001l6.6 -6.6a1.3333333333333333 1.3333333333333333 0 0 1 1.885333333333333 0Zm0 7.542L7.104666666666667 12.666666666666666H6.066666666666666l-3.252 -3.2526666666666664 3.771333333333333 -3.771333333333333 3.770666666666666 3.771333333333333Zm0.9433333333333334 -0.9426666666666665L7.528666666666666 4.699999999999999l1.885333333333333 -1.885333333333333 3.771333333333333 3.771333333333333 -1.885333333333333 1.885333333333333Z" stroke-width="0.6667"></path>
                          </g>
                        </svg>
                    `
                    : `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="Task-Line--Streamline-Mingcute" height="16" width="16" aria-hidden="true" focusable="false">
                          <desc>Task Line Streamline Icon: https://streamlinehq.com</desc>
                          <g fill="none" fill-rule="evenodd">
                            <path d="M24 0v24H0V0h24ZM12.594 23.258l-0.012 0.002 -0.071 0.035 -0.02 0.004 -0.014 -0.004 -0.071 -0.036c-0.01 -0.003 -0.019 0 -0.024 0.006l-0.004 0.01 -0.017 0.428 0.005 0.02 0.01 0.013 0.104 0.074 0.015 0.004 0.012 -0.004 0.104 -0.074 0.012 -0.016 0.004 -0.017 -0.017 -0.427c-0.002 -0.01 -0.009 -0.017 -0.016 -0.018Zm0.264 -0.113 -0.014 0.002 -0.184 0.093 -0.01 0.01 -0.003 0.011 0.018 0.43 0.005 0.012 0.008 0.008 0.201 0.092c0.012 0.004 0.023 0 0.029 -0.008l0.004 -0.014 -0.034 -0.614c-0.003 -0.012 -0.01 -0.02 -0.02 -0.022Zm-0.715 0.002a0.023 0.023 0 0 0 -0.027 0.006l-0.006 0.014 -0.034 0.614c0 0.012 0.007 0.02 0.017 0.024l0.015 -0.002 0.201 -0.093 0.01 -0.008 0.003 -0.011 0.018 -0.43 -0.003 -0.012 -0.01 -0.01 -0.184 -0.092Z" stroke-width="1"></path>
                            <path fill="currentColor" d="M15 2a2 2 0 0 1 1.732 1H18a2 2 0 0 1 2 2v12a5 5 0 0 1 -5 5H6a2 2 0 0 1 -2 -2V5a2 2 0 0 1 2 -2h1.268A2 2 0 0 1 9 2h6ZM7 5H6v15h9a3 3 0 0 0 3 -3V5h-1a2 2 0 0 1 -2 2H9a2 2 0 0 1 -2 -2Zm9.238 4.379a1 1 0 0 1 0 1.414l-4.95 4.95a1 1 0 0 1 -1.414 0l-2.12 -2.122a1 1 0 0 1 1.413 -1.414l1.415 1.414 4.242 -4.242a1 1 0 0 1 1.414 0ZM15 4H9v1h6V4Z" stroke-width="1"></path>
                          </g>
                        </svg>
                    `;
            }
            const editBtn = li.querySelector('.edit');
            if (editBtn) editBtn.style.display = updated.completed ? 'none' : '';
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
    if (logoutBtn) logoutBtn.addEventListener('click', logout);
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