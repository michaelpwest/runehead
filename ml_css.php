<?
list($width) = @getimagesize($clanimage);
if ($width == "" || $width == 0 || $width < 775 || $width > 850){
	$width = "850px";
} else {
	$width .= "px";
}
echo "
body {
background-color: $bgcolour;				/* BG COLOUR */
color: $fontcolour1;						/* FONT COLOUR 1 */
font-family: $fontfamily;					/* FONT FAMILY */
font-size: $fontsize;						/* FONT SIZE */
margin: 0px;
padding: 0px;
line-height: 130%;
}

p {
margin-bottom: 0px;
}

select {
font-family: $fontfamily;					/* FONT FAMILY */
font-size: $fontsize;						/* FONT SIZE *
background-color: $bgcolour;				/* BG COLOUR */
color: $fontcolour1;                  		/* FONT COLOUR 1 */
letter-spacing: 0.5px;
width: 120px;
margin-right: 10px;
border: 1px solid $bordercolour;			/* BORDER COLOUR */
}

input {
font-family: $fontfamily;					/* FONT FAMILY */
font-size: $fontsize;						/* FONT SIZE *
background-color: $bgcolour;          		/* BG COLOUR */
color: $fontcolour1;                  		/* FONT COLOUR 1 */
border: 1px solid $bordercolour;			/* BORDER COLOUR */
}

.search {
text-align: center;
width: 110px;
}

a:link, a:visited, li a:link, li a:visited, a:hover, li a:hover {
text-decoration: underline;
color: $fontcolour2;						/* HEADER FONT 2 */
}

h1 {
width: $width;
margin: 5px auto 0px auto;
text-align: center;
font-size: 26px;
border: 1px solid $bordercolour;			/* BORDER COLOUR */
padding: 20px 0px 20px 0px;
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $headerfont;							/* HEADER FONT COLOUR */
line-height: 100%;
}

.banner {
display: block;
padding: 0px;
margin: 5px auto 0px auto;
}

#wrapper {
width: $width;
margin: 0px auto;
}

#runehead {
width: 100%;
background-color: $headerbg;				/* HEADER BG COLOUR */
text-align: center;
font-weight: bold;
height: 26px;
border: 1px solid $bordercolour;			/* BORDER COLOUR */
margin: 5px auto 0px;
text-align: left;
}

#runehead td {
padding: 0px 10px;
}

.selectrow {
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $headerfont;							/* HEADER FONT COLOUR */
text-align: center;
letter-spacing: 1px;
}

select, input {
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $headerfont;							/* HEADER FONT COLOUR */
}

.header {
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $headerfont;							/* HEADER FONT COLOUR */
text-align: center;
font-weight: bold;
text-transform: uppercase;
letter-spacing: 2px;
}

.subheader {
font-weight: bold;
background-color: $tablecolour;				/* TABLE COLOUR */
color: $fontcolour2;						/* FONT COLOUR 2 */
}

.header td{
height: 22px;
}

img {
color: $headerfont;							/* HEADER FONT COLOUR */
border: 0px;
}

#stats {
background-color: $tablecolour;				/* TABLE COLOUR */
color: $fontcolour2;
margin: 5px 0px;
width: 98%;
border-bottom: 1px solid $bordercolour;		/* BORDER COLOUR */
overflow: scroll;
}

#stats td {
border-width: 1px 1px 0px 1px;
border-style: solid;
border-color: $bordercolour;				/* BORDER COLOUR */
}

#stats ul {
padding: 0px;
margin: 9px 0px 9px 18px;
}

#stats li {
list-style-type: square;
padding: 0px;
margin: 4px;
}

#stats .gap{
margin-bottom: 20px;
}

#info {
background-color: $tablecolour;				/* TABLE COLOUR */
color: $fontcolour2;						/* FONT COLOUR 2 */
width: 100%;
margin: 5px 0px;
border-bottom: 1px solid $bordercolour;		/* BORDER COLOUR */
}

#info .border{
border-width: 1px 1px 0px 1px;
border-style: solid;
border-color: $bordercolour;				/* BORDER COLOUR */
}

#info #details {
margin: 2px auto;
display: block;
width: 500px;
}

#info p {
margin: 0px 0px 4px 0px;
padding: 0px;
}

#info .ranks{
width: 500px;
margin: 10px auto 0px;
display: block;
text-align: center;
border-left: 1px solid $bordercolour;		/* BORDER COLOUR */
border-top: 1px solid $bordercolour;		/* BORDER COLOUR */
}

#info .ranks td{
border-width: 0px 1px 1px 0px;
border-style: solid;
border-color: $bordercolour;				/* BORDER COLOUR */
}

#adtable, #editorialtable {
width: 100%;
padding: 0px 0px 0px 0px;
margin: 0px 0px 5px 0px;
text-align: center;
border: 1px solid $bordercolour;			/* BORDER COLOUR */
background-color: $tablecolour;				/* TABLE COLOUR */
}

.mlad_editorial {
display: block;
margin: 4px auto;
width: 100%;
}

.mlad_editorial .title {
font-weight: bold;
padding-right: 10px;
}

.mlad_editorial .details {
text-align: left;
}

.main {
margin: 0px 0px 5px 0px;
background-color: $tablecolour;				/* TABLE COLOUR */
width: 100%;
border-width: 0px;
text-align: center;
border-right: 1px solid $bordercolour;		/* BORDER COLOUR */
border-bottom: 1px solid $bordercolour;		/* BORDER COLOUR */
}

.main td {
padding: 2px 0px;
border-width: 1px 0px 0px 1px;
border-style: solid;
border-color: $bordercolour;				/* BORDER COLOUR */
}

#footer {
width: 100%;
text-align: center;
font-weight: bold;
border: 1px solid $bordercolour;			/* BORDER COLOUR */
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $fontcolour2;						/* FONT COLOUR 2 */
margin-bottom: 5px;
}

#footer p {
padding: 5px 0px;
margin: 0px 0px 0px 0px;
}

.headerfooter {
background-color: $headerbg;				/* HEADER BG COLOUR */
color: $headerfont;							/* HEADER FONT COLOUR */
}

.headerfooter a:link, .headerfooter a:visited, .headerfooter li a:link, .headerfooter li a:visited, .headerfooter a:hover, .headerfooter li a:hover {
text-decoration: underline;
color: $headerfont;							/* HEADER FONT 2 */
}
";
?>