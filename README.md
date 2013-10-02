joomla-dynamic-orders-form
==========================

Joomla 1.5 component that allows you to create dynamic forms


Features
========

* Create multiple forms and use them on different pages
* Add different field types: Static / Text input/ Checkbox / Text area / Dropdown list
* Captcha for validating forms
* Option to restrict form access only to registered users
* Form input entries are saved in database
* Form input can be sent to google form ( this is configured in form settings)


Installation
============

Download as a ZIP file and install as component. The new component will appear in administrator menu in
Components -> Orders

1. Create a form with fields from Components -> Orders -> Forms
2. Create form fields in Fields pane of the Orders component

To make new form available in front end, create a menu item of type "Orders" and select desired form from
created menu Basic parameters. Lower in "Parameters (Component)" choose if you want to make the form available
only for registered users or for logged in users
