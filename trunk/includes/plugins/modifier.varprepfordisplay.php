<?php

/**
 * Smarty modifier to prepare a variable for display
 *
 * This modifier carries out suitable escaping of characters such that when
 * output as part of an HTML page the exact string is displayed.
 *
 * Running this modifier multiple times is cumulative and is not reversible.
 * It recommended that variables that have been returned from this modifier
 * are only used to display the results, and then discarded.
 *
 * Example
 *
 *   <!--[$MyVar|pnvarprepfordisplay]-->
 *
 *
 * @author       The pnCommerce team
 * @since        16. Sept. 2003
 * @see          modifier.pnvarprephtmldisplay.php::smarty_modifier_DataUtil::formatForDisplayHTML()
 * @param        array    $string     the contents to transform
 * @return       string   the modified output
 */
function smarty_modifier_varprepfordisplay ($string)
{
    global $eve;
    return $eve->VarPrepForDisplay($string);
}

?>