
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
