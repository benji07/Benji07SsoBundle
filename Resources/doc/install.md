## Installation for OAuth 1.0a

    # composer.json
    {
        "autoload": {
            "classmap": ["vendor/oauth/oauth"]
        },
        "repositories": [
            {
                "type": "package",
                "package": {
                    "name": "oauth/oauth",
                    "version": 1,
                    "source": {
                        "url": "http://oauth.googlecode.com/svn/",
                        "type": "svn",
                        "reference": "code/php"
                    }
                }
            }
        ],
        "require": {
            "oauth/oauth": 1,
            "sensio/buzz-bundle": "*",
            "benji07/sso-bundle": "dev-master"
        }
    }

# Installation for OAuth2

    # composer.json
    {
        "require": {
            "benji07/sso-bundle": "dev-master"
        }
    }

# Installation for OpenId (only steam is currently supported)

    # composer.json
    {
        "require": {
            "fp/lightopenid": "dev-master",
            "benji07/sso-bundle": "dev-master"
        }
    }
