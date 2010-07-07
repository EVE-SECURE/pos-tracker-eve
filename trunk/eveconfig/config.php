<?php
/**********************************************************/
/* All Eve-Online logos, images, trademark and related    */
/* material are copyright CCP http://www.ccpgames.com     */
/**********************************************************/

//useless line now
$theme = 'posmanager';

$absolocation = 1;    #Turns absolute tower location on/off

$focus_fuel = 72;     # Bring the fuel level to our attention
$minimal_fuel = 48;   # Minimal fuel that should be kept in the towers at any time
$critical_fuel = 24;  # Critical fuel level

$page_limit = 50; #Sets the number of towers to display on tracking page

$focus_fuel_font_color          = "#E5F212" ; #
$minimal_fuel_font_color        = "#E5F212" ; #
$critical_fuel_text_color       = "#E5F212" ; #
$owner_text_color               = "#FFFFFF" ; #
$edited_text_color              = "#FFFFFF" ; #
$focus_fuel_background_color    = "#053D49" ; #
$minimal_fuel_background_color  = "#770000" ; #
$critical_fuel_background_color = "#FF0000" ; #
$owner_background_color         = "#001642" ; #
$edited_background_color        = "#F13600" ; #

// Done... no need to touch anything else. (Unless you know what you are doing)
// Path for templates and xml files - This only needs to be changed if you
// want the cache to be in another place than 'yoursite/cache'
// Otherwise, leave as is.
$eve_filepath = realpath('cache'); // Remember to chmod it 770

//Uncomment following line to turn on file XML caching, for debug purposes only, needs a writable directory at /cache/api (chmod 770)
//define('POS_CACHE_XML', 'TRUE');

$config['theme']                         = $theme;
$config['filepath']                      = $eve_filepath;
$config['eve_filepath']                  = $eve_filepath;
$config['absolocation']                  = $absolocation;
$config['pagelimit']                     = $page_limit;
$config['minimal_fuel']                  = $minimal_fuel;
$config['critical_fuel']                 = $critical_fuel;
$config['minimal_fuel_font_color']       = $minimal_fuel_font_color;
$config['critical_fuel_text_color']      = $critical_fuel_text_color;
$config['owner_text_color']              = $owner_text_color;
$config['edited_text_color']             = $edited_text_color;
$config['minimal_fuel_background_color'] = $minimal_fuel_background_color;
$config['critical_fuel_background_color']= $critical_fuel_background_color;
$config['owner_background_color']        = $owner_background_color;
$config['edited_background_color']       = $edited_background_color;

$incDir = realpath(dirname(__file__));
$ds = DIRECTORY_SEPARATOR;
$realpath = realpath($incDir . $ds . '../cache');
    if ($realpath && is_dir($realpath))
    {
        define('POS_CACHE_DIR', $realpath . $ds);
    } else
    {
        $mess = 'Nonexistent directory defined for POS_CACHE DIR constant';
        trigger_error($mess, E_USER_ERROR);
    }
    ;

/* $Id: config.php 51 2008-06-30 14:31:03Z eveoneway $ */
?>
