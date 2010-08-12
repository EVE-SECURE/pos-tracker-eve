<!--[include file='header.tpl']-->
Adding:<br>
<!--[foreach item='structure' from=$structures]-->
<!--[$structure.typeName]--><br>
<!--[/foreach]-->
<a href="viewpos.php?i=<!--[$pos_id]-->" title="Done">Done</a>
<!--[include file='footer.tpl']-->