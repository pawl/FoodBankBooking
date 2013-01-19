<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$acccept_charset = "Specifies the character-sets the server can handle for form-data."
."To specify more than one character set, separate the sets with a comma.<br/> "
."In theory, any character encoding can be used, but no browser understands all of them. "
."The more widely a character encoding is used, the better the chance that a browser will understand it.";

$action = "Specifies where to send the form-data when a form is submitted.<br/>"
."Possible values:<br/>"
."<ul><li>An absolute URL - points to another web site (like action='http://www.example.com/example.htm')</li>"
."<li>A relative URL - points to a file within a web site (like action='example.htm')</li><ul>";

$autocomplete = "Specifies whether or not the form should have autocomplete enabled.<br/>"
."Autocomplete allows the browser to predict the input for a field. "
."When the user starts to type in a field, the browser should display options "
."to fill in the field, based on earlier typed values.";

$enctype = "The enctype attribute specifies how form-data should be encoded before "
."sending it to the server.<br/>Form-data is encoded to 'application/x-www-form-urlencoded' "
."by default. This means that all characters are encoded before they are sent "
."to the server (spaces are converted to '+' symbols, and special characters are converted to ASCII HEX values)."
."<b>Value</b><ul>"
."<li><b>application/x-www-form-urlencoded </b> - All characters are encoded before sent (this is default)</li>"
."<li><b>multipart/form-data</b> - No characters are encoded. This value is required when you are using forms that have a file upload control</li>"
."<li><b>text/plain</b> - Spaces are converted to '+' symbols, but no special characters are encoded</li>";

$method = "The method attribute specifies how to send form-data.<br/>"
."The form-data can be sent as URL variables (with method='get') or as HTTP post (with method='post').<br/> "
."<b>Notes on the 'get' method:</b><ul>"
."<li>This method appends the form-data to the URL in name/value pairs</li>"
."<li>This method is useful for form submissions where a user want to bookmark the result</li>"
."<li>There is a limit to how much data you can place in a URL (varies between browsers), "
."therefore, you cannot be sure that all of the form-data will be correctly transferred</li>"
."<li>Never use the 'get' method to pass sensitive information! "
."(password or other sensitive information will be visible in the browser's address bar)</ul> "
."<b>Notes on the 'post' method:</b><ul>"
."<li>This method sends the form-data as an HTTP post transaction</li>"
."<li>Form submissions with the 'post' method cannot be bookmarked</li>"
."<li>The 'post' method is more robust and secure than 'get', and 'post' does not have size limitations</li></ul>";

$novalidate = "The novalidate attribute specifies that the form-data (input) should not be validated when submitted.";

$accesskey = "The accesskey attribute specifies a shortcut key for an element.<br/>"
."A keyboard shortcut will give the element focus and/or activate it.<br/>"
."<b>Value :</b> One or more keyboard characters, separated by spaces.";

$class ="The class attribute specifies a classname for an element.<br/>"
."The class attribute is mostly used to point to a class in a style sheet. "
."However, it can also be used by a JavaScript (via the HTML DOM) to make "
."changes to HTML elements with a specified class.<br/>"
."<b>Tip:</b> It is possible to assign multiple classes to one HTML element, "
."e.g. &lt; span class='left_menu important' &gt;. This allows you to combine several "
."CSS classes for one HTML element.<br/>"
."<b>Tip:</b> Do NOT start a class name with a number! This is not supported in most browsers.";

$contenteditable = "The contenteditable attribute specifies whether or not the content of the element should be editable.<br/>"
."<b>Values</b>:<br/>"
."<ul><li>true - Specifies that the content of the element should be editable</li>"
."<li>false - Specifies that the content of the element should not be editable</li>"
."<li>inherit -Specifies that the content of the element should be editable if the parent element is</li></ul>";

$contextmenu ="The value of the id attribute on the menu with which to associate the element as a context menu.";

$dir = "The dir attribute specifies the text direction of the element's content."
."<b>Values:</b><br/>"
."<ul><li>ltr - Left-to-right text direction</li>"
."<li>rtl - Right-to-left text direction</li>"
."<li>auto -Let the browser figure out the text direction based on the content. This is only recommended if the text directionality is unknown</li></ul>";

$draggable ="Specifies whether the element is draggable.";

$dropzone = "Specifies what types of content can be dropped on the element, and instructs "
."the UA about which actions to take with content when it is dropped on the element. <br>"
."<b>Value :</b><ul>"
."<li>copy - Indicates that dropping an accepted item on the element will result in a copy of the dragged data.</li>"
."<li>move -Indicates that dropping an accepted item on the element will result in the dragged data being moved to the new location.</li>"
."<li>link - Indicates that dropping an accepted item on the element will result in a link to the original data.</li>"
."<li>Any string with three characters or more, beginning with the literal string 's:'. - ndicates that Plain Unicode string items, of the type indicated by the part of of the keyword after the 's:' string, can be dropped on this element. </li>"
."<li>Any string with three characters or more, beginning with the literal string 'f:'. - Indicates that File items, of the type indicated by the part of of the keyword after the 'f:' string, can be dropped on this element.</li>"
."</ul>"
."The value must not have more than one of the three tokens 'copy', 'move', or 'link'. If none are specified, the element represents a copy dropzone.";

$hidden = "The hidden attribute specifies that the element should be hidden. <br/>Hidden elements are not displayed."
."If this attribute is present the element will be hidden. <br/>The hidden attribute can be set to keep a user from seeing an element until some other condition has been met (like selecting a checkbox, etc.). Then, a JavaScript could remove the hidden attribute, and make the element visible.";

$id = "The id attribute specifies a unique id for an HTML element (the id attribute value must be unique within the HTML document).<br/>"
."The id attribute can be used to point to a style in a style sheet.<br/>"
."The id attribute can also be used by a JavaScript (via the HTML DOM) to make changes to the HTML element with the specific id. <br/>"
."If not set in the form, the id is then generated automatiaclly (only for inputs) as a combination of form id plus '_' plus the name of the element.<br/>"
."<b>Value :</b> Any string, with the following restrictions: <br/> <ul>"
."<li>must be at least one character long</li>"
."<li>must not contain any space characters</li> </ul>"
."<b>Note: </b>Previous versions of HTML placed greater restrictions on the content of ID values (for example, they did not permit ID values to begin with a number).";
		
$lang = "    Specifies the primary language for the contents of the element and for any of the element’s attributes that contain text.<br/>"
."<b>Value:</b> A valid language tag as defined in [BCP 47].";

$spellcheck = "The spellcheck attribute is currently supported in Opera, Chrome, and Safari.<br/>"
."The spellcheck attribute specifies whether the element should have its spelling checked.<br/>"
."The following text can be spellchecked:"
."<ul><li>The text values in input elements (not password)</li>"
."<li>The text in &lt; textarea &gt; elements</li>"
."<li>The text in editable elements</li></ul>"
."<b>Values:</b><br/>"
."<ul><li>true - Specifies that the text is spellchecked</li>"
."<li>false -Specifies that the text is not spellchecked</li></ul>";

$style = "The style attribute specifies an inline style for an element.<br>"
."The style attribute will override any style set globally, e.g. styles specified in the <style> tag or in an external style sheet.<br/>"
."<b>Value:</b> One or more CSS properties and values separated by semicolons (e.g. style='color:blue;text-align:center')";

$tabindex ="The tabindex attribute specifies the tab order of an element (when the 'tab' button is used for navigating).<br/>"
."Specifies whether the element represents an element that is is focusable (that is, an element which is part of the sequence of focusable elements in the document), and the relative order of the element in the sequence of focusable elements in the document.<br/>"
."<b>Value:</b> number - Specifies the tabbing order of the element (1 is first)";

$title = "The title attribute specifies extra information about an element.<br/>"
."The information is most often shown as a tooltip text when the mouse moves over the element.<br/>"
."<b>Tip:</b> The title attribute is often used with &lt; form &gt; and &lt; a &gt; elements, to provide information about input formats and link destinations. It is also a required attribute for the &lt; abbr &gt; and &lt; acronym &gt; elements.";


$label = "The text which describes the field and appear near the input field.";
$disabled = "The disabled attribute specifies that an input element should be disabled.A disabled input element is unusable and un-clickable.<br/>"
."The disabled attribute can be set to keep a user from using an input element until some other condition has been met (like selecting a checkbox, etc.). Then, a JavaScript is required to remove the disabled value, and make the input element usable.<br/>"
."<b>Note:</b> The disabled attribute will not work with <input type='hidden'>.<br/>"
."<b>Tip:</b> Disabled form elements will not be submitted.<br/>"
."<Value:</b> - disabled - Specifies that the input element should be disabled";

$form = "The form attribute specifies one or more forms the input element belongs to.<br/>"
."<b>Value: </b> Specifies a space-separated list of id's to one or more forms the input element belongs to";

$maxlength = "The maxlength attribute specifies the maximum number of characters allowed in an input field.<br/>"
."<b>Value:</b> number - Specifies the maximum number of characters allowed in the input field";

$readonly = "The readonly attribute specifies that an input field is read-only, and cannot be modified (however, a user can tab to it, highlight it, and copy the text from it).<br/>"
."The readonly attribute can be set to keep a user from changing the value until some other conditions have been met (like selecting a checkbox, etc.). Then, a JavaScript is required to remove the readonly value, and make the input field editable.<br/>"
."<b>Note:</b> Read-only input fields will not be validated.<br/>"
."<b>Value:</b> readonly - Specifies that the input field should be read-only";

$size = "The size attribute specifies the width, in characters, of an input element.<br/>"
."<b>Value:</b> number - The width, in characters, of an input element";

$size2 = "The size attribute specifies the number of visible options in a drop-down list.<br/>"
."If the value of the size attribute is greater than '1', but lower than the total number of options in the list, the browser will add a scroll bar to indicate that there are more options to view.<br/>"
."<b>Value</b> number - The number of visible options in the drop-down list";

$value = "The value attribute specifies a value for an input element.<br/>"
."The value attribute is used differently for different types of input: <ul>"
."<li>For types like 'button', 'reset', 'submit - defines the text on the button</li>"
."<li>For types like 'text', 'password', 'hidden' - defines the initial (default) value of the input field</li>"
."<li>For types like 'checkbox', 'radio', 'image' - defines the value associated with the input. This is the value sent to the form's action URL</li>"
."</ul>"
."<b>Note:</b> The value attribute is required with input type='checkbox' and input type='radio'."
."Note: The value attribute cannot be used with input type='file'.<br/>"
."<b>Value:</b> value -The value of the input element";

$autofocus = "The autofocus attribute specifies that an input element should automatically get focus when the page loads.<br/>"
."<b>Value:</b> autofocus - Specifies that the input element should automatically get focus when the page loads";

$list = "The list attribute refers to a <b>datalist</b> containing predefined options for an input field. <br/>"
."<b>Value:</b> datalist-id  - Refers to an id of a datalist that contains predefined options for the input element";

$pattern = "The pattern attribute specifies a regular expression that input's value will be checked against.<br/>"
."Note: The pattern attribute works with the following input types: text, search, url, telephone, email, and password <br/>"
."Tip: Use the standard 'title' attribute to describe the pattern. <br/>"
."<b>Value</b> - regexp - Specifies a pattern used to validate an input field";

$required = "The required attribute specifies that an input field must be filled out before submitting.<br/>"
."Note: The required attribute works with the following input types: text, search, url, telephone, email, password, date pickers, number, checkbox, radio, and file. <br/>"
."<b>Value:</b> required - Specifies that the input field is a required field";

$placeholder = "The placeholder attribute specifies a short hint that describes the expected value of an input field (e.g. a sample value or a short description of the expected format).<br/>"
."The hint is displayed in the input field when it is empty, and disappears when the field gets focus.<br/>"
."<b>Note:</b> The placeholder attribute works with the following input types: text, search, url, telephone, email, and password"
."<b>Value:</b> text - Specifies a short hint that describes the expected value of the input field";

$checked ="The checked attribute specifies that an input element should be preselected when the page loads.<br/>"
."The checked attribute is used with input type='checkbox' or input type='radio'.<br/>"
."The checked attribute can also be set after the page load, with a JavaScript.<br/>"
."<b>Value:</b> checked - Specifies that the input element should be preselected when the page loads";

$multiple ="The multiple attribute specifies that multiple options can be selected at the same time.<br/>"
."Selecting multiple options vary in different operating systems and browsers: <ul>"
."<li>For windows: Hold down the control (ctrl) button to select multiple options</li>"
."<li>For Mac: Hold down the command button to select multiple options</li>"
."</ul>"
."Because of the different ways of doing this, and because you have to inform the user that multiple selection is available, it is more user-friendly to use checkboxes instead.";

$datalist = "The attribute is not a standard HTML5 attribute. With this we construvt the options elements in the select.<br/>"
."The value must contain a set of value:label pairs with the value separated from the label with a colon (:) and ended with(;). Whichever you use, something like the following <br/><br/>"
."<b>FE:FedEx; IN:InTime; TN:TNT</b> <br/><br/>"
."will construct <br/><br/>"
."&lt; select &gt; <br/>"
."&lt; option value='FE' &gt; FedEx &lt; /option &gt; <br/>"
."&lt; option value='IN' &gt; InTime &lt; /option &gt; <br/>"
."&lt; option value='TN' &gt; TNT &lt;/option &gt; <br/>"
."&lt; /select &gt;";

$datasql = "The attribute is not a standard HTML5 attribute. Use this if you want to obtain the options elemets from database using SQL query.<br/>"
."If the sql query contain only one field it is set as value and label.<br/>"
."If the query contain two or more fields the first field is used as value, while the second as label.<br/>"
."<b>Note</b> Both options Data List and Data SQL can be used at the same time. In this case the values from Data List are inserted first and then the values from SQL";
		
$formaction ="Specifies where to send the form-data when a form is submitted. Overrides the form's action attribute.<br/>"
."Possible values:<br/>"
."<ul><li>An absolute URL - points to another web site (like action='http://www.example.com/example.htm')</li>"
."<li>A relative URL - points to a file within a web site (like action='example.htm')</li><ul>";

$formenctype = "Specifies how form-data should be encoded before sending it to a server. Overrides the form's enctype attribute. <br/>"
."<b>Value</b><ul>"
."<li><b>application/x-www-form-urlencoded </b> - All characters are encoded before sent (this is default)</li>"
."<li><b>multipart/form-data</b> - No characters are encoded. This value is required when you are using forms that have a file upload control</li>"
."<li><b>text/plain</b> - Spaces are converted to '+' symbols, but no special characters are encoded</li>";

$formmethod = "Specifies how to send form-data. Overrides the form's action attribute.<br/>"
."<b>Value</b><ul>"
."<li><b>get </b> - Appends the form-data to the URL in name/value pairs: URL?name=value&name=value</li>"
."<li><b>post</b> - Sends the form-data as an HTTP post transaction</li>";

$target = "The target attribute specifies where to open the action URL.<br/>"
."Note: Frames and framesets are not supported in HTML5. The _parent, _top and framename values are now mostly used with iframes."
."<b>Values</b><ul>"
."<li><b>_blank</b> Open in a new window or tab</li>"
."<li><b>_self</b> Open in the same frame as it was clicked</li>"
."<li><b>_parent</b> Open in the parent framese</li>"
."<li><b>_top</b> Open in the full body of the window</li></ul>";

$formtarget = "Specifies where to open the action URL. Overrides the forms target attribute.<br/>"
."<b>Values</b><ul>"
."<li><b>_blank</b> Open in a new window or tab</li>"
."<li><b>_self</b> Open in the same frame as it was clicked</li>"
."<li><b>_parent</b> Open in the parent framese</li>"
."<li><b>_top</b> Open in the full body of the window</li></ul>";

$multiple2 = "The multiple attribute specifies that multiple values can be selected for an input field.<br/>"
."<b>Note:</b> The multiple attribute works with the following input types: email, and file.";

$accept ="The accept attribute is only used with input type='file' and it specifies the types of files that can be submitted through a file upload.<br/>"
."<b>Tip:</b> Do not use this attribute as your only validation tool. File uploads should be validated on the server.<br/>"
."<b>Values</b> <br/>"
."MIME_type 	One or more MIME types that can be submitted/uploaded. To specify more than one MIME type, separate the types with a comma."
."Look at IANA MIME types for a complete list of standard MIME types. <br/>(application, audio, example, image, message, model, multipart, text, video)";

$formnovalidate = "	Overrides the form's novalidate attribute. Defines that the input element should not be validated when submitted";

$alt = "The alt attribute is only used with input type=image and it specifies an alternate text for an image input.<br/>"
."The alt attribute provides alternative information if the user for some reason cannot view the image (because of slow connection, an error in the src attribute, or if the user uses a screen reader).";

$src ="The src attribute is only used with input type=image and it specifies the URL of an image to use.<br/>"
."The src attribute is required with input type=image."
."Possible values:<br/>"
."<ul><li>An absolute URL - points to another web site (like action='http://www.example.com/submit.gif')</li>"
."<li>A relative URL - points to a file within a web site (like action='submit.gif')</li><ul>";

$width = "The width attribute is only used with input type=image and it specifies the width of an image input.<br/>"
."<bTip:</b> Always specify both the height and width attributes for images. If height and width are set, the space required for the image is reserved when the page is loaded. However, without these attributes, the browser does not know the size of the image, and cannot reserve the appropriate space to it. The effect will be that the page layout will change during loading (while the images load).<br/>"
."<b>Value</b>:<ul>"
."<li> pixels - The width in pixels (like 100px or just 100)</li>"
."<li> % - The width in percent of the containing element (like 50%)</li></ul>";

$height = "The height attribute is only used with input type=image and it specifies the height of an image input.<br/>"
."<bTip:</b> Always specify both the height and width attributes for images. If height and width are set, the space required for the image is reserved when the page is loaded. However, without these attributes, the browser does not know the size of the image, and cannot reserve the appropriate space to it. The effect will be that the page layout will change during loading (while the images load).<br/>"
."<b>Value</b>:<ul>"
."<li> pixels - The width in pixels (like 100px or just 100)</li>"
."<li> % - The width in percent of the containing element (like 50%)</li></ul>";

$min = "The min attribute specifies the minimum value allowed for an input field.<br/>"
."<b>Tip:</b> The min attribute can be used together with the max attribute to create a range of legal values.<br/>"
."<b>Note:</b> The max and min attributes works with the following input types: number, range, date, datetime, datetime-local, month, time and week."
."<b>Value</b>:<ul>"
."<li> number - Specifies the minimum value allowed in the input field</li>"
."<li> date - Specifies the minimum date allowed in the input field</li></ul>";

$max = "The max attribute specifies the maximum value allowed for an input field.<br/>"
."<b>Tip:</b> The max attribute can be used together with the min attribute to create a range of legal values.<br/>"
."<b>Note:</b> The max and min attributes works with the following input types: number, range, date, datetime, datetime-local, month, time and week."
."<b>Value</b>:<ul>"
."<li> number - Specifies the maximum value allowed in the input field</li>"
."<li> date - Specifies the maximum date allowed in the input field</li></ul>";

$step = "The step attribute specifies the legal number intervals for an input field (if step='3', legal numbers could be -3,0,3,6, etc).<br/>"
."<b>Tip:</b> The step attribute can be used together with the max and min attributes to create a range of legal values.<br/>"
."<b>Note:</b> The step, max, and min attributes works with the following input types: number, range, date, datetime, datetime-local, month, time and week.<br/>"
."<b>Value:</b> <i>number</i> Specifies the legal number intervals for the input field.";

$valuedate ="A string representing a date.<br/>"
."<b>Value:</b> A valid full-date as defined in [RFC 3339], with the additional qualification that the year component is four or more digits representing a number greater than 0.";

$valueemail ="A single e-mail address or a list of valid e-mail addresses separated with comma.<br>"
."<b>Value:</b><br/>"
."Any string that matches the following [ABNF] production: <br/><br/>"
."<i> 1*( atext / '.' ) '@' ldh-str 1*( '.' ldh-str ) </i><br/><br/>"
."...where atext is as defined in [RFC 5322], and ldh-str is as defined in [RFC 1034].<br/>"
."<b>Example</b><br/>"
."<i>foo-bar.baz@example.com</i>";

$valuecolor ="An string representing a color.<br/>"
."<b>Value:</b> A string exactly seven characters long, consisting of the following parts, in exactly the following order: <ol>"
."<li>A '#' character.</li>"
."<li>Six characters in the range 0–9, a–f, and A–F.</li></ol>"
."<b>Note:</b> Color keywords (for example, strings such as 'red' or 'green') are not allowed.";

$separator = "Text that separates the elements within a group. For space use &amp; nbsp; word";
$text = "This not a standard HTML5 attribute. It set the text which should appear near to radio button";
$offval = "This not a standard HTML5 attribute. It determines the value which will be posted to the server if the checkbox in not checked.";
//============================
$data ="An object containing extra data that should be submitted along with the form. <br/>This is a name:value pair separated with comma. <b>Note</b> Enter a valid json like &quot; mykey &quot; : &quot; myval &quot; ";
$dataType ="Expected data type of the response. One of: null, 'xml', 'script', or 'json'. The dataType option provides a means for specifying how the server response should be handled. This maps directly to the jQuery.httpData method. The following values are supported: <br/> 'xml': if dataType == 'xml' the server response is treated as XML and the 'success' callback method, if specified, will be passed the responseXML value <br/>'json': if dataType == 'json' the server response will be evaluted and passed to the 'success' callback, if specified <br/>'script': if dataType == 'script' the server response is evaluated in the global context <br/>Default value: null";
$resetForm = "Boolean flag indicating whether the form should be reset if the submit is successful";
$clearForm = "Boolean flag indicating whether the form should be cleared if the submit is successful";
$iframe ="Boolean flag indicating whether the form should always target the server response to an iframe. This is useful in conjuction with file uploads. See the File Uploads documentation on the Code Samples page for more info. ";
$iframeSrc = "String value that should be used for the iframe's src attribute when/if an iframe is used.<br/>Default value: about:blank<br/>Default value for pages that use https protocol: javascript:false";
$forceSync = "Boolean value. Set to true to remove short delay before posting form when uploading files (or using the iframe option). The delay is used to allow the browser to render DOM updates prior to performing a native form submit. This improves usability when displaying notifications to the user, such as 'Please Wait...' ";
$beforeSerialize = "Callback function to be invoked before the form is serialized. This provides an opportunity to manipulate the form before it's values are retrieved. The beforeSerialize function is invoked with two arguments: the jQuery object for the form, and the Options Object passed into ajaxForm/ajaxSubmit. ";
$beforeSubmit ="Callback function to be invoked before the form is submitted. The 'beforeSubmit' callback can be provided as a hook for running pre-submit logic or for validating the form data. If the 'beforeSubmit' callback returns false then the form will not be submitted. The 'beforeSubmit' callback is invoked with three arguments: the form data in array format, the jQuery object for the form, and the Options Object passed into ajaxForm/ajaxSubmit. ";
$success ="Callback function to be invoked after the form has been submitted. If a 'success' callback function is provided it is invoked after the response has been returned from the server. It is passed the following arguments: <br/><ol><li>responseText or responseXML value (depending on the value of the dataType option).</li><li>statusText</li><li>xhr (or the jQuery-wrapped form element if using jQuery < 1.4)</li><li>jQuery-wrapped form element (or undefined if using jQuery < 1.4)</li></ol>";
$jscode = "Java Script code to be executed when the page renders.";
$jsevent = "Valid event name for the form or input element";
$jseventcode = "Java Script code associated with this event.";
$phpcode_b = "PHP Script code to be executed before the creation of the instance.";
$phpcode_r = "PHP Script code to be executed before the renderer class.";

$formlayout = "Defines the layout of the form. It can be: one column or two column.<br/> When one couln layout is used the label element is placed above the input element.<br> If a two colukmn layout is used the label element is places left(or right) to input element creating a table with two columns one for the label the other for the input element.";
$formheader = "A text which is placed at top at the form. This is the caption of the form.";
$formicon = "A valid name of icon from jQuery UI Theme roller. The icon is placed at left(right) of the caption of the form. The element is valid only if the form header attribute is set.";
$tablestyle = "The inline style attributes for table element with the input elements.";
$labelstyle = "Common inline style attributes for the labels column(s)";
$datastyle = "Common inline style attributes for the data (input elemens) column(s)";
$formfooter ="Text which is placed at bottom of the form";
$dbtype = "Select the database driver used.";
$conname ="The name of the connection. This name later can be used in the generated script to get and set data. ";
$connstring ="The connection string which create the connection. The string should contain a pair name=value separated by (;). <br/>Valid are the following values <i>host, database, user, password</i>. Additionally the following can be used too : <i>charset, port</i>. <br/><b>Example:</b> <br/> host=localhost;database=northwind;user=root;password=mypass";
$createconn = "If you plan to use your own connection set this to no, otherwiese the script will generate the needed connection code.";
$sqlstring = "Enter the SQL query to build and fill the fields into the form. Note that the query can be a diffrent from the table below.";
$table = "A table name from the database where the data will be submitted. The use of priimary key is mantadory.";
$tblkeys = "The primary key or a list of keys separated by comma. This field is mantadory and without this setting the data will not be saved into the database.<br/> The script automatically detect if the row exists in the database and if not create a new record.";
$serialkey = "Check this if the primary key is serial (autoincrement)";
?>
