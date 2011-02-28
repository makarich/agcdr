#!/bin/sh

# exclude private functions (use this for public documentation)
#phpdoc -d ../application/classes,../application/models,../application/controllers -t ./phpdoc -ti 'Heddon House' -dn 'House'

# include private functions (use this for internal documentation)
phpdoc -d ../application/classes,../application/models,../application/controllers -t ./phpdoc -ti 'Heddon House' -dn 'House' -pp

# add this to the end of each to use the Evolve template (doesn't seem to work with House for some reason)
# -o HTML:Smarty/Evolve:default -s on
