<?php include './server/server.php'?>
<?php 
$id = $_GET['id'];
$query = "SELECT * FROM tbl_households WHERE `id`='$id'";
$result = $conn->query($query);
$resident = $result->fetch_assoc();

if($resident['household_head'] == 'yes') {
    $headName = $resident['firstname'] . " " . $resident['middlename'] . " " . $resident['lastname'];

    $query2 = "SELECT * FROM tbl_households WHERE `household_head`='$headName' OR `id`='$id'"; 
    $result2 = $conn->query($query2);
} else if(empty(trim($resident['household_head'])) || $resident['household_head'] == "no") {
    header("Location: ./residentInfo.php");
    exit();
}
else {
    $nameParts = explode(' ', $resident['household_head']);

    // Separate the name parts
    $firstname = isset($nameParts[0]) ? $nameParts[0] : ''; // Renz
    $middlename = isset($nameParts[1]) ? $nameParts[1] : ''; // Check if middle name exists
    $lastname = isset($nameParts[2]) ? $nameParts[2] : ''; // Bato

    $headName = $firstname . " " . $middlename . " " . $lastname;

    $query2 = "SELECT * FROM tbl_households WHERE `household_head`='$headName' OR `id`='$id'"; 
}
$result2 = $conn->query($query2);

if ($result2->num_rows > 0) {
    $members = array();
    while ($row = $result2->fetch_assoc()) {
        $members[] = $row;
    }
} else {
    echo "No results found.". $headName;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT RECORD OF BARANGAY INHABITANTS BY HOUSEHOLD</title>
    <link rel="stylesheet" href="style3.css ">
    <link rel="stylesheet" href="style4.css ">
    <link rel="stylesheet" href="sidenav.css ">
    <link rel="stylesheet" href="./style/generateCert.css">
    <script src="sidebar.js "></script>
</head>

<body>
    <?php include './model/fetch_brgy_role.php' ?>
    <?php include './actives/active_restore.php' ?>
    <?php include './actives/active_account.php' ?>
    <?php include './sidebar.php' ?>


    <div class="home_residents">
        <div class="first_layer">
            <p>EDIT RECORD OF BARANGAY INHABITANTS BY HOUSEHOLD</p>
         
        </div>
        <a href="residentInfo.php" class="backContainer">
            <img src="iconsBackend/back.png" alt="">
            <p>Go Back</p>
        </a>

        <div class="input-form">
            <div class="headerInfo">
                <p>Household Information</p>
                <p><?= $headName ?></p>
            </div>
            <div class="bodyInfo">
                <div class="leftInfo">
                    <div class="inputFullname">
                        <div class="name-cont">
                            <p>First Name<span>*</span></p>
                            <input type="text" name="firstName[]" id="firstName"
                                oninput="this.value = this.value.toUpperCase()" placeholder="First Name" required>
                        </div>
                        <div class="name-cont">
                            <p>Middle Name<span></span></p>  
                            <input type="text" name="middleName[]" id="middleName"
                                oninput="this.value = this.value.toUpperCase()" placeholder="Middle Name" required>
                        </div>
                        <div class="name-cont">
                            <p>Last Name<span>*</span></p>
                            <input type="text" name="lastName[]" id="lastName"
                                oninput="this.value = this.value.toUpperCase()" placeholder="Last Name" required>
                        </div>
                        <div class="name-cont">
                            <p>Suffix <span></span></p>
                            <input type="text" name="ext[]" class="suffix" id="ext"
                                oninput="this.value = this.value.toUpperCase()" placeholder="Suffix">
                        </div>
                    </div>
                    <div class="inputDob">
                        <p>Date of Birth<span>*</span></p>
                        <input type="date" name="dateBirth[]" id="dateBirth"
                            oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="inputPob">
                        <p>Place of Birth<span>*</span></p>
                        <input type="text" name="placeBirth[]" id="placeBirth"
                            oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="inputCitizenship">
                        <p>Citizenship<span>*</span></p>
                        <input type="text" name="citizenship[]" id="citizenship"
                            oninput="this.value = this.value.toUpperCase()" required>
                    </div>
                    <div class="inputPhoneNo">
                        <p>Contact Number</p>
                        <input type="number" name="phoneNo[]" id="phoneNo" placeholder="e.g., 09123456789">
                    </div>
                    <div class="inputEmail">
                        <p>Email Address</p>
                        <input type="text" name="email[]" id="email" placeholder="Enter your email">
                    </div>
                </div>

                <div class="rightInfo">
                    <div class="inputAddress">
                        <p>Address<span>*</span></p>
                        <input type="text" name="no[]" class="houseNo" id="no"
                            oninput="this.value = this.value.toUpperCase()" placeholder="House No.">
                        <input type="text" name="streetName[]" id="streetName"
                            oninput="this.value = this.value.toUpperCase()" placeholder="Street Name" required>
                        <input type="text" name="subdiName[]" id="subdiName"
                            oninput="this.value = this.value.toUpperCase()" placeholder="Subdivision Name">
                    </div>

                    <div class="inputOccupation">
                        <p>Occupation <span>*</span></p>
                        <input type="text" name="occupation[]" id="occupation"
                            oninput="this.value = this.value.toUpperCase()" required>
                    </div>

                    <div class="inputSex">
                        <p>Sex <span>*</span></p>
                        <select id="sex" name="sex[]" required>
                            <option value=""></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="inputCivilStatus">
                        <p>Civil Status<span>*</span></p>
                        <select id="civilStatus" name="civilStatus[]" required>
                            <option value=""></option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    

                  

                </div>
            </div>
            <div class="footerInfo">
                <button type="button" class="addSaTable">Create</button>
            </div>
        </div>

        <p class="List">List of Members</p>

        <form action="./model/edit_households.php   " enctype="multipart/form-data" method="post" class="input-table">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th style="display: none">Place of Birth</th>
                        <th style="display: none">Citizenship</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th style="display: none">Occupation</th>
                        <th>Sex</th>
                        <th style="display: none">Civil Status</th>
                        <th style="display: none">Voters Status</th>
                        <th style="display: none">Image Profile</th>
                        <th class="houseTitle">Household Head</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be dynamically added here using JavaScript -->
                            <?php if(!empty($members)) { ?>
                        <?php $no=1; foreach($members as $row) : ?>
                    <tr>
                        <td style="width: 100%; display:flex; padding-top: 8px;">
                            <input style="width: 30%; margin-right: 5px;" type="text" value="<?= $row['lastname'] ?>" name="lastName[]" id="">
                            <input style="width: 30%; margin-right: 5px;" type="text" value="<?= $row['firstname'] ?>" name="firstName[]" id="">
                            <input style="width: 30%; margin-right: 5px;" type="text" value="<?= $row['middlename'] ?>" name="middleName[]" id="">
                            <input style="width: 20%;" type="text" value="<?= $row['suffix'] ?>" name="ext[]" id="">
                        </td>
                        <td>
                            <input type="text" value="<?= $row['date_of_birth'] ?>" name="dateBirth[]" id="">
                        </td>
                        <td>
                            <input type="text" value="<?= $row['contact_no'] ?>" name="contact_no[]" id="">
                        </td>
                        <td>
                            <input type="text" value="<?= $row['email'] ?>" name="email[]" id="">
                        </td>
                        <td style="width: 100%; display:flex; padding-top: 8px;">
                            <input style="width: 50px; margin-right: 5px;" type="text" value="<?= $row['house_no'] ?>" name="no[]" id="">
                            <input style="margin-right: 5px;" type="text" value="<?= $row['street'] ?>" name="streetName[]" id="">
                            <input style="margin-right: 5px;" type="text" value="<?= $row['subdivision'] ?>" name="subdiName[]" id="">
                        </td>
                        <td><input type="text" value="<?= $row['sex'] ?>" name="sex[]" id=""></td>
                        <?php if($row['household_head'] == $headName) { ?>
                            <td><input type="radio" value="yes" name="householdHead[<?= $no ?>]"></td>
                        <?php } else { ?>
                            <td><input type="radio" value="yes" checked name="householdHead[<?= $no ?>]"></td>
                        <?php }?>
                        <td>
                            <button class="delete" style="border:none; background: none; color: #ff0000;
                              font-size: 10px; font-family: Poppins; font-style: normal; font-weight: 700; line-height: normal;"><a href="./model/remove/remove_resident.php?id=<?= $row['id'] ?>&head=<?= $row['household_head'] ?>" style="color: #ff0000; text-decoration:none;">Delete</a></button>
                        </td>
                        <td style="display: none;"><input type="text" value="<?= $row['place_of_birth'] ?>" name="placeBirth[]" id=""></td>
                        <td style="display: none;"><input type="text" value="<?= $row['citizenship'] ?>" name="citizenship[]" id=""></td>
                        <td style="display: none;"><input type="text" value="<?= $row['occupation'] ?>" name="occupational[]" id=""></td>
                        <td style="display: none;"><input type="text" value="<?= $row['civil_status'] ?>" name="civilStatus[]" id=""></td>
                        <td style="display: none;"><input type="text" value="<?= $row['voter_status'] ?>" name="voter_status[]" id=""></td>
                        <td style="display: none;"><input type="text" value="<?= $row['id'] ?>" name="id[]" id=""></td>
                    </tr>
                    <?php $no++; endforeach ?>
                    <?php } ?>
                </tbody>
            </table>
            <div class="submitContainerDaw">
                <button type="submit" class="submitHouseholdDaw">Submit</button>
            </div>

        </form>
    </div>

    <script src="./js//jQuery-3.7.0.js"></script>
    <script>
        $(document).ready(function() {
            $("input[type=radio]").prop("checked", false);
            $("input[type=radio]:first").prop("checked", true);

            $("input[type=radio]").click(function(event) {
                $("input[type=radio]").prop("checked", false);
                $(this).prop("checked", true);

                // event.preventDefault();
            })
        })
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addSaTableButton = document.querySelector('.addSaTable');
        const inputTableBody = document.querySelector('.input-table tbody');

        addSaTableButton.addEventListener('click', function(event) {
            event.preventDefault();

            // Define an array of required fields
            const requiredFields = ['lastName', 'firstName', 'middleName', 'dateBirth', 'placeBirth',
                'citizenship', 'streetName', 'occupation', 'sex', 'civilStatus'
            ];

            // Check if all required fields are filled out
            const allFieldsFilled = requiredFields.every(fieldName => {
                const field = document.getElementById(fieldName);
                return field.value.trim() !== '';
            });

            if (!allFieldsFilled) {
                alert("Please fill out all required fields.");
                return; // Stop execution if not all required fields are filled
            }

            // Continue with creating a new row if all required fields are filled
            const lastName = document.getElementById('lastName').value;
            const firstName = document.getElementById('firstName').value;
            const middleName = document.getElementById('middleName').value;
            const ext = document.getElementById('ext').value;
            const dateBirth = document.getElementById('dateBirth').value;
            const placeBirth = document.getElementById('placeBirth').value;
            const citizenship = document.getElementById('citizenship').value;
            const phoneNo = document.getElementById('phoneNo').value;
            const email = document.getElementById('email').value;
            const houseNo = document.getElementById('no').value;
            const streetName = document.getElementById('streetName').value;
            const subdiName = document.getElementById('subdiName').value;
            const occupation = document.getElementById('occupation').value;
            const sex = document.getElementById('sex').value;
            const civilStatus = document.getElementById('civilStatus').value;
       

            // Phone number validation for the Philippines (10 digits starting with 09)
            const phoneNoValue = document.getElementById('phoneNo').value;
            if (phoneNoValue.trim() !== "") {
                const phoneNumberPattern = /^(09|\+639)\d{9}$/;
                if (!phoneNumberPattern.test(phoneNoValue)) {
                    alert("Please enter a valid Philippine phone number.");
                    return; // Stop execution if the phone number is invalid
                }
            }

            // Email validation
            const emailValue = document.getElementById('email').value;
            if (emailValue.trim() !== "") {
                const emailPattern = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
                if (!emailPattern.test(emailValue)) {
                    alert("Please enter a valid email address.");
                    return; // Stop execution if the email is invalid
                }
            }

            // Create a new row in the table
            // Create a new row in the table
            const newRow = inputTableBody.insertRow();
            const inputNames = [
                'lastName',
                'firstName',
                'middleName',
                'dateBirth',
                'placeBirth',
                'citizenship',
                'phoneNo',
                'email',
                'no',
                'streetName',
                'subdiName',
                'occupational',
                'sex',
                'civilStatus',
                'ext'
            ];
            // Create a single set of input fields for names
            const nameCell = newRow.insertCell(0);
            nameCell.style.width = '100%';
            nameCell.style.display = 'flex';
            nameCell.style.flexDirection = 'row';
            nameCell.style.paddingTop = '8px';
            const lastNameInput = document.createElement('input');
            lastNameInput.type = 'text';
            lastNameInput.name = 'lastName' + "[]";
            lastNameInput.value = lastName
            lastNameInput.style.width = '30%';
            lastNameInput.style.marginRight = '5px';

            const firstNameInput = document.createElement('input');
            firstNameInput.type = 'text';
            firstNameInput.name = 'firstName[]';
            firstNameInput.value = firstName
            firstNameInput.style.width = '30%';
            firstNameInput.style.marginRight = '5px';

            const middleNameInput = document.createElement('input');
            middleNameInput.type = 'text';
            middleNameInput.name = 'middleName[]';
            middleNameInput.value = middleName
            middleNameInput.style.width = '30%';
            middleNameInput.style.marginRight = '5px';

            const extInput = document.createElement('input');
            extInput.type = 'text';
            extInput.name = 'ext[]';
            extInput.value = ext
            extInput.style.width = '20%';

            nameCell.appendChild(lastNameInput);
            nameCell.appendChild(firstNameInput);
            nameCell.appendChild(middleNameInput);
            nameCell.appendChild(extInput);

            const dobCell = newRow.insertCell(1);
            const dobInput = document.createElement('input');
            dobInput.type = 'text';
            dobInput.name = 'dateBirth[]';
            dobInput.value = dateBirth


            dobCell.appendChild(dobInput);

            const pobCell = newRow.insertCell(2);
            pobCell.style.display = 'none';
            const pobInput = document.createElement('input');
            pobInput.type = 'text';
            pobInput.name = 'placeBirth[]';
            pobInput.value = placeBirth

            pobCell.appendChild(pobInput);

            const citizenshipCell = newRow.insertCell(3);
            citizenshipCell.style.display = 'none';
            const citizenshipInput = document.createElement('input');
            citizenshipInput.type = 'text';
            citizenshipInput.name = 'citizenship[]';
            citizenshipInput.value = citizenship

            citizenshipCell.appendChild(citizenshipInput);

            const phoneCell = newRow.insertCell(4);
            const phoneInput = document.createElement('input');
            phoneInput.type = 'text';
            phoneInput.name = 'contact_no[]';
            phoneInput.value = phoneNo

            phoneCell.appendChild(phoneInput);

            const emailCell = newRow.insertCell(5);
            const emailInput = document.createElement('input');
            emailInput.type = 'text';
            emailInput.name = 'email[]';
            emailInput.value = email

            emailCell.appendChild(emailInput);

            const addressCell = newRow.insertCell(6);
            addressCell.style.width = '100%';
            addressCell.style.display = 'flex';
            addressCell.style.flexDirection = 'row';
            const houseNoInput = document.createElement('input');
            houseNoInput.type = 'text';
            houseNoInput.name = 'no[]';
            houseNoInput.value = document.getElementById('no').value;
            houseNoInput.style.width = '50px';
            houseNoInput.style.marginRight = '5px';

            const streetNameInput = document.createElement('input');
            streetNameInput.type = 'text';
            streetNameInput.name = 'streetName[]';
            streetNameInput.value = document.getElementById('streetName').value;
            streetNameInput.style.marginRight = '5px';

            const subdiNameInput = document.createElement('input');
            subdiNameInput.type = 'text';
            subdiNameInput.name = 'subdiName[]';
            subdiNameInput.value = document.getElementById('subdiName').value;
            subdiNameInput.style.marginRight = '5px';

            addressCell.appendChild(houseNoInput);
            addressCell.appendChild(streetNameInput);
            addressCell.appendChild(subdiNameInput);

            const occupationCell = newRow.insertCell(7);
            occupationCell.style.display = 'none';
            const occupationInput = document.createElement('input');
            occupationInput.type = 'text';
            occupationInput.name = 'occupational[]';
            occupationInput.value = occupation

            occupationCell.appendChild(occupationInput);

            const sexCell = newRow.insertCell(8);
            const sexInput = document.createElement('input');
            sexInput.type = 'text';
            sexInput.name = 'sex[]';
            sexInput.value = sex

            sexCell.appendChild(sexInput);

            const civilStatusCell = newRow.insertCell(9);
            civilStatusCell.style.display = 'none';
            const civilStatusInput = document.createElement('input');
            civilStatusInput.type = 'text';
            civilStatusInput.name = 'civilStatus[]';
            civilStatusInput.value = civilStatus


            civilStatusCell.appendChild(civilStatusInput);

            

            const householdHeadCell = newRow.insertCell(10);

            const radioInput = document.createElement('input');
            radioInput.type = 'radio';
            radioInput.style.marginTop = '5px';
            radioInput.style.height = '18px';
            radioInput.style.width = '18px';
            radioInput.name = 'householdHead' + "[" + inputTableBody.rows.length + "]";
            // radioInput.value = 'no'; // Set the value to 'yes'
            console.log(inputTableBody.rows.length)

            radioInput.value = 'no'; // Default value is 'no'
            radioInput.addEventListener('change', function() {
                if (radioInput.checked) {
                    radioInput.value = 'yes';
                }
            });
            console.log(radioInput.value)
            householdHeadCell.appendChild(radioInput);

            // Create a "Delete" button for the "Action" column
            const actionCell = newRow.insertCell(11);
            const deleteButton = document.createElement('button');
            deleteButton.textContent =
                'Delete';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.color =
                '#ff0000';
            deleteButton.style.fontSize = '10px';
            deleteButton.style.fontFamily =
                'Poppins';
            deleteButton.style.fontStyle = 'normal';
            deleteButton.style.fontWeight =
                '700';
            deleteButton.style.lineHeight = 'normal';
            deleteButton.style.border =
                'none';
            deleteButton.addEventListener('click', function() {
                // Remove the row when the "Delete" button is clicked
                inputTableBody.removeChild(newRow);
            });
            actionCell.appendChild(deleteButton);

            // Clear input fields (except for 'no', 'streetName', and 'subdiName')
            requiredFields.forEach(fieldName => {
                if (fieldName !== 'no' && fieldName !== 'streetName' && fieldName !==
                    'subdiName') {
                    document.getElementById(fieldName).value = '';
                }
            });

            // Clear additional fields
            document.getElementById('ext').value = '';
            document.getElementById('phoneNo').value =
                '';
            document.getElementById('email').value = '';
        });
    });
    </script>


</body>

</html>