####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default {

	title = Default
	description = The YAG Gallery default theme.

	## Show the breadcrumb header
	showBreadcrumbs = 1
	
	
	## Define the resolutions 
    resolutionConfigs {
 		thumb {
    		maxW = 150
    		maxH = 150
    	}
    	
    	# Per default, gallery thumbs have the same size as item list thumbs.
    	# Feel free to override this, if you want to have a different resolution for gallery thumbs

    	galleryThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb
    	
        # Per default, album thumbs have the same size as item list thumbs.
        # Feel free to override this, if you want to have a different resolution for album thumbs

    	albumThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb

    	medium {
    		maxW = 800
    		maxH = 600
    	}
    }

	## include CSS/JS from defined libraries. SEE: BaseConfig/HeaderInclusion
	includeLibJS = 
	includeLibCSS = 
	
	## Define JS Files to include. 
	includeJS {

	}
	
	## Define CSS Files to include.
	includeCSS {
		yag_theme = EXT:yag/Resources/Public/CSS/theme.css
		yag_theme_default = EXT:yag/Resources/Public/CSS/Default.css
	}

	# Javascript file include position
	# Options are header / footer / inline
	jsPosition = footer


	feed {
		active = 0
		title = YAG Gallery Feed
		description = Feed Description
		author = The Photographer
		language = de_de
	}


	## Configures optional visitor interaction services
	interaction {

		# StarRating
		# You need to have the extension Stars installed.
		stars {
			path = Interaction/Stars
			show = 0
		}

		# 2-Click Social Share Buttons
		socialSharePrivacy  {
			path = Interaction/SocialSharePrivacy
			show = 0

			settings {

				info_link = http://panzi.github.com/SocialSharePrivacy/
				language = en

				services {
					buffer.status = false
					delicious.status = false
					disqus.status = false
					mail.status = false
					flattr.status = false
					linkedin.status = false
					pinterest.status = false
					reddit.status = false
					stumbleupon.status = false
					tumblr.status = false
					xing.status = false
					facebook.status = true
					twitter.status = true
					gplus.status = true
				}
			}
		}

		# Disqus Commenting Service
		disqus {
			path = Interaction/Disqus
			show = 0

			settings {
				disqus_shortname =
			}
		}
	}
}
