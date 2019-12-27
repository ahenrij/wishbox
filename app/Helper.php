<?php
/**
 * Created by TheFather <ahenrij@gmail.com>.
 * User: HD
 * Date: 23/12/2019
 * Time: 19:25
 */

$visibilities = array(
    'private' => 'Moi uniquement',
    'public' => 'Tout le monde',
    'protected' => 'Mes amis'
);

$wish_types = array(
    'gift', 'wish'
);

$wish_priorities = array(
    'top' => 'Important'
);

define('visibilities', $visibilities);
define('wish_types', $wish_types);
define('wish_priorities', $wish_priorities);

function routeBaseName() {
    return explode('.', Route::currentRouteName())[0];
}