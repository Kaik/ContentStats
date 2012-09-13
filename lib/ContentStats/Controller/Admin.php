<?php
/**
 * $Id$
 *
 * ContentStats - an advanced private messaging solution for Zikula
 *
 */
class ContentStats_Controller_Admin extends Zikula_AbstractController
{
    public function postInitialize()
    {
        $this->view->setCaching(false);
    } 
  
    public function main()
    {
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', '::', ACCESS_EDIT)) {
            return LogUtil::registerPermissionError(System::getHomepageUrl());
        }

        // Return the output that has been generated by this function
        return $this->view->fetch('contentstats_admin_main.tpl');    
     }

    /**
     * add new item
     */
    public function newitem()
    {
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', '::', ACCESS_ADD)) {
            return LogUtil::registerPermissionError(System::getHomepageUrl());
        }

        // Return the output that has been generated by this function
        return $this->view->fetch('contentstats_admin_new.tpl');  
     }

    /**
     * Create item
     */
    public function create($args)
    {
        // Get parameters from whatever input we need
        $contentstats = FormUtil::getPassedValue('contentstats', isset($args['contentstats']) ? $args['contentstats'] : null, 'POST');
    
        // Confirm authorisation code
        if (!SecurityUtil::confirmAuthKey()) {
            return LogUtil::registerAuthidError (ModUtil::url('ContentStats', 'admin', 'view'));
        }
    
        // Notable by its absence there is no security check here
    
        // Create the new item
        $pid = ModUtil::apiFunc('ContentStats', 'admin', 'create',
                            array('name' => $contentstats['name'],
                                  'sql'  => $contentstats['sql'],
                                  'url'  => $contentstats['url'],
    							  'img'  => $contentstats['img']));
    
        // The return value of the function is checked
        if ($pid != false) {
            // Success
            LogUtil::registerStatus ($this->__('Element created'));
        }
    
        return System::redirect(ModUtil::url('ContentStats', 'admin', 'view'));
    }

    /**
     * modify an item
     */
    public function modify($args)
    {
        
        // Get parameters from whatever input we need
        $pid = FormUtil::getPassedValue('pid', isset($args['pid']) ? $args['pid'] : null, 'GET');
        $objectid = FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'GET');
    
        if (!empty($objectid)) {
            $pid = $objectid;
        }
    
    
        // Get the item
        $item = ModUtil::apiFunc('ContentStats', 'user', 'get', array('pid' => $pid));
        if ($item == false) {
            return LogUtil::registerError ($this->__('No such item found.'), 404);
        }
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$item[name]::$pid", ACCESS_EDIT)) {
            return LogUtil::registerPermissionError();
        }
    
        $this->view->assign('item', $item);
    
        return $this->view->fetch('contentstats_admin_modify.tpl');
    }

    /**
     * Update item
     *
     */
    public function update($args)
    {
        // Get parameters from whatever input we need
        $contentstats = FormUtil::getPassedValue('contentstats', isset($args['contentstats']) ? $args['contentstats'] : null, 'POST');
        if (!empty($contentstats['objectid'])) {
            $contentstats['pid'] = $contentstats['objectid'];
        }
    
        // Confirm authorisation code
        if (!SecurityUtil::confirmAuthKey()) {
            return LogUtil::registerAuthidError (ModUtil::url('ContentStats', 'admin', 'view'));
        }
    
        // Notable by its absence there is no security check here
    
        // Update the item
        if (ModUtil::apiFunc('ContentStats', 'admin', 'update',
                         array('pid' => $contentstats['pid'],
                               'name' => $contentstats['name'],
                               'sql' => $contentstats['sql'],
                               'url' => $contentstats['url'],
    						   'img' => $contentstats['img']))) {
            // Success
            LogUtil::registerStatus ($this->__('Element updated'));
        }
    
        return System::redirect(ModUtil::url('ContentStats', 'admin', 'view'));
    }

    /**
     * delete item
     *
     * @param 'pid' the id of the item to be deleted
     * @param 'confirmation' confirmation that this item can be deleted
     */
    public function delete($args)
    {
    
        $pid = FormUtil::getPassedValue('pid', isset($args['pid']) ? $args['pid'] : null, 'REQUEST');
        $objectid = FormUtil::getPassedValue('objectid', isset($args['objectid']) ? $args['objectid'] : null, 'REQUEST');
        $confirmation = FormUtil::getPassedValue('confirmation', null, 'POST');
        if (!empty($objectid)) {
            $pid = $objectid;
        }
    
        // Get the item
        $item = ModUtil::apiFunc('ContentStats', 'user', 'get', array('pid' => $pid));
        if ($item == false) {
            return LogUtil::registerError ($this->__('No such item found.'), 404);
        }
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$item[name]::$pid", ACCESS_DELETE)) {
            return LogUtil::registerPermissionError();
        }
    
        // Check for confirmation.
        if (empty($confirmation)) {
            // No confirmation yet

            // Add a hidden field for the item ID to the output
            $this->view->assign('pid', $pid);
    
            // Return the output that has been generated by this function
            return $this->view->fetch('contentstats_admin_delete.tpl');
    
        }
    
        // If we get here it means that the user has confirmed the action
    
        // Confirm authorisation code
        if (!SecurityUtil::confirmAuthKey()) {
            return LogUtil::registerAuthidError (ModUtil::url('ContentStats', 'admin', 'view'));
        }
    
        // Delete item
        if (ModUtil::apiFunc('ContentStats', 'admin', 'delete',
                         array('pid' => $pid))) {
            // Success
            LogUtil::registerStatus ($this->__('Element deleted'));
        }
    
        return System::redirect(ModUtil::url('ContentStats', 'admin', 'view'));
    }

    /**
     * view items
     */
    public function view()
    {

       // Security Check
        if (!SecurityUtil::checkPermission('ContentStats::', '::', ACCESS_EDIT)) {
            return LogUtil::registerPermissionError();
        }
    
        $startnum = FormUtil::getPassedValue('startnum', isset($args['startnum']) ? $args['startnum'] : null, 'GET');
           
        // Get the matching items
        $items = ModUtil::apiFunc('ContentStats', 'user', 'getall',
                              array('startnum' => $startnum,
                                    'numitems' => ModUtil::getVar('ContentStats','itemsperpage')));
    
        // loop through each item to build the avialable options
        $pendingitems = array();
        foreach ($items as $item) {
            if (SecurityUtil::checkPermission('ContentStats::', "$item[name]::$item[pid]", ACCESS_READ)) {
    
                // Options for the item
                $options = array();
                if (SecurityUtil::checkPermission('ContentStats::', "$item[name]::$item[pid]", ACCESS_EDIT)) {
                    $options[] = array('url' => ModUtil::url('ContentStats', 'admin', 'modify', array('pid' => $item['pid'])),
                                       'image' => 'xedit.gif',
                                       'title' => __('Edit', $dom));
                    if (SecurityUtil::checkPermission('ContentStats::', "$item[name]::$item[pid]", ACCESS_DELETE)) {
                        $options[] = array('url' => ModUtil::url('ContentStats', 'admin', 'delete', array('pid' => $item['pid'])),
                                           'image' => '14_layer_deletelayer.gif',
                                           'title' => __('Delete', $dom));
                    }
                }
                $item['options'] = $options;
                $pendingitems[] = $item;
            }
        }
    
        // assign the items to the array
        $this->view->assign('pendingitems', $pendingitems);
        $this->view->assign('imagespath', ModUtil::getVar('ContentStats','imagespath'));
    
        // assign the values for the smarty plugin to produce a pager
        $this->view->assign('pager', array('numitems' => ModUtil::apiFunc('ContentStats', 'user', 'countitems'),
                                         'itemsperpage' => ModUtil::getVar('ContentStats','itemsperpage')));
    
        // Return the output that has been generated by this function
        return $this->view->fetch('contentstats_admin_view.tpl');
    }
    
    
    /**
     * This is a standard function to modify the configuration parameters of the
     * module
     */
    public function modifyconfig()
    {
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
        }
        
        // assign the module vars
        $this->view->assign(ModUtil::getVar('ContentStats'));
    
        // Return the output that has been generated by this function
        return $this->view->fetch('contentstats_admin_modifyconfig.tpl');
    }
    
    /**
     * This is a standard function to update the configuration parameters of the
     * module given the information passed back by the modification form
     */
    public function updateconfig()
    {
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::', '::', ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
        }
    
        // Confirm authorisation code
        if (!SecurityUtil::confirmAuthKey()) {
            return LogUtil::registerAuthidError (ModUtil::url('ContentStats', 'admin', 'view'));
        }
    
        // Update module variables
        $itemsperpage = FormUtil::getPassedValue('itemsperpage', 10, 'POST');
        ModUtil::setVar('ContentStats', 'itemsperpage', $itemsperpage);
    		
    		// Update module variables
        $imagespath = FormUtil::getPassedValue('imagespath', 'images/icons/extrasmall' , 'POST');
        ModUtil::setVar('ContentStats', 'imagespath', $imagespath);
    
    
        // the module configuration has been updated successfuly
        LogUtil::registerStatus ($this->__('Done! Module configuration updated.'));
    
        return System::redirect(ModUtil::url('ContentStats', 'admin', 'view'));
    }

}
