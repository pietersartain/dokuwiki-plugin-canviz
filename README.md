# Canviz Demo for Dokuwiki

This is a demonstration of how you could create a plugin to leverage canviz for your dokuwiki installation.

I never had a real need, so I never finished it. I'm releasing it now as a tech demo. Obvious improvements/todos include:

* Configuration settings for the graphviz binaries 

## Prerequisites

* Access to PHP's exec() function
* [Graphviz][graphviz] installed on your webserver
* A copy of [Canviz][canviz]

## Installation

* Clone this repo or otherwise unpack this plugin into your dokuwiki plugins directory. It should be called "canviz".
* Copy [Canviz][canviz]

## Usage

The plugin is embedded like:

`<canviz dot>
   digraph graphname {
      a -> b -> c;
      b -> d;
   }
</canviz>`

It will default to using dot if no renderer is included in the call.

## References

[Dokuwiki][dw] is a simple to use Wiki aimed at the documentation needs of a small company.

[Canviz][canviz] is a JavaScript library for drawing [Graphviz][graphviz] graphs to a web browser canvas.

[Graphviz][graphviz] is open source graph visualization software that takes textual descriptions of graphs, and outputs diagrams in various formats.

[dw]: http://www.splitbrain.org/projects/dokuwiki
[canviz]: http://code.google.com/p/canviz/
[graphviz]: http://www.graphviz.org/