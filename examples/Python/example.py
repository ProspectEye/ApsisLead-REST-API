#
# Install Reqests to be able to run this script
# http://docs.python-requests.org/en/latest/
#
import requests
import json

API_KEY = "ENTER_API_KEY_HERE"
ACCOUNT_ID = "ENTER_ACCOUNTID_HERE"
REST_HOST = "http://api.apsislead.com/rest/"

def getApiKey(usermail = "", password = ""):
	result = requests.get(REST_HOST + "apikey?usermail=" + usermail + "&password=" + password)
	return result.json

def getFilter(filterId = 0):
	sUrl = "filter"
	if filterId > 0:
		sUrl += "/{0}".format(filterId)
	result = requests.get(REST_HOST + sUrl, auth=(ACCOUNT_ID, API_KEY))
	return result.json

def getVisits(limit = 10):
	result = requests.get(REST_HOST + "visits/aftervisit?limit=" + "{0}".format(limit), auth=(ACCOUNT_ID, API_KEY))
	return result.json

def getCompanyType():
	result = requests.get(REST_HOST + "companytype", auth=(ACCOUNT_ID, API_KEY))
	return result.json


if __name__ == '__main__':
	data = getApiKey("your@email.com", "your_account_password_here")
	print json.dumps(data, indent=True)

	if data["accountid"]:
		ACCOUNT_ID = data["accountid"]
	if data["apikey"]:
		API_KEY = data["apikey"]

	data = getFilter()
	print json.dumps(data, indent=True)

	data = getVisits()
	print json.dumps(data, indent=True)

	data = getCompanyType()
	print json.dumps(data, indent=True)