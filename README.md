# API Error Bundle

This bundle provides various tools to handle errors in a consistent way in your RESTful APIs based on Symfony.
This solution is inspired by the [RFC 7807](https://tools.ietf.org/html/rfc7807.html) but is fully customizable 
and extensible. I could say you can use this bundle in every API project to render your error messages in the format 
you like.
 	
## Installation
Add the following dependency in the require section of your composer.json:
```json
"ped/api-error-bundle": "dev-master"
```
Add the repository as well in the repositories section of the composer.json:
```json
"repositories": [
	{
  		"type": "vcs",
		"url": "git@bitbucket.org:paneedesign/api-error-bundle.git"
	}
],
```
Enable the bundle by adding the following line in the ```bundles.php```:
```php
<?php

return [
    ...
    PED\ApiErrorBundle\PedApiErrorBundle::class => ['all' => true],
];

```


Create the config file ```config/packages/ped_api_error.yml``` and add your settings like in the following example:
```yaml
ped_api_error:
  mapping:
    fqcn:
      Symfony\Component\HttpKernel\Exception\NotFoundHttpException: NOT_FOUND
      Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException: METHOD_NOT_ALLOWED
      Assert\InvalidArgumentException:
        type: BAD_REQUEST
        forwardMessage: true
      InvalidArgumentException:
        type: BAD_REQUEST
        forwardMessage: true
      ErrorException:
        type: INTERNAL_SERVER_ERROR
        forwardMessage: false
      Symfony\Component\Debug\Exception\FatalThrowableError:
        type: INTERNAL_SERVER_ERROR
        forwardMessage: false
      Symfony\Component\HttpKernel\Exception\BadRequestHttpException:
        type: BAD_REQUEST
        forwardMessage: true
    errors:
      NOT_FOUND:
        title: Not found
        statusCode: 404
      METHOD_NOT_ALLOWED:
        title: Method not allowed
        statusCode: 405
      BAD_REQUEST:
        title: Bad request
        statusCode: 404
      INTERNAL_SERVER_ERROR:
        title: Internal server error
        statusCode: 500
```
## Basic usage
At the moment the bundle allows to map the Fully-Qualified Class Name of the exceptions to  error codes. 
This mapping is defined in the ```ped_api_error.mapping.fqcn``` section of the config file.
For instance look at the following snippet extracted from the previous example: 
```yaml
ped_api_error:
  mapping:
    fqcn:
      Symfony\Component\HttpKernel\Exception\NotFoundHttpException: NOT_FOUND
```
This entry defines the association between the ```NotFoundHttpException``` and the ```NOT_FOUND``` error type.
According to the RFC 7807, each "problem detail" must have a type and a title. We also need to map it to a HTTP status 
code. This mapping is defined in the ```ped_api_error.mapping.errors``` section of the config file.
For instance look at the following snippet extracted from the previous example: 
```yaml
errors:
  NOT_FOUND:
	title: Not found
	statusCode: 404
```
This entry defines the association between the ```NOT_FOUND``` error type and the the related title and status code.
So every time the ```NotFoundHttpException``` will be trown a response like the following will be displayed:
```json
{
    "type": "NOT_FOUND",
    "title": "Not found"
}
```
Note that the type can be whatever you want, and you can also customize the way it is rendered simply extending the 
default behaviour of this bundle. For instance you could render the type as an URL like in the following example:
```json
{
    "type": "https://example.com/probs/not-found",
    "title": "Not found"
}
```
Sometime you would also display some details. The bundle offers you a basic way to do it. You can set the 
```forwardMessage``` to true to tell the bundle that the exception message must be displayed to the client:
```yaml
ped_api_error:
  mapping:
    fqcn:
      App\Domain\OutOfCreditException:
        type: OUT_OF_CREDIT
        forwardMessage: true # Enables the exception message to be displayed
    errors:
       OUT_OF_CREDIT:
          title: You do not have enough credit
          statusCode: 400
```
The resulting response will be something like this:
```json
{
    "type": "OUT_OF_CREDIT",
    "title": "You do not have enough credit",
    "detail": "Your current balance is 30, but that costs 50."
}
```
