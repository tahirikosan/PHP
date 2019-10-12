<!DOCTYPE html>
<html>
<style>
table,th,td {
  border : 1px solid black;
  border-collapse: collapse;
}
th,td {
  padding: 5px;
}
</style>
<body>

<h2>Öğrenci Bilgi Sistemi Javascript</h2>

  <button onclick="listStudents()" style="background-color:red;color:white">List Students</button>
<br>
	<div>
		<table id="myTable">
			<tr>
					<tr>
						<td>NO <button type=href onclick=listStudentsWithCases("ASC","id")> ˄ </button> <button type=href onclick=listStudentsWithCases("DESC","id")> ˅ </button> </td>
						<td>AD <button type=href onclick=listStudentsWithCases("ASC","ad")> ˄ </button> <button type=href onclick=listStudentsWithCases("DESC","ad")> ˅ </button> </td>
						<td>SOYAD <button type=href onclick=listStudentsWithCases("ASC","soyad")> ˄ </button> <button type=href onclick=listStudentsWithCases("DESC","soyad")> ˅ </button> </td>
						<td>BÖLÜM <button type=href onclick=listStudentsWithCases("ASC","bolum")> ˄ </button> <button type=href onclick=listStudentsWithCases("DESC","bolum")> ˅ </button> </td>
						<td>DELETE</td>
						<td>UPDATE</td>
					</tr>
									
					<tr>
						<td> <input id="adds_id" name=id type=text placeholder=id> </td>
						<td> <input id="adds_ad" name=ad type=text placeholder=name> </td>
						<td> <input id="adds_soyad" name=soyad type=text placeholder=soyad> </td>
						<td> <input id="adds_bolum" name=bolum type=text placeholder=bolum> </td>
						<td> <button onclick=clearAddCells()>Clear Inputs</button> </td>
						<td> <button onclick=addStudent()>Add Student</button> </td>
					</tr>
			</tr>
						
			<tr>
					<tr>
						<td> <input id="find_id" name=id type=text placeholder=id> </td>
						<td> <input id="find_ad" name=ad type=text placeholder=name> </td>
						<td> <input id="find_soyad" name=soyad type=text placeholder=soyad> </td>
						<td> <input id="find_bolum" name=bolum type=text placeholder=bolum> </td>
						<td> <button onclick=clearFindCells()>Clear Inputs</button> </td>
						<td> <button onclick=findStudent()>Find Student</button> </td>								
					</tr>
			</tr>
		
			<tbody = id="tempTable"> </tbody>
			
			<table style="margin-left:300px; margin-top:20px">
				<tr>
					<td> <button onclick=showFirstLastPage(0,2)> << </button> </td>
					<td> <button onclick=showPage(1,"left")> < </button> </td>
					<td> <button id="twoPageBefore" onclick=showPage(2,"left") > </button> </td>
					<td> <button id="onePageBefore" onclick=showPage(1,"left")>  </button> </td>
					<td> <button id="currentPage" style="background-color:blue;color:white"> currentPage </button> </td>
					<td> <button id="onePageNext" onclick=showPage(1,"right") >  </button> </td>
					<td> <button id="twoPageNext" onclick=showPage(2,"right")>  </button> </td>
					<td> <button onclick=showPage(1,"right")> > </button> </td>
					<td> <button onclick=showFirstLastPage(-999,2)> >> </button> </td> <!--The reason of first parameter is -9 is to define it is last page,it will be handle in showPage() func.-->
				</tr>
			</table>
		
		</table>
	</div>
<script>

    var lastPage = 0;
	var pageLimit = 2;
	var currentPageNo = 0;
	//need be here to setting last page
	setLastPage(pageLimit);



function listStudents() {
  setPageNumbersLook(currentPageNo);
  
  //call ajax
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = "listStudents.php";
  var asynchronous = true;
  
  ajax.open(method, url, asynchronous);
  ajax.send();
  
  //receiving response from listStudents.php()
  ajax.onreadystatechange = function(){
	  if(this.readyState == 4 && this.status == 200){
		 //converting Json back to array
		 var data = JSON.parse(this.responseText);
		 
		 //html value for id="tempTable"
		 var html = "";
		 
		 //looping through the data
		 for(var i = 0; i < data.length; i++){
			 var id = data[i].id;
			 var ad = data[i].ad;
			 var soyad = data[i].soyad;
			 var bolum = data[i].bolum;
			 
			 //appending at hmtl
			 html += "<tr id="+ id +">";
				html += "<td>" + id + "</td>";
				html += "<td>" + ad + "</td>";
				html += "<td>" + soyad + "</td>";
				html += "<td>" + bolum + "</td>";
				html += "<td> <button style=width:100% onclick=deleteStudent(this,"+ id +")> Delete </button> </td>";
				html += "<td> <button style=width:100% onclick=updateStudentForm("+ id +")> Update </button> </td>";
			 html += "</tr>";
		 }
		 //replacing the </tbody> of <table>
		 document.getElementById("tempTable").innerHTML = html;
	  }
  }
}

function deleteStudent(myRow, id) {
	 var row = myRow.parentNode.parentNode;
     row.parentNode.removeChild(row);
		 
	 
	 //call ajax
	 var ajax = new XMLHttpRequest();
	 var method = "POST";
	 var url = "deleteStudent.php";
	 var asynchronous = true;
	
	 ajax.open(method, url, asynchronous);
	 ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 ajax.send("id="+ id +"");
	 
}

function addStudent(){
	//Making row and cells
	var row = document.getElementById("myTable").insertRow(-1);
	var cell0 = row.insertCell(0);
	var cell1 = row.insertCell(1);
	var cell2 = row.insertCell(2);
	var cell3 = row.insertCell(3);
	var cell4 = row.insertCell(4);
	var cell5 = row.insertCell(5);
	
	//Preparing values
	var id = document.getElementById("adds_id").value;
	var ad = document.getElementById("adds_ad").value;
	var soyad = document.getElementById("adds_soyad").value;
	var bolum = document.getElementById("adds_bolum").value;
	
	
	//Filling cells
	cell0.innerHTML = id;
	cell1.innerHTML = ad;
	cell2.innerHTML = soyad;
	cell3.innerHTML = bolum;
	cell4.innerHTML = "<button style=width:100% onclick=deleteStudent(this,"+ id +")>Delete</button>";
	cell5.innerHTML = "<button style=width:100% onclick=updateStudentForm("+ id +")> Update </button>";
	
	//call ajax
	var ajax = new XMLHttpRequest();
	var method = "POST";
	var url = "addStudent.php";
	var asynchronous = true;
	
	ajax.open(method, url, asynchronous);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("id=" +id+ "&ad=" +ad+ "&soyad=" +soyad+ "&bolum=" +bolum+ "");
}

//Clear input of addStudent cells
function clearAddCells(){
	document.getElementById("adds_id").value = "";
	document.getElementById("adds_ad").value = "";
	document.getElementById("adds_soyad").value = "";
	document.getElementById("adds_bolum").value = "";
}

//Clear input of findStudent cells
function clearFindCells(){
	document.getElementById("find_id").value = "";
	document.getElementById("find_ad").value = "";
	document.getElementById("find_soyad").value = "";
	document.getElementById("find_bolum").value = "";
}

//show student updating form
function updateStudentForm(id){
	
	//prepare update table
	var html = "";
	html += "<table>";
	html += "<tr> <td>ID </td> <td><input placeholder="+ id +" type=readable name=ad readonly></td> </td> </tr>";
	html += "<tr> <td>AD </td> <td><input id=\"upd_ad\" type=text name=ad></td> </td> </tr>";
	html += "<tr> <td>SOYAD <td><input id=\"upd_soyad\" type=text name=soyad></td> </td> </tr>";
	html += "<tr> <td>BOLUM <td><input id=\"upd_bolum\" type=text name=bolum></td> </td> </tr>";
	html += "<tr> <td> <td><button onclick=updateStudent("+ id +")>Update</button></td> </td> </tr>";
	html += "<tr>";
	html += "</table>";
	
	//set <table id="myTable">
	document.getElementById("tempTable").innerHTML = html; 
}

//Update the student where id = id
function updateStudent(id){
		
    //Preparing values
	var ad = document.getElementById("upd_ad").value;
	var soyad = document.getElementById("upd_soyad").value;
	var bolum = document.getElementById("upd_bolum").value;
		
	 //call ajax
	 var ajax = new XMLHttpRequest();
	 var method = "POST";
	 var url = "updateStudent.php";
	 var asynchronous = true;
	
	 ajax.open(method, url, asynchronous);
	 ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	 ajax.send("id=" +id+ "&ad=" +ad+ "&soyad=" +soyad+ "&bolum=" +bolum+ "");
	 
	 ajax.onreadystatechange = function(){
		 if(this.readyState == 4 && this.status == 200){
			 listStudents();
		 }
	 }
}

//find students that provide occasions
function findStudent(){
	
	//Preparing values
	var id = document.getElementById("find_id").value;
	var ad = document.getElementById("find_ad").value;
	var soyad = document.getElementById("find_soyad").value;
	var bolum = document.getElementById("find_bolum").value;
	
	//call ajax
	var ajax = new XMLHttpRequest();
	var method = "POST";
	var url = "findStudent.php";
	var asynchronous = true;
	
	ajax.open(method, url, asynchronous);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("id=" +id+ "&ad=" +ad+ "&soyad=" +soyad+ "&bolum=" +bolum+ "");
	
	ajax.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			
			//Converting json back to array
			var data = JSON.parse(this.responseText);
			
			 //html value for id="tempTable"
			 var html = "";
			 
			 //looping through the data
			 for(var i = 0; i < data.length; i++){
				 var id = data[i].id;
				 var ad = data[i].ad;
				 var soyad = data[i].soyad;
				 var bolum = data[i].bolum;
				 
				  //appending at hmtl
				 html += "<tr id="+ id +">";
					html += "<td>" + id + "</td>";
					html += "<td>" + ad + "</td>";
					html += "<td>" + soyad + "</td>";
					html += "<td>" + bolum + "</td>";
					html += "<td> <button style=width:100% onclick=deleteStudent(this,"+ id +")> Delete </button> </td>";
					html += "<td> <button style=width:100% onclick=updateStudentForm("+ id +")> Update </button> </td>";
				 html += "</tr>";
			 }
			  //replacing the </tbody> of <table>
			  document.getElementById("tempTable").innerHTML = html;
		}
	}
}

//list students that provide occasions
function listStudentsWithCases(order, orderType){
	
  setPageNumbersLook(currentPageNo);
	
  //call ajax
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "listStudentsWithCases.php";
  var asynchronous = true;
  
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("order="+ order +"&orderType="+ orderType +"");
  
  //receiving response from listStudents.php()
  ajax.onreadystatechange = function(){
	  if(this.readyState == 4 && this.status == 200){
		 //converting Json back to array
		 var data = JSON.parse(this.responseText);
		 
		 //html value for id="tempTable"
		 var html = "";
		 
		 //looping through the data
		 for(var i = 0; i < data.length; i++){
			 var id = data[i].id;
			 var ad = data[i].ad;
			 var soyad = data[i].soyad;
			 var bolum = data[i].bolum;
			 
			 //appending at hmtl
			 html += "<tr id="+ id +">";
				html += "<td>" + id + "</td>";
				html += "<td>" + ad + "</td>";
				html += "<td>" + soyad + "</td>";
				html += "<td>" + bolum + "</td>";
				html += "<td> <button style=width:100% onclick=deleteStudent(this,"+ id +")> Delete </button> </td>";
				html += "<td> <button style=width:100% onclick=updateStudentForm("+ id +")> Update </button> </td>";
			 html += "</tr>";
		 }
		 //replacing the </tbody> of <table>
		 document.getElementById("tempTable").innerHTML = html;
	  }
  }
}

//show first and last page;
function showFirstLastPage(pageNo, pageLimit){
	
	//getting the last page number
	if(pageNo == -999){
		pageNo = getLastPage();
	}
	
	//setting the current page number and look
    currentPageNo = pageNo;
	setPageNumbersLook(currentPageNo);

   //call ajax
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "showPage.php";
  var asynchronous = true;
  
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("pageNo="+ pageNo +"&pageLimit="+ pageLimit +"");


  //receiving response from listStudents.php()
  ajax.onreadystatechange = function(){
	  if(this.readyState == 4 && this.status == 200){
		 //converting Json back to array
		 var data = JSON.parse(this.responseText);
		 
		 //html value for id="tempTable"
		 var html = "";
		 
		 //looping through the data
		 for(var i = 0; i < data.length; i++){
			 var id = data[i].id;
			 var ad = data[i].ad;
			 var soyad = data[i].soyad;
			 var bolum = data[i].bolum;
			 
			 //appending at hmtl
			 html += "<tr id="+ id +">";
				html += "<td>" + id + "</td>";
				html += "<td>" + ad + "</td>";
				html += "<td>" + soyad + "</td>";
				html += "<td>" + bolum + "</td>";
				html += "<td> <button style=width:100% onclick=deleteStudent(this,"+ id +")> Delete </button> </td>";
				html += "<td> <button style=width:100% onclick=updateStudentForm("+ id +")> Update </button> </td>";
			 html += "</tr>";
		 }
		 //replacing the </tbody> of <table>
		 document.getElementById("tempTable").innerHTML = html;
	  }
  }
}


//setting last page number
function setLastPage(pageLimit){
	//call ajax
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "getLastPage.php";
  var asynchronous = true;

  //receiving response from getLastPage.php
  ajax.onreadystatechange = function(){
	  if(this.readyState == 4 && this.status == 200){
		  lastPage = this.responseText;
	  }
  }
  
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("pageLimit="+ pageLimit +"");
}

//Getting last page number
function getLastPage(){
	return lastPage;
}

//show the list in pageAmount page before
function showPage(pageAmount, direction){

//check if our page number is not minus
  if(currentPageNo > 0 && direction == "left"){
	  
	  if(pageAmount == 1){
		currentPageNo = currentPageNo - pageAmount;
	  }else if(currentPageNo > 1){
		currentPageNo = currentPageNo - pageAmount;
	  }
	//show page numbers on buttons
	setPageNumbersLook(currentPageNo);
	pageLimit = 2;
	
  }else if(currentPageNo < lastPage && direction == "right"){
	  
	  if(pageAmount == 1){
		currentPageNo = currentPageNo + pageAmount;
	  }else if(currentPageNo < lastPage - 1){
		currentPageNo = currentPageNo + pageAmount;
	  }
	  
	//show page numbers on buttons
	setPageNumbersLook(currentPageNo);
	pageLimit = 2;
	
  }else{
	  alert("Daha fazla gidilemez!");
  }
 
   //call ajax
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "showPage.php";
  var asynchronous = true;
  
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("pageNo="+ currentPageNo +"&pageLimit="+ pageLimit +"");


  //receiving response from listStudents.php()
  ajax.onreadystatechange = function(){
	  if(this.readyState == 4 && this.status == 200){
		 //converting Json back to array
		 var data = JSON.parse(this.responseText);
		 
		 //html value for id="tempTable"
		 var html = "";
		 
		 //looping through the data
		 for(var i = 0; i < data.length; i++){
			 var id = data[i].id;
			 var ad = data[i].ad;
			 var soyad = data[i].soyad;
			 var bolum = data[i].bolum;
			 
			 //appending at hmtl
			 html += "<tr id="+ id +">";
				html += "<td>" + id + "</td>";
				html += "<td>" + ad + "</td>";
				html += "<td>" + soyad + "</td>";
				html += "<td>" + bolum + "</td>";
				html += "<td> <button style=width:100% onclick=deleteStudent(this,"+ id +")> Delete </button> </td>";
				html += "<td> <button style=width:100% onclick=updateStudentForm("+ id +")> Update </button> </td>";
			 html += "</tr>";
		 }
		 //replacing the </tbody> of <table>
		 document.getElementById("tempTable").innerHTML = html;
	  }
  }

}

//seting page numbers look in buttons
function setPageNumbersLook(currentPageNo){
	
	document.getElementById("currentPage").innerHTML = currentPageNo;

	//set pages before current page
	if(currentPageNo > 0){
		document.getElementById("onePageBefore").innerHTML = currentPageNo - 1;
		
		if(currentPageNo > 1){
			document.getElementById("twoPageBefore").innerHTML = currentPageNo - 2;
		}else{
			document.getElementById("twoPageBefore").innerHTML = "";
		}
	}else{
		document.getElementById("onePageBefore").innerHTML = "";
		document.getElementById("twoPageBefore").innerHTML = "";
	}

	//set pages next to curent page
	if(currentPageNo < lastPage){
		document.getElementById("onePageNext").innerHTML = currentPageNo + 1;
		
		if(currentPageNo < lastPage - 1){
			document.getElementById("twoPageNext").innerHTML = currentPageNo + 2;
		}else{
			document.getElementById("twoPageNext").innerHTML = "";
		}
	}else{
		document.getElementById("onePageNext").innerHTML = "";
		document.getElementById("twoPageNext").innerHTML = "";
	}
}
</script>
</body>
</html>
