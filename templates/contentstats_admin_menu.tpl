{*  $Id: pendingcontent_admin_menu.tpl  *}
{admincategorymenu}
<div class="z-adminbox">
    <h1>{gt text="Pending Content"}</h1>
    <div class="z-menu">
        {* call the plugin to display the admin links based on the user's permission *}
        {moduleadminlinks modname=ContentStats}
    </div>
</div>
