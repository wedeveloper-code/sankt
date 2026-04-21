# Sankt Andreasberg WP Theme – Инструкция по установке

## Требования
- WordPress 6.0+
- PHP 8.0+
- GD-расширение PHP (для конвертации WebP)
- Apache с mod_rewrite

## Установка

### 1. Установите WordPress
Загрузите чистый WordPress на ваш VPS, настройте БД и завершите установку.

### 2. Загрузите тему
Скопируйте папку `sant-andreasberg-wp` в `/wp-content/themes/`  
или создайте ZIP из папки и загрузите через `Внешний вид → Темы → Добавить → Загрузить тему`.

### 3. Активируйте тему
В WordPress Admin: **Внешний вид → Темы → Sant Andreasberg → Активировать**

При активации автоматически создаются:
- Категории: Winter, Sommer, News
- Страницы: Über Sankt Andreasberg, Geschichte, Winter, Sommer, Sehenswürdigkeiten, Impressum, Datenschutz, Kontakt
- Записи в категориях Winter и Sommer (контент со старого сайта)
- Главное меню и меню подвала
- Структура постоянных ссылок: `/%category%/%postname%/`

### 4. Настройте .htaccess
Скопируйте файл `htaccess.txt` в корень сайта и переименуйте в `.htaccess`.  
Он содержит:
- 301-редиректы со всех старых страниц
- WordPress permalink rules
- GZIP-сжатие
- Браузерное кэширование
- Заголовки безопасности

### 5. Установите главную страницу
Admin → **Настройки → Чтение** → Статическая страница  
_(тема устанавливает это автоматически при активации)_

### 6. Логотип (опционально)
Admin → **Внешний вид → Настроить → Идентификация сайта → Логотип**

---

## Возможности темы

### SEO-метатеги
Для каждой страницы, записи и категории можно задать:
- **H1** — заголовок страницы
- **Meta Title** — для вкладки браузера и Google
- **Meta Description** — для сниппета в поиске

Редактирование: при редактировании страницы/записи — блок "SEO & Meta-Angaben" под контентом.  
Для категорий: **Записи → Рубрики → Редактировать рубрику**.  
Для главной: **Внешний вид → Настроить → Startseite – SEO Meta**.

### Sitemap
Admin → **Инструменты → Sitemap** → кнопка "Jetzt aktualisieren"  
Создаёт `/sitemap.xml` автоматически также при публикации новых материалов.

### Конвертация изображений в WebP
При загрузке любого изображения (JPG, PNG, GIF):
- автоматически конвертируется в WebP
- уменьшается до ≤200 KB
- оригинал удаляется

---

## Структура URL

| Тип | URL |
|-----|-----|
| Главная | `/` |
| Страница | `/about-sankt-andreasberg/` |
| Категория | `/winter/` |
| Запись | `/winter/ski-slopes/` |

---

## Старый сайт → Новый (301-редиректы)

| Старый URL | Новый URL |
|-----------|-----------|
| `/index.html` | `/` |
| `/bergsport/de/text/info.html` | `/about-sankt-andreasberg/` |
| `/bergsport/de/text/geschichte.html` | `/history/` |
| `/andreasberg/de/frames/winter.html` | `/winter/` |
| `/bergsport/de/text/loipen.html` | `/winter/ski-trails/` |
| `/bergsport/de/text/rodeln.html` | `/winter/sledding/` |
| `/bergsport/de/text/winter-wandern.html` | `/winter/winter-hiking/` |
| `/bergsport/de/text/wandertouren.html` | `/sommer/hiking/` |
| `/bergsport/de/text/biketouren.html` | `/sommer/mountain-biking/` |
| `/bergsport/de/text/walkingtouren.html` | `/sommer/nordic-walking/` |
| `/andreasberg/de/text/action.html` | `/sommer/adventure/` |
| `/andreasberg/de/text/sehenswertes.html` | `/sights/` |
| `/andreasberg/de/text/impressum.html` | `/impressum/` |
| `/bergsport/de/text/datenschutz.html` | `/privacy-policy/` |
