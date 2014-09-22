<?php
$server_file = 'but01.gif';
$local_file = '../mykad_img/'.$_GET['id'];

// set up basic connection
$conn_id = ftp_connect("192.168.0.140");

// login with username and password
$login_result = ftp_login($conn_id, "hazman", "89256552");

// upload a file
if (ftp_get($conn_id, $local_file, $server_file, FTP_ASCII)) {
    //echo "Successfully written to $local_file\n";
} else {
    //echo "There was a problem\n";
}
// close the connection
ftp_close($conn_id);
?>
