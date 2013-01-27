####################################################
# Configuration and adjustements of external plugins
#
# @author Daniel Lienert <daniel@lienert.cc>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.externalPlugins {
	socials = USER
	socials {
		userFunc = tx_extbase_core_bootstrap->run
		pluginName = Pi1
		extensionName = Socials
		controller = Share
		action = show

		switchableControllerActions {
			Share {
				1 = show
			}
		}

		settings =< plugin.tx_socials.settings
		persistence =< plugin.tx_socials.persistence
		view =< plugin.tx_socials.view

		settings {
			items = googleplus,twitter,facebooklike
			2clickPrivacy = 1
		}
	}
}

