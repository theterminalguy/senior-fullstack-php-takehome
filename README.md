# senior-fullstack-take-home

All source code in this repo should not be used in production. This is for development purpose only. Feel free to clone/fork the repo and modify as expected. 

## Overview

A simple microservice application using REST, SOAP and Webhooks. The SOAP server is written in PHP, allowing you call procedures remotely. JSON is used over XML for simplicity. REST is done through Python Flask API, which is also responsible for handling webhook requests and talking to React via WebSocket or API calls.


## Highlevel Architecture Overview

![Architecture](architecture.svg)


The entire application is expected to be dockerized and deployed on AWS Elastic Beanstalk


## What has been done for me?

We have made it easier for to get started with this project after you must have gone through the requirement document. The following have been implemented for you

1. A SOAP server written in PHP
2. A SOAP client written in Python
3. Project bootstraped for PHP, Python and React
4. An ORM written in PHP (don't use in production 😉)
5. PHPUnit has been setup correctly
6. ORM thorougly tested 😉 🤔 😉
7. And lots more

## What we didn't for you

The exercise
