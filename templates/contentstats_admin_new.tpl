{*  $Id: contentstats_admin_new.tpl  *}
{gt text="Add element" assign=templatetitle}
{include file="contentstats_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=filenew.gif set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <form class="z-form" action="{modurl modname="contentstats" type="admin" func="create"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="authid" value="{insert name="generateauthkey" module="contentstats"}" />
            <fieldset>
                <legend>{$templatetitle}</legend>
                <div class="z-formrow">
                    <label for="contentstats_name">{gt text="Name"}</label>
                    <input id="contentstats_name" name="contentstats[name]" type="text" size="32" maxlength="255" />
                </div>
                <div class="z-formrow">
                    <label for="contentstats_url">{gt text="URL"}</label>
                    <input id="contentstats_url" name="contentstats[url]" type="text" size="50" maxlength="255" />
                </div>
                <div class="z-formrow">
                    <label for="contentstats_sql">{gt text="SQL Command"}</label>
                    <input id="contentstats_sql" name="contentstats[sql]" type="text" size="50" maxlength="255" />
                </div>
								 <div class="z-formrow">
                    <label for="contentstats_img">{gt text="Image"}</label>
                    <input id="contentstats_img" name="contentstats[img]" type="text" size="32" maxlength="255" />
                </div>
            </fieldset>

            <div class="z-buttons">
                {button src=button_ok.gif set=icons/small __alt="Save" __title="Save"}
                <a href="{modurl modname=contentstats type=admin func=view}">{img modname=core src=button_cancel.gif set=icons/small __alt="Cancel" __title="Cancel"}</a>
            </div>
        </div>
    </form>
</div>
