<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'privetiq-proj');

/** Имя пользователя MySQL */
define('DB_USER', 'mywpadmin');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '1234');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'a>k(P2/FyofM!3(p%^^Kdc4`ry/*K3d} me3W&q>6g+4)6X4Gd!`h`a4)`N5JKHK');
define('SECURE_AUTH_KEY',  '6SyEqm=y%m^H%py}sl_)bJ|A2FvPxK0V_6;E!I0!H[6oUkCXV+=/}ecI?G#6#6E~');
define('LOGGED_IN_KEY',    ' TG6A$vea,oia:K|j_`Yf1Ws=&l<gUl@++=/81o.f[/I $:WG5J#$]G^)+s`,cC=');
define('NONCE_KEY',        '$6*w^G6[5md2To<r+m4GC9r;Eq}VR@>9|!oac-KOQg[p&jDMgj6-yWRJJO_~]RO=');
define('AUTH_SALT',        '=R4Nu#(;7~{<h`@5+R-HVfqMnyg:LQ(] i3x$P)F14JVCd^sj^A_72$Jbw<_Ty^=');
define('SECURE_AUTH_SALT', '*E:7V94=n`#.<z/ UX-eWUY/d@loj#^u^zq%T<CE8ljD=QnrU=%`+hQo<%RF{);|');
define('LOGGED_IN_SALT',   'jD+HkQ:3([zh0;t+dotq<nxMnB5ATv2,Sw}c~A?U2ZpTa9|{X0|b?<&[PQ07;KBs');
define('NONCE_SALT',       'Yd{!3T@jTNp]%EAGoR&RL}JQy|B%?$fW,&M;=Ze9%V@_~Q$]j,Lg?dryi)?ZB}Uu');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
