<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<?php include('../h.php'); ?>
	<script type="text/javascript">
		function confirmdelete(data) {
			Swal.fire({
				title: 'ต้องการลบข้อมูลหรือไม่ ?',
				text: "ตรวจสอบข้อมูลให้ถูกต้อง!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete!'
			}).then((result) => {
				if (result.value) {
					console.log(data);
					window.location = data;
					// Swal.fire('Delete Success','','success')
				} else {
					Swal.fire('ยกเลิกการทำรายการ', '', 'error')
				}
			})
		}

		function backform() {
			document.myformshow.action = "product_show.php";
		}
	</script>
</head>

<?php include('../connectdb.php'); ?>
<?php include('../navbar.php'); ?>
<div class="container-fluid">
	<p></p>
	<div class="row">
		<div class="col-md-2">
			<!-- Left side column. contains the logo and sidebar -->
			<div class="color-login">
				<h6><i class="fas fa-user-circle"></i>&ensp;<a style="font-weight:bold;"><?php echo "ผู้ใช้"; ?></a><a style="color:#c92828;font-weight:bold;"><?php echo " : " . $_SESSION['user']; ?></a></h6>
				<h6><i class="fas fa-check-square"></i></i></i>&ensp;<a style="font-weight:bold;"><?php echo "ตำแหน่ง"; ?></a><a style="color:#1d4891;font-weight:bold;"><?php echo " : " . $_SESSION['posname']; ?></a></h6>
			</div>
			<?php include('../menu_left.php'); ?>
			<!-- Content Wrapper. Contains page content -->
		</div>
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<form action="#" id="myformshow" name="myformshow" method="post">
						<h4>สีทาอาคาร</h4>
						<div class="form-inline">
							<!-- เพิ่มขอมูล -->
							<div class="form-group mb-2">
								<a href="product.php?act=add" class="btn-danger btn-sm"><i class='fa fa-undo' aria-hidden='true'></i> ย้อนกลับ</a>&ensp;
								<a href="cgr_color_insert.php" class="btn-info btn-sm"><i class='fa fa-plus' aria-hidden='true'></i> เพิ่มสีทาอาคาร</a>
							</div>

						</div>

						<?php
						$search = isset($_POST['search']) ? $_POST['search'] : '';
						$sql = "SELECT product.product_id,product.product_name,product.product_saleprice,brand_name,color_name,unit_name,categorycolor.cc_volume,material.*
					FROM product 
					LEFT JOIN categorycolor ON product.product_id = categorycolor.product_id
					INNER JOIN color ON color.color_id = categorycolor.color_id
					INNER JOIN brand ON brand.brand_id = product.brand_id
					INNER JOIN unit ON unit.unit_id = product.unit_id
					INNER JOIN material ON material.mt_id = categorycolor.mt_id
					ORDER BY categorycolor.product_id ASC";
						$result = $conn->query($sql);
						$row = mysqli_fetch_array($result);
						?>

						<script>
							$(document).ready(function() {
								$('#example').DataTable({
									"pageLength": 10,
									"order": [
										[0, 'asc']
									]
								});
							});
						</script>

						<?php
						echo ' <table border="2" class="display table table-bordered" id="example" align="center">';
						//หัวข้อตาราง
						echo "
					<thead>
						<tr bgcolor='#AED6F1' align='center' style='font-weight:bold'>
						<th>รหัสสินค้า</th>
						<th>ชื่อสินค้า</th>
						<th>ยี่ห้อ</th>
						<th>สี</th>
						<th>วัสดุ</th>
						<th>หน่วย</th>
						<th>ปริมาณ</th>
						<th>ราคาขาย</th>
						<th>บริษัทคู่ค้า</th>
						<th>จัดการ</th>
						</tr>
					</thead>";
						do {
							if ($row['product_id'] != '') {
								echo "<tr>";
								echo "<td align='center'>" . $row["product_id"] . "</td> ";
								echo "<td>" . $row["product_name"] . "</td> ";
								echo "<td align='center'>" . $row["brand_name"] . "</td> ";
								echo "<td align='center'>" . $row["color_name"] . "</td> ";
								echo "<td align='center'>" . $row["mt_name"] . "</td> ";
								echo "<td align='center'>" . $row["unit_name"] . "</td> ";
								echo "<td align='right'>" . $row["cc_volume"] . "</td> ";
								echo "<td align='right'>" . number_format($row["product_saleprice"], 2) . "</td> ";
								//เพิ่มราคาทุนสินค้า
								echo "<td align='center' width='10%'><a href='cgrcolor_costprice.php?p_id=$row[product_id]'><img src='/picture/add.png' width='30' height='30' alt='เพิ่มราคาสินค้า'>&emsp;<a href='cgrcolor_costprice_show.php?p_id=$row[product_id]'><img src='/picture/product.png' width='30' height='30' alt='ดูสินค้า'></a></td> ";
								echo "<td align='center' width='15%'><a href='cgr_color_edit.php?p_id=$row[product_id]' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i>&ensp;แก้ไข</a>
							<a href='#' onclick=\"JavaScript:confirmdelete('cgr_color_delete.php?p_id=$row[product_id]')\" class='btn btn-danger btn-xs'</a><i class='fa fa-trash'></i>&ensp;ลบ</td> ";
								echo "</tr>";
							}
						} while ($row = mysqli_fetch_array($result));
						echo '</table>';
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

</body>

</html>