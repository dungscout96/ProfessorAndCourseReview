<?php
include_once('db_connect.php');

session_start();

//print_r($_POST);

$userID = $_SESSION['user_id'];
echo "user id: " . $userID;
//$profID = $_POST['profID'];
//$courseID = $_POST['courseID'];
$college = $_POST['college'];
$department = $_POST['department'];
$course = $_POST['course'];
$professor = $_POST['professor'];
$textbook = $_POST['isTextRequired'];
//echo "textbook require value: " . $textbook;
$easiness = $_POST['easiness'];
$courseReview = $_POST['review'];
$usefulness = array_key_exists('usefulness', $_POST) ? $_POST['usefulness'] : 'NULL';
$tips = array_key_exists('usefulness', $_POST) ? $_POST['tips'] : 'NULL';
$overall = $_POST['overall'];

//if ($courseID == null) {
	/** search for course id
	 *  No checking for result to exist yet */
	/* college id */
	$getCollege = $db->query("SELECT id FROM college WHERE name='$college'");
	$resultCollege = $getCollege->fetch();
	$collegeID = $resultCollege['id'];
	//printf("College id: %d\n", $collegeID);

	/* department id */
	$getDept = $db->query("SELECT id FROM department WHERE name='$department' AND college_id=$collegeID");
	$resultDept = $getDept->fetch();
	$deptID = $resultDept['id'];
	printf("Department id: %d\n", $deptID);

	/* professor id */
	$getProf = $db->query("SELECT id FROM professor WHERE dept_id=$deptID AND name='$professor'");
	$resultProf = $getProf->fetch();
	$profID = $resultProf['id'];
	printf("Professor id: %d\n", $profID);

	/* course id */
	$getCourse = $db->query("SELECT id FROM course WHERE name = '$course'  AND dept_id='$deptID'");
	$resultCourse = $getCourse->fetch();
	$courseID = $resultCourse['id'];
	printf("Course id: %d\n", $courseID);


/* Add review to course */
$query = $db->prepare("INSERT INTO course_review VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
$result = $query->execute(array($userID, $courseID, $profID, $easiness, $textbook, $courseReview, $usefulness, $tips, $overall));

if ($result) {
	printf("<p>You have reviewed course <b>%s</b>! If you have not reviewed professor <b>%s</b> yet, please take some minutes to <a href='professor_review.php'>review</a> or click <a href='main.html'>here</a> to go back to main page</p>", $course, $professor);
}
else {
	printf("<p>You have already reviewed course <b>%s</b> with professor <b>%s</b>. Please <a href='main.html'>update</a> your review or <a href='course_review.php'>review</a> a new course</p>", $course, $professor);
}

?>

<html>
<head>
<title>Review added</title>

</head>
<body>
<script type="text/javascript">
	//console.log("college: " + "<?php echo $college ?>");
	sessionStorage.setItem('college', "<?php echo $college ?>");
	sessionStorage.setItem('department', "<?php echo $department ?>");
	sessionStorage.setItem('course', "<?php echo $course ?>");
	sessionStorage.setItem('professor', "<?php echo $professor ?>");
	sessionStorage.setItem('profID', "<?php echo $profID ?>");
	sessionStorage.setItem('courseID', "<?php echo $courseID ?>");

</script>

</body>
</html>