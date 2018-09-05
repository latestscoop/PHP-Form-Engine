# PHP-Form-Engine

An attempt to simplify form creation whilst enabling site-wide form updates. In a nut shell:
+index.php = set form, form style and send parameters
+styles.css = style form and error output
+view.php = generate output
+controller = process inputted data to view.php (error handeling & send email)
+model.php = define/construct object
+template.html = optional reponsive email template

Within the form output page (in this case; index.php), set the the following parameters:
+'to' and 'from' email addresses
+send params (subject, heading, body and footer)

Also set the form parameters as an array of fields:
+field type (text, email, tel, url, number, text area, radio, select and submit)
+field name
+field label
+placeholder (use this to list field options separated by commas with no spaces)
+optional (false for mandatory fields)
+field class
+field style

Optional parameters include:
+form div id
+email template location
+Google Analytics account id and campaign name
+an email address for duplicate email or receipt

Then use the output() function to display the form.

view.php contains the form output methods, form error-handeling/user-messages and checks for errors within mandatory parameters.
Use the dev_report() function to output the object data and error messages. Manage error messages here.

Addition: Email templating
The template.html file contains 'variables' using the following structure: {var name} . These are replaced with form data within controller.php .

Addition: Google Analytics (GA)
Track links within the email by including; {tracking} , after the url (eg; http:example.com{traking}) within body or footer parameters. This requires 'GA_campaign'.
The email template also includes; {email_open) , which is replaced by a false image that is registered upon load, indicating that the email was opened. This requires both 'GA_campaign' and 'GA_account'.
