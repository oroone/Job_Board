<?php include_once '../config/init.php'; ?>
<?php include_once '../lib/Job.php'; ?>

<?php
$job = new Job;

$template = new Template('view_applicants.php');


$template->job = $job->getAllApplicants($id);




echo $template;
