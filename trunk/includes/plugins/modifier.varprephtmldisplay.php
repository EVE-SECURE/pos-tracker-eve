<?php
/**
 * Smarty modifier to prepare variable for display, preserving some HTML tags
 *
 * This modifier carries out suitable escaping of characters such that when output
 * as part of an HTML page the exact string is displayed, except for a number of
 * admin-defined HTML tags which are left as-is for display purposes.
 *
 * This modifier should be used with great care, as it does allow certain
 * HTML tags to be displayed.
 *
 * The HTML tags that will be displayed are those defined in the configuration
 * variable AllowableHTML , which is set on a per-instance basis by the site administrator.
 *
 * Running this modifier multiple times is cumulative and is not reversible.
 * It recommended that variables that have been returned from this modifier
 * are only used to display the results, and then discarded.
 *
 * Example
 *
 *   <!--[$MyVar|pnvarprephtmldisplay]-->
 *
 *
 * @author       The pnCommerce team
 * @since        16. Sept. 2003
 * @see          modifier.pnvarprepfordisplay.php::smarty_modifier_pnvarprepfordisplay()
 * @param        array    $string     the contents to transform
 * @return       string   the modified output
 */
function smarty_modifier_varprephtmldisplay($string)
{
    global $eve;
    return $eve->VarPrepHTMLDisplay($string);
}

?>