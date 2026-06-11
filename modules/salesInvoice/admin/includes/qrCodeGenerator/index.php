<?php    

    include "qrlib.php";    
  
    
	
    
        $filename ='temp/test.png';
        QRcode::png('		      Vat No : 310606145600003
					 Invoice No : 103
					 Invoice Date : 08-09-2021
					 Vat Amt : 600.00
           Total With Vat: 4600.00
		', $filename,'L',2, 2);    
        
 
        
   echo '<img src="temp/test.png" /><br><br>';  
    

echo '<b>&nbsp;     شركة الدعم الرقمى للتجارة والمقاولات
			<br> &nbsp;    Digital Support Company <br>
			<br> &nbsp;&nbsp;&nbsp; CR No &nbsp;  2050240207 &nbsp;   س. ت. <br>
			<br>&nbsp;&nbsp;&nbsp;&nbsp;  Vat No&nbsp;&nbsp;&nbsp;  الرقم الضريبي 
			<br>&nbsp;&nbsp;  &nbsp;&nbsp; 310606145600003 
			
			<br><br>
			<span style="font-size:25px">TAX INVOICE /فاتوره ضريبه. </span>
			<br>
			
			Four thousand six hundred forty-six
			
			</b>
			';
			
echo " <BR><B style='font-size:15px'> Customer Name / اسم الزبون 	    &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;        : A.H.AI-ZAHIR TRADING EST <BR></b>
			<B style='font-size:13px'> Customer Address / عنوان العميل    &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  : PO BOX NO 72013 <BR> 
			&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; DAMMAM-31911 
			<BR>&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KINGDOW OF SAUDI ARABIA <BR>
		 
		    Customer Telephone No/رقم هاتف العميل &nbsp;<span style='color:#fff'>ad</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 013 833 7044  <br> 

			 Customer Vat Number/رقم ضريبة القيمة المضافة للعميل <span style='color:#fff'>ad</span>: 300405897700003<BR>			
		 
		 
		 </B>";

    