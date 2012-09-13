<?php

/**
 * ContentStats module installer.
 */
class ContentStats_Installer extends Zikula_AbstractInstaller
{
    /**
     * Initialise the ContentStats  module.
     *
     * @return boolean True on success or false on failure.
     */
    public function install()
    {
        if (!DBUtil::createTable('contentstats')) {
            return false;
        }
        
        $this->setVar('itemsperpage', '10');
        return true;
    }

    /**
     * Upgrade the ContentStats module from an old version.
     * 
     * @param string $oldversion The version from which the upgrade is beginning (the currently installed version); this should be compatible 
     *                              with {@link version_compare()}.
     * 
     * @return boolean True on success or false on failure.
     */
    public function upgrade($oldversion)
    {

        // Update successful
        return true;
    }

    /**
     * Delete the ContentStats module.
     *
     * @return boolean True on success or false on failure.
     */
    public function uninstall()
    {
       
       if (!DBUtil::dropTable('contentstats')) {
            return false;
        }
       
       $this->delVars('ContentStats');
        // Deletion successful
        return true;
    }  
        
}