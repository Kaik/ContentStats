{*  $Id: contentstats_admin_view.tpl*}
{pageaddvar name="javascript" value="javascript/helpers/Zikula.itemlist.js"}
{if $content != "" }
<div>
<h2>{gt text="Current statistics" domain='zikula'}</h2>
<ol id="currentlist" class="z-itemlist">
    <li class="z-clearfix z-itemheader">
				<span class="z-itemcell z-w10"><strong>{gt text="ID" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w10"><strong>{gt text="Image" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w22"><strong>{gt text="Name" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w10"><strong>{gt text="Active" domain='zikula'}</strong></span>
    </li>
            {foreach key='citemid' item='currentitems' from=$currentitems} 
<li id="li_currentitemlist_{$citemid}" class="{cycle values='z-odd,z-even'} z-sortable z-clearfix">
<span class="z-itemcell z-w05">{$currentitems.pid|safehtml}</span>
<span class="z-itemcell z-w10"><img src="{$imagespath|safehtml}/{$currentitems.img|safehtml}" /></span>
<span class="z-itemcell z-w22">{$currentitems.name|safehtml}</span>
 <span class="z-itemcell z-w10">
{if $currentitems.active}{pnimg src=greenled.gif modname=core set=icons/extrasmall __alt="Active"}{else}{pnimg src=redled.gif modname=core set=icons/extrasmall __alt="Inactive"}{/if} 
	</span>
            </li>
            {/foreach}
						</ol>
</div>
{/if}
<div>
<h2>{gt text="Reorder and activate or deactivate here" domain='zikula'}</h2>
<ol id="menuitemlist" class="z-itemlist">
    <li class="z-clearfix z-itemheader">
				<span class="z-itemcell z-w10"><strong>{gt text="ID" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w10"><strong>{gt text="Image" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w22"><strong>{gt text="Name" domain='zikula'}</strong></span>
        <span class="z-itemcell z-w10"><strong>{gt text="Active" domain='zikula'}</strong></span>
    </li>
						{foreach key='itemid' item='pendingitems' from=$pendingitems} 
<li id="li_menuitemlist_{$itemid}" class="{cycle values='z-odd,z-even'} z-sortable z-clearfix">

<span class="z-itemcell z-w05">
<input type="text" id="statsitem_{$itemid}_pid" name="statsitem[{$itemid}][pid]" size="5" maxlength="5" value="{$pendingitems.pid|safehtml}" readonly />
</span>
<span class="z-itemcell z-w10"><img src="{$imagespath|safehtml}/{$pendingitems.img|safehtml}" /></span>
<span class="z-itemcell z-w22">{$pendingitems.name|safehtml}</span>
<span class="z-itemcell z-w10">
                <input type="checkbox" id="statsitem_{$itemid}_active" name="statsitem[{$itemid}][active]" {if $pendingitems.active}checked="checked"{/if} value="1" />
	</span>							
		</li>
						{/foreach}
</ol>
</div>
<script type="text/javascript">
    /* <![CDATA[ */
    var list_menuitemlist = null;
    Event.observe(window, 'load', function() {
        list_menuitemlist = new Zikula.itemlist('menuitemlist', {headerpresent: true, firstidiszero: true});
    }, false);
    /* ]]> */
</script>

