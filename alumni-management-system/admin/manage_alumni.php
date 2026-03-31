<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include "layout.php";

?>

<h2 class="mb-4">Manage Alumni</h2>

<div class="row mb-3">

    <div class="col-md-4">
        <input type="text" id="search" class="form-control" placeholder="Search by name...">
    </div>

    <div class="col-md-4">
        <select id="branch" class="form-control">
            <option value="">All Branches</option>
            <option value="Information Technology">Information Technology</option>
            <option value="Electronics">Electronics</option>
            <option value="Mechanical">Mechanical</option>
            <option value="Electrical">Electrical</option>
            <option value="Civil">Civil</option>
            <option value="Pharmacy">Pharmacy</option>
        </select>
    </div>

    <div class="col-md-4">
        <input type="number" id="batch_year" class="form-control" placeholder="Batch Year">
    </div>

</div>

<div id="alumni_table">
    <!-- Table loads here dynamically -->
</div>

<br>
<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

<script>
function loadData() {

    let search = document.getElementById("search").value;
    let branch = document.getElementById("branch").value;
    let batch_year = document.getElementById("batch_year").value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_alumni.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        document.getElementById("alumni_table").innerHTML = this.responseText;
    };

    xhr.send("search=" + encodeURIComponent(search) +
             "&branch=" + encodeURIComponent(branch) +
             "&batch_year=" + encodeURIComponent(batch_year));
}

/* ADD THIS BELOW loadData() */

function updateStatus(action, id){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_alumni.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        loadData(); // reload table
    };

    xhr.send(action + "=" + id);
}

document.getElementById("search").addEventListener("keyup", loadData);
document.getElementById("branch").addEventListener("change", loadData);
document.getElementById("batch_year").addEventListener("keyup", loadData);

window.onload = loadData;
</script>

<?php include "layout_footer.php"; ?>
