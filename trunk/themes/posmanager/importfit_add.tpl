<!--[include file='header.tpl']-->
Adding:<br>
<!--[foreach item='structure' from=$structures]-->
<!--[$structure.typeName]--><br>
<!--[/foreach]-->
<a class="arialwhite14 txtunderlined" href="viewpos.php?i=<!--[$pos_id]-->" title="Done">Done</a>
<!--[include file='footer.tpl']-->