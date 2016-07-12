<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'smsf_tpocom_dash_dev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1234567890');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}>vfMVnc>cugejVTT/n{Q|#J4OjCzzFUk:=ctGfVtK3ekL0wIrUNV`Wvm2!Tnv2Z');
define('SECURE_AUTH_KEY',  '}@BMQ9{*o$.NU^d`YhiBxTLUAv6y_.BlB%+i$F==QHV$(avS%DYgcIw5c:NnK15P');
define('LOGGED_IN_KEY',    'e}!aNCqyu@uG]8,j)z,(,IRu?~0oa*tP.ZA09>mIWwTR)J#oit{PcvR,kuOAE$is');
define('NONCE_KEY',        'ZQ`rx6Aa[SKJ#3AyZ<>2D@[y[{R%_+aI>D_Cmn#4|KZdZw&R6! FIzbX7489hqyw');
define('AUTH_SALT',        'pc/i|{YWuVHE+a}/rl-Ct&azw6IJ|f8^Hp<UvGj{</ 3q^-,k{da/&m~ur`/T5_P');
define('SECURE_AUTH_SALT', '7H6RgfF5zlla}_D{V7ZBV;YL{j~PY{n{2Ond2mAQe6Gy+<fmE`7a<}+G]cE<,u.Z');
define('LOGGED_IN_SALT',   '>5*HH{k]F)0OvcYt4#2Mo3`<e$?b_JVP8$%y&}S*#2IM.]fiGO^@;g2]U86)S4Zi');
define('NONCE_SALT',       'K?.Ec7,sn|%ygU]v%AvAi5bx,[$rDvp]#zh@]+a@(ttw9w?4;cS@uFA?Sx;F~fbJ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
