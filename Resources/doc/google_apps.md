# Configuration of your domain to allow login with openid

Go on this page and enable OpenId https://www.google.com/a/cpanel/{domain}/SetupIdp


Next you need to add few files inside your server (to fix a bug of LightOpendId)

    # http://domain/openid
    <?xml version="1.0" encoding="UTF-8"?>
    <xrds:XRDS xmlns:xrds="xri://$xrds" xmlns="xri://$xrd*($v*2.0)">
        <XRD>
            <Service priority="0">
                <Type>http://specs.openid.net/auth/2.0/signon</Type>
                <Type>http://openid.net/srv/ax/1.0</Type>
                <URI>https://www.google.com/accounts/o8/ud?source={domain}</URI>
            </Service>
            <Service priority="0">
                <Type>http://specs.openid.net/auth/2.0/server</Type>
                <Type>http://openid.net/srv/ax/1.0</Type>
                <URI>https://www.google.com/accounts/o8/ud?source={domain}</URI>
            </Service>
        </XRD>
    </xrds:XRDS>


    # http://domain/.htaccess
    <Files openid>
        ForceType application/xrds+xml
    </Files>


    # http://domain/.well-known/host-meta
    Link: <https://www.google.com/accounts/o8/site-xrds?hd={domain}>; rel="describedby http://reltype.google.com/openid/xrd-op"; type="application/xrds+xml"
