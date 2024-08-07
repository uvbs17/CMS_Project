<?php
require_once "connection/connection.php";
$transaction_id = $_GET['transaction_id'];

require('fpdf/fpdf.php');
class Invoice extends FPDF
{
    private $dept_name;

    function __construct($dept_name)
    {
        parent::__construct();
        $this->dept_name = $dept_name;
    }

    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Image('Images/fav.png', 10, 10, 30, 30);
        $this->Cell(0, 5, 'Bhagwan Mahavir ' . $this->dept_name, 0, 1, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, "Sr.No.149,VIP Road,New City Light Road,B/h Hina \n Bunglows,Bharthana,Vesu,Surat. \n PHONE : (0261) 3247110", 0, 'C');
        $this->Ln(10);
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Transaction ID: ' . $_GET['transaction_id'], 0, 0, 'L');
        $this->Cell(0, 10, 'Offline Payment', 0, 0, 'R');
    }

    function LineItems($transaction_id, $con, $course_name, $sem, $name, $formatted_date, $start_date, $end_date, $enrollment_no, $amount)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(70, 10, "", 0, 0, 'L');
        $this->Cell(50, 10, "College Fee Receipt", 1, 0, 'C');
        $this->Cell(70, 10, "", 0, 1, 'L');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(140, 10, 'Course : ' . $course_name, 0, 0, 'L');
        $this->Cell(50, 10, 'Semester : ' . $sem, 0, 1, 'L');
        $this->Cell(140, 10, 'Recieved From Mr./Miss : ' . $name, 0, 0, 'L');
        $this->Cell(50, 10, "Date : " . $formatted_date . "", 0, 1, 'L');

        $this->Cell(50, 10, 'Financial Year: ' . $start_date . '-' . $end_date, 0, 0, 'L');
        $this->Cell(90, 10, "", 0, 0, 'L');
        $this->Cell(50, 10, 'Enrollment No : ' . $enrollment_no . '', 0, 1, 'L');
        $this->Ln();

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(20, 20, "Sr. No.", 1, 0, 'C');
        $this->Cell(50, 20, "Particulars", 1, 0, 'C');
        $this->Cell(40, 20, "Total Amount (Rs.)", 1, 0, 'C');
        $this->Cell(40, 20, "Received (Rs.)", 1, 0, 'C');
        $this->Cell(40, 20, "Outstanding (Rs.)", 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 12);

        // Add line items for college fees
        $this->Cell(20, 10, '1', 1, 0, 'C');
        $this->Cell(50, 10, 'Tuition Fee', 1, 0, 'L');
        $this->Cell(40, 10, $amount, 1, 0, 'R');
        $this->Cell(40, 10, $amount, 1, 0, 'R');
        $this->Cell(40, 10, '0', 1, 0, 'R');
        $this->Ln();

        // Add line items for college fees
        $this->Cell(20, 10, '', 1, 0, 'C');
        $this->Cell(50, 10, 'Total', 1, 0, 'R');
        $this->Cell(40, 10, $amount, 1, 0, 'R');
        $this->Cell(40, 10, $amount, 1, 0, 'R');
        $this->Cell(40, 10, '0', 1, 0, 'R');
        $this->Ln(); // outputs "five thousand one hundred twenty"
        $this->Ln(); // outputs "five thousand one hundred twenty"
        $this->MultiCell(0, 6, "Transaction Id : " . $transaction_id . " \nPayment Mode : Offline", 0, 'L');

        // Add notes
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(0, 10, 'NOTE : ', 0, 1, 'L');
        $this->MultiCell(0, 5, "1. Online generated fee receipt do not require stamp and sign.\n2. Please attach original receipt with Refund application.\n3. Deposites would be refunded within 6 months after completion of course, only on submission of all original receipts.", 0, 'L');

    }
}

// Prepare the SQL statement with a parameter placeholder
$sql = "SELECT sf.enrollment_no, sf.posting_date, sf.amount, sf.paid_sem, si.middle_name, si.first_name, si.last_name, c.course_name, d.dept_name FROM student_fee sf 
        INNER JOIN student_info si ON sf.enrollment_no = si.enrollment_no 
        INNER JOIN courses c ON si.course_code = c.course_code 
        INNER JOIN department d ON c.dept_id = d.dept_id
        WHERE sf.transaction_id = ? LIMIT 1";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    // Bind the transaction_id parameter to the statement
    mysqli_stmt_bind_param($stmt, "s", $transaction_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the first row from the result set as an associative array
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Get the enrollment_no value from the row
        $enrollment_no = $row['enrollment_no'];
        $date = $row['posting_date']; // assuming $row['posting_date'] contains '2023-04-27 17:47:17'
        $formatted_date = date('d-m-Y', strtotime($date));
        $amount = $row['amount'];
        $sem = $row['paid_sem'];
        $name = strtoupper($row['middle_name'] . ' ' . $row['first_name'] . ' ' . $row['last_name']);
        $course_name = $row['course_name'];
        $dept_name = $row['dept_name'];

        // Determine the starting and ending dates of the financial year (April 1 - March 31)
        $year = date('Y', strtotime($date));
        if (date('m', strtotime($date)) < 4) {
            $start_date = ($year - 1);
            $end_date = $year;
        } else {
            $start_date = $year;
            $end_date = ($year + 1);
        }
    } else {
        // Handle the case where no rows were returned
        echo "No rows found";
        // Close the current tab/window
        echo "<script>window.close();</script>";
        
        
        exit;
    }
} else {
    // Handle the case where the query failed
    echo "Error: " . mysqli_error($con);
    echo "<script>window.close();</script>";
    exit;
}


// Step 3: Instantiate the new class
$invoice = new Invoice($dept_name);
$invoice->SetTitle("College Fee Receipt");
$invoice->SetAuthor("Bhagwan Mahavir College of Computer Application");

// Step 4: Add new pages as needed (optional)
$invoice->AddPage();
// Retrieve the transaction details from the database
// Add line item content, like product details and prices.



// Step 5: Call functions to format each section of the invoice

$invoice->LineItems($transaction_id, $con, $course_name, $sem, $name, $formatted_date, $start_date, $end_date, $enrollment_no, $amount);

// Step 6: Output the finished PDF invoice for download(D) or display(I) (optional)
$invoice->Output("I", "college_fee_receipt.pdf");



// ...
?>