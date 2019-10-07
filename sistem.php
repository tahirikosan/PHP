<?php
//Global variables
$pageLimit = 5;

$onePageBefore;
$twoPageBefore;
$onePageNext;
$twoPageNext;
	
$onePageBeforeLook;
$twoPageBeforeLook;
$onePageNextLook;
$twoPageNextLook;
//****
if(! isset($_GET['option'])){
	$_GET['option'] = '';
}
if((! isset($_GET['pageNo'])) || $_GET['pageNo'] == null){
	$_GET['pageNo'] = 0;
}

if(! isset($_GET['order'])){
	$_GET['order'] = 'ASC';
}

if(! isset($_GET['orderType'])){
	$_GET['orderType'] = 'id';
}

setPages();

//********\\




switch ($_GET['option']){
	case 'deleteStudent':
		deleteStudent();
		listStudents();
		break;
	case 'addStudent':
		addStudent();
		listStudents();
		break;
	case 'listStudents':
		listStudents();
		break;
	case 'updateStudentForm':
		updateStudentForm();
		break;
	case 'updateStudent':
		updateStudent();
		listStudents();
		break;
	case 'findStudent':
		findStudents();
		break;
	default:
		listStudents();
}

//Lists all student in the database
function listStudents(){
	global $pageLimit;
	
	global $onePageBefore;
	global $twoPageBefore;
	global $onePageNext;
	global $twoPageNext;
	
	global $onePageBeforeLook;
	global $twoPageBeforeLook;
	global $onePageNextLook;
	global $twoPageNextLook;
	
	$connection = mysqli_connect('localhost','root','','okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		//Select 2 student from database according to pageNo
		$queryListStudents = mysqli_query($connection, "SELECT * FROM ogrenci ORDER BY {$_GET['orderType']} {$_GET['order']} LIMIT ".($_GET['pageNo']*$pageLimit).",".$pageLimit.";"); 
		
		if(! $queryListStudents){
			echo "SQL hatasi ".mysqli_error($connection);
		}else{
			echo "<table>
						<tr>
							<form action=''>
									<tr>
										<td>NO <a type=submit href=?order=ASC&orderType=id> ˄ </a> <a type=submit href=?order=DESC&orderType=id> ˅ </a> </td>
										<td>AD <a type=submit href=?order=ASC&orderType=ad> ˄ </a> <a type=submit href=?order=DESC&orderType=ad> ˅ </a></td>
										<td>SOYAD <a type=submit href=?order=ASC&orderType=soyad> ˄ </a> <a type=submit href=?order=DESC&orderType=soyad> ˅ </a></td>
										<td>BÖLÜM <a type=submit href=?order=ASC&orderType=bolum> ˄ </a> <a type=submit href=?order=DESC&orderType=bolum> ˅ </a></td>
										<td>DELETE</td>
										<td>UPDATE</td>
									</tr>
									
									<tr>
										<td> <input name=id type=text placeholder=id> </td>
										<td> <input name=ad type=text placeholder=name> </td>
										<td> <input name=soyad type=text placeholder=soyad> </td>
										<td> <input name=bolum type=text placeholder=bolum> </td>
										<td> <input name=clearInputs type=submit value=ClearInputs> </td>
										<td> <input name=option type=submit value=addStudent> </td>
									</tr>
							</form>
						</tr>
						
						<tr>
							<form action=''>
									<tr>
										<td> <input name=id type=text placeholder=id> </td>
										<td> <input name=ad type=text placeholder=name> </td>
										<td> <input name=soyad type=text placeholder=soyad> </td>
										<td> <input name=bolum type=text placeholder=bolum> </td>
										<td> <input name=clearInputs type=submit value=ClearInputs> </td>
										<td> <input name=option type=submit value=findStudent> </td>								
									</tr>
							</form>
						</tr>";
			while($students = mysqli_fetch_array($queryListStudents)){
					echo "
						<tr>
							<td>".$students[0]."</td>
							<td>".$students[1]."</td>
							<td>".$students[2]."</td>
							<td>".$students[3]."</td>
							<td><a href=' ?option=deleteStudent&id=".$students[0]."'>delete</a></td>
							<td><a href=' ?option=updateStudentForm&id={$students[0]}&ad={$students[1]}&soyad={$students[2]}&bolum={$students[3]}'>update</a></td>
						</tr>
					";
			}	
			echo "</table>";
			echo "<br><table>
					<tr>
						<form action = ''>
							<tr> <a type=submit href=?pageNo=0 > << </a> </tr> 
							<tr> &emsp; <a type=submit href=?pageNo=".$onePageBefore." > < </a> </tr> 
							<tr> &emsp; <a type=submit href=?pageNo=".$twoPageBefore." > ".$twoPageBeforeLook."</a> </tr> 
							<tr> &ensp; <a type=submit href=?pageNo=".$onePageBefore." > ".$onePageBeforeLook."</a> </tr> 
							<tr> &ensp; <a> ".($_GET['pageNo'] + 1)." </a> </tr>
							<tr> &ensp; <a type=submit href=?pageNo=".$onePageNext." > ".$onePageNextLook."</a> </tr> 
							<tr> &ensp; <a type=submit href=?pageNo=".$twoPageNext." > ".$twoPageNextLook."</a> </tr> 
							<tr> &emsp; <a type=submit href=?pageNo=".$onePageNext." > > </a> </tr> 
							<tr>&emsp;<a type=submit href=?pageNo=".(getNumberOfLastPage())."> >> </a> </tr>
						</form>
					</tr>
				 </table>";
		}
	}
	mysqli_close($connection);
}

//Delete a specific student
function deleteStudent(){
	$connection = mysqli_connect('localhost','root','','okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryDeleteStudent = mysqli_query($connection, "DELETE FROM ogrenci WHERE id=".$_GET['id'].";");
		
		if(! $queryDeleteStudent){
			echo "SQL hatası ".mysqli_error($connection);
		}
	}
	mysqli_close($connection);
}

//Add a new student to database
function addStudent(){
	$connection = mysqli_connect('localhost', 'root', '', 'okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryAddStudent = mysqli_query($connection, "INSERT INTO ogrenci (id, ad, soyad, bolum) VALUES 
		(".$_GET['id'].",
		 '".$_GET['ad']."',
		 '".$_GET['soyad']."',
		 '".$_GET['bolum']."')");
		 
		 if(! $queryAddStudent){
			 echo "SQL Hatası ".mysqli_error($connection);
		 }
	}
	mysqli_close($connection);
}

//Collect value for updating student
function updateStudentForm(){
	echo "<h2> Öğrenci Güncelleme </h2>
		<form action=''>
			<table>
								<input type=hidden name=option value=updateStudent> 
								<input type=hidden name=id value={$_GET['id']}> 
				<tr>
					<td>Ad</td> <td><input type=text name=ad> </td>
				</tr>
				<tr>
					<td>Soyad</td> <td><input type=text name=soyad> </td>
				</tr>
				<tr>
					<td>Bölüm</td> <td><input type=text name=bolum> </td>
				</tr>
				<tr>
					<td><input type=submit name=update value=update> </td>
				</tr>
			</table>
		</form>";
}

//Update information of a specific student
function updateStudent(){
	$connection = mysqli_connect('localhost', 'root', '', 'okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryUpdateStudent = mysqli_query($connection, "UPDATE ogrenci SET ad='{$_GET['ad']}', soyad='{$_GET['soyad']}', bolum='{$_GET['bolum']}' WHERE id={$_GET['id']};");
		
		if(! $queryUpdateStudent){
			echo "SQL Hatası ".mysqli_error($connection);
		}
		if(mysqli_affected_rows($connection) == 0){
			echo "Kayıt bulunamadı (no={$_GET['no']})";
		}
	}
	mysqli_close($connection);
}

//Find all student in that match the cases
function findStudents(){
	$connection = mysqli_connect('localhost','root','','okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryListStudents = mysqli_query($connection, "SELECT * FROM ogrenci WHERE id={$_GET['id']} or ad='{$_GET['ad']}' or soyad='{$_GET['soyad']}' or bolum='{$_GET['bolum']}';");
		
		if(! $queryListStudents){
			echo "SQL hatasi ".mysqli_error($connection);
		}else{
			echo "<table>
						<tr>
							<form action=''>
									<tr>
										<td>NO</td>
										<td>AD</td>
										<td>SOYAD</td>
										<td>BÖLÜM</td>
										<td>DELETE</td>
										<td>UPDATE</td>
									</tr>
									
									<tr>
										<td> <input name=id type=text placeholder=id> </td>
										<td> <input name=ad type=text placeholder=name> </td>
										<td> <input name=soyad type=text placeholder=soyad> </td>
										<td> <input name=bolum type=text placeholder=bolum> </td>
										<td> <input name=clearInputs type=submit value=ClearInputs> </td>
										<td> <input name=option type=submit value=addStudent> </td>
									</tr>
							</form>
						</tr>
						
						<tr>
							<form action=''>
									<tr>
										<td> <input name=id type=text placeholder=id> </td>
										<td> <input name=ad type=text placeholder=name> </td>
										<td> <input name=soyad type=text placeholder=soyad> </td>
										<td> <input name=bolum type=text placeholder=bolum> </td>
										<td> <input name=clearInputs type=submit value=ClearInputs> </td>
										<td> <input name=option type=submit value=findStudent> </td>								
									</tr>
							</form>
						</tr>";
			while($students = mysqli_fetch_array($queryListStudents)){
				echo "
						<tr>
							<td>".$students[0]."</td>
							<td>".$students[1]."</td>
							<td>".$students[2]."</td>
							<td>".$students[3]."</td>
							<td><a href=' ?option=deleteStudent&id=".$students[0]."'>delete</a></td>
							<td><a href=' ?option=updateStudentForm&id={$students[0]}&ad={$students[1]}&soyad={$students[2]}&bolum={$students[3]}'>update</a></td>
						</tr>
				";
			}	
			echo "</table>";
		}
	}
	mysqli_close($connection);
}

//Return number of row in the database
function getNumberOfLastPage(){
	global $pageLimit;
	$connection = mysqli_connect('localhost','root','','okul');
	
	if(! $connection){
		echo "Bağlantı hatası ".mysqli_error($connection);
	}else{
		$queryRows = mysqli_query($connection, "SELECT * FROM ogrenci;");
		$rows = mysqli_num_rows($queryRows);
		$lastPageNumber = ($rows / $pageLimit) - 1;
		return $lastPageNumber;
	}	
}

function setPages(){
	global $onePageBefore;
	global $twoPageBefore;
	global $onePageNext;
	global $twoPageNext;
	
	global $onePageBeforeLook;
	global $twoPageBeforeLook;
	global $onePageNextLook;
	global $twoPageNextLook;
	
	$mainPage = $_GET['pageNo'];
	$lastPageNumber = getNumberOfLastPage();
	if($mainPage > 0){
		$onePageBefore = $mainPage - 1;
		$onePageBeforeLook = $mainPage;
		
		if($mainPage > 1){
			$twoPageBefore = $mainPage - 2;
			$twoPageBeforeLook = $mainPage - 1;
		}
	}

	if($mainPage < $lastPageNumber){
		$onePageNext = $mainPage + 1;
		$onePageNextLook = $mainPage + 2;
		
		if($mainPage < $lastPageNumber - 1){
			$twoPageNext = $mainPage + 2;
			$twoPageNextLook = $mainPage + 3;
		}
	}
}


?>