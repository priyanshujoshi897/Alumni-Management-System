<?php
require_once "../config/db.php";

/* ---------- HANDLE APPROVE / REJECT ---------- */

if(isset($_POST['approve'])){
    $id = intval($_POST['approve']);
    $stmt = $conn->prepare("UPDATE users SET status='approved' WHERE id=? AND role='alumni'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    exit();
}

if(isset($_POST['reject'])){
    $id = intval($_POST['reject']);
    $stmt = $conn->prepare("UPDATE users SET status='rejected' WHERE id=? AND role='alumni'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    exit();
}

/* ---------- FETCH DATA ---------- */

$search = $_POST['search'] ?? '';
$branch = $_POST['branch'] ?? '';
$batch_year = $_POST['batch_year'] ?? '';

$query = "
SELECT users.id, full_name, roll_no, email, status,
       branch, semester, batch_year
FROM users
JOIN alumni_profiles ON users.id = alumni_profiles.user_id
WHERE role='alumni'
";

/* --- Filters (basic version) --- */

if (!empty($search)) {
    $query .= " AND full_name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

if (!empty($branch)) {
    $query .= " AND branch='" . mysqli_real_escape_string($conn, $branch) . "'";
}

if (!empty($batch_year)) {
    $query .= " AND batch_year='" . mysqli_real_escape_string($conn, $batch_year) . "'";
}

$query .= " ORDER BY users.id DESC";

$result = mysqli_query($conn, $query);
?>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Roll No</th>
    <th>Email</th>
    <th>Branch</th>
    <th>Semester</th>
    <th>Batch Year</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['roll_no']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['branch']; ?></td>
    <td><?php echo $row['semester']; ?></td>
    <td><?php echo $row['batch_year']; ?></td>

    <!-- STATUS COLUMN -->
    <td>
        <?php
        if($row['status'] == 'pending'){
            echo "<span class='badge bg-warning'>Pending</span>";
        } elseif($row['status'] == 'approved'){
            echo "<span class='badge bg-success'>Approved</span>";
        } else {
            echo "<span class='badge bg-danger'>Rejected</span>";
        }
        ?>
    </td>

    <!-- ACTION COLUMN -->
    <td>

        <?php if($row['status'] == 'pending'): ?>
            <button onclick="updateStatus('approve', <?php echo $row['id']; ?>)"
                    class="btn btn-sm btn-success">
                Approve
            </button>

            <button onclick="updateStatus('reject', <?php echo $row['id']; ?>)"
                    class="btn btn-sm btn-danger">
                Reject
            </button>
        <?php else: ?>
            <a href="edit_alumni.php?id=<?php echo $row['id']; ?>"
               class="btn btn-sm btn-warning">Edit</a>

            <a href="delete_alumni.php?id=<?php echo $row['id']; ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Are you sure you want to delete this alumni?')">
               Delete
            </a>
        <?php endif; ?>

    </td>
</tr>
<?php } ?>

</tbody>
</table>
