# Messagebird Interview Assignment
---

by Aimilia Kelaidi (aim.kelaidi@gmail.com)

## Getting started

### Introduction
This small project was implemented for the purposes of the the Interview Assignment that was given to me on 09/08/2017 by Messagebird and
it was built in PHP using `Codeigniter v.3.1` through `composer` from https://github.com/kenjis/codeigniter-composer-installer using JQuery CDN, Bootstrap CDN
and a Javascript cookie library from https://github.com/js-cookie/js-cookie.


The look-and-feel of this project is based on Messagebird's platform.

In this project a web page is created in which a user can perform the following:
*Fill its mobile number, one or more recipient(s) number(s) and a message and send it to the Messagebird API.
*Receive messages on a VMN number (Virtual Mobile Number).
*View a list of the sent and received messages which updates in realtime. 

For the assignment purposes, a Messagebird account was created in Messagebird's platform: dashboard.messagebird.com.
A test API key was created in this account and used to test the project's functionality.

### Instalation and Configuration

1. Download or clone repository into your webserver. The domain should point to folder `public` where `index.php` will route into `Codeigniter`.
2. Replace `base_url` in `applications/config/config.php` with your domain name.

---

### Login
In order to be able to use the project's functionalities, the user must first provide with a valid API key.
This API key is created in his/ her account in Messagebird dashboard.
The application uses cURL to check the HTTP code status returned by Messagebird's Authentication service.
If the returned HTTP status is 200, the user is allowed to proceed.
Otherwise, the user is asked to fill in a valid API key.

---

### Send SMS
In order to send an SMS to one or more recipients, the user should navigate in the SMS area on the left and click on the option 'Quick Send'.
In this case, the user is asked to provide with an originator's number or string, one or more recipients numbers seperated by enter and the message.
When 'Send SMS' button is pressed, a notification will appear indicating a success or fail message.

---

### SMS Overview
In order to get an overview of all SMSes, the user should navigate in the SMS area on the left and click on the option 'SMS Overview'.
The application uses cURL in order to retrieve the messages as they arrive through the Messagebird's API and manipulates the returned data
to display the messages and the pagination. 
Moreover, the application sets to a COOKIE the ids retrieved from the messages above. 

As instructed in the assignment, on window load the application uses the receiveMessages() function to retrieve the messages with a set interval.
The COOKIE mentioned above is now used to validate which messages have already been displayed in the overview table or not.
This functionality is performed as mentioned below:
For each receiveMessages() call the application parses the messages' ids and compares them with the ids already stored in the COOKIE.
For each message, if its id is not already stored in the COOKIE, the application renders it by appending a new line in the overview table 
and pushes this message's id in the COOKIE.
Also alters the pagination's links with the new ones. 

For the purposes of this assignment we assume that the pagination limit is 20 messages.

---

#### How to Use 
* The project can be used by providing with a valid API key through a Messagebird account.
* After successfully logging in, the user is redirected to the Dashboard area.
* From that point on, the user can navigate on the menu area to send a message to one or more recipients.
* The user can also retriece an SMS overview based on the API key provided in the first step.

