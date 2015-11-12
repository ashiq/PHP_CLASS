<?php
class functions
{
	
	function AddCustomersInfo()
	{
		$userExist = $this->checkUser();
		
		if(trim($userExist) == 'yes')
		{
			$error="0";
		}
		else
		{
			$dbObj1 = new Cdb(SERVER,DBNAME,DBUSER,DBPASS);
			$dbObj1->connectDB();
			$dbObj1->writeToDB("(
							`UserEmail` , 
							`UserName` , 
							`UserPassword` , 
							`RegisteredDate` , 
							`RegisteredTime` , 
							`BillingFirstName` , 
							`BillingAddress1` , 
							`BillingTownCity` , 
							`BillingCountyState` , 
							`BillingPostcode` , 
							`BillingTelephone` , 
							`BillingMobile`
							
		
							)							
							VALUES (
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['txtusrname'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['txtusrname'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['txtpasswd'])."', 
							'".date("Y-m-d")."', 
							'".date("h:i:s A")."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['fullName'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['streetAddress'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['city'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['State'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['zipCode'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['phoneDay'])."', 
							'".$this->ReplaceSingleAndDoubleQuote($_REQUEST['phoneNight'])."'
							
							)","customers");
			
			 				$_SESSION['USER_ID'] = $dbObj1->getCellFromDB("UserID", "customers", "UserEmail='".$_REQUEST['txtusrname']."' ");
			 				$_SESSION['BillingFirstName'] = $dbObj1->getCellFromDB("BillingFirstName", "customers", "UserID='".$_SESSION['USER_ID']."' ");
							$_SESSION['Email'] = $dbObj1->getCellFromDB("UserEmail", "customers", "UserID='".$_SESSION['USER_ID']."' ");
			 				$error="";
							

			}
			
			return $error;
			
	}
	
	
	function checkUser()
	{
		$dbObj = new Cdb(SERVER,DBNAME,DBUSER,DBPASS);
		$dbObj->connectDB();
	
		$data = $dbObj->getCellFromDB("UserName", "customers", "UserName='($_REQUEST[txtusrname]' or UserEmail = '$_REQUEST[txtusrname]'");
		
		
		if($data)
		{
			$msasdg = 'yes';
		}
		else
		{
		
			$msasdg = '';
		}
		
		return $msasdg;

	}
	
	function EditProperty()
	{
		$dbObj1 = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbObj1->connectDB();	
			
		
			
			$folder = "images/productimages/";
			
			move_uploaded_file($_FILES["productimage"]["tmp_name"] ,"$folder".$_FILES["productimage"]["name"]);
			move_uploaded_file($_FILES["productimage1"]["tmp_name"] ,"$folder".$_FILES["productimage1"]["name"]);
			
			move_uploaded_file($_FILES["productimage2"]["tmp_name"] ,"$folder".$_FILES["productimage2"]["name"]);
			move_uploaded_file($_FILES["productimage3"]["tmp_name"] ,"$folder".$_FILES["productimage3"]["name"]);
			move_uploaded_file($_FILES["productimage4"]["tmp_name"] ,"$folder".$_FILES["productimage4"]["name"]);
			move_uploaded_file($_FILES["LogoImage"]["tmp_name"] ,"$folder".$_FILES["LogoImage"]["name"]);
			
			$image1='';$image2='';$image3='';$image4='';$image5='';$logo='';
			
			if($_FILES["productimage"]["tmp_name"]!='')
			{
				$image1="ProductImage = '".$_FILES['productimage']['name']."',";
			}
			if($_FILES["productimage1"]["tmp_name"]!='')
			{
				$image2="ProductImage1 = '".$_FILES['productimage1']['name']."',";
			}
			if($_FILES["productimage2"]["tmp_name"]!='')
			{
				$image3="ProductImage2 = '".$_FILES['productimage2']['name']."',";
			}
			if($_FILES["productimage3"]["tmp_name"]!='')
			{
				$image4="ProductImage3 = '".$_FILES['productimage3']['name']."',";
			}
			if($_FILES["productimage4"]["tmp_name"]!='')
			{
				$image5="ProductImage4 = '".$_FILES['productimage4']['name']."',";
			}
			if($_FILES["LogoImage"]["tmp_name"]!='')
			{
				$logo="LogoImage = '".$_FILES['LogoImage']['name']."',";
			}
			
			
			if($_REQUEST["imgNew"])
			{
				$logoimage="new_tiny.gif";
			}
			elseif ($_REQUEST["imgAvailableSoon"])
			{
				$logoimage="available-soon_scriptred.jpg";
			}
			elseif ($_REQUEST["imgSold"])
			{
				$logoimage="sold_ani.gif";
			}
			elseif ($_REQUEST["imgUnderContract"])
			{
				$logoimage="undercontract.gif";
			}
			elseif ($_REQUEST["imgOwnerFinancing"])
			{
				$logoimage="ownerfinancing.gif";
			}
			elseif ($_REQUEST["imgDepositTaken"])
			{
				$logoimage="deposittaken.gif";
			}
			elseif ($_REQUEST["imgBackOnTheMarket"])
			{
				$logoimage="backonthemarket.gif";
			}
			
			 $qry="update products set   
			 
			 	  City = '".$_REQUEST['City']."',
			 	  ZipCode = '".$_REQUEST['ZipCode']."',
			 	  CompanyName = '".$_REQUEST['CompanyName']."',
			 	  FirstName = '".$_REQUEST['FirstName']."',
			 	  LastName = '".$_REQUEST['LastName']."',
			 	  EmailAddress = '".$_REQUEST['EmailAddress']."',
			 	  PhoneNumber = '".$_REQUEST['PhoneNumber']."',
			 	  FaxNumber = '".$_REQUEST['FaxNumber']."',
			 	  CategoryID = '".$_REQUEST['CategoryID']."',
			 	  CategoryID = '".$_REQUEST['CategoryID']."',
			 	  
			 	  Address= '".$_REQUEST['Address']."',
			 	  SalePrice= '".$_REQUEST['SalePrice']."',
			 	  ProductDescription= '".$_REQUEST['Comments']."',
			 	  MonthlyRentCredit = '".$_REQUEST['MonthlyRentCredit']."',
			 	  Type= '".$_REQUEST['Type']."',
			 	  Bedrooms= '".$_REQUEST['Bedrooms']."',
			 	  Basement= '".$_REQUEST['Basement']."',
			 	  FullBathrooms= '".$_REQUEST['FullBathrooms']."',
			 	  HalfBathrooms= '".$_REQUEST['HalfBathrooms']."',
			 	  Levels= '".$_REQUEST['Levels']."',
			 	  Parking= '".$_REQUEST['Parking']."',
			 	  Contact= '".$_REQUEST['Contact']."',
			 	  ParkingSpaces= '".$_REQUEST['ParkingSpaces']."',
			 	  SqFtTotal= '".$_REQUEST['SqFtTotal']."',
			 	  SqFtUNFinished= '".$_REQUEST['SqFtUNFinished']."',
			 	  SqFtFinished= '".$_REQUEST['SqFtFinished']."',
			 	  Direction= '".$_REQUEST['Direction']."',
			 	  RentPrice= '".$_REQUEST['RentPrice']."',
			 	  EmailBlastText= '".trim($_REQUEST['EmailBlastText'])."',
			 	  LogoImage = '".$logoimage."',
			 	  
			 	  desc1= '".trim($_REQUEST['desc1'])."',
			 	  desc2= '".trim($_REQUEST['desc2'])."',
			 	  desc3= '".trim($_REQUEST['desc3'])."',
			 	  desc4= '".trim($_REQUEST['desc4'])."',
			 	  desc5= '".trim($_REQUEST['desc5'])."',
			 	  desc6= '".trim($_REQUEST['desc6'])."',
			 	  desc7= '".trim($_REQUEST['desc7'])."',
			 	  desc8= '".trim($_REQUEST['desc8'])."',
			 	  desc9= '".trim($_REQUEST['desc9'])."',
			 	  desc10= '".trim($_REQUEST['desc10'])."',
			 	  desc11= '".trim($_REQUEST['desc11'])."',
			 	  
			 	  
			 	  headline= '".trim($_REQUEST['headline'])."',
			 	  estimaterepairs= '".trim($_REQUEST['estimaterepairs'])."',
			 	  saleaddress1= '".trim($_REQUEST['saleaddress1'])."',
			 	  soldprice1= '".trim($_REQUEST['soldprice1'])."',
			 	  saleaddress2= '".trim($_REQUEST['saleaddress2'])."',
			 	  soldprice2= '".trim($_REQUEST['soldprice2'])."',
			 	  saleaddress3= '".trim($_REQUEST['saleaddress3'])."',
			 	  soldprice3= '".trim($_REQUEST['soldprice3'])."',
			 	  rentaddress1= '".trim($_REQUEST['rentaddress1'])."',
			 	  rentprice1= '".trim($_REQUEST['rentprice1'])."',
			 	  rentaddress2= '".trim($_REQUEST['rentaddress2'])."',
			 	  rentprice2= '".trim($_REQUEST['rentprice2'])."',
			 	  rentaddress3= '".trim($_REQUEST['rentaddress3'])."',
			 	  rentprice3= '".trim($_REQUEST['rentprice3'])."',
			 	  salemis1='".trim($_REQUEST['salemis1'])."',
			 	  salemis2='".trim($_REQUEST['salemis2'])."',
			 	  salemis3='".trim($_REQUEST['salemis3'])."',
			 	  
			 	  rentmis1='".trim($_REQUEST['rentmis1'])."',
			 	  rentmis2='".trim($_REQUEST['rentmis2'])."',
			 	  rentmis3='".trim($_REQUEST['rentmis3'])."',
			 	  
			 	  
			 	  
			 	  
			      $image1 $image2 $image3 $image4 $image5 
			      LotSizeAcres= '".$_REQUEST['LotSizeAcres']."'
			      
			      where ProductID = '".$_REQUEST['ProductID']."'";
			 
			
			$dbObj1->queryDB($qry);
		
		
	}
	
	
	function AddProperty()
	{
		
			$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
			$dbobj->connectDB();
			
			$folder = "images/productimages/";
			move_uploaded_file($_FILES["productimage"]["tmp_name"] ,"$folder".$_FILES["productimage"]["name"]);
			
			move_uploaded_file($_FILES["productimage1"]["tmp_name"] ,"$folder".$_FILES["productimage1"]["name"]);
			
			move_uploaded_file($_FILES["productimage2"]["tmp_name"] ,"$folder".$_FILES["productimage2"]["name"]);
			
			move_uploaded_file($_FILES["productimage3"]["tmp_name"] ,"$folder".$_FILES["productimage3"]["name"]);
			
			move_uploaded_file($_FILES["productimage4"]["tmp_name"] ,"$folder".$_FILES["productimage4"]["name"]);
			
	
			
			//move_uploaded_file($_FILES["LogoImage"]["tmp_name"] ,"$folder".$_FILES["LogoImage"]["name"]);
			
			if($_REQUEST["imgNew"])
			{
				$logoimage="new_tiny.gif";
			}
			elseif ($_REQUEST["imgAvailableSoon"])
			{
				$logoimage="available-soon_scriptred.jpg";
			}
			elseif ($_REQUEST["imgSold"])
			{
				$logoimage="sold_ani.gif";
			}
			elseif ($_REQUEST["imgUnderContract"])
			{
				$logoimage="undercontract.gif";
			}
			elseif ($_REQUEST["imgOwnerFinancing"])
			{
				$logoimage="ownerfinancing.gif";
			}
			elseif ($_REQUEST["imgDepositTaken"])
			{
				$logoimage="deposittaken.gif";
			}
			elseif ($_REQUEST["imgBackOnTheMarket"])
			{
				$logoimage="backonthemarket.gif";
			}
			
			$dbobj->writeToDB("(CategoryID,Address,SalePrice,RentPrice,ProductDescription,
									MonthlyRentCredit,ProductImage,ProductImage1,ProductImage2,ProductImage3,ProductImage4,LogoImage,
									Type,Bedrooms,FullBathrooms,HalfBathrooms,Levels,Parking,Contact,ParkingSpaces,SqFtTotal,SqFtUNFinished
									,SqFtFinished,LotSizeAcres,Direction
									,City
									,ZipCode
									,CompanyName
									,FirstName
									,LastName
									,EmailAddress
									,PhoneNumber
									,FaxNumber
									,Basement
									,EmailBlastText
									,UserID
									,desc1
									,desc2
									,desc3
									,desc4
									,desc5
									,desc6
									,desc7
									,desc8
									,desc9
									,desc10
									,desc11
									,headline
									,estimaterepairs
									,saleaddress1
									,soldprice1
									,saleaddress2
									,soldprice2
									,saleaddress3
									,soldprice3
									,rentaddress1
									,rentprice1
									,rentaddress2
									,rentprice2
									,rentaddress3
									,rentprice3
									,salemis1
									,salemis2
									,salemis3
									,rentmis1
									,rentmis2
									,rentmis3
									
									)
									VALUES
									(
										'".$_REQUEST["CategoryID"]."','".$_REQUEST["Address"]."','".$_REQUEST["SalePrice"]."'
										,'".$_REQUEST["RentPrice"]."','".$_REQUEST["Comments"]."',
							 			'".$_REQUEST["MonthlyRentCredit"]."','".$_FILES['productimage']['name']."','".$_FILES['productimage1']['name']."'
							 			,'".$_FILES['productimage2']['name']."','".$_FILES['productimage3']['name']."','".$_FILES['productimage4']['name']."',
							 			'".$logoimage."','".$_REQUEST["Type"]."',
							 			'".$_REQUEST["Bedrooms"]."','".$_REQUEST["FullBathrooms"]."','".$_REQUEST["HalfBathrooms"]."',
							 			'".$_REQUEST["Levels"]."','".$_REQUEST["Parking"]."','".$_REQUEST["Contact"]."','".$_REQUEST["ParkingSpaces"]."'
							 			,'".$_REQUEST["SqFtTotal"]."','".$_REQUEST["SqFtUNFinished"]."','".$_REQUEST["SqFtFinished"]."','".$_REQUEST["LotSizeAcres"]."','".$_REQUEST["Direction"]."'
							 			
							 			,'".$_REQUEST["City"]."','".$_REQUEST["ZipCode"]."'
							 			,'".$_REQUEST["CompanyName"]."','".$_REQUEST["FirstName"]."'
							 			,'".$_REQUEST["LastName"]."','".$_REQUEST["EmailAddress"]."'
							 			,'".$_REQUEST["PhoneNumber"]."','".$_REQUEST["FaxNumber"]."','".$_REQUEST['Basement']."','".trim($_REQUEST['EmailBlastText'])."','".$_SESSION['USER_ID']."'
							 			
							 			,'".$_REQUEST['desc1']."'
							 			,'".$_REQUEST['desc2']."'
							 			,'".$_REQUEST['desc3']."'
							 			,'".$_REQUEST['desc4']."'
							 			,'".$_REQUEST['desc5']."'
							 			,'".$_REQUEST['desc6']."'
							 			,'".$_REQUEST['desc7']."'
							 			,'".$_REQUEST['desc8']."'
							 			,'".$_REQUEST['desc9']."'
							 			,'".$_REQUEST['desc10']."'
							 			,'".$_REQUEST['desc11']."'
							 			
							 			,'".$_REQUEST['headline']."'
							 			,'".$_REQUEST['estimaterepairs']."'
							 			,'".$_REQUEST['saleaddress1']."'
							 			,'".$_REQUEST['soldprice1']."'
							 			,'".$_REQUEST['saleaddress2']."'
							 			,'".$_REQUEST['soldprice2']."'
							 			,'".$_REQUEST['saleaddress3']."'
							 			,'".$_REQUEST['soldprice3']."'
							 			,'".$_REQUEST['rentaddress1']."'
							 			,'".$_REQUEST['rentprice1']."'
							 			,'".$_REQUEST['rentaddress2']."'
							 			,'".$_REQUEST['rentprice2']."'
							 			,'".$_REQUEST['rentaddress3']."'
							 			,'".$_REQUEST['rentprice3']."'
							 			,'".trim($_REQUEST['salemis1'])."'
							 			,'".trim($_REQUEST['salemis2'])."'
							 			,'".trim($_REQUEST['salemis3'])."'
							 			,'".trim($_REQUEST['rentmis1'])."'
							 			,'".trim($_REQUEST['rentmis2'])."'
							 			,'".trim($_REQUEST['rentmis3'])."'
							 			
							 		)",
							 		"products"
							  	 );
							  	 
			
			
		
	}
	
	
	
	function roundNumber($value,$decimalplaces)
	{
		return number_format($value, $decimalplaces, '.', '');
	}
	
	
	function ReplaceSingleAndDoubleQuote($str)
	{
	  $ChangedStr = str_replace(array('\"','"'),"&quot;",str_replace(array("\'","'"),"&#39;",$str));
	  return $ChangedStr;
	}

	
	function sigin()
	{
		$dbObj = new Cdb(SERVER,DBNAME,DBUSER,DBPASS);
		$dbObj->connectDB();
		
		$billingRecord = $dbObj->getRowFromDB("select * from customers  where UserEmail like '".$_REQUEST['txtusrname']."' and UserPassword='".$_REQUEST['txtpasswd']."' limit 0,1");
		
		if (count($billingRecord)>0) 
		{
			$_SESSION['USER_ID'] = $billingRecord['UserID'];
			$_SESSION['BillingFirstName'] = $billingRecord['BillingFirstName'];
			$_SESSION['Email'] = $billingRecord['UserEmail'];
			$error="";
		}
		else 
		{
			$error="Invalid User Email / Password";
		}
		
		return $error;
		
	}
	
	function getContentSigin($error)
	{
		if($error=="Invalid User Email / Password")
		{
			$content = 'login.php';
		}
		else 
		{
			$content="dashboard.php";
		}
		
		return $content;
	}
	
	
	function getContentSignup($error)
	{
		if($error=="0")
		{
			$content = 'signup.php';
		}
		else 
		{
			$content="dashboard.php";
		}
		
		return $content;
	}
	
	
	function DeleteRecord()
	{
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$qry="delete from products where ProductID = '".$_REQUEST['pid']."'";
		$dbobj->queryDB($qry);
		
		
		
	}
	
	function ShowOneRecord()
	{
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from products where ProductID = '".$_REQUEST['pid']."'");
		return $row; 

		
	}
	
	function showcategory(){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from category order by  CategoryID asc");
		return $row; 
	
	}
	
	
	function showonecategory($catid){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from category where CategoryID='".$catid."' order by  CategoryID asc");
		return $row; 
	
	}
	
	function get_Brochure_Text()
	{
		$row=mysql_fetch_array(mysql_query("select * from products where ProductID = '".$_REQUEST['pid']."'"));
		$g=mysql_fetch_array(mysql_query("select CategoryDescription from category where CategoryID='".$row[CategoryID]."'"));
		$Brochure_Text='
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Brochure</title>
		</head>
		
		<body >
		<table width="994" border="0" cellpadding="0" cellspacing="0" align="center" style="font-family:times;font-size:12px;border:1px solid #2F1F12;" height="700">
		<tr>
		<td bgcolor="#e5dac6" align="center" width="494" height="15" style="border-bottom:1px solid #fff;">&nbsp;</td>
		</tr>
		<tr>
		<td bgcolor="#e5dac6" align="center" width="994" height="162" style="border-bottom:1px solid #fff;padding-bottom:5px;">
		<font color="#000013" face="times" size="5">FOR SALE &diams; RENT TO OWN!!</font><br />
		<font color="#000013" face="times" size="7">FOR ONLY $'.$row["RentPrice"].'/MONTH</font><br />
		<font color="#bf2c1a" face="times" size="4">NO BANK QUALIFYING! NO/DAMAGED CREDIT O.K.</font><br />
		<font color="#bf2c1a" face="times" size="4">Low Down Payment!</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#e5dac6" align="center" width="994" height="15" style="border-bottom:1px solid #1a1108;">&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table width="994" border="0" cellpadding="0" cellspacing="0" align="center" height="517">
		<tr>
		<td width="240" bgcolor="#67512c" height="517" align="left">
			<table width="240" border="0" cellpadding="0" cellspacing="0" align="center"  > 
		      <tr>
		        <td width="240" height="132" bgcolor="#e41b2d" style="line-height:135%;font-size:18px;padding-left:20px;color:#fff;" >
		                <br>
		                	Self-Employed?<br>
		                   Damaged Credit?<br>
		                   No Credit?<br><br>
		   					<strong> YOU CAN BUY <br>
		                  THIS HOUSE !<br>
							</strong>
		                <br>
		             </td>
		      </tr>
		     
		      <tr>
		        <td width="240" height="191" style="line-height:155%;font-size:18px;padding-top:5px;padding-left:10px;color:#fff;" >
		        <br>
		        	&#149; &nbsp;Rent to own for only<br>
					&nbsp;&nbsp;&nbsp;$'.$row["RentPrice"].'/mo</font><br>
				
				
				
					
					&#149; &nbsp;$'.$row["MonthlyRentCredit"].'/mo rent</font><br>
					&nbsp;&nbsp;&nbsp;credit goes towards<br>
					&nbsp;&nbsp;&nbsp;PRINCIPLE!!<br>
					
						
		          &#149; &nbsp;Low Down Payment!<br>
		           &#149; &nbsp;Aggressively priced<br>
					&nbsp;&nbsp;&nbsp;at only $199900!<br />
				
		        </td>
		      </tr>
		      
		       <tr><Td height="130"></td></tr>
		      <tr>
		        <td style="padding-left:25px;"><a href="http://thertoplace.com" target="_blank">
		        								<img src="http://thertoplace.com/images/rsz_logo_b.png" width="170" height="175" border="0">
		        								</a></td>
		      </tr>
		        <tr>
		        <td style="padding-left:15px;height:5px;"></td>
		      </tr> <tr>
		        <td style="line-height:135%;font-size:18px;padding-left:30px;color:#fff;">&nbsp;</td>
		      </tr> <tr>
		        <td style="line-height:135%;font-size:18px;padding-left:30px;color:#fff;">&nbsp;</td>
		      </tr> ';
		      
		     if($row['PhoneNumber']!=""){
		         $Brochure_Text.=' <tr>
		           <td style="line-height:135%;font-size:18px;padding-left:30px;color:#fff;">&nbsp;</td> 
		          </tr>';
		      }
		      
		      
		       $Brochure_Text.='<tr>
		       <td style="line-height:135%;font-size:18px;padding-left:30px;color:#fff;">&nbsp;</td> 
		      </tr>';
		      
		     if($row['PhoneNumber']==""){
		           $Brochure_Text.='<tr>
		           <td style="line-height:135%;font-size:18px;padding-left:30px;color:#fff;">&nbsp;</td> 
		          </tr>';
		      }
		      
		     $Brochure_Text.='</table>';
		
		$Brochure_Text.=' </td>
		<td width="754" height="547" align="right">
			<table width="350" border="0"  cellpadding="0" cellspacing="0" align="center" height="517">
		      <tr>
		        <td height="300" width="744" align="center"><img src="http://thertoplace.com/PHP/admin/images/productimages/'.$row['ProductImage'].'" height="300" width="754" /></td>
		      </tr>
		      <tr>
		        <td height="32" width="744" bgcolor="#2f1f12" align="center" style="text-align:center; font-weight:bold;font-size:20px;color:white; ">'.$row["Address"].", ".$row["City"].", ".$g["CategoryDescription"]."  ".$row["ZipCode"].'</td>
		      </tr>
		      <tr>
		        <td height="260" width="744" align="left" valign="top" style="padding-left:20px;padding-top:10px;font-size:19px;">
		        	<p  style="text-align:left; font-style:italic; font-size:20px;"><b>Description:</b>
		           
		            <br><span style="text-align:left; font-style:normal; font-size:19px;">
		          '.$row["ProductDescription"].'</span></p>
		        </td>
		      </tr>
		     <tr><Td height="190"></td></tr>
		      
		    
		
		      <tr>
		        <td height="66" width="744" style="border-top:1px solid #a2a6a9;color:white;" bgcolor="#2f1f12" align="left">
		
		          
								
		           <font color="#fff" face="times" size="3" style="text-align:left; font-style:italic; margin-left:30px;  margin-right:0px; font-weight:bold;color:white;font-size:19px;">Find more details on how the Rent To Own Program works</font><br />
		           <font color="#fff" face="times" size="3" style="text-align:left; font-style:italic; margin-left:30px;  margin-right:0px; font-weight:bold;color:white;font-size:19px;">& see other Rent To Own homes at www.theRTOplace.com</font><br />
		
		        </td>
		      </tr>
		    </table>
		
		</td>
		</tr>
		</table>
		
		</td>
		</tr>
		</table>
		
		</body>
		</html>';
		  
		return trim($Brochure_Text);
		
	}
	


}

?>