from flask import Flask
from lib.interview_soap_client import InterviewSoapClient

app = Flask(__name__)


@app.route("/")
def index():
    return "Congratulations, lets get started!"


@app.route("/soap")
def soap():
    client = InterviewSoapClient()
    soap_response = client.call(
        service='CompanyService',
        action='helloFromPHP',
        args={
            'id': 1
        }
    )

    return soap_response
