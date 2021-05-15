from flask import Flask
from lib.interview_soap_client import InterviewSoapClient

app = Flask(__name__)


@app.route("/")
def index():
    return "Congratulations, lets get started!"


@app.route("/soap")
def soap():
    client = InterviewSoapClient()
    res = client.call(
        service='CompanyService',
        action='helloFromPHP',
    )

    return res


@app.route("/company")
def company():
    client = InterviewSoapClient()
    res = client.call(
        service='CompanyService',
        action='getCompanyById',
        args={'id': 1}
    )

    return res
