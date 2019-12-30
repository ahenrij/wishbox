<?php
/**
 * Created by TheFather <ahenrij@gmail.com>.
 * User: HD
 * Date: 23/12/2019
 * Time: 19:25
 */

define('VISIBILITY_PRIVATE', 'private');
define('VISIBILITY_PUBLIC', 'public');
define('VISIBILITY_PROTECTED', 'protected');

$visibilities = array(
    VISIBILITY_PRIVATE => 'Moi uniquement',
    VISIBILITY_PUBLIC => 'Tout le monde',
    VISIBILITY_PROTECTED => 'Mes amis'
);

define('TYPE_WISH', 'wish');
define('TYPE_GIFT', 'gift');

$wish_types = array(
    TYPE_GIFT, TYPE_WISH
);

$wish_priorities = array(
    'top' => 'Important'
);

define('visibilities', $visibilities);
define('wish_types', $wish_types);
define('wish_priorities', $wish_priorities);

define('PROFILE_INFO_TEMPLATE', 'users.profile_infos');
define('PROFILE_EDIT_FORM', 'users.edit');

function routeBaseName() {
    return explode('.', Route::currentRouteName())[0];
}
