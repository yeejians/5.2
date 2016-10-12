<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width"/>
		<style type="text/css">
			#outlook a {
			  padding:0;
			}

			body{
			  width:100% !important;
			  min-width: 100%;
			  -webkit-text-size-adjust:100%;
			  -ms-text-size-adjust:100%;
			  margin:0;
			  padding:0;
			}

			img {
			  outline:none;
			  text-decoration:none;
			  -ms-interpolation-mode: bicubic;
			  width: auto;
			  max-width: 100%;
			  float: left;
			  clear: both;
			  display: block;
			}

			center {
			  width: 100%;
			  min-width: 580px;
			}

			a img {
			  border: none;
			}

			p {
			  margin: 0 0 0 10px;
			}

			table {
			  border-spacing: 0;
			  border-collapse: collapse;
			}

			td {
			  word-break: break-word;
			  -webkit-hyphens: none;
			  -moz-hyphens: none;
			  hyphens: none;
			  border-collapse: collapse !important;
			}

			table, tr, td {
			  padding-right: 10px !important;
			  padding-left: 10px !important;
			  vertical-align: top;
			  text-align: left;
			}

			hr {
			  color: #d9d9d9;
			  background-color: #d9d9d9;
			  height: 1px;
			  border: none;
			}

			body, h1, h2, h3, h4, h5, h6, p, td {
			  color: #222222;
			  font-family: Helvetica, Arial, sans-serif;
			  font-weight: normal;
			  padding:0;
			  margin: 0;
			  text-align: left;
			  line-height: 1.3;
			}

			h1, h2, h3, h4, h5, h6 {
			  word-break: normal;
			}

			h1 {font-size: 40px;}
			h2 {font-size: 36px;}
			h3 {font-size: 32px;}
			h4 {font-size: 28px;}
			h5 {font-size: 24px;}
			h6 {font-size: 20px;}
			body, p, td {font-size: 14px;line-height:19px;}

			p {
			  margin-bottom: 10px;
			}

			small {
			  font-size: 10px;
			}

			a {
			  color: #2ba6cb;
			  text-decoration: none;
			}

			a:hover {
			  color: #2795b6 !important;
			}

			a:active {
			  color: #2795b6 !important;
			}

			a:visited {
			  color: #2ba6cb !important;
			}

			h1 a,
			h2 a,
			h3 a,
			h4 a,
			h5 a,
			h6 a {
			  color: #2ba6cb;
			}

			h1 a:active,
			h2 a:active,
			h3 a:active,
			h4 a:active,
			h5 a:active,
			h6 a:active {
			  color: #2ba6cb !important;
			}

			h1 a:visited,
			h2 a:visited,
			h3 a:visited,
			h4 a:visited,
			h5 a:visited,
			h6 a:visited {
			  color: #2ba6cb !important;
			}

			body.outlook p {
			  display: inline !important;
			}
		</style>
	</head>
	<body class="outlook" id="outlook">
		@yield('mailbody')

		<br /><br /><br /><p>This is an <strong>automatic generate</strong> and <strong>post-only</strong> mailing. Replies to this message are <strong>NOT</strong> monitored or answered. </p>
	</body>
</html>