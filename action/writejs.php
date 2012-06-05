<?php
/**
 * Add the canviz javascript headers into the page.
 * Adapted from the example action plugin by Samuele Tognini <samuele@cli.di.unipi.it>
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Pieter E Sartain <pesartain@googlemail.com
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
 
class action_plugin_canviz_writejs extends DokuWiki_Action_Plugin {
 
  /**
   * return some info
   */
  function getInfo(){
    return array(
		 'author' => 'Pieter E Sartain',
		 'email'  => 'pesartain@googlemail.com',
		 'date'   => '2009-06-28',
		 'name'   => 'Canviz (action plugin component)',
		 'desc'   => 'Canviz action functions.',
		 'url'    => '',
		 );
  }
 
  /**
   * Register its handlers with the DokuWiki's event controller
   */
  function register(&$controller) {
    $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE',  $this, '_hookjs');
  }
 
  /**
   * Hook js script into page headers.
   */
  function _hookjs(&$event, $param) {
	$event->data["script"][] = array ("type" => "text/javascript","charset" => "utf-8","_data" => "",
					                  "src" => DOKU_BASE."lib/plugins/canviz/canviz/prototype/prototype.js");
	$event->data["script"][] = array ("type" => "text/javascript","charset" => "utf-8","_data" => "",
					                  "src" => DOKU_BASE."lib/plugins/canviz/canviz/path/path.js");					                  
	$event->data["script"][] = array ("type" => "text/javascript","charset" => "utf-8","_data" => "",
					                  "src" => DOKU_BASE."lib/plugins/canviz/canviz/canviz.js");					                  
	$event->data["script"][] = array ("type" => "text/javascript","charset" => "utf-8","_data" => "",
					                  "src" => DOKU_BASE."lib/plugins/canviz/canviz/x11colors.js");
/*
	$event->data["script"][] = array ("type" => "text/javascript","charset" => "utf-8",
									  "_data" => "
									  
	function canviz_Show(fname,hash) {
	canviz = new Canviz(hash);
	canviz.load(fname);
	}
	");
*/
  }
}