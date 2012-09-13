<?php

/**
 * ContentStats version information and other metadata.
 */
class ContentStats_Version extends Zikula_AbstractVersion
{
    /**
     * Provides an array of standard Zikula Extension metadata.
     * 
     * @return array Zikula Extension metadata.
     */
    public function getMetaData()
    {
        return array(
            'displayname'   => $this->__('ContentStats'),
            'description'   => $this->__('Display content statistics.'),
            'url'           => $this->__('ContentStats'),
            'version'       => '1.3.0',
            'core_min'      => '1.3.0', // Fixed to 1.3.x range
            'core_max'      => '1.3.99', // Fixed to 1.3.x range
            'securityschema'=> array('ContentStats::'  => '::')
        );
    }

}

