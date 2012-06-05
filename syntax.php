<?php
/**
 * Plugin canviz: allow the use of graphviz syntax directly in wiki pages.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Pieter E Sartain <pesartain@googlemail.com>
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
 
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_canviz extends DokuWiki_Syntax_Plugin {
 
  /**
   * return some info
   */
  function getInfo(){
      return array(
          'author' => 'Pieter E Sartain',
          'email'  => 'pesartain@googlemail.com',
          'date'   => '2009-06-28',
          'name'   => 'Canviz plugin',
          'desc'   => 'Allows graphviz to be directly embedded into wiki pages',
          'url'    => '',
      );
  }

  function getType(){ return 'formatting'; }
  function getAllowedTypes() { return array('formatting', 'disabled'); }   
  function getSort(){ return 195; }

  /**
   * The plugin is called with:
   * <canviz dot>
   *   digraph graphname {
   *      a -> b -> c;
   *      b -> d;
   *   }
   * </canviz>
   * http://www.graphviz.org/About.php
   * http://en.wikipedia.org/wiki/DOT_language
   * It will default to using dot if no renderer is included in the call.
   */
  function connectTo($mode) { $this->Lexer->addEntryPattern('<canviz.*?>(?=.*?\x3C/canviz\x3E)',$mode,'plugin_canviz'); }
  function postConnect() { $this->Lexer->addExitPattern('</canviz>','plugin_canviz'); } 

  /**
   * Handle the match
   */
  function handle($match, $state, $pos, &$handler){
      switch ($state) {
        case DOKU_LEXER_ENTER :		return array($state,substr($match,7,-1));
        case DOKU_LEXER_UNMATCHED :	return array($state, $match);
        case DOKU_LEXER_EXIT :       	return array($state, '');
      }
      return array();
  }
    
  /**
   * Create output
   */
  function render($mode, &$renderer, $data) {
    global $conf;
    global $graphcmd;

    if($mode == 'xhtml') {
      list($state,$match) = $data;
      switch ($state) {
        case DOKU_LEXER_ENTER :
          // This'll return the graphviz renderer (dot, neato, etc)
          $graphcmd = trim($match);
          break;
        case DOKU_LEXER_UNMATCHED :
        	// This is pretty much every thing that's not an opening or closing tag
        	// Which in this case is some graphviz syntax
        	
        	// We can use the fact it should all be returned in the same variable to deal
        	// with the file names, set up the initial div and close it, all without
        	// breaking a sweat.

    			$cmds = array('dot','neato','twopi','circo','fdp');
  				if ( !in_array($graphcmd, $cmds) ) $graphcmd = 'dot';
  	
          if ( !is_dir($conf['mediadir'] . '/auto/graphviz/' . $graphcmd) ) {
				    io_mkdir_p($conf['mediadir'] . '/auto/graphviz/' . $graphcmd);
        	}

    			$hash = md5(serialize($match));
    			$filename = $conf['mediadir'].'/auto/graphviz/'.$graphcmd.'/'.$hash.'.gv.txt';

    			if ( !is_readable($filename) ) {
  					// File does not exist, so let's whip it up ...

  					$tmpfname = $conf['mediadir'].'/auto/graphviz/dokuwiki.graphviz';
    				io_saveFile($tmpfname, $match); //Using dokuwiki framework
    				
    				//debug output
    				//$renderer->doc .= $tmpfname.' + '.$filename.'<br>';
    				// Passing the full path to the engine, and backgrounding the process:
 					  //exec('/opt/local/bin/dot '.$tmpfname.' -Txdot -o '.$filename.'  > /dev/null 2>&1 &');
 					  exec('/usr/local/bin/dot '.$tmpfname.' -Txdot -o '.$filename.' ');
					  //unlink($tmpfname);
    			}

  				$fname = "lib/exe/fetch.php?media=auto:graphviz:dot:".$hash.".gv.txt";
  				
  				$handle = fopen($filename, "r");
  				$contents = fread($handle, filesize($filename));
  				fclose($handle);

          $renderer->doc .= "<div id=\"$hash\" 
          					onclick='javascript:canviz_Show(\"$fname\",\"$hash\")' 
          					>Click here to load</div>
          					
          					<div id=\"debug_output\"></div>
          					
          					";
          break;

        case DOKU_LEXER_EXIT : break;
      } // end switch
      
      // Rendering succeeded 
      return true;
    } // end xhtml

    // Rendering failed
    return false;
  } // end function

}
?>