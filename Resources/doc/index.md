# Benji07SsoBundle

## Installation

### Installation for OAuth2 (facebook, github, ...)

    # composer.json
    {
        "require": {
            "sensio/buzz-bundle": "*",                  # Only for Google provider on OAuth2
            "benji07/sso-bundle": "dev-develop"
        }
    }

### Installation for OAuth 1.0a (twitter)

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
            "benji07/sso-bundle": "dev-develop"
        }
    }

### Installation for OpenId (google apps & steam)

    # composer.json
    {
        "require": {
            "fp/lightopenid": "dev-master",
            "benji07/sso-bundle": "dev-develop"
        }
    }


## Configuration

    # AppKernel.php:registerBundles()
    $bundles[] = new Benji07\SsoBundle\Benji07SsoBundle();

    # routing.yml
    _sso:
        resource: "@Benji07SsoBundle/Resources/config/routing.yml"

    # app.yml
    benji07_sso:
        user_manager: acme.sso.user_manager
        providers:
            facebook:
                service: benji07_sso.provider.facebook
                options:
                    clientId: %fb_clientId%
                    secretId: %fb_secretId%
                    scope:  %fb_scope%
            twitter:
                service: benji07_sso.provider.twitter
                options:
                    clientId: %twitter_clientId%
                    secretId: %twitter_secretId%

    # security.yml
    firewalls:
        sso:
            pattern: ^/sso/login/
            security: false

## Find / Create user

You must create an UserManager that implements Benji07\SsoBundle\Security\Core\User\UserManagerInterface

- findUser must return a UserInterface or null if the user doesn't exist
- createUser must return a user if the user is created, a RedirectResponse if we can't automaticaly create the user or null
- linkUser link the  user with the provider
- unlinkUser unlink the user with the provider

If we return a RedirectResponse inside the create user, we can find the user informations inside the session (with sso_user key).

## Link to login, link and unlink

- _sso_login -> start the authentication process for a given provider
- _sso_link -> link the current user to a provider
- _sso_unlink -> unlink the current user to the provider

# Add new Provider

You can find examples for OAuth1 and OAuth2 inside TwitterProvider and FacebookProvider
