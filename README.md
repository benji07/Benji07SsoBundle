# Questions:

- Comment récupérer le provider actif dans le SSOListener
- Comment récupérer l'id de l'utilisateur ? (dépend vraiment du provider, si oauth = token_access, sinon méthode a prévoir avec openid)
- Comment récupérer les informations de l'utilisateur ? (via un service, puis ça dépends vraiment de ce que l'on a besoin)
- Comment créer un utilisateur ?
    - via un service -> marche bien si on a pas besoin d'autre champ
    - redirection sur l'inscription via une url (avec les données de l'openid en session)
- Comment on récupère les informations de l'utilisateurs pour tous ces providers ? (oauth2, oauth1, openid)
    -> dépends vraiment de l'api qui va avec le site

- Création du compte d'un utilisateur:
    - 2 cas (création automatique, ou renseignement de champ suplémentaire)


---------------------

Workflow OAuth (1 ou 2) et OpenId:
    - request -> redirection vers une url
    - response -> récupération d'info dans la request




Step 1: handleRequest
- Comment lancer la redirection ?

```yml
benji07_sso:
    user_manager: benji07.sso.usermanager
    providers:
        twitter:
            service: benji07.sso.provider.twitter
            options:
                clientId: %twitter_clientId%
                secretId: %twitter_secretId%
        facebook:
            service: benji07.sso.provider.facebook
            options:
                clientId: %twitter_clientId%
                secretId: %twitter_secretId%
        github:
            service: benji07.sso.provider.github
            options:
                clientId: %github_clientId%
                secretId: %github_secreitId%
        steam:
            service: benji07.sso.provider.steam
            options:
                url: http://steamcommunity.com/openid
```