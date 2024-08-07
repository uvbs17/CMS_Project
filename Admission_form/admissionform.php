<?php
require_once "../connection/connection.php";
?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description goes here">
    <meta name="keywords" content="Keywords go here">
    <link rel="icon" type="image/png" sizes="32x32" href="/CMS/Images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/CMS/Images/fav.png">

    <!-- css style goes here -->

    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/card.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        * {
            color: #1a1f36;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Ubuntu, sans-serif;
        }

        body {
            min-height: 100%;
            background-color: #E2ECF4;
            font-family: 'Helvetica Neue', sans-serif;
        }

        #regForm {
            background-color: #ffffff;
            margin: 50px auto;
            display: grid;
            justify-content: center;
            border-radius: 10px;
            font-family: 'Roboto', sans-serif;
            padding: 40px;
            width: 70%;
            max-width: 600px;
            min-width: 330px;
            box-shadow:
                rgba(60, 66, 87, 0.12) 0px 7px 14px 0px,
                rgba(0, 0, 0, 0.12) 0px 3px 6px 0px;
        }

        h1 {
            text-align: center;
        }

        input,
        select {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            line-height: 28px;
            min-height: 44px;
            background-color: rgb(255, 255, 255);
            box-shadow:
                rgba(60, 66, 87, 0.16) 0px 0px 0px 1px,
                rgba(0, 0, 0, 0) 0px 0px 0px 0px,
                rgba(0, 0, 0, 0) 0px 0px 0px 0px,
                rgba(0, 0, 0, 0) 0px 0px 0px 0px;
            border: unset;
            border-radius: 4px;
            outline-color: rgb(84 105 212 / 0.5);
        }

        @media screen and (max-width: 768px) {

            input,
            select {
                padding: 10px;
                width: 95%;
                min-width: 290px;
                font-size: 17px;
                /* border: 1px solid #aaaaaa; */
            }
        }

        @media screen and (max-width: 480px) {

            input,
            select {
                padding: 10px;
                width: 100%;
                min-width: 220px;
                font-size: 17px;
                /* border: 1px solid #aaaaaa; */
            }
        }

        button {
            background-color: #04AA6D;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
            border-radius: 3px;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid,
        select.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
            margin: auto;
            /* adjust margin as per your needs */
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Make circles that indicate the steps of the form: */
        .circles {
            display: flex;
            justify-content: center;
            margin-top: 27px;
        }

        .step {
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
        }

        .step.active {
            background-color: #4CAF50;
        }



        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #04AA6D;
        }

        label {
            margin-bottom: 10px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        div div h2 {
            letter-spacing: 0px;
            font-size: 36px;
            margin: 5px;
            color: #5469d4;
            text-decoration: unset;
        }

        /* Style for form container */

        .steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            font-family: 'Roboto', sans-serif;
        }

        .steps button {
            background-color: #4CAF50;
            border: none;
            width: 100%;
            height: 60px;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            font-family: 'Roboto', sans-serif;
        }

        .steps #prevBtn {
            background-color: #f44336;
        }

        .steps #submit {
            background-color: #2196F3;
        }


        /* Style for step indicators */
        .steps .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #ddd;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .steps .step.active {
            opacity: 1;
        }

        /* Styles for error messages */
        .error-message {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            color: #ff0000;
            font-weight: bold;
        }

        /* Styles for form elements */
        p {
            margin-bottom: 10px;
        }

        label {
            display: inline-block;
            width: 200px;
            font-weight: bold;
        }

        input[type="text"],
        select {
            padding: 10px;
            border: none;
            border-radius: 3px;
            transition: all 0.1s ease-in-out;
            width: 100%;
        }

        label[for="alt-mobile"] span.optional {
            color: #999;
            font-weight: normal;
            margin-left: 5px;
        }


        input[type="file"] {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        select {
            cursor: pointer;
        }

        input:focus,
        select:focus {
            outline: 3px solid rgba(81, 203, 238, 1);
        }

        /* Tablet plus styles */
        @media (min-width: 768px) {
            label {
                width: 400px;
            }

            input[type="text"],
            select {
                width: 100%;
            }

        }

        div div h2 {
            font-weight: 650;
        }

        input,
        select {
            height: 50px;
        }

        input {
            padding: 9px;
        }
    </style>
    <title>Admission</title>
    <!-- css style go to end here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php //include "../common/header.php"; 
    ?>
    <form id="regForm" action="form_submit.php" method="post" enctype="multipart/form-data">
        <!-- HTML code with added class -->
        <div>
            <div class="header admission-form-header">
                <h2>Online Admission Form</h2>
            </div>
        </div>
        
        
        <!-- CSS code for the new class -->
        <style>
            .admission-form-header {
                padding: 10px;
                text-align: center;
            }
        </style>
        
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
            <hr>
            <p>
                <label for="Stream">Stream</label>
                <select name="stream" id="Stream">
                    <option value="" disabled selected hidden>Select stream</option>
                </select>
                <span id="Stream-error" class="error-message"></span>
            </p>

            <p id="disCourse" style="display:none;">
                <label for="Course">Course</label>
                <select name="course" id="Course">
                    <option value="" disabled selected hidden>Select a course</option>
                </select>
                <span id="Course-error" class="error-message"></span>
            </p>

            <p>
                <label for="last-ssc-exam-board">Last Qualifying S.S.C Exam Board</label><br>
                <select name="last-ssc-exam-board" id="last-ssc-exam-board">
                    <option value="" disabled selected hidden>Select a board</option>
                    <option value="gshseb">GSHSEB</option>
                    <option value="cbse">CBSE</option>
                    <option value="icse">ICSE</option>
                    <option value="ib">IB</option>
                    <option value="other">Other boards</option>
                </select>
                <span id="last-ssc-exam-board-error" class="error-message"></span>
            </p>


            <p>
                <label for="first-input">Select Month and Year of Exam</label><br>
                <input type="month" id="first-input" name="ssc_emy">
                <span id="first-input-error" class="error-message"></span>
            </p>




            <p>
                <label for="per-score">Percentage Scored</label><br>
                <input placeholder="Percentage Scored" id="per-score-ssc" class="per" type="number" min="0" max="100"
                    step="0.01" name="per_ssc">
                <span id="per-score-ssc-error" class="error-message"></span>
            </p>

            <p>
                <label for="ssc-file">Upload your S.S.C Exam result</label><br>
                <input id="ssc-file" type="file" name="ssc_file">
                <span id="ssc-file-error" class="error-message"></span>
            </p>


            <p>
                <label for="last-hsc-exam-board">Last Qualifying H.S.C Exam Board</label><br>
                <select id="last-hsc-exam-board" name="last_hsc_exam_board">
                    <option disabled selected hidden>Select an option</option>
                    <option value="gshseb">GSHSEB</option>
                    <option value="cbse">CBSE</option>
                    <option value="other-boards">Other Boards</option>
                </select>
                <span id="last-hsc-exam-board-error" class="error-message"></span>
            </p>


            <p>
                <label for="second-input">H.S.C Exam Month and Year</label><br>
                <input type="month" id="second-input" placeholder="Select the Month and Year of exam.."
                    name="hsc_exam_month_year">
                <span id="second-input-error" class="error-message"></span>
            </p>

            <p>
                <label for="hsc-percentage-scored">Percentage Scored</label><br>
                <input type="number" id="hsc-percentage-scored" class="per" placeholder="Enter Percentage Scored.."
                    name="per_hsc" min="0" max="100" step="0.01">
                <span id="hsc-percentage-scored-error" class="error-message"></span>
            </p>

            <p>
                <label for="hsc-file">Upload your H.S.C Exam result</label><br>
                <input type="file" id="hsc-file" name="hsc_file">
                <span id="hsc-file-error" class="error-message"></span>
            </p>


        </div>
        <div class="tab">Personal Details
            <hr>
            <p>
                <label for="first-name">Name</label><br>
                <input type="text" id="first-name" name="fname" placeholder="Name">
                <span id="first-name-error" class="error-message"></span>
            </p>
            <p>
                <label for="middle-name">Middle Name</label><br>
                <input type="text" id="middle-name" name="mname" placeholder="Father Name/Mother/Husband">
                <span id="middle-name-error" class="error-message"></span>
            </p>

            <p>
                <label for="last-name">Last Name</label><br>
                <input type="text" id="last-name" name="lname" placeholder="Surname">
                <span id="last-name-error" class="error-message"></span>
            </p>



            <p>
                <label for="dob">Date of Birth</label><br>
                <input type="date" id="dob" name="dob" placeholder="DOB (DD/MM/YYYY)" oninput="this.className = ''">
                <span id="dob-error" class="error-message"></span>
            </p>
            <p>
                <label for="gender">Gender</label><br>
                <select id="gender" name="gender">
                    <option value="" disabled selected hidden>Select your Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="non-binary">Non-Binary</option>
                </select>
                <span id="gender-error" class="error-message"></span>
            </p>
            <p>
                <label for="email">Email</label><br>
                <input id="email" placeholder="E-mail" type="email" value="" name="email" />
                <span id="email-error" class="error-message"></span>
            </p>

            <p>
                <label for="mobile">Mobile No</label><br>
                <input id="mobile" placeholder="Mobile No" type="tel" value="" name="mobile">
                <span id="mobile-error" class="error-message"></span>
            </p>
            <p>
                <label for="alt-mobile">Alternate Mobile No <span class="optional">(optional)</span></label>
                <input id="alt-mobile" class="nocheck" type="tel" name="alt_mno" placeholder="Alternate Mobile No"
                    value="">
                <span id="alt-mobile-error" class="error-message"></span>
            </p>


        </div>
        <div class="tab">More details
            <hr>
            <p>
                <label for="aadhar-no">Aadhar Card No</label>
                <input id="aadhar-no" placeholder="Enter Aadhar no" type="text" name="aadharno">
                <span id="aadhar-no-error" class="error-message"></span>
            </p>


            <p>
                <label for="aadhar-file">Photo of Aadhar Card</label>
                <input id="aadhar-file" type="file" name="aadhar_file" title="Choose your Aadhar card">
                <span id="aadhar-file-error" class="error-message"></span>
            </p>



            <p>
                <label for="cast-select">Select your Cast</label>
                <select name="cast" id="cast-select">
                    <option value="" disabled selected hidden>Choose one</option>
                    <option value="general">General</option>
                    <option value="ST">ST</option>
                    <option value="EWS">EWS</option>
                    <option value="SEBC">SEBC</option>
                    <option value="SC">SC</option>
                </select>
                <span id="cast-select-error" class="error-message"></span>
            </p>


            <p>
                <label for="disability-select">Do you have any kind of Disability?</label>
                <select name="disability" id="disability-select">
                    <option value="" disabled selected hidden>Choose one</option>
                    <option value="none">No disability</option>
                    <option value="hearing">Hearing impairment</option>
                    <option value="visual">Visual impairment</option>
                    <option value="mobility">Mobility impairment</option>
                </select>
                <span id="disability-select-error" class="error-message"></span>
            </p>

        </div>

        <div class="steps">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <button type="button" name="btn_apply" id="submit" onclick="finalvalidateForm()">SUBMIT</button>
        </div>

        <!-- Circles which indicates the steps of the form: -->
        <div class="circles">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
        </div>

    </form>

    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script>
        const sscMonthInput = document.getElementById('first-input');
        const sscMonthError = document.getElementById('first-input-error');

        // add blur event listener to SSC Month input element
        sscMonthInput.addEventListener('blur', (event) => {
            // check if a valid month is selected
            if (!sscMonthInput.checkValidity()) {
                // show error message and set focus on SSC Month input element
                sscMonthError.textContent = 'Please select a valid month';
                sscMonthError.style.display = 'block';
                sscMonthInput.focus();
                sscMonthInput.style.outline = "3px solid red";
            } else {
                // clear error message and reset outline color
                sscMonthError.textContent = '';
                sscMonthError.style.display = 'none';
                sscMonthInput.style.outline = "";
            }
        });

        const perScoreInput = document.querySelector('input[name="per_ssc"]');
        const perScoreError = document.getElementById("per-score-ssc-error");

        // add blur event listener to Percentage Scored input element
        perScoreInput.addEventListener('blur', (event) => {
            const score = parseFloat(perScoreInput.value);

            if (isNaN(score) || score < 0 || score > 100) {
                // show error message and set focus on Percentage Scored input element
                perScoreError.textContent = 'Please enter percentage between 0 to 100.';
                perScoreError.style.display = 'block';
                perScoreInput.focus();
                perScoreInput.style.outline = "3px solid red";
            } else {
                // clear error message and reset outline color
                perScoreError.textContent = '';
                perScoreError.style.display = 'none';
                perScoreInput.style.outline = "";
            }
        });

        const sscFile = document.getElementById("ssc-file");
        const sscFileError = document.getElementById("ssc-file-error");
        const validExtensions = ["png", "jpeg", "jpg", "pdf"];

        sscFile.addEventListener("change", (event) => {
            const file = event.target.files[0];
            // check if a file is selected
            if (!file) {
                sscFileError.textContent = "No file selected";
                sscFileError.style.display = "block";
                sscFile.style.outline = "3px solid red";
                // set focus back to the invalid file input
                sscFile.focus();
            } else if (file.size > 5 * 1024 * 1024) {
                // check if the file size is greater than 5 MB
                sscFileError.textContent = "File size must be less than 5 MB";
                sscFile.style.outline = "3px solid red";
                sscFile.value = "";
                sscFileError.style.display = "block";
                // set focus back to the invalid file input
                sscFile.focus();
            } else {
                // get the file extension
                const extension = file.name.split(".").pop().toLowerCase();
                // check if the file type is valid
                if (!validExtensions.includes(extension)) {
                    sscFileError.textContent = "Invalid file type. Only PNG, JPEG, JPG, and PDF files are allowed.";
                    sscFile.style.outline = "3px solid red";
                    sscFile.value = "";
                    sscFileError.style.display = "block";
                    // set focus back to the invalid file input
                    sscFile.focus();
                } else {
                    // hide the error message if the input is valid
                    sscFileError.style.display = "none";
                    sscFile.style.outline = "";
                }
            }
        });

        const lastHscExamBoard = document.getElementById('last-hsc-exam-board');
        const lastHscExamBoardError = document.getElementById('last-hsc-exam-board-error');

        lastHscExamBoard.addEventListener('blur', () => {
            if (lastHscExamBoard.value === "") {
                lastHscExamBoardError.innerHTML = "Please select an option";
                lastHscExamBoardError.style.color = "red";
                lastHscExamBoard.style.outline = "3px solid red";
                lastHscExamBoard.focus();
            } else {
                lastHscExamBoardError.innerHTML = "";
                lastHscExamBoard.style.outline = "";
            }
        });

        const firstInput = document.getElementById('first-input');
        const secondInput = document.getElementById('second-input');
        const hscExamMonthYearError = document.getElementById('second-input-error');

        //Set minimum date for H.S.C exam input based on the SSC exam input
        firstInput.addEventListener('blur', () => {
            let minDate = new Date(firstInput.value);
            minDate.setFullYear(minDate.getFullYear() + 2);
            secondInput.min = minDate.toISOString().slice(0, 7);
        });

        secondInput.addEventListener('blur', () => {
            if (!secondInput.value) {
                hscExamMonthYearError.innerHTML = "Please select a month and year";
                hscExamMonthYearError.style.color = "red";
                secondInput.style.outline = "3px solid red";
                secondInput.focus();
            } else {
                const sscExamYear = parseInt(firstInput.value.substring(0, 4));
                const sscExamMonth = parseInt(firstInput.value.substring(5, 7));
                const hscExamYear = parseInt(secondInput.value.substring(0, 4));
                const hscExamMonth = parseInt(secondInput.value.substring(5, 7));
                if (hscExamYear - sscExamYear < 2 ||
                    (hscExamYear - sscExamYear === 2 && hscExamMonth < sscExamMonth)) {
                    hscExamMonthYearError.innerHTML = "H.S.C exam must be at least 2 years after SSC exam";
                    hscExamMonthYearError.style.color = "red";
                    secondInput.style.outline = "3px solid red";
                    secondInput.focus();
                } else {
                    hscExamMonthYearError.innerHTML = "";
                    secondInput.style.outline = "";
                }
            }
        });

        const hscPercentageScored = document.getElementById('hsc-percentage-scored');
        const hscPercentageScoredError = document.getElementById('hsc-percentage-scored-error');

        function validatePercentageScored() {
            const percentageScored = hscPercentageScored.value;
            if (percentageScored === '' || percentageScored < 0 || percentageScored > 100) {
                hscPercentageScoredError.textContent = 'Please enter percentage between 0 to 100.';
                hscPercentageScored.style.outline = "3px solid red";
                hscPercentageScored.focus();
                return false;
            }
            hscPercentageScoredError.textContent = '';
            hscPercentageScored.style.outline = "";
            return true;
        }

        hscPercentageScored.addEventListener('blur', validatePercentageScored);

        const hscFile = document.getElementById("hsc-file");
        const hscFileError = document.getElementById("hsc-file-error");

        hscFile.addEventListener("change", (event) => {
            const file = event.target.files[0];
            // check if a file is selected
            if (!file) {
                hscFileError.textContent = "No file selected";
                hscFileError.style.display = "block";
                hscFile.style.outline = "3px solid red";
                // set focus back to the invalid file input
                hscFile.focus();
            } else if (file.size > 5 * 1024 * 1024) {
                // check if the file size is greater than 5 MB
                hscFileError.textContent = "File size must be less than 5 MB";
                hscFile.style.outline = "3px solid red";
                hscFile.value = "";
                hscFileError.style.display = "block";
                // set focus back to the invalid file input
                hscFile.focus();
            } else {
                // get the file extension
                const extension = file.name.split(".").pop().toLowerCase();
                // check if the file type is valid
                if (!validExtensions.includes(extension)) {
                    hscFileError.textContent = "Invalid file type. Only PNG, JPEG, JPG, and PDF files are allowed.";
                    hscFile.style.outline = "3px solid red";
                    hscFile.value = "";
                    hscFileError.style.display = "block";
                    // set focus back to the invalid file input
                    hscFile.focus();
                } else {
                    // hide the error message if the input is valid
                    hscFileError.style.display = "none";
                    hscFile.style.outline = "";
                }
            }
        });


        const lastNameInput = document.getElementById("last-name");
        const lastNameError = document.getElementById("last-name-error");

        // Add event listener for when input loses focus
        lastNameInput.addEventListener("blur", () => {
            const lastNameValue = lastNameInput.value.trim();

            // Check if input is empty
            if (lastNameValue === "") {
                // Display error message
                lastNameError.innerHTML = "Please enter your surname.";
                lastNameInput.style.outline = "3px solid red";
                lastNameInput.focus();
            }
            // Check if input has non-alphabetic characters
            else if (!/^[a-zA-Z]+$/.test(lastNameValue)) {
                // Display error message
                lastNameError.innerHTML = "Please enter only alphabetic characters.";
                lastNameInput.style.outline = "3px solid red";
                lastNameInput.focus();

            }
            // Input is valid
            else {
                // Clear error message
                lastNameError.innerHTML = "";
                lastNameInput.style.outline = "";
            }
        });

        const firstNameInput = document.getElementById("first-name");
        const firstNameError = document.getElementById("first-name-error");

        // Add event listener for when input loses focus
        firstNameInput.addEventListener("blur", () => {
            const firstNameValue = firstNameInput.value.trim();

            // Check if input is empty
            if (firstNameValue === "") {
                // Display error message
                firstNameError.innerHTML = "Please enter your first name.";
                firstNameInput.style.outline = "3px solid red";
                firstNameInput.focus();
            }
            // Check if input has non-alphabetic characters
            else if (!/^[a-zA-Z]+$/.test(firstNameValue)) {
                // Display error message
                firstNameError.innerHTML = "Please enter only alphabetic characters.";
                firstNameInput.style.outline = "3px solid red";
                firstNameInput.focus();
            }
            // Input is valid
            else {
                // Clear error message
                firstNameError.innerHTML = "";
                firstNameInput.style.outline = "";
            }
        });

        const middleNameInput = document.getElementById("middle-name");
        const middleNameError = document.getElementById("middle-name-error");

        // Add event listener for when input loses focus
        middleNameInput.addEventListener("blur", () => {
            const middleNameValue = middleNameInput.value.trim();

            // Check if input is empty
            if (middleNameValue === "") {
                // Display error message
                middleNameError.innerHTML = "Please enter your middle name.";
                middleNameInput.style.outline = "3px solid red";
                middleNameInput.focus();
            }

            // Check if input has non-alphabetic characters or digits or special characters
            else if (!/^[a-zA-Z ]+$/.test(middleNameValue)) {
                // Display error message
                middleNameError.innerHTML = "Please enter only alphabetic characters for your middle name.";
                middleNameInput.style.outline = "3px solid red";
                middleNameInput.focus();

            }
            // Input is valid
            else {
                // Clear error message
                middleNameError.innerHTML = "";
                middleNameInput.style.outline = "";
            }
        });

        const dobInput = document.getElementById('dob'); // get the date of birth input element
        const dobError = document.getElementById('dob-error'); // get the error message element

        dobInput.addEventListener('blur', function () {
            const dob = new Date(this.value); // convert the date input value to a Date object
            const minDate = new Date();
            minDate.setFullYear(minDate.getFullYear() - 16); // calculate the minimum date (16 years ago)

            if (!this.value) { // check if the input is empty
                dobError.textContent = 'Please enter your date of birth'; // show the error message
                dobInput.style.outline = "3px solid red";
                dobInput.focus();
                this.className = 'error'; // add a CSS class to highlight the input field
            } else if (dob > minDate) { // compare the entered date with the minimum date
                dobError.textContent = 'You must be at least 16 years old to register'; // show the error message
                dobInput.style.outline = "3px solid red";
                dobInput.focus();
                this.className = 'error'; // add a CSS class to highlight the input field
            } else {
                dobError.textContent = ''; // clear the error message
                dobInput.style.outline = "";
                this.className = ''; // remove the CSS class
            }
        });

        const genderSelect = document.getElementById('gender');
        const genderError = document.getElementById('gender-error');


        // add an event listener to the form's submit button
        genderSelect.addEventListener('blur', (event) => {
            // prevent the form from submitting by default
            // check if the gender value is empty
            if (!genderSelect.value) {
                // display an error message in the <span> element with id="gender-error"
                genderError.textContent = 'Please select your gender.';
                genderSelect.style.outline = "3px solid red";
                genderSelect.focus();
            } else {
                // clear any previous error messages
                genderError.textContent = '';
                genderSelect.style.outline = "";
            }
        });

        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');

        // add blur event listener to email input field
        emailInput.addEventListener('blur', () => {
            if (emailInput.value === '') { // check if value is empty
                emailError.textContent = 'Email is required'; // display error message
                emailInput.style.outline = "3px solid red";
                emailError.style.display = 'block'; // show error element
                emailInput.focus(); // set focus on email input field
            } else if (!isValidEmail(emailInput.value)) { // check if value is a valid email format
                emailError.textContent = 'Invalid email format'; // display error message
                emailInput.style.outline = "3px solid red";
                emailError.style.display = 'block'; // show error element
                emailInput.focus(); // set focus on email input field
            } else {
                emailError.style.display = 'none'; // hide error element
                emailInput.style.outline = "";
            }
        });

        // function to validate email format
        function isValidEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        const streamSelect = document.getElementById('Stream');
        const streamError = document.getElementById('Stream-error');

        // add blur event listener to stream select element
        streamSelect.addEventListener('blur', (event) => {
            // check if a valid option is selected
            if (streamSelect.value === '') {
                // show error message and set focus on stream select element
                streamError.textContent = 'Please select a stream';
                streamSelect.style.outline = "3px solid red";
                streamError.style.display = 'block';
                streamSelect.focus();
            } else {
                // clear error message
                streamError.textContent = '';
                streamError.style.display = 'none';
                streamSelect.style.outline = "";

            }
        });



        // Caching the DOM elements
        const aadharNoInput = document.getElementById('aadhar-no');
        const aadharNoError = document.getElementById('aadhar-no-error');
        const aadharNoRegex = /^\d{12}$/;

        aadharNoInput.addEventListener('keyup', (event) => {
            const aadharNo = event.target.value.replace(/\s+/g, '');

            // Adding space after every 4 digits in the entered value
            const formattedAadharNo = aadharNo.replace(/(.{4})/g, '$1 ').trim();
            event.target.value = formattedAadharNo;

            // Checking if the entered value is a valid 12-digit Aadhar card number
            const isValidAadharNo = aadharNoRegex.test(aadharNo);

            if (isValidAadharNo) {
                aadharNoError.style.display = 'none';
                aadharNoInput.style.outline = "";
            } else {
                aadharNoInput.style.outline = "3px solid red";
                aadharNoError.textContent = 'Please enter a valid 12-digit Aadhar card number';
                aadharNoError.style.display = 'block';
            }
        });

        const aadharFile = document.getElementById("aadhar-file");
        const aadharFileError = document.getElementById("aadhar-file-error");

        aadharFile.addEventListener("change", (event) => {
            const file = event.target.files[0];
            // check if a file is selected
            if (!file) {
                aadharFileError.textContent = "No file selected";
                aadharFileError.style.display = "block";
                aadharFile.style.outline = "3px solid red";
                // set focus back to the invalid file input
                aadharFile.focus();
            } else if (file.size > 5 * 1024 * 1024) {
                // check if the file size is greater than 5 MB
                aadharFileError.textContent = "File size must be less than 5 MB";
                aadharFile.style.outline = "3px solid red";
                aadharFile.value = "";
                aadharFileError.style.display = "block";
                // set focus back to the invalid file input
                aadharFile.focus();
            } else {
                // get the file extension
                const extension = file.name.split(".").pop().toLowerCase();
                // check if the file type is valid
                if (!validExtensions.includes(extension)) {
                    aadharFileError.textContent = "Invalid file type. Only PNG, JPEG, JPG, and PDF files are allowed.";
                    aadharFile.style.outline = "3px solid red";
                    aadharFile.value = "";
                    aadharFileError.style.display = "block";
                    // set focus back to the invalid file input
                    aadharFile.focus();
                } else {
                    // hide the error message if the input is valid
                    aadharFileError.style.display = "none";
                    aadharFile.style.outline = "";
                }
            }
        });

        const mobileInput = document.getElementById('mobile');
        const altMobileInput = document.getElementById('alt-mobile');
        const mobileError = document.getElementById('mobile-error');
        const altMobileError = document.getElementById('alt-mobile-error');

        // add blur event listener to mobile input field
        mobileInput.addEventListener('blur', () => {
            if (mobileInput.value === '') { // check if value is empty
                mobileError.textContent = 'Mobile number is required'; // display error message
                mobileInput.style.outline = "3px solid red";
                mobileError.style.display = 'block'; // show error element
                mobileInput.focus(); // set focus on mobile input field
            } else if (!isValidMobile(mobileInput.value)) { // check if value is a valid mobile number
                mobileError.textContent = 'Invalid mobile number format'; // display error message
                mobileInput.style.outline = "3px solid red";
                mobileError.style.display = 'block'; // show error element
                mobileInput.focus(); // set focus on mobile input field
            } else {
                mobileError.style.display = 'none'; // hide error element
                mobileInput.style.outline = "";
            }
        });

        // add blur event listener to alternate mobile input field
        altMobileInput.addEventListener('blur', () => {
            if (altMobileInput.value && !isValidMobile(altMobileInput.value)) { // check if value is not empty and not a valid mobile number
                altMobileError.textContent = 'Invalid mobile number format'; // display error message
                altMobileInput.style.outline = "3px solid red";
                altMobileError.style.display = 'block'; // show error element
                altMobileInput.focus(); // set focus on alternate mobile input field
            } else if (altMobileInput.value === mobileInput.value) { // check if alternate mobile number is same as primary mobile number
                altMobileError.textContent = 'Alternate mobile number cannot be same as mobile number'; // display error message
                altMobileInput.style.outline = "3px solid red";
                altMobileError.style.display = 'block'; // show error element
                altMobileInput.focus(); // set focus on alternate mobile input field
            } else {
                altMobileError.style.display = 'none'; // hide error element
                altMobileInput.style.outline = "";
            }
        });


        // function to validate mobile number format
        function isValidMobile(mobile) {
            const regex = /^[6-9]\d{9}$/; // allow only 10 digit mobile number starting with 6,7,8 or 9
            return regex.test(mobile);
        }


        const castSelect = document.getElementById("cast-select");
        const castSelectError = document.getElementById("cast-select-error");

        castSelect.addEventListener("blur", (event) => {
            if (!castSelect.value) {
                castSelectError.innerText = "Please select your cast";
                castSelect.style.outline = "3px solid red";
                castSelectError.style.display = "block";
                castSelect.focus();
            } else {
                castSelectError.style.display = "none";
                castSelect.style.outline = "";
            }
        });

        const disabilitySelect = document.getElementById("disability-select");
        const disabilitySelectError = document.getElementById("disability-select-error");

        disabilitySelect.addEventListener("blur", (event) => {
            if (!disabilitySelect.value) {
                disabilitySelectError.innerText = "Please select your disability status";
                disabilitySelect.style.outline = "3px solid red";
                disabilitySelectError.style.display = "block";
                disabilitySelect.focus();
            } else {
                disabilitySelectError.style.display = "none";
                disabilitySelect.style.outline = "";
            }
        });

        const courseSelect = document.getElementById('Course');
        const courseError = document.getElementById('Course-error');

        // add blur event listener to Course select element
        courseSelect.addEventListener('blur', (event) => {
            // check if a valid option is selected
            if (courseSelect.value === '') {
                // show error message and set focus on Course select element
                courseError.textContent = 'Please select a course';
                courseError.style.display = 'block';
                courseSelect.style.outline = "3px solid red";
                courseSelect.focus();

            } else {
                // clear error message
                courseError.textContent = '';
                courseError.style.display = 'none';
                courseSelect.style.outline = "";
            }
        });

        const boardSelect = document.getElementById('last-ssc-exam-board');
        const boardError = document.getElementById('last-ssc-exam-board-error');

        // add blur event listener to Board select element
        boardSelect.addEventListener('blur', (event) => {
            // check if a valid option is selected
            if (boardSelect.value === '') {
                // show error message and set focus on Board select element
                boardError.textContent = 'Please select a board';
                boardSelect.style.outline = "3px solid red";
                boardError.style.display = 'block';
                boardSelect.focus();
            } else {
                // clear error message
                boardError.textContent = '';
                boardError.style.display = 'none';
                boardSelect.style.outline = "";
            }
        });

        // Calculate the maximum date (16 years ago)
        var today = new Date();
        var maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());

        // Set the maximum date for the input element
        document.getElementById('dob').setAttribute('max', formatDate(maxDate));

        // Format the date as YYYY-MM-DD (required by the "max" attribute)
        function formatDate(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            return year + '-' + month + '-' + day;
        }

        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
                document.getElementById("submit").style.display = "none";
                document.getElementById("nextBtn").style.display = "inline";
            } else if (n == 1) {
                document.getElementById("prevBtn").style.display = "inline";
                document.getElementById("submit").style.display = "none";
                document.getElementById("nextBtn").style.display = "inline";
            } else if (n == 2) {
                document.getElementById("prevBtn").style.display = "inline";
                document.getElementById("submit").style.display = "inline";
                document.getElementById("nextBtn").style.display = "none";
            }


            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }
        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab bye 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...

            // Otherwise, display the correct tab:
            showTab(currentTab);
        }


        function validateForm() {
            // This function deals with validation of the form fields
            var x = document.getElementsByClassName("tab")[currentTab];
            var y = x.querySelectorAll("input:not(.nocheck)");
            var z = x.getElementsByTagName("select");
            var valid = true;

            for (var i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].style.outline = "3px solid red";
                    var errorEl = document.getElementById(`${y[i].id}-error`);
                    errorEl.textContent = "This field is required.";

                    valid = false;
                }
            }

            for (var i = 0; i < z.length; i++) {
                if (z[i].selectedIndex == 0) {
                    z[i].style.outline = "3px solid red";
                    var errorEl = document.getElementById(`${z[i].id}-error`);
                    errorEl.textContent = "This field is required.";

                    valid = false;
                    z[i].addEventListener("change", function (event) {
                        event.target.style.outline = "";
                        event.target.removeEventListener("change", arguments.callee);
                    });
                }
            }

            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
                if (x == 2) {

                }
            }
            return valid;

            // return the valid status
        }

        function finalvalidateForm() {
            if (validateForm()) {
                // Change the button type to "submit"
                var submitBtn = document.getElementById("submit");
                submitBtn.type = "submit";

                // Trigger a click event on the button
                submitBtn.click();
            }
        }



        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
        function validateInput(input) {
            if (input.value > 100) {
                input.classList.add('invalid');
                valid = false;
            } else {
                input.classList.remove('invalid');
            }
        }

        //function for dyanmic dependent Stream,Course Dropdown List
        $(document).ready(function () {
            function stream_func(type, sid) {
                $.ajax({
                    url: "showdropdown.php",
                    type: "POST",
                    data: {
                        type: type,
                        id: sid
                    },
                    success: function (data) {
                        if (type == "coursedata") {
                            $("#Course").html(data);
                        } else {
                            $("#Stream").append(data);
                        }
                    }
                });
            }
            stream_func();
            $("#Stream").on("change", function () {

                var Stream = $("#Stream").val();

                if (Stream != "") {

                    stream_func("coursedata", Stream);
                } else {
                    $("#Course").html("");
                }
            })
        });
    </script>
    <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>