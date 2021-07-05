<?php
$connect = mysqli_connect("localhost", "root", "", "testing");
$query = "SELECT * FROM countries ORDER BY country ASC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>imalisheraz</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 align="center">Import CSV File Data into MySQL Database using PHP & Ajax</h2>
        <h3 align="center">Countries Data</h3><br />
        <form id="upload_csv" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Upload File</label>
                    <input type="file" name="csv_file" id="csv_file" class="form_control">
                </div>
                <div class="col-md-12 form-group">
                    <input type="submit" class="form_control btn btn-success" name="upload" id="upload" value="Upload" />
                </div>
            </div>
        </form>
        <br /><br /><br />
        <div class="table-responsive" id="countries_table">
            <table class="table table-bordered">
                <tr>
                    <th width="10%">ID</th>
                    <th width="35%">Country</th>
                    <th width="35%">Nationality</th>
                    <th width="20%">Language</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["country"]; ?></td>
                        <td><?php echo $row["nationality"]; ?></td>
                        <td><?php echo $row["language"]; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#upload_csv').on("submit", function(e) {
            e.preventDefault(); //form will not submitted  
            $.ajax({
                url: "import.php",
                method: "POST",
                data: new FormData(this),
                contentType: false, // The content type used when sending data to the server.  
                cache: false, // To unable request pages to be cached  
                processData: false, // To send DOMDocument or non processed data file it is set to false  
                success: function(data) {
                    if (data == 'Error1') {
                        alert("Invalid File");
                    } else if (data == "Error2") {
                        alert("Please Select File");
                    } else {
                        $('#countries_table').html(data);
                    }
                }
            })
        });
    });
</script>

</html>