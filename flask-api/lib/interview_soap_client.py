import xmltodict
import json

from pysimplesoap.client import SoapClient


class InterviewSoapClient:
    def __init__(self, url):
        self.client = SoapClient(
            location=url,
            http_headers={
                'Authorization': 'awes0meyou@!234'
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
