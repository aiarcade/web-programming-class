<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Students</title>
</head>

<body>

<table border="1">

    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Course</th>
            <th>Created At</th>
        </tr>
    </thead>

    <tbody id="studentsTable">
    </tbody>

</table>

<script>

function loadStudents() {

    fetch("ajax.php")
        .then(response => response.json())
        .then(students => {

            const table = document.getElementById("studentsTable");

            table.innerHTML = "";

            students.forEach(student => {

                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${student.id}</td>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.age ?? ""}</td>
                    <td>${student.course}</td>
                    <td>${student.created_at}</td>
                `;

                table.appendChild(row);

            });

        })
        .catch(error => {
            console.error("Error loading students:", error);
        });
}

// Load immediately
loadStudents();

// Check for new data every 2 seconds
setInterval(loadStudents, 2000);

</script>

</body>

</html>
