<?php
    include('../connectdb.php');

        $id = isset($_GET['delete_id']) ? $_GET['delete_id']:'';
        if($id!=''){
            $sqldelete = "DELETE FROM unit where unit_id ='".$id."'";
            if(mysqli_query($conn,$sqldelete)){ 
                echo "<script>"; 
                echo "alert('Delete Success!');"; 
                echo "window.location.href='/unit/unit_show.php';";
                echo "</script>";
            }
        }
?>
