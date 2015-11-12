<?php

class GContentManagement{
	private $page;
	private $paging;
	//Constructor
	function GContentManagement(){}
	
	//Function to add section
	function addSection($section_type,$section_description){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$dbobj->writeToDB("(SectionTitle, SectionDescription)VALUES('$section_type', '$section_description')","pagesection");		
		$dbobj->disconnectDB();
	}
	
	//Funtion showing one row record 	
		function showOneSectionRecord($section_id){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getRowFromDB("select * from pagesection where SectionID = '".$section_id."'");
		return $row; 
		$dbobj->disconnectDB();
	}
	//Funtion showing all records 	
	function ShowSectionsRecord(){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from pagesection order by  SectionID asc");
		return $row; 
		$dbobj->disconnectDB();
	}
	//Funtion showing all records 	
	function ShowSectionPagesRecord($section_id){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from contentspagetemplate where SectionID= '".$section_id."'  order by  sortOrder asc");
		return $row; 
		$dbobj->disconnectDB();
	}
	//Funtion update section record 	
	function editSection($section_id, $section_title,$section_description){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$dbobj->updateInDB("SectionTitle = '".$section_title."', SectionDescription= '".$section_description."'"," SectionID='".$section_id."'","pagesection");
		$dbobj->disconnectDB();
	}
	//Funtion to delete section record 	
	function deleteSection($section_id){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$dbobj->deleteFromDB("delete from pagesection where SectionID = '".$section_id."'");
		$dbobj->disconnectDB();
	}
	//Function to add page contents
	function addPage($page_title,$page_meta_title,$page_meta_description,$page_meta_keywords,$page_content,$show_on_page,$section_type){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$maxqry=$dbobj->getCellFromDB("max(sortOrder)","contentspagetemplate","1=1");
 		$sort_order=$maxqry+1;		
		$dbobj->writeToDB("(SectionID, PageTitle, PageMetaTitle, PageMetaDescription, PageMetaKeywords, PageContents, showOnPage, sortOrder )VALUES('$section_type', '$page_title', '$page_meta_title', '$page_meta_description', '$page_meta_keywords','".nl2br($page_content)."', '$show_on_page', '$sort_order')","contentspagetemplate");		
		$dbobj->disconnectDB();
	}
	//Funtion showing all records 	
	function ShowPagesRecord(){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getTablesFromDB("select * from  contentspagetemplate order by  sortOrder asc");
		return $row; 
		$dbobj->disconnectDB();
	}
	//Funtion to delete content page record 	
	function deletePage($page_id){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$dbobj->deleteFromDB("delete from  contentspagetemplate where ContentPageID = '".$page_id."'");
		$dbobj->disconnectDB();
	}
	//Funtion update content page record 	
	function editPage($page_id,$page_title,$page_meta_title,$page_meta_description,$page_meta_keywords,$page_content,$show_on_page,$section_type){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$dbobj->updateInDB("SectionID = '".$section_type."', PageTitle= '".$page_title."', PageMetaTitle= '".$page_meta_title."', PageMetaDescription='".$page_meta_description."', PageMetaKeywords='".$page_meta_keywords."', PageContents='".$page_content."', showOnPage='".$show_on_page."'"," ContentPageID='".$page_id."'","contentspagetemplate");
		$dbobj->disconnectDB();
	}
	//Funtion showing one row record 	
	function showOnePageRecord($page_id){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		$row = $dbobj->getRowFromDB("select * from contentspagetemplate where ContentPageID = '".$page_id."'");
		//if(){
				$str = "[[CLOSE_WINDOW]]";
				
			//}
		return $row; 
		$dbobj->disconnectDB();
	}
	//Funtion update content page record 	
	function sortPageOrder($present_sortid,$future_sortid,$current_pageID){
		$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$dbobj->connectDB();
		if($present_sortid!='' && $future_sortid!=''){
		$dbobj->updateInDB("sortOrder='".$present_sortid."'","sortOrder='".$future_sortid."'","contentspagetemplate");
		$dbobj->updateInDB("sortOrder='".$future_sortid."'","ContentPageID='".$current_pageID."'","contentspagetemplate");
		}
		$dbobj->disconnectDB();
	}
	//add form for section
	function addSectionForm(){
		$content = 'addSectionForm.php';
		include_once('templates/main/main_page.php');
	}	
	//insert section record into db
	function insertSectionRecord(){
			//$cmsObj = new GContentManagement();
			$this->addSection($_REQUEST["section_title"],$_REQUEST["section_description"]);
			header("location:contentManagement.php?cmd=showSections&msg=add");
	}
	//update section record	
	function updateSectionRecord(){
			//$cmsObj = new GContentManagement();
			$this->editSection($_REQUEST["section_id"],$_REQUEST["section_title"],$_REQUEST["section_description"]);
			header("location:contentManagement.php?cmd=showSections&msg=update");
	}
		
	//showing all records of sections
	function showSections(){
			$content = 'showSections.php';
			include_once('templates/main/main_page.php');	
	}
	//showing update section form 	
	function updateSectionForm(){
			$content = 'updateSectionForm.php';
			include_once('templates/main/main_page.php');	
	}
	//delete section record from db
	function delSection(){		
			//$cmsObj = new GContentManagement();
			$this->deleteSection($_REQUEST['sectionID']);
			$content = 'showSections.php';
			include_once('templates/main/main_page.php');
	}
	//showing new page add form
	function addNewPageForm(){
	$content = 'addNewPageForm.php';
	include_once('templates/main/main_page.php');
	
	}
	function showPageInactiveContents($page_id){
			$dbobj = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
			$dbobj->connectDB();
			$row = $dbobj->getRowFromDB("select * from contentspagetemplate where ContentPageID = '".$page_id."' and showOnPage = 'N' ");
			return $row; 
			$dbobj->disconnectDB();
	}
	//insert section record into db
	function insertNewPage(){
			//$cmsObj = new GContentManagement();
			$this->addPage($_REQUEST["page_title"],$_REQUEST["page_meta_title"],$_REQUEST["page_meta_description"],$_REQUEST["page_meta_keywords"],$_REQUEST['FCKeditor'],$_REQUEST["show_on_page"],$_REQUEST["section_type"]);
			header("location:contentManagement.php?cmd=showPages&msg=add");
	}
	//showing all records of sections
	function showPages(){
			$content = 'showPages.php';
			include_once('templates/main/main_page.php');	
	}
	//delete content page record from db
	function delPage(){		
			//$cmsObj = new GContentManagement();
			$this->deletePage($_REQUEST['pageID']);
			$content = 'showPages.php';
			include_once('templates/main/main_page.php');
	}
	//showing update content page form 	
	function updatePageForm(){
			$content = 'updatePageForm.php';
			include_once('templates/main/main_page.php');	
	}
	//update content page record	
	function updatePageRecord(){
			//$cmsObj = new GContentManagement();
			$this->editPage($_REQUEST['pageID'],$_REQUEST["page_title"],$_REQUEST["page_meta_title"],$_REQUEST["page_meta_description"],$_REQUEST["page_meta_keywords"],$_REQUEST['FCKeditor'],$_REQUEST["show_on_page"],$_REQUEST["section_type"]);
			header("location:contentManagement.php?cmd=showPages&msg=update");
	}
	
	//showing update content page form 	
	function sortOrder(){
			
			$rec = $this->sortPageOrder($_REQUEST['present_sortid'],$_REQUEST['furture_sortid'],$_REQUEST['pageID'] );
			header("location:contentManagement.php?cmd=showPages");

	}
	//set default sections all records to view
	function defaultSections(){	
		$content = 'sections.php';
		include_once('templates/main/main_page.php');
	}

	function showLatestNews(){
		$dbObj = new Cdb(SERVER,DBNAME,DBUSER,DBPASS);		
		$dbObj->connectDB();
		$query = "SELECT * from news WHERE NewsActive = 'Y' order by NewsDate desc";
	
		if( !$recordsperpageform=$_REQUEST['recordsperpage']){$recordsperpageform=1000;}
		$this->paging=new paging($recordsperpageform,3);
		$this->paging=new paging($recordsperpageform , 3 , "|prev|" , "|next|" , "[%%number%%]");
		$this->paging->db(SERVER,DBUSER,DBPASS,DBNAME);
		$this->paging->query($query);
		$this->page = $this->paging->print_info();
		$row=$dbObj->getTableFromDB($query);
		$size = mysql_num_rows($row);
		if($size>0)
		{
			$page=$this->getPageinfo();  
			$paging=$this->getPagingObj(); 
			$i=$page[start];
			while ($data=$paging->result_assoc()) 
			{	
				echo "
				<div class='full_space'>
				<div class='char_mainheade'>
					<div class='char_imgestyle'><img src='images/charitystyle.jpg' alt='' /></div>
					<div class='char_nametxt'>".$data['NewsTitle']."</div>
				</div>
				
				<h4>".date('M d, Y', strtotime($data['NewsDate']))." by ".$data['NewsManager']."</h4>
				<div class='full_space'>
				".$data['NewsDetails']."
				</div></div>
				
				<div class=space></div>";
			}//while end
			
			if($size!=0 && $size>$recordsperpageform)
			{
				echo "<div class=bodytxt>";
				//paging perametors===========================================================================			
				echo "Record $page[start] - $page[end] of $page[total] [Total $page[total_pages] Pages]<br>\n";
				echo $paging->print_link();
				//end paging perametors===========================================================================
				echo "</div>";	
			}
		
		}//if end
	$dbObj->disconnectDB();
	
	//==============
	}
	//showing contents detailed pages
	function showContentPages()
	{
		$res = $this->showOnePageRecord($_REQUEST['id']);

		if($_REQUEST['id'] == 17 && $res['PageTitle'] == 'Latest News')//latest news
		{

			$content = 'showLatestNews.php';
		}
		elseif($_REQUEST['id'] == 34 or $_REQUEST['id'] == 27)//Technical Staff
		{
			$content = 'technicalStaff.php';
		}
		
		else
		{	
			$res = $this->showOnePageRecord($_REQUEST['id']);	
			$userrec = $this->getUserRecord();

				$var = array("[contactname]", "[emailaddress]", "[telephone]");
				
			$val = array($contactname, $useremail, $usertel);
			$res['PageContents'] =  str_replace($var, $val, $res['PageContents']);
			$content = 'showContentPages.php';
		}
		include_once('templates/main/main_page.php');
	}

	
	function getUserRecord()
	{
		$ObjDb = new Cdb(SERVER, DBNAME, DBUSER, DBPASS); 
		$ObjDb->connectDB();
		$Qry = "SELECT  BillingFirstName, BillingLastName, UserEmail, BillingTelephone  FROM customers where UserID = '".$_SESSION['USER_ID_GTECH']."'";
		$result = $ObjDb->getRowFromDB($Qry);
		return $result;
	}
		//starts function get error messages
	
	//ends function get error messages for users
	
	
	function getPageinfo()
	{
		return $this->page;
	}
	
	function getPagingObj()
	{
		return $this->paging;
	}
	
}
?>