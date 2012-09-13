{*  $Id: contentstats_admin_modifyconfig.tpl  *}
{gt text="Settings" assign=templatetitle}
{include file="contentstats_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=configure.gif set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <form class="z-form" action="{modurl modname="contentstats" type="admin" func="updateconfig"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{insert name="generateauthkey" module="contentstats"}" />
            <fieldset>
                <legend>{$templatetitle}</legend>
                <div class="z-formrow">
                    <label for="contentstats_itemsperpage">{gt text="Items per page"}</label>
                    <input id="contentstats_itemsperpage" type="text" name="itemsperpage" size="3" value="{$itemsperpage|safehtml}" />
										  <label for="contentstats_imagespath">{gt text="Images Path"}</label>
                    <input id="contentstats_imagespath" type="text" name="imagespath" size="32" value="{$imagespath|safehtml}" />
                </div>
            </fieldset>
            {* modcallhooks hookobject=module hookaction=modifyconfig module=contentstats *}
            <div class="z-formbuttons">
                {button src=button_ok.gif set=icons/small __alt="Update Configuration" __title="Update Configuration"}
                <a href="{modurl modname=contentstats type=admin func=view}">{img modname=core src=button_cancel.gif set=icons/small __alt="Cancel" __title="Cancel"}</a>
            </div>
        </div>
    </form>
</div>
