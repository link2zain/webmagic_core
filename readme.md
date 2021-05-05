# Core module #

Module uses for place base abstract and real classes which can be reused in future


## Entityt functionality ##

Extend EntityRepo class and you will have base methods for work with entities

## Secure routes check
Use \Webmagic\Core\Middleware\SecureRoutesCheck if you want to redirect a not secure request to the secure one when the app working on the production environment.

## Redirect realization for AJAX requests

It is difficult to recognize the redirect destination in javascript when you making a standard redirect response. Use \Webmagic\Dashboard\Controllers\AjaxRedirectTrait to make the redirect process more clear for javascript. The result of the function  redirect will for the AJAX request (with header x-requested-with: XMLHttpRequest) will be the next kind of json
```json
    {
      "status": "302",
      "redirect" : "https://destination.com"
    }
```
For the regular HTTP requests the function will return regular redirect. 