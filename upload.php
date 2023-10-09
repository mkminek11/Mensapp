<?php
    if(isset($_FILES['image'])){
         
        $statusMsg = ''; 
        $targetDir = "img/user_upload/"; 
         
        if(isset($_POST["submit"])){ 
            if(!empty($_FILES["image"]["name"])){ 
                $fileName = basename($_FILES["image"]["name"]); 
                $targetFilePath = $targetDir . $fileName; 
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
             
                $allowTypes = array('jpg','png','jpeg','gif'); 

                if(in_array($fileType, $allowTypes)){ 
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){ 
                        // Insert image file name into database 
                        $statusMsg = "The file ".$fileName. " has been uploaded successfully."; 
                    }else{ 
                        $statusMsg = "Sorry, there was an error uploading your file."; 
                    } 
                }else{ 
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
                } 
            }else{ 
                $statusMsg = 'Please select a file to upload.'; 
            } 
        }
         
        // Display status message 
        echo $statusMsg;
    }
?>

<html>
    <body>
      
        <form action = "" method = "POST" enctype = "multipart/form-data">
            <input type = "file" name = "image" />
            <input type = "submit" name="submit"/>
   
            <ul>
                <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
                <li>File size: <?php echo $_FILES['image']['size'];  ?>
                <li>File type: <?php echo $_FILES['image']['type'] ?>
            </ul>

            <?php
                if(isset($_FILES['image'])) {
                    echo '<img data="'.$_FILES['image']['tmp_name'].'">';
                }
            ?>
			
        </form>
      
    </body>
</html>