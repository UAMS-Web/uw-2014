<?php

/*
 * This is the object that holds all the UAMS shortcodes
 * Shortcodes are how we get functionality in content for power users
 */

class UAMS_Shortcodes
{
    function __construct()
    {
        $this->includes();
        $this->initialize();
    }

    private function includes()
    {
        require_once('class.tile-box-shortcode.php');
        require_once('class.button-shortcode.php');
        require_once('class.youtube-shortcode.php');
        require_once('class.subpage-list-shortcode.php');
        require_once('class.accordion-shortcode.php');
        require_once('class.maps-shortcode.php');
      //  require_once('class.tiny-shortcode.php');
        require_once('class.tabs-shortcode.php');
        require_once('class.grid-shortcode.php');
        require_once('class.menu-shortcode.php');
    }

    private function initialize()
    {
        $this->tile_box       = new TileBox();
        $this->button         = new UAMS_Button();
        $this->youtube        = new UAMS_YouTube();
        $this->subpage_list   = new UAMS_SubpageList();
        $this->accordion      = new UAMS_AccordionShortcode();
        $this->maps           = new UAMS_Map();
      //  $this->tiny           = new UAMS_TinyShortcode();
        $this->tabs           = new UAMS_TabsShortcode();
        $this->bootstrap      = new UAMS_GridShortcode();
        $this->custommenu     = new UAMS_MenuShortcode();
    }
}
