LOCAL CRLF
CRLF = CHR(13) + CHR(10)
_out = []

 lcSeeAlsoTopics = oHelp.InsertSeeAlsoTopics() 

Response.Write(TRANSFORM( EVALUATE([ ExecuteTemplate("Header_Template.wcs") ]) ))

Response.Write([]+ CRLF +;
   []+ CRLF +;
   [<div style="margin-left:10pt;margin-right=10pt">]+ CRLF +;
   [<br>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Body) ]) ))

Response.Write([]+ CRLF +;
   [<br>]+ CRLF +;
   [<table border="0" cellpadding="3" width="99%">])

 IF !EMPTY(oHelp.oTopic.Example) 
Response.Write([]+ CRLF +;
   [  <tr>]+ CRLF +;
   [	 <td width="122" valign="top" align="right" class="labels">Example:</td>]+ CRLF +;
   [	 <td><pre><b>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Example)]) ))

Response.Write([</b></pre>]+ CRLF +;
   [</td>]+ CRLF +;
   [  </tr>])

 ENDIF 

 IF !EMPTY(oHelp.oTopic.Remarks) 
Response.Write([]+ CRLF +;
   [  <tr>]+ CRLF +;
   [	 <td width="122" valign="top" align="right" class="labels">Remarks:</td>]+ CRLF +;
   [	 <td>])

Response.Write(TRANSFORM( EVALUATE([ oHelp.FormatHTML(oHelp.oTopic.Remarks)]) ))

Response.Write([]+ CRLF +;
   [	 </td>]+ CRLF +;
   [  </tr>])

 ENDIF 
Response.Write([]+ CRLF +;
   [</table>]+ CRLF +;
   [])

 if !EMPTY(oHelp.oTopic.SeeAlso) 
Response.Write([]+ CRLF +;
   [<b>See also:</b>]+ CRLF +;
   [<div style="margin-left:10pt">])

Response.Write(TRANSFORM( EVALUATE([ STRTRAN(lcSeeAlsoTopics,"<BR>" + CHR(13) + CHR(10)," | ") ]) ))

Response.Write([]+ CRLF +;
   [</div>])

  endif 
Response.Write([]+ CRLF +;
   [</div>])

Response.Write(TRANSFORM( EVALUATE([ ExecuteTemplate("Footer_Template.wcs") ]) ))

