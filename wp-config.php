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
define('DB_NAME', 'mulberry');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'toor');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'cod6izzlfufowgsykce1kzn9uoluywjtnmnvw9xb1cmvfc5k8uuhz5obsffpngse');
define('SECURE_AUTH_KEY',  'hzf5hytbeq42dp8md5h8aogwvddvchwwj9dx5nuv6nclntebnshcdlgpruwzqvu3');
define('LOGGED_IN_KEY',    'odkjo7otkjqpakonugpsf0ybczqobkffgajubox2h4b9e2nkyyzzbjsfsounpgys');
define('NONCE_KEY',        'k5b0dadqjzs3jyuufyx5bjnyvp2tfzkt6qsh3ety6q9cadcggroxgsashdfjvcxx');
define('AUTH_SALT',        'mjvleuim7obnu9fkr7zel5xhwaxq0hr3ga500cilah9urzbgug53lhqn8ewute1b');
define('SECURE_AUTH_SALT', 'a6xmlqxubicrimrotjuslyyxmsjglktjcktxk01rtenul2rciet7nf4l4ecxv3tp');
define('LOGGED_IN_SALT',   'zrdeks61jgxfnjex0vde8xdhvkh3nmkk06ucd0eycilnueoun9xxmrelt7agthqt');
define('NONCE_SALT',       'ipd7wdaljvz3q16pgh0vl9xndby0iritfpci4uonxpwqsgglrplqlmbhuqkepklc');

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
define('WP_DEBUG', true);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
