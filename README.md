ProspectEye REST API
====================

Hello and welcome to ProspectEye REST API. This document includes tutorials and documentation how to use our API.

What is ProspectEye
====================

http://www.prospecteye.com is a webbased BI-system that tracks all visitors on your webpage and presents them as prospects.
ProspectEye delivers each visit with company information such as company name, telephone numbers, descision makers etc.

What is possible with the REST API?
====================

The following information can be recieved from the API

- Visits
- Filter
- Companystatus
- Apikey

The REST service is based on CRUD thus the following commands are allowed

- GET
- POST
- UPDATE
- DELETE

API keys and Authentication
====================
To be able to make calls to the REST service ones need an API-key. To be able to recieve an API-key you have to be a customer to prospecteye.
Once a customer you can generate a API-key from the Prospectey client. Go to settings->Addins and klick the API-key generate button.

The REST service have a BASIC authentication with your accountid as username and API-key as password.

Sandbox
====================
It is also possible to make calls to our sandbox account. In order to revieve access to the sandbox just send an email
to us support@pospecteye.com and asking for access and what you want to try out.

Limitations
====================
The is currently no limitation on number of calls to our API.

Errorhandling
====================
All responses comes with a "Success" attribute that is either true or false. If "Success" is false an error message
always present in the attribute "Error".

Format
====================
The REST API supports both JSON and XML. JSON is standard of you dont specify anything else.

example for json response:
http://api.prospecteye.com/rest/companytype.json

example for xml response:
http://api.prospecteye.com/rest/companytype.xml

Examples
====================

REST/Visits
--------------------
It's possible to get visits in two ways. Either by specifing the first visitid you want to start search from or by specifing
a timeframe.

`GET http://api.prospecteye.com/visits/aftervisit`

REST/Filter
--------------------


REST/Companytype
--------------------


REST/Apikey
--------------------
