LOCAL CRLF
CRLF = CHR(13) + CHR(10)
_out = []

 lcSeeAlsoTopics = oHelp.InsertSeeAlsoTopics() 

Response.Write(TRANSFORM( EVALUATE([ ExecuteTemplate("Header_template.wcs") ]) ))

Response.Write([]+ CRLF +;
   []+ CRLF +;
   [<div class="contentpane">]+ CRLF +;
   []+ CRLF +;
   [<div class="contentbody" id="body">])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Body) ]) ))

Response.Write([]+ CRLF +;
   [</div>]+ CRLF +;
   [])

 IF !EMPTY(oHelp.oTopic.Syntax) 
Response.Write([]+ CRLF +;
   [<pre class="SyntaxBox" id="syntax">])

Response.Write(TRANSFORM( EVALUATE([ oHelp.oTopic.Syntax ]) ))

Response.Write([]+ CRLF +;
   [</pre>])

 ENDIF 

 IF !EMPTY(oHelp.oTopic.Returns) 
Response.Write([]+ CRLF +;
   [<h3 class="outdent" id="returnvalue">Return Value</h3>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Returns)]) ))


 ENDIF 

 IF !EMPTY(oHelp.oTopic.Parameters) 
Response.Write([]+ CRLF +;
   [<h3 class="outdent" id="parameters">Parameters</h3>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(strtran(oHelp.oTopic.Parameters,"b>","i>"))]) ))


 ENDIF 

 IF !EMPTY(oHelp.oTopic.Remarks) 
Response.Write([]+ CRLF +;
   [<h3 class="outdent" id="remarks">Remarks</h3>]+ CRLF +;
   [])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Remarks) ]) ))


 ENDIF 

 IF !EMPTY(oHelp.oTopic.Example) 
Response.Write([]+ CRLF +;
   [<h3 class="outdent" id="example">Example</h3>]+ CRLF +;
   [<pre>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatExample(oHelp.oTopic.Example) ]) ))

Response.Write([</pre>])

 ENDIF 

 if !EMPTY(oHelp.oTopic.SeeAlso) 
Response.Write([]+ CRLF +;
   [<h3 class="outdent" id="seealso">See also</h3>])

Response.Write(TRANSFORM( EVALUATE([ lcSeeAlsoTopics ]) ))


  endif 
Response.Write([]+ CRLF +;
   []+ CRLF +;
   [</div>])

Response.Write(TRANSFORM( EVALUATE([ ExecuteTemplate("Footer_Template.wcs") ]) ))

