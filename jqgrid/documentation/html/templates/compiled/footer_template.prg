LOCAL CRLF
CRLF = CHR(13) + CHR(10)
_out = []
Response.Write([<hr />]+ CRLF +;
   [<div class="footer">]+ CRLF +;
   [	Last Updated: ])

Response.Write(TRANSFORM( EVALUATE([ TTOD(oHelp.oTopic.Updated) ]) ))

Response.Write([ | ]+ CRLF +;
   [	&copy ])

Response.Write(TRANSFORM( EVALUATE([ oHelp.cProjCompany ]) ))

Response.Write([, ])

Response.Write(TRANSFORM( EVALUATE([ Year(Date()) ]) ))

Response.Write([]+ CRLF +;
   [</div>]+ CRLF +;
   [<br class="clear" />]+ CRLF +;
   [<br />]+ CRLF +;
   [</body>]+ CRLF +;
   [</html>])
