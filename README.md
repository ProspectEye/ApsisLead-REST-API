APSIS Lead REST API
====================

Hello and welcome to APSIS Lead REST API. This document includes tutorials and documentation how to use our API.

What is APSIS Lead
====================

http://www.apsislead.com is a webbased BI-system that tracks all visitors on your webpage and presents them as prospects.
APSIS Lead delivers each visit with company information such as company name, telephone numbers, descision makers etc.

What is possible with the REST API?
====================

The following information can be recieved from the API

- Visits
- Filter
- Conversion
- Company
- Companystatus
- Settings
- Apikey

The REST service is based on CRUD thus the following commands are allowed

- GET
- POST
- UPDATE
- DELETE

API keys and Authentication
====================
To be able to make calls to the REST service ones need an API-key. To be able to recieve an API-key you have to be a customer to APSIS Lead.
Once a customer you can generate a API-key from the APSIS Lead client. Go to Settings-> Connections and klick the API-key generate button.

The REST service have a BASIC authentication with your accountid as username and API-key as password.

Sandbox
====================
It is also possible to make calls to our sandbox account. In order to revieve access to the sandbox just send an email
to us support@apsis.com and asking for access and what you want to try out.

Limitations
====================
The is currently no limitation on number of calls to our API. We recommend that polling occur once every 5 minutes. If polling exceed this recommendation we have the authority too close your access.

Errorhandling
====================
All responses comes with a "Success" attribute that is either true or false. If "Success" is false an error message
always present in the attribute "Error".

Format
====================
The REST API supports both JSON and XML. JSON is standard of you dont specify anything else.

example for json response:
http://api.apsislead.com/rest/companytype.json

example for xml response:
http://api.apsislead.com/rest/companytype.xml

Examples
====================

REST/Visits
--------------------
It's possible to get visits in two ways. Either by specifing the first visitid you want to start search from or by specifing
a timeframe.

`GET http://api.apsislead.com/rest/visits/aftervisit`

`Params: visitid (int), limit (int), step (int), filterid (int), withpageviews (boolean)`

Response:

```
{
  'Success': true,
  'visits' : [
    {
      'name': 'Company name',
      'companytype': 2
      ...
      'timespent': 1000
    } 
  ]
}
```


`GET http://api.apsislead.com/rest/visits/betweendates`

`Params: startdate (ex 2012-11-03), enddate (date), limit (int), step (int), filterid (int), withpageviews (boolean)`


`GET http://api.apsislead.com/rest/visits/search`

`Params: query (ex "ProspectEye AB")`

You can also get more details about a visit with `visits/details`. Here you will also get all company information

`GET http://api.apsislead.com/rest/visits/details/:visitid`

REST/Filter
--------------------

Get all filters
`GET http://api.apsislead.com/rest/filter`

Get a filter by id
`GET http://api.apsislead.com/rest/filter/:id`

REST/Conversion
--------------------

Get all conversions
`GET http://api.apsislead.com/rest/conversion`

`Params: limit (integer), step (integer)`

Get all conversions after a specific conversion-id
`GET http://api.apsislead.com/rest/conversion/afterid/:id`

`Params: id (integer), limit (integer), step (integer)`

Get all conversions between dates
`GET http://api.apsislead.com/rest/conversion/betweendates`

`Params: startdate (date), enddate (date), limit (integer), step (integer)`

Get conversions for a specific form
`GET http://api.apsislead.com/rest/conversion/:formId`

`Params: limit (integer), step (integer)`

Get conversions for a specific form and for a specific email
`GET http://api.apsislead.com/rest/conversion/:formId/:email`

`Params: limit (integer), step (integer)`

Post conversion to a specific form
`POST http://api.apsislead.com/rest/conversion/:formId`

```
POST body
@Param: uuid (string|required),
@Param: pageurl (string|required)
@Param: data (json-array|required)
```

Example of data json-array:
```
  [
    {
      key: 'email',
      value: 'email@domain.com'
    },
    {
      key: 'firstname',
      value: 'Firstname'
    }
  ]
```

REST/Company
--------------------

Get a company by companyid that have visited your site
`GET http://api.apsislead.com/rest/company/:companyid`

or by registerednumber

`GET http://api.apsislead.com/rest/company/registerednumber/:registerednumber`

REST/Companytype
--------------------

There are 6 kinds of statuses on a visitor in ProspectEye

1. Prospect
2. Customer
3. Partner
4. Competitor
5. Supplier
6. Other

Get all companystatuses

`GET http://api.apsislead.com/rest/companytype`

Get a companystatus by companyid

`GET http://api.apsislead.com/rest/companytype/:companyid`

Get a companystatus by registerednumber

`GET http://api.apsislead.com/rest/companytype/registerednumber/:registerednumber`

Insert new status

`POST http://api.apsislead.com/rest/companytype/`

Post data:
```
{
  companyid: 10001,
  userid: 10001,
  type: 3,
  registerednumber: 5512123434 (optional)
}
```

Update a companystatus with user and/or type

`PUT http://api.apsislead.com/rest/companytype/:companyid`

Put data:
```
{
  userid: 10001,
  type: 3
}
```

Update a companystatus with user and/or type by registerednumber

`PUT http://api.apsislead.com/rest/companytype/registerednumber/:registerednumber`

REST/Settings
--------------------

Get settings for user-id

`GET http://api.apsislead.com/rest/settings/:userid`


REST/Apikey
--------------------

Get API-key, accountid and userid with you standard Login

`GET http://api.apsislead.com/rest/apikey/`

`Params: usermail (string), password (string)`
