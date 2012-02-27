# Installation

## Step 1: Download the bundle using composer

```json
"require": {
    "benji07/sso-bundle": "*"
}
```

## Alternative Step 1: Download the bundle using the vendors script

```
[Buzz]
    git=https://github.com/kriswallsmith/Buzz.git
    version=v0.5

[BuzzBundle]
    git=https://github.com/sensio/SensioBuzzBundle.git
    target=/bundles/Sensio/Bundle/BuzzBundle

[LightOpenId]
    git=git://gitorious.org/lightopenid/lightopenid.git
    target=/lightopenid


[Benji07SSoBundle]
    git=https://github.com/benji07/Benji07SsoBundle.git
    target=/bundles/Benji07/SsoBundle
```

## Step 2: Routing Configuration

```
Benji07SsoBundle:
    resource: "@Benji07SsoBundle/Resources/config/routing.yml"
```

## Step 3: Security Configuration

```yml
firewalls:
    sso:
        pattern: ^/sso/login/
        security: false
    main:
        sso:
            check_path: /sso/login_check
```

## Step 4: Application configuration

```yml
benji07_sso:
    user_manager: your_user_manager.id
    providers:
        steam:
            service: benji07.sso.provider.steam
            options:
                apiKey: %steam_apiKey%
```

## Step 5: Create an user manager

Create a class that implements UserManagerInterface and declare it as a service

- findUser: find a user using the provider name and informations send by the provider
- createUser: create a user or return a response to handle the user registration on a different way (providers data is set in session on sso_user)

# Create new provider

There is a few provider defined by default, but if you need you could extends OAuth or OpenId providers or implements the ProviderInterface

# Add a link to login

<a href="{{ path('_sso_login', {name: 'steam'}) }}">Login with steam</a>
