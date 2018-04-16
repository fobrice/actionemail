Action Email
=========

Wordpress plugin to send email to some target throw email client.

Configuration
-------------

* email providers or client (thunderbird, gmail, yahoo) can be configured in the admin preferences settings of this plugin.

Usage
---------
* Create a wordpress article or page with the content:
```
[form_actionemail_data name="CONTEXTNAME" bcc="SEND_A_COPY_TO"]
DISPLAY_NAME,CONTACT_EMAIL,CONTACT_NAME
[/form_actionemail_data]

[form_actionemail]
MESSAGE TEMPLATE TO SEND TO TARGET
[/form_actionemail]
```

### example

```
[form_actionemail_data name="CONTEXTNAME" bcc="SEND_A_COPY_TO"]
DISPLAY_NAME,CONTACT_EMAIL,CONTACT_NAME
[/form_actionemail_data]
New York,mayor@new-york.gov.us,Mr Mansion
[/form_actionemail_data]

[form_actionemail]
@NOMCONTACT@,
   Nous souhaiterions attirer votre attention sur 
--
@TONNOM@
[/form_actionemail]
```

* template accept those values:
 * `@NOMCONTACT@` will be replaced by CONTACT_NAME
 * `@TONNOM`: replaced by text in the `name` input box

