# YAG TYPO3 Gallery Extension

[![Build Status](https://travis-ci.org/beyondAgentur/yag.svg?branch=namespaces)](https://travis-ci.org/beyondAgentur/yag)

YAG is a gallery extension for TYPO3 based on Extbase and Fluid.

To get some further information check http://www.yag-gallery.de!


## Versioning

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major
* New additions without breaking backward compatibility bumps the minor
* Bug fixes and misc changes bump the patch


## Setup from GitHub

YAG requires the TYPO3 extension pt_extbase and pt_extlist:

1. pt_extbase git://github.com/punktDe/pt_extbase.git
2. pt_extlist git://github.com/punktDe/pt_extlist.git

The lightbox javascript is included via submodule, so don't forget to run a `git submodule update --init` after cloning the extension.

## Bugs

Found a bug? Please create an issue, or even better: fix it and create a pull request.

## Authors

*Daniel Lienert*

+ http://daniel.lienert.cc
+ http://github.com/daniellienert
+ https://twitter.com/dlienert

*Michael Knoll*

+ http://mimi.kaktusteam.de
+ http://github.com/michaelknoll


## Copyright and license

(c) 2010-2015  Daniel Lienert & Michael Knoll
			
All rights reserved

Licensed under the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. You may not use this work except in compliance with the License.
