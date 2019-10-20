<!DOCTYPE html>
<html>
<head>

	<h2>My Excel</h2> 
	<h3> <input id="add_f_name" type="text" name="f_name" placeholder="Add File"> <button onclick="addFile()">+</button> </h3>


	<button onclick="showFiles()">Show Files</button>

	<table border="1" >
		<tbody id="tempBody"></tbody>
	</table>
	
	 <table border="1">
	    <tbody id="tempSheets"></tbody>
	</table> 
   


	
</head>
<body>
<script type="text/javascript" >

	function showFiles() {
		
		//call ajax
		var ajax = new XMLHttpRequest();
		var method = "GET";
		var url = "listFiles.php";
		var asychronous = true;


		ajax.open(method, url, asychronous);
		ajax.send();

		ajax.onreadystatechange = function () {
			if(this.readyState == 4 && this.status == 200){

				//converting json back to array
				var data = JSON.parse(this.responseText);


				//html value for id="files"
				var myHtml = "";

				//looping through the data
				for(var i = 0; i < data.length; i++){
					var f_id = data[i].f_id;
					var f_name = data[i].f_name; 

					myHtml += "<tr> <td><h4 style='color:Blue;'>" +f_name+ "</h4></td>  <td><button onclick=deleteFile("+f_id+")>Delete</button></td>  <td><button onclick=openFile("+f_id+")>Open</button></td> </tr> ";
					/*myHtml += "<tr> <td> <h4>" +f_name+ "";
					myHtml += "<button onclick=deleteFile("+f_id+")>Delete</button> ";
					myHtml += "<button onclick=openFile("+f_id+",5,5)>Open</button> </h4> </td> </tr>";*/
				}

				//setting <tbody id="files">
				document.getElementById("tempBody").innerHTML = myHtml;
			}
		}
	}

	function addFile() {
		
		var f_name = document.getElementById("add_f_name").value;
		//call ajax
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "addFile.php";
		var asychronous = true;

		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_name="+f_name+"");

		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				showFiles();
			}
		}

	}

//deleting file
	function deleteFile(f_id) {
		
		//call ajax
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteFile.php";
		var asychronous = true;

		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id="+f_id+"");

		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				showFiles();
				deleteSheets(f_id);
			}
		}
	}
	
//updating file
	function openFile(f_id) {
		//show sheet list at bottom
		getSheets(f_id);
		
		//getting current date
		var today = new Date();
		var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		
		//call ajax
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "updateFileDate.php";
		var asychronous = true;

		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id=" +f_id+ "&update_date=" +date+ "");

		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){

			}
		}
	}
//get sheet list at bottom of table
	function getSheets(f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "getSheets.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id="+ f_id +"");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
			
			     //converting Json back to array
				 var data = JSON.parse(this.responseText);
			 
				 //html value for id="tempTable"
				 var html = "<td> <input id='in_add_sheet' onchange=addSheet("+f_id+")  placeholder='Add Sheet' style=width:70px;></td>";
				 
				 //looping through the data
				 for(var i = 0; i < data.length; i++){
					 var s_id = data[i].s_id;
					 var s_name = data[i].s_name;
					 var maxRow = data[i].maxRow;
					 var maxColumn = data[i].maxColumn;
					 
					 
					 html += "<td> <button onclick=openSheet(" +s_id+ "," +maxRow+ "," +maxColumn+ ","+f_id+")>"+s_name+"</button> </td>   <td> <button onclick=deleteSheet(" +s_id+ "," +f_id+ ")>-</button> </td>";
					 
				 }
				 
				 //replacing the </tbody> of <table>
				document.getElementById("tempSheets").innerHTML = html;
			}
		}
	}
//open a specific sheet
	function openSheet(s_id, maxRow, maxColumn,f_id){
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "getDatas.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "");
		
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){

				//converting Json back to array
				var datas = JSON.parse(this.responseText);
				
				//prepare table
				myHtml = "";
				
				//insert default inputs
				var i;
				var j;
				for(i = 0; i < maxRow; i++){
				
					myHtml += "<tr>";
					for(j = 0; j < maxColumn; j++){
						
						//to write upper and left numbers
						if(i==0 || j==0){
							if(i==0 && j==0){
								myHtml += "<td id='f_name_holder'>"+getFileName(f_id)+"</td>";
							}else{
								if(j>=i){
									myHtml += "<td style=text-align:center>"+j+" <button style=color:red; onclick=deleteColumn("+s_id+","+j+","+maxRow+","+maxColumn+","+f_id+")>-</button> </td>"; //writing columns at up row
								}else{
									myHtml += "<td style=text-align:center>"+i+" <button style=color:red; onclick=deleteRow("+s_id+","+i+","+maxRow+","+maxColumn+","+f_id+")>-</button> </td>"; //writing rows at left side
								}
							}
						}else{
							var isCellFull = false; //cheching if cell is full or not
						
							//check for every cell
							for(var x = 0; x < datas.length; x++){
								var rNo = datas[x].rNo;
								var cNo = datas[x].cNo;
								var data = datas[x].data;
								
								if(i == rNo && j == cNo){
									myHtml += "<td><input id= '("+i+","+j+")' type=text name=satir value=" +data+ " style=width:70px; onchange=updateCell(" +i+ "," +j+ "," +s_id+ ")> </td> ";
									isCellFull = true;																								
								}
							}
						
							if(! isCellFull){
								myHtml += "<td><input id= '("+i+","+j+")' type=text name=satir style=width:70px; onchange=updateCell(" +i+ "," +j+ "," +s_id+ ")> </td> ";
								isCellFull = false;
							}
						}
					}
					//to add a new column
					if(i==0){
						myHtml += "<td onclick=addColumn("+s_id+","+f_id+")><button>+</button></td>";
					}
					myHtml += "</tr>";
				}
				//to add a new row
				myHtml += "<tr> <button onclick=addRow("+s_id+","+f_id+")>+</button> </tr>";
				
			}
			document.getElementById("tempBody").innerHTML = myHtml;
		}
	}
//add a new sheet 
	function addSheet(f_id){
	
		var s_name = document.getElementById("in_add_sheet").value;
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "addSheet.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id=" +f_id+ "&s_name=" +s_name+ "");
		
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//after add sheet to show the sheets
				getSheets(f_id);
			}
		}
	}
//deleting a specific sheet
	function deleteSheet(s_id, f_id){

		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteSheet.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id=" +f_id+ "&s_id=" +s_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//after deleting sheet to show the sheets
				getSheets(f_id);
				deleteDatas(s_id);
			}
		}
	}
//delete all sheet in the file where f_id = $f_id
	function deleteSheets(f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteSheets.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id=" +f_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//after deleting sheet to show the sheets
				getSheets(f_id);
			}
		}
	}
//update cells realtime
	function updateCell(rNo, cNo, s_id){

		//get new data
		var newData = document.getElementById("("+rNo+","+cNo+")").value;
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "updateCell.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("data=" +newData+ "&rNo=" +rNo+ "&cNo=" +cNo+ "&s_id=" +s_id+ "");
		
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
		
			}
		}
	}
//delete all datas in the sheets when a sheet deleted
	function deleteDatas(s_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteDatas.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				
			}
		}
	}
//addd a new row to bottom	
	function addRow(s_id, f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "addRow.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//get max row and max column
				var data = JSON.parse(this.responseText);
				maxRow = data.maxRow;
				maxColumn = data.maxColumn;
				
				openSheet(s_id, maxRow, maxColumn, f_id);
				//we should refresh button of getSheets() for get current max_row and max_column,so we call it again
				getSheets(f_id);
			}
		}
	}
//add a new column at the right
	function addColumn(s_id, f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "addColumn.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//get max row and max column
				var data = JSON.parse(this.responseText);
				maxRow = data.maxRow;
				maxColumn = data.maxColumn;
				
				openSheet(s_id, maxRow, maxColumn, f_id);
				//we should refresh button of getSheets() for get current max_row and max_column,so we call it again
				getSheets(f_id);
			}
		}
	}
//get curret file name
	function getFileName(f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "getFileName.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("f_id=" +f_id+ "");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				//get max row and max column
				var data = JSON.parse(this.responseText);
				//set file name holder to file value
				document.getElementById("f_name_holder").innerHTML = data.f_name;
			}
		}
	}

	//delete all data at a specific row and row itself
	function deleteRow(s_id, rowNumber, maxRow, maxColumn, f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteDatasAtRow.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "&rowNumber="+rowNumber+"&maxRow="+maxRow+"");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				maxRow--;
				openSheet(s_id, maxRow, maxColumn, f_id);
				//call getSheet again for get current max row and max column
				getSheets(f_id);
			}
		}
	}
	
	
	//delete all data at a specific column and column itself
	function deleteColumn(s_id, columnNumber, maxRow, maxColumn, f_id){
		
		//call ajax 
		var ajax = new XMLHttpRequest();
		var method = "POST";
		var url = "deleteDatasAtColumn.php";
		var asychronous = true;
		
		ajax.open(method, url, asychronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("s_id=" +s_id+ "&columnNumber="+columnNumber+"&maxColumn="+maxColumn+"");
	
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				maxColumn--;
				openSheet(s_id, maxRow, maxColumn, f_id);
				//call getSheet again for get current max row and max column
				getSheets(f_id);
			}
		}
	}
	
</script>

</body>
</html>