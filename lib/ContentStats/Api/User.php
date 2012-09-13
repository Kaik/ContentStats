<?php
/**
 * $Id$
 *
 * ContentStats - for Zikula
 *
 */
class ContentStats_Api_User extends Zikula_AbstractApi {
  
     
    public function getall($args)
    {
        // Optional arguments.
        if (!isset($args['startnum']) || !is_numeric($args['startnum'])) {
            $args['startnum'] = 1;
        }
        if (!isset($args['numitems']) || !is_numeric($args['numitems'])) {
            $args['numitems'] = -1;
        }
    
        $items = array();
    
        // Security check
        if (!SecurityUtil::checkPermission('ContentStats::', '::', ACCESS_READ)) {
            return $items;
        }
    
        // define the permission filter to apply
        $permFilter = array(array('realm'          => 0,
                                  'component_left' => 'ContentStats',
                                  'instance_left'  => 'name',
                                  'instance_right' => 'pid',
                                  'level'          => ACCESS_READ));
    
        // get the objects from the db
        $items = DBUtil::selectObjectArray('contentstats', '', 'pid', $args['startnum']-1, $args['numitems'], '', $permFilter);
        if ($items === false) {
            return LogUtil::registerError ($this->__('Error! Could not load items.'));
        }
    
        // Return the items
        return $items;
    }
    
    /**
     * get a specific item
     * @param $args['pid'] id of pending item to get
     * @return mixed item array, or false on failure
     */
    public function get($args)
    {
   
        // Argument check
        if (!isset($args['pid'])) {
            return LogUtil::registerArgsError();
        }
    
        // define the permission filter to apply
        $permFilter = array(array('realm'          => 0,
                                  'component_left' => 'ContentStats',
                                  'instance_left'  => 'name',
                                  'instance_right' => 'pid',
                                  'level'          => ACCESS_READ));
    
        return DBUtil::selectObjectByID('contentstats', $args['pid'], 'pid', '', $permFilter);
    }
    
    /**
     * utility function to count the number of items held by this module
     * @return integer number of items held by this module
     */
    public function countitems()
    {
        return DBUtil::selectObjectCount('contentstats', '');
    }


    public function getstats($vars)
    {
     
     // define the permissions filter to use
        $permFilter = array();
        $permFilter[] = array('realm'            => 0,
                              'component_left'   => 'ContentStats',
                              'component_middle' => '',
                              'component_right'  => '',
                              'instance_left'    => 'name',
                              'instance_middle'  => '',
                              'instance_right'   => 'pid',
                              'level'            => ACCESS_READ);
    
            
         $currentitems = array();
         foreach ($vars['items'] as $citem => $citemx) {
         if ($citemx['active'] == 1){
         $xitems = DBUtil::selectObjectByID('contentstats', $citemx['pid'], 'pid', '', $permFilter);
            // remove empty keys 
            if (isset($xitems)){
            $currentitems[] = $xitems;
            }
         }           
         }
            
        // Display each item, permissions permitting
        foreach ($currentitems as $k=>$pd) {
            $res = DBUtil::executeSql ($pd['sql']);
            $number = DBUtil::marshallFieldArray($res);
            unset($currentitems[$k]['pid']);
            unset($currentitems[$k]['sql']);
            $currentitems[$k]['number'] = $number['0'];
    
        }   

      
        return $currentitems;        
    }

}