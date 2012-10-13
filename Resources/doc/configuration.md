
# config.yml
benji07_sso:
    user_manager: your.sso.user_manager
    providers:
        facebook:
            service: benji07_sso.provider.facebook
            options:
                clientId: %fb_app_id%
                secretId: %fb_app_secret%
                scope: %fb_scope%


# Facebook provider

    providers:
        facebook:
            service: benji07_sso.provider.facebook
            options:
                clientId: %fb_app_id%
                secretId: %fb_app_secret%
                scope: %fb_scope%

# Twitter provider

    providers:
        twitter:
            service: benji07_sso.provider.twitter
            options:
                clientId: %twitter_key%
                secretId: %twitter_secret%


# Google Apps provider

    providers:
        google_apps:
            service: benji07_sso.provider.google_apps
            options:
                domain: %google_apps_domain%
