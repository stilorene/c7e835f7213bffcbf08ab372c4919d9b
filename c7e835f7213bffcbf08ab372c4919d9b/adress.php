




<?php
session_start();
include("functions.php");
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Versuch 2</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 
 
    
<div class="menu">
    <div class="icon-container">
        <a href="index.php" target="_self">
        <span class="material-symbols-outlined home">home</span>
        </a>
    </div> 


    <div class="link-container">
        <a href="index.php" target="_self" class="home">Startseite</a>
    </div>
</div>



   




</head>
<body>






<p>weiß nicht</p>
    <img src="" id="refresh" onclick="reloadPage()">



    <?php
    h1("Das ist die Seitenüberschrift");
    t("Hello Newbies!");
    br(2);
    t("Dies ist der aktuelle PHP-Timestamp:");
    
    $now_ts = time();
    
    t($now_ts);
    br();
    t("Jetzt: " . date("d.m.Y H:i:s", $now_ts));

    

    ?>



<style>




body {
    background-color: black;
      color: white;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      
}

.circle{
        position: absolute;
        height: 24px;
        width: 24px;
        border-radius: 24px;
        background-color: white;
        top: 0;
        left: 0;
        
    }

    .material-symbols-outlined{
        color: black;
        user-select: none;
        background-color: white; /* Standard-Hintergrundfarbe */
        display: inline-block;
        transition: color 0.3s; 
        cursor: pointer;
    }

    .material-symbols-outlined:hover{
        color: #6495ED;

    }

    .refresh{
        color: blue;
        user-select: none;
    }

    .menu{
        display: flex;
        
    }

    .icon-container, .link-container{
        border: 1px solid #ccc;
        padding: 10px;
        margin: 1px;
    }
    </style>
    
    
    <h2>Neuen Kontakt hinzufügen</h2>
    
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform" method="post">


        <input type="hidden" name="aktion" value="neu">
        <div style="display: flex; gap: 10px;">
            <div>
                <input placeholder="Vorname" name="vorname" style="width: 150px; height: 20px;">
            </div>
            <div>
                <input placeholder="Nachname" name="nachname" style="width: 150px; height: 20px;">
            </div>
            <div>
                <input placeholder="Stadt" name="stadt" style="width: 150px; height: 20px;">
            </div>
        </div>
        <input type="submit" name="senden">
        
        
    </form>
<!-- 
    // Fügt ein ein Dropdown-Auswahlfeld hinzu -->
<!-- <div>                              
<select id="unit-selector">
    <option value="mgdl">mg/dL</option>
    <option value="mmoll">mmol/L</option>
</div> -->
    
    <?php
    if (isset($_POST['aktion'])) {
        if ($_POST['aktion'] == "neu") {
            $vorname = $_POST["vorname"];
            $nachname = $_POST["nachname"];
            $stadt = $_POST["stadt"];

           
            $sql = "INSERT INTO adressen (vorname, nachname, stadt) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql); //Prepared Statement
            $stmt->bind_param("sss", $vorname, $nachname, $stadt);
            $stmt->execute();
           

            h3($sql);
            if ($vorname !== "" && $nachname !== "" && $stadt !== "") {
                $stmt->execute();
                $stmt->close();
            }
            
            h3("Datensatz wurde gespeichert.");
        }
        if ($_POST['aktion'] == "update") {
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $stadt = $_POST['stadt'];
            $rec_id = $_POST['REC_ID'];
            $sql = "UPDATE adressen SET vorname='$vorname', nachname='$nachname', stadt='$stadt' WHERE REC_ID=$rec_id";
            $conn->query($sql);
            h3("Datensatz wurde aktualisiert.");
        }
    }
    
	if (isset($_POST['delete'])) {
        $rec_id = $_POST['REC_ID'];
        $sql = "DELETE FROM adressen WHERE REC_ID=$rec_id";
        
        // Führen Sie die SQL-DELETE-Anweisung aus, um den Datensatz zu löschen
        $conn->query($sql);

        h3("Datensatz wurde gelöscht.");
    

        h3("Datensatz soll abgespeichert werden.");
        h3("Das wurde von einem Formular empfangen:");
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        echo "<pre>";
        print_r($rec_id);
        echo "</pre>";
    }
    
    $sql = "SELECT * FROM adressen";
    $result = $conn->query($sql);
    echo "<table border='1' style='border: 1px solid grey;'>";
    echo "<tr>";
    echo "<th>REC_ID</th>";
    echo "<th>Vorname</th>";
    echo "<th>Nachname</th>";
    echo "<th>Stadt</th>";
    echo "<th>&nbsp;</th>";
    echo "</tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<form action='/' method='post' id='form_" . $row['REC_ID'] . "'>";
        echo "<input type=\"hidden\" name=\"aktion\" value=\"update\">";
        echo "<input type=\"hidden\" name=\"REC_ID\" value=\"" . $row['REC_ID'] . "\">";
        echo "<td>" . $row['REC_ID'] . "</td>";
        echo "<td><input type=\"text\" name=\"vorname\" value=\"" . $row['vorname'] . "\"></td>";
        echo "<td><input type=\"text\" name=\"nachname\" value=\"" . $row['nachname'] . "\"></td>";
        echo "<td><input type=\"text\" name=\"stadt\" value=\"" . $row['stadt'] . "\"></td>";
        

        echo "<td><span class=\"material-symbols-outlined\" onclick=\"submitForm(this)\" data-form-id='form_" . $row['REC_ID'] . "'>send</span></td>";

            
        



        echo "<td><input type='submit' name='delete' value='Löschen'></td>";
        echo "</form>";
        echo "</tr>";
    }
    
    echo "</table>";

   
    ?>


<script>

function submitForm(icon) {
  console.log("submitForm called");
  var formId = icon.dataset.formId;
  console.log("formId:", formId);
  var form = document.getElementById(formId);
  if (form) {
    form.submit();
  }
}

</script>

</body>
</html>
