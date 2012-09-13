{*  $Id: contentstats_admin_modify.tpl  *}
{gt text="Edit element" assign=templatetitle}
{include file="contentstats_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=edit.gif set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <form class="z-form" action="{modurl modname="contentstats" type="admin" func="update"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{insert name="generateauthkey" module="contentstats"}" />
            <input type="hidden" name="contentstats[pid]" value="{$item.pid}" />
            <fieldset>
                <legend>{$templatetitle}</legend>
                <div class="z-formrow">
                    <label for="contentstats_name">{gt text="Name"}</label>
                    <input id="contentstats_name" name="contentstats[name]" type="text" size="32" maxlength="255" value="{$item.name|safehtml}" />
                </div>
                <div class="z-formrow">
                    <label for="contentstats_url">{gt text="URL"}</label>
                    <input id="contentstats_url" name="contentstats[url]" type="text" size="50" maxlength="255" value="{$item.url|safehtml}" />
                </div>
                <div class="z-formrow">
                    <label for="contentstats_sql">{gt text="SQL Command"}</label>
                    <input id="contentstats_sql" name="contentstats[sql]" type="text" size="50" maxlength="255" value="{$item.sql|safehtml}" />
                </div>
								  <div class="z-formrow">
                    <label for="contentstats_img">{gt text="Image"}</label>
                    <input id="contentstats_img" name="contentstats[img]" type="text" size="32" maxlength="255" value="{$item.img|safehtml}" />
                </div>
            </fieldset>
            {* pnmodcallhooks hookobject=item hookaction=modify hookid=$pid module=contentstats *}
            <div class="z-formbuttons">
                {button src=button_ok.gif set=icons/small __alt="Update element" __title="Update element"}
                <a href="{modurl modname=contentstats type=admin func=view}">{img modname=core src=button_cancel.gif set=icons/small __alt="Cancel" __title="Cancel"}</a>
            </div>
        </div>
    </form>
</div>
