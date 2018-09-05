# PHP-Form-Engine

An attempt to simplify form creation whilst enabling site-wide form updates. In a nut shell:<br />
+index.php = set form, form style and send parameters<br />
+styles.css = style form and error output<br />
+view.php = generate output<br />
+controller = process inputted data to view.php (error handeling & send email)<br />
+model.php = define/construct object<br />
+template.html = optional reponsive email template<br />
<br />
Within the form output page (in this case; index.php), set the the following parameters:<br />
+'to' and 'from' email addresses<br />
+send params (subject, heading, body and footer)<br />
<br />
Also set the form parameters as an array of fields:<br />
+field type (text, email, tel, url, number, text area, radio, select and submit)<br />
+field name<br />
+field label<br />
+placeholder (use this to list field options separated by commas with no spaces)<br />
+optional (false for mandatory fields)<br />
+field class<br />
+field style<br />
<br />
Optional parameters include:<br />
+form div id<br />
+email template location<br />
+Google Analytics account id and campaign name<br />
+an email address for duplicate email or receipt<br />
<br />
Then use the output() function to display the form.<br />
<br />
view.php contains the form output methods, form error-handeling/user-messages and checks for errors within mandatory parameters.<br />
Use the dev_report() function to output the object data and error messages. Manage error messages here.<br />
<br />
Addition: Email templating<br />
The template.html file contains 'variables' using the following structure: {var name} . These are replaced with form data within controller.php .<br />
<br />
Addition: Google Analytics (GA)<br />
Track links within the email by including; {tracking} , after the url (eg; http:example.com{traking}) within body or footer parameters. This requires 'GA_campaign'. The email template also includes; {email_open) , which is replaced by a false image that is registered upon load, indicating that the email was opened. This requires both 'GA_campaign' and 'GA_account'.<br />
