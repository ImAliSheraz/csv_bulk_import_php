<?php
if (!empty($_FILES["csv_file"]["name"])) {
    $connect = mysqli_connect("localhost", "root", "", "testing");
    $output = '';
    $allowed_ext = array("csv");
    $extension = end(explode(".", $_FILES["csv_file"]["name"]));
    if (in_array($extension, $allowed_ext)) {
        $file_data = fopen($_FILES["csv_file"]["tmp_name"], 'r');
        fgetcsv($file_data);
        while ($row = fgetcsv($file_data)) {
            $country = mysqli_real_escape_string($connect, $row[0]);
            $nationality = mysqli_real_escape_string($connect, $row[1]);
            $language = mysqli_real_escape_string($connect, $row[2]);
            $query = "INSERT INTO countries (country, nationality, language) VALUES ('$country', '$nationality', '$language') ";
            mysqli_query($connect, $query);
        }
        $select = "SELECT * FROM countries ORDER BY country ASC";
        $result = mysqli_query($connect, $select);
        $output .= '<table class="table table-bordered">
        <tr>
        <th width="10%">ID</th>
        <th width="35%">Country</th>
        <th width="35%">Nationality</th>
        <th width="20%">Language</th>
        </tr>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr>  
            <td>' . $row["id"] . '</td>  
            <td>' . $row["country"] . '</td>
            <td>' . $row["nationality"] . '</td>  
            <td>' . $row["language"] . '</td>  
            </tr> ';
        }
        $output .= '</table>';
        echo $output;
    } else {
        echo 'Error1';
    }
} else {
    echo "Error2";
}
