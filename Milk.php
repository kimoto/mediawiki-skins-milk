<?php
/**
 * Example skin
 *
 * This is an example skin showcasing the best practices, a companion to the MediaWiki skinning
 * guide available at <https://www.mediawiki.org/wiki/Manual:Skinning>.
 *
 * The code is released into public domain, which means you can freely copy it, modify and release
 * as your own skin without providing attribution and with absolutely no restrictions. Remember to
 * change the license information if you do not intend to provide your changes on the same terms.
 *
 * @file
 * @ingroup Skins
 * @author ...
 * @license CC0 (public domain) <http://creativecommons.org/publicdomain/zero/1.0/>
 */

$wgExtensionCredits['skin'][] = array(
    'path' => __FILE__,
    'name' => 'Milk',
    'namemsg' => 'milk',
    'version' => '1.0',
    'url' => 'http://kymt.me/wiki',
    'author' => 'kimoto',
    'descriptionmsg' => 'milk skin',
    // When modifying this skin, remember to change the license information if you do not want to
    // waive all of your rights to your work!
    'license' => 'CC0',
);

require_once(__DIR__ . "/CologneBlue.php");

$wgValidSkinNames['milk'] = 'Milk';

$wgAutoloadClasses['SkinMilk'] = __DIR__ . '/Milk.skin.php';
$wgMessagesDirs['Milk'] = __DIR__ . '/i18n';

$wgResourceModules['skins.milk'] = array(
    'styles' => array(
        'Milk/resources/screen.css' => array( 'media' => 'screen' ),
        'Milk/resources/print.css' => array( 'media' => 'print' ),
    ),
    'remoteBasePath' => &$GLOBALS['wgStylePath'],
    'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);

