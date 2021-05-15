import json
import os
import xmltodict

from dotenv import load_dotenv
from pysimplesoap.client import SoapClient

load_dotenv()


class InterviewSoapClient:
    def __init__(self):
        self.client = SoapClient(
            location=os.getenv("SOAP_SERVICE_HOST"),
            http_headers={
                'Authorization': os.getenv("SOAP_SERVICE_TOKEN")
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
