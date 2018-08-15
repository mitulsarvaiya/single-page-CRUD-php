<?php
	session_start();
	$sqli = mysqli_connect("localhost", "root", "root", "test") or die("Could not connect database...");
	$update = false;
	$id = $name = $sal = "";
	if (isset($_REQUEST['edit'])) {
		$id = $_REQUEST['edit'];
		$update = true;
		$record = mysqli_query($sqli, "SELECT * FROM emp WHERE empno=$id");

		if (count($record) == 1 ) {
			$num = mysqli_fetch_array($record);
			$id = $num['empno'];
			$name = $num['empname'];
			$sal = $num['sal'];
		}

	}
	if(isset($_REQUEST['save'])){
		$id = $_REQUEST['id'];
		$name = $_REQUEST['name'];
		$sal = $_REQUEST['salary'];
		mysqli_query($sqli, "INSERT INTO `emp` (`empno`, `empname`, `sal`) VALUES ('$id', '$name', '$sal')");
		$_SESSION['msg'] = "Employee Saved";
		header("location:index.php");

	}
	if(isset($_REQUEST['update'])){
		$id = $_REQUEST['id'];
		$name = $_REQUEST['name'];
		$sal = $_REQUEST['salary'];

		mysqli_query($sqli, "UPDATE emp SET empname = '$name', sal = $sal WHERE empno = $id");
		$_SESSION['msg']= "Employee Data Updated.";
		header("location:index.php");
		
	}
	if(isset($_REQUEST['del'])){
		$id = $_REQUEST['del'];
		mysqli_query($sqli, "DELETE FROM emp WHERE empno = $id");
		$_SESSION['msg'] = "Employee Data is deleted";
		header("location:index.php");
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript">
		function clear(){
			document.getElementsByTagName('id').clear();
			document.getElementsByTagName('name').clear();
			document.getElementsByTagName('salary').clear();
		}
		function back(){
			 window.location.href = "https://www.google.com";
		}
	</script>
</head>
<body>	
		<?php

			if(isset($_SESSION['msg'])){
				echo "<div class='msg'>";
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
				echo "</div>";
			}
			$query = mysqli_query($sqli, "SELECT * FROM emp");
		?>
		<table>
				<tr>
					<td>Name</td>
					<td>Salary</td>
					<td colspan="2">Action</td>
				</tr>
				<?php
					while($row = mysqli_fetch_array($query)){
						echo "<tr>";
						
						echo "<td>".$row['empname']."</td>";
						echo "<td>".$row['sal']."</td>";
						echo "<td><a class='link' href=index.php?edit=".$row['empno'].">Edit</a></td>";
						echo "<td><a class='link' href=index.php?del=".$row['empno'].">Delete</a></td>";
						echo "</tr>";
					}
				?>
		</table>
		<form action="#" method="POST">
			<div class="input-group">
				<label>Employee No.</label>
				<input type="text" name="id" value="<?php echo $id; ?>">
			</div>
			<div class="input-group">
				<label>Name</label>
				<input type="text" name="name" value="<?php echo $name; ?>">
			</div>
			<div class="input-group">
				<label>Salary</label>
				<input type="text" name="salary" value="<?php echo $sal; ?>">
			</div>
			<div class="input-group">
				<?php if($update == true) { ?>
				 <button class="btn" type="submit" name="update" style="background: red;" onclick="back()"> Update </button>
				 <?php } elseif ($update == false) { ?>
				 	<button class="btn" type="submit" name="save" onclick="clear()"> Save </button>
				 <?php } ?>
			</div>
		</form>
		<div class="footer">Shree Developers</div>
</body>
</html>
