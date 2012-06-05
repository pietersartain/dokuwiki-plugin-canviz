/**
 * Hook the canviz functions into the page to actually get it to display.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Pieter E Sartain <pesartain@googlemail.com
 */

 function canviz_Show(fname,fhash) {
	canviz = new Canviz(fhash);
	canviz.setImagePath('graphs/images/');
	canviz.load(fname);
}