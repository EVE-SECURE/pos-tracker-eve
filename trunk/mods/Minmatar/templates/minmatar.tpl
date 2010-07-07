<!--[*include file='header.tpl'*]-->
<!--[* $Id: minmatar.tpl 165 2008-09-19 17:11:44Z eveoneway $ *]-->


<!--[if $mintowers]-->
  <table class="mcenter">
  <!--[foreach item='tower' from=$mintowers]-->
    <tr>
      <td><!--[$tower.pos_id]--></td>
      <td><!--[$tower.corp]--></td>
      <td><!--[$tower.towerName]--></td>
      <td><!--[$tower.systemID]--></td>
    </tr>
  <!--[/foreach]-->
  </table>
<!--[/if]-->


<!--[*include file='footer.tpl'*]-->