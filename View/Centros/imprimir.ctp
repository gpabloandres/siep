<?php /* 
02 App::import('Vendor','tcpdf/tcpdf');  
03 ob_clean();
04 // create new PDF document
05 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 
06        PDF_PAGE_FORMAT, true, 'UTF-8', false);
07 
08 // set document information
09 $pdf->SetCreator(PDF_CREATOR);
10 $pdf->SetAuthor('Nicola Asuni');
11 $pdf->SetTitle('TCPDF Example 001');
12 $pdf->SetSubject('TCPDF Tutorial');
13 $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
14 
15 // set default header data
16 $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 
17                     PDF_HEADER_TITLE.' 001', 
18                     PDF_HEADER_STRING, array(0,64,255), 
19                     array(0,64,128));
20 $pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));
21 
22 // set header and footer fonts
23 $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 
24                     PDF_FONT_SIZE_MAIN));
25 $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 
26                     PDF_FONT_SIZE_DATA));
27 
28 // set default monospaced font
29 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
30 
31 //set margins
32 $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, 
33                  PDF_MARGIN_RIGHT);
34 $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
35 $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
36 
37 //set auto page breaks
38 $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
39 
40 //set image scale factor
41 $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
42 
43 //set some language-dependent strings
44 $pdf->setLanguageArray($l);
45 
46 // ---------------------------------------------------------
47 
48 // set default font subsetting mode
49 $pdf->setFontSubsetting(true);
50 
51 // Set font
52 // dejavusans is a UTF-8 Unicode font, if you only need to
53 // print standard ASCII chars, you can use core fonts like
54 // helvetica or times to reduce file size.
55 $pdf->SetFont('dejavusans', '', 14, '', true);
56 
57 // Add a page
58 // This method has several options, check the source code 
59 documentation for more information.
60 $pdf->AddPage();
61 
62 // set text shadow effect
63 $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 
64                     'depth_h'=>0.2, 'color'=>array(196,196,
65                     196), 'opacity'=>1, 'blend_mode'=>
66                     'Normal'));
67 
68 $html = '<h1>HTML Example</h1>
69 Some special characters: &lt; ? &euro; &#8364; &amp; è 
70 &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-
71 slash
72 <h2>List</h2>
73 List example:
74 <ol>
75     
76     <li><b>bold text</b></li>
77     <li><i>italic text</i></li>
78     <li><u>underlined text</u></li>
79     <li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
80     <li><a href="http://www.tecnick.com" dir="ltr">link to 
81                 http://www.tecnick.com</a></li>
82     <li>Sed ut perspiciatis unde omnis iste natus error sit 
83     voluptatem accusantium doloremque laudantium, totam rem 
84     aperiam, eaque ipsa quae ab illo inventore veritatis et 
85     quasi architecto beatae vitae dicta sunt explicabo.<br />
86     Nemo enim ipsam voluptatem quia voluptas sit aspernatur 
87     aut odit aut fugit, sed quia consequuntur magni dolores 
88     eos qui ratione voluptatem sequi nesciunt.</li>
89     <li>SUBLIST
90         <ol>
91             <li>row one
92                 <ul>
93                     <li>sublist</li>
94                 </ul>
95             </li>
96             <li>row two</li>
97         </ol>
98     </li>
99     <li><b>T</b>E<i>S</i><u>T</u> <del>line through</del><
100     /li>
101     <li><font size="+3">font + 3</font></li>
102     <li><small>small text</small> normal <small>small text<
103     /small> normal <sub>subscript</sub> normal <sup>
104     superscript</sup> normal</li>
105 </ol>
106 <dl>
107     <dt>Coffee</dt>
108     <dd>Black hot drink</dd>
109     <dt>Milk</dt>
110     <dd>White cold drink</dd>
111 </dl>
112 <div style="text-align:center">IMAGES<br />
113 
114 </div>';
115 
116 // output the HTML content
117 $pdf->writeHTML($html, true, false, true, false, '');
118 
119 // ---------------------------------------------------------
120 
121 // Close and output PDF document
122 // This method has several options, check the source code 
123 documentation for more information.
124 $pdf->Output($centro['Centro']['id'].'.pdf', 'I');
125 exit;
126 //===========================================================
127    =+
128 // END OF FILE
129 //===========================================================
130    =+
131 */ ?>
