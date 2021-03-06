<?php
/**
 * $Id$
 *
 * ContentStats - for Zikula
 *
 */

class ContentStats_Block_Stats extends Zikula_Controller_AbstractBlock
{
    /**
     * Initialise block.
     */
    public function init()
    {
        SecurityUtil::registerPermissionSchema('ContentStats:statsblock:', 'Block title::');
    }  /**
     * Get information on block.
     */
    public function info()
    {
        return array (
            'module'         => 'ContentStats',
            'text_type'      => $this->__('Stats Content'),
            'text_type_long' => $this->__('Stats Block'),
            'allow_multiple' => true,
            'form_content'   => false,
            'form_refresh'   => false,
            'show_preview'   => true
        );
    } 
    /**
     * display block
     *
     */
    public function display($blockinfo)
    {
        // Check if the module is available.
        if (!ModUtil::available('ContentStats')) {
            return false;
        }
        
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats:statsblock:', "$blockinfo[title]::", ACCESS_READ)) {
            return;
        }

        // Get variables from content block
        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        $currentitems = ModUtil::apiFunc('ContentStats', 'user', 'getstats', $vars);
        
        // assign the pending content
        $this->view->assign('statsitems', $currentitems);
        $this->view->assign('numPendingItems', count($currentitems));
    	$this->view->assign('imagespath', ModUtil::getVar('ContentStats','imagespath'));
    
        $blockinfo['content'] = $this->view->fetch('contentstats_block_stats.tpl');

        return BlockUtil::themeBlock($blockinfo);
    }
    
    /**
     * modify block settings
     */
    public function modify($blockinfo)
    {
    	$vars = BlockUtil::varsFromContent($blockinfo['content']);
        $blockinfo['content'] = '';
    		
    	// Get currentitems order
    	$currentitems = array();
        
        if (isset($vars['items']))
        {
    		foreach ($vars['items'] as $citem => $citemx) {
    			$currentitems[$citem] = ModUtil::apiFunc('ContentStats', 'user', 'get', $citemx['pid']);
    			$currentitems[$citem]['active'] = $citemx['active'];
        }
        }	
    		// Get the all items
        $items = ModUtil::apiFunc('ContentStats', 'user', 'getall');
    		
    	$pendingitems = array();
        foreach ($items as $item) {
            if (SecurityUtil::checkPermission('ContentStats::', "$item[name]::$item[pid]", ACCESS_READ)) {
                $pendingitems[] = $item;
            }
        }
    	
        
        // Create output object
        $this->view->setCaching(false);

    	// assign the items to the array
        $this->view->assign('pendingitems', $pendingitems);
    	$this->view->assign('currentitems', $currentitems);
    	$this->view->assign('varss', $vars);
    	$this->view->assign('imagespath', ModUtil::getVar('ContentStats','imagespath'));
    
       
    
        // Return the output that has been generated by this function
        return $this->view->fetch('contentstats_block_stats_modify.tpl');
    
    }
    
    /**
     * update block settings
     */
    public function update($blockinfo)
    {
        $vars = BlockUtil::varsFromContent($blockinfo['content']);    
        $vars['items'] = FormUtil::getPassedValue('statsitem');
        $blockinfo['content'] = BlockUtil::varsToContent($vars);
        return $blockinfo;
    }
}