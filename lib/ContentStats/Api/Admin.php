<?php
/**
 * $Id$
 *
 * ContentStats -  for Zikula
 *
 */

class ContentStats_Api_Admin extends Zikula_AbstractApi
{
    public function create($args)
    {
  
        // Argument check
        if ((!isset($args['name'])) ||
            (!isset($args['url'])) ||
    		(!isset($args['img'])) ||
            (!isset($args['sql']))) {
            return LogUtil::registerArgsError();
        }
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$args[name]::", ACCESS_ADD)) {
            return LogUtil::registerPermissionError();
        }
    
        $item = array('name' => $args['name'],
                      'url' => $args['url'],
                      'img' => $args['img'],
                      'sql' => $args['sql']);
    
        if (!DBUtil::insertObject($item, 'contentstats', 'pid')) {
            return LogUtil::registerError ($this->__('Error! Creation attempt failed.'));
        }
    
        // Return the id of the newly created item to the calling process
        return $item['pid'];
    }
    
    /**
     * delete a pending item
     * @param $args['pid'] ID of the item
     * @return bool true on success, false on failure
     */
    public function delete($args)
    {
        // Argument check
        if (!isset($args['pid'])) {
            return LogUtil::registerArgsError();
        }
    
        // Get the item
        $item = ModUtil::apiFunc('ContentStats', 'user', 'get', array('pid' => $args['pid']));
        if ($item == false) {
            return LogUtil::registerError ($this->__('Element not found'));
        }
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$item[name]::$args[pid]", ACCESS_DELETE)) {
            return LogUtil::registerPermissionError();
        }
    
        if (!DBUtil::deleteObjectByID('contentstats', $args['pid'], 'pid')) {
            return LogUtil::registerError ($this->__('Error! Deletion attempt failed.'));
        }

        // Let the calling process know that we have finished successfully
        return true;
    }
    
    /**
     * update a pending item
     * @param $args['pid'] the ID of the item
     * @param $args['name'] the new name of the item
     * @param $args['number'] the new number of the item
     */
    public function update($args)
    {
        // Argument check
        if ((!isset($args['pid'])) ||
            (!isset($args['name'])) ||
            (!isset($args['sql'])) ||
    		(!isset($args['img'])) ||
            (!isset($args['url']))) {
            return LogUtil::registerArgsError();
        }
    
        // Get the item
        $item = ModUtil::apiFunc('ContentStats', 'user', 'get', array('pid' => $args['pid']));
        if ($item == false) {
            return LogUtil::registerError ($this->__('Element not found'));
        }
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$item[name]::$args[pid]", ACCESS_EDIT)) {
            return LogUtil::registerPermissionError();
        }
        if (!SecurityUtil::checkPermission('ContentStats::Item', "$args[name]::$args[pid]", ACCESS_EDIT)) {
            return LogUtil::registerPermissionError();
        }
    
        $item = array('pid'  => $args['pid'],
                      'name' => $args['name'],
                      'url'  => $args['url'],
                      'img'  => $args['img'],
                      'sql'  => $args['sql']);
    
        if (!DBUtil::updateObject($item, 'contentstats', '', 'pid')) {
            return LogUtil::registerError ($this->__('Error! Update attempt failed.'));
        }
    
        return true;
    }


    /**
     * get available admin panel links
     *
     * @return array array of admin links
     */
    public function getlinks()
    {
        $links = array();
        if (SecurityUtil::checkPermission('ContentStats::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('ContentStats', 'admin', 'view'),
                'text' => $this->__('Show all elements'),
                'class' => 'z-icon-es-info'
            );
            $links[] = array(
                'url' => ModUtil::url('ContentStats', 'admin', 'newitem'),
                'text' => $this->__('Create element'),
                'class' => 'z-icon-es-gears'
            );
            $links[] = array(
                'url' => ModUtil::url('ContentStats', 'admin', 'modifyconfig'),
                'text' => $this->__('Settings'),
                'class' => 'z-icon-es-config'
            );
        }
        return $links;
    }

}
