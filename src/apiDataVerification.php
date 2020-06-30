<?php
// Completed by Hannah Carl
include 'apiDataPull.php';

class apiDataVerify {

  // Function verifies the updated date is later than created from the API
  public function verifyDate($createdAt, $updatedAt): void {
    $createdTime = new DateTime($createdAt);
    $updatedTime = new DateTime($updatedAt);

    printf("-----------------------------------------------------------------------\n");
    printf("\nDate Verification\n");

    if($updatedTime > $createdTime){
      echo "Updated time of " . $updatedAt . " is later than the created time of " . $createdAt . "\n";
    }
    else{
      echo "Failure: Updated time was not later than the created time\n";
    }
  }

  // Function verifies repository count
  public function verifyReposCount($publicReposCount, $reposURL, $context): void {
    $pageNumber = 1;
    $urlRepoCount = 0;

    // Loop until counter is greater than or matches expected count
    // Secoundary check on page number to ensure that it doesn't continue to search if the page is 
    // a 404 or doesn't have values. It's set to 10, but this could be changed in the future if needed.
    while(($urlRepoCount < $publicReposCount) && ($pageNumber < 10)) {
      $repoURLInfo = file_get_contents($reposURL . "?page=" . $pageNumber, false, $context);
      $urlRepoCount += substr_count($repoURLInfo, "full_name");
      $pageNumber += 1;
    }

    printf("-----------------------------------------------------------------------\n");
    printf("\nRepository Count Verification\n");

    if($urlRepoCount === $publicReposCount){
      echo "Repository Counter: Verified\n";
      echo "Repository Count: " . $urlRepoCount . "\n";
    }
    else{
      echo "Respository Counter: Not Verified\n";
    }
  }
};

// Create new instance and run functions
$apiDataVerify = new apiDataVerify;
$apiDataVerify->verifyDate($mainArray["created_at"],$mainArray["updated_at"]);
$apiDataVerify->verifyReposCount($mainArray["public_repos"],$mainArray["repos_url"], $context);
?>