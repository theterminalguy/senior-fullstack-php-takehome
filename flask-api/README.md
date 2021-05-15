# Flask API

This python flask API talks to the PHP Soap service and relays the message to the React FrontEnd app, it's also responsible for handling GitHub webhooks. 

We've implemented a simple SOAP client that lets you talk to the PHP SOAP server. Look at `app.py` for example on how to use it. 

Please reach out to me if you have any questions.

Happy Coding!

### Setup

Ensure you are using virtualenv (not a requirement). Activate the virtualenv and install all dependencies with 

```
pip install -r requirements.txt
```

Run the app with 

```
flask run
```
