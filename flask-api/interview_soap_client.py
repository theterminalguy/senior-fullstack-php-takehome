import xmltodict
import json

from pysimplesoap.client import SoapClient

class InterviewSoapClient:
    def __init__(self, url):
        self.client = SoapClient(
            location=url,
            http_headers={
                'Authorization': 'Basic Token'
            }
        )

    def call(self, service, action, args={}):
        params = {
            'service': service,
            'action': action,
            'args': args
        }

        self.client.handle(request=json.dumps(params))
        res = xmltodict.parse(self.client.xml_response)
        body = res['SOAP-ENV:Envelope']['SOAP-ENV:Body']

        return json.dumps(
            body['ns1:handleResponse']['return']['#text']
        )

client = InterviewSoapClient('')
soap_response = client.call(
	service='CompanyService',
	action='getCompanyById',
	args={
		'id': 1
	}
)

print(soap_response)