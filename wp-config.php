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

define('DB_NAME', 'fstech_foodorder');



/** MySQL database username */

define('DB_USER', 'fstech_foodorder');



/** MySQL database password */

define('DB_PASSWORD', 'Zo~^NviCUzhd');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



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

define('AUTH_KEY',         '[v(Lday|!]X5AkJW`r8+6S|c@mI4vV+6z5*:Kc1^/BMwU|7P5C].r.p=>h|E *]Y');

define('SECURE_AUTH_KEY',  '@s+-tVq{<F%5z[0#gR?,fMu4~] 4no+<J>5tWgk?!^g;LXv2E-W;5IA_qAnv@Gg5');

define('LOGGED_IN_KEY',    '}ABbD> ?&6)v2.RH|VZ.M0Ni;C)13vT4lu~oDnc)&ZJ<6+w+?S]pm/l{h,,<ZZfb');

define('NONCE_KEY',        'O^wJ5&2+&]iCJ<OA&~xn83&|Mgt {RVDo@0I{h-fn{aScdnZ/(o&sQp R-uO(-_e');

define('AUTH_SALT',        'I0<a1|C+:Xlnv#mTA,|.0R|k+8eSeDT2 .byf3(X3-|V<&qdmJ?s83[/D}F@dZVt');

define('SECURE_AUTH_SALT', '[[Bv#ObX.R%^XuqP%n#tQ3FUsXNm66B5+v{p(6,I+w=9$z=27n|y-fyI]9@W-ej7');

define('LOGGED_IN_SALT',   '5;C8ex;$z;JPh4u[++vkw~~#<,ItA !Hz}&T0g+ q^Ax:adY`wL1#BPhc&EgrP<3');

define('NONCE_SALT',       'MN_09LJ&PycZJMaMGl ~v=i+&| Fg>3:d~9X{7M]|rZbG=(,=D.!+)i1i*hFBk}K');



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

