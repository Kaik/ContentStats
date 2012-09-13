{*  $Id: contentstats_admin_view.tpl  *}
{gt text="Show all elements" assign=templatetitle}
{include file="contentstats_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname=core src=windowlist.gif set=icons/large alt=$templatetitle}</div>
    <h2>{$templatetitle}</h2>
    <table class="z-admintable">
        <thead>
            <tr>
                <th>{gt text="Name"}</th>
                <th>{gt text="URL"}</th>
                <th>{gt text="SQL Command"}</th>
				<th>{gt text="Image"}</th>
                <th>{gt text="Options"}</th>
            </tr>
        </thead>
        <tbody>
            {section name="pendingitems" loop=$pendingitems}
            <tr class="{cycle values="z-odd,z-even"}">
                <td>{$pendingitems[pendingitems].name|safehtml}</td>
                <td>{$pendingitems[pendingitems].url|safehtml}</td>
                <td>{$pendingitems[pendingitems].sql|safehtml}</td>
								<td><img src="{$imagespath|safehtml}/{$pendingitems[pendingitems].img|safehtml}" /></td>
                <td>
                    {assign var="options" value=$pendingitems[pendingitems].options}
                    {section name=options loop=$options}
                    <a href="{$options[options].url|pnvarprepfordisplay}">{img modname=core set=icons/extrasmall src=$options[options].image title=$options[options].title alt=$options[options].title}</a>
                    {/section}
                </td>
            </tr>
            {sectionelse}
            <tr class="z-admintableempty"><td colspan="4">{gt text="No items found."}</td></tr>
            {/section}
        </tbody>
    </table>
    {pager show="page" rowcount=$pager.numitems limit=$pager.itemsperpage posvar=startnum shift=1}
</div>
