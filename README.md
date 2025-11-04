# Test-Laravel

تطبيق مهام (To‑Do) مبني على Laravel مع مصادقة Sanctum باستخدام الكوكيز (SPA). يتضمن صفحة واجهة بسيطة عند المسار `/tasks` تُنفّذ دورة كاملة: إنشاء حساب، تسجيل دخول/خروج، عرض المهام، إنشاء/تعديل/حذف، وتبديل حالة الإكمال.

## المتطلبات
- PHP 8.2+
- Composer
- SQLite (افتراضيًا يتم استخدام ملف قاعدة بيانات داخل `database/database.sqlite`)
- اختياري: Node.js لإدارة الأصول

## الإعداد السريع
1) انسخ ملف البيئة:
   - `cp .env.example .env`
2) أنشئ مفتاح التطبيق:
   - `php artisan key:generate`
3) تأكد من وجود قاعدة البيانات:
   - أنشئ ملفًا فارغًا: `database/database.sqlite`
4) نفّذ الترقيات:
   - `php artisan migrate`

نصائح إعداد البيئة:
- اضبط `APP_URL` في `.env` على `http://127.0.0.1:8000` (أو المنفذ الذي ستستخدمه).
- إعداد `SANCTUM_STATEFUL_DOMAINS` يحتوي افتراضيًا على `127.0.0.1`، مما يتيح طلبات الكوكيز من نفس الأصل.

## التشغيل محليًا
- شغّل السيرفر: `php artisan serve`
- افتح: `http://127.0.0.1:8000/tasks`

## المصادقة (Sanctum عبر الكوكيز)
هذا التطبيق يستخدم أسلوب SPA مع Sanctum؛ جميع طلبات المهام تحت `web + auth:sanctum` وتُعامل كطلبات حالة (stateful) باستخدام الكوكيز.

التدفق المتوقع للمتصفح:
- احصل على CSRF أولًا: `GET /sanctum/csrf-cookie`
- للطلبات المعدِّلة (POST/PUT/PATCH/DELETE) أرسل رأس `X-XSRF-TOKEN` بالقيمة المأخوذة من كوكي `XSRF-TOKEN`، مع `credentials: 'same-origin'`.

نقاط النهاية المستخدمة:
- الجلسة:
  - `POST /api/session/login` تسجيل الدخول (بالبريد وكلمة المرور)
  - `GET  /api/session/user` معلومات المستخدم الحالي
  - `POST /api/session/logout` تسجيل الخروج
- إنشاء حساب:
  - `POST /api/register` مع CSRF والكوكيز
- المهام:
  - `GET    /api/tasks` عرض المهام
  - `POST   /api/tasks` إنشاء مهمة
  - `PUT    /api/tasks/{task}` تعديل
  - `PATCH  /api/tasks/{task}/toggle` تبديل حالة الإكمال
  - `DELETE /api/tasks/{task}` حذف

ملاحظة حول الراوت:
- تم نقل راوت المهام إلى `routes/web.php` تحت `prefix('api')->middleware(['web','auth:sanctum'])` لضمان قراءة الكوكيز بنمط SPA.

## واجهة `/tasks`
- الصفحة `resources/views/tasks.blade.php` تحتوي سكربتًا بسيطًا يتكامل مع النقاط أعلاه.
- دالة `ensureCsrf()` تجلب كوكي CSRF وتقرأ `XSRF-TOKEN`.
- دوال `register`, `login`, `createTask`, `toggleTask`, `deleteTask` تُرسِل الرأس `X-XSRF-TOKEN` وتستعمل `credentials: 'same-origin'`.

## أوامر شائعة
- تثبيت الاعتماديات: `composer install`
- الترقيات: `php artisan migrate`
- تشغيل: `php artisan serve`
- إنشاء مستخدم تجريبي (اختياري عبر التسجيل من الواجهة): افتح `/tasks` وأنشئ حسابًا جديدًا.

## ملاحظات أمنية
- لا تُضمِّن `.env` في المستودع (مستثنى عبر `.gitignore`).
- عند العمل عبر طلبات خارج المتصفح، تأكد من الحصول على CSRF وإرسال `X-XSRF-TOKEN`، وإلا ستحصل على 419.

## مشاكل شائعة
- 401 عند `GET /api/tasks`: يظهر إن لم تكن مسجّلًا الدخول؛ سجّل أولًا ثم حدّث القائمة.
- 419 عند `POST /api/register`: يعني أن CSRF غير مُرسَل؛ استدعِ `/sanctum/csrf-cookie` ثم أرسل `X-XSRF-TOKEN` مع الكوكيز.

## ترخيص
هذا المشروع يُقدّم لأغراض تعليمية وتجريبية.

Laravel to-do app with Sanctum cookie authentication. Frontend page at `/tasks`.
