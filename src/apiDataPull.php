<?php
// Completed by Hannah Carl

// Global variables
$githubAPIURL = 'https://api.github.com/orgs/BoomTownROI';
$urlAPIArray = array();
$mainArray = array();

// Setup context
$context = stream_context_create(
  array(
      "http" => array(
          "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
      )
  )
);

class apiDataPull {

  // Get information from API
  public function getGithubAPIInfo($githubAPIURL, $context): array {

    // The line below pulls directly from the live github api
    $mainJSON = file_get_contents($githubAPIURL, false, $context);
    // To prevent excessive pulls, I used a downloaded json in /resources for developing
    //$mainFilePath = '../resources/main.json';
    //$mainJSON = file_get_contents($mainFilePath);
    $mainArray = json_decode($mainJSON, true);

    return $mainArray;

  }

  // Get information from URL's from API information above
  public function getGithubAPIURL($githubAPIURL, $mainArray): array {
    $urlArray = array();

    // Find url values that include "api.github.com/orgs/BoomTownROI"
    // Parse through any secondary urls and make sure those are included
    foreach ($mainArray as $mainValue) {
      if (strpos($mainValue, $githubAPIURL) !== false) { 
        // Clean up secondary url location
        if(strpos($mainValue, '{') !== false) { 
          $mainValue = str_replace('}', '', $mainValue);
          $secondaryURL = explode('{',$mainValue);
          array_push($urlArray, $secondaryURL[0], $githubAPIURL . $secondaryURL[1]);
        }
        else{
          $urlArray[] = $mainValue; 
        }
      }
    }
    return $urlArray;
  }

  // Check the status of a request for each URL
  public function checkURLStatus($urlAPIArray, $context, $githubAPIURL): void {
    $mask = "|%6.6s |%-60.60s |\n";

    foreach ($urlAPIArray as $urlToVisit) {
      $headerArray = get_headers($urlToVisit, 1, $context);

      // Failed status
      if(strpos($headerArray[0], '200') === false) { 
        printf("-----------------------------------------------------------------------\n");
        printf($mask, "URL", $urlToVisit);
        printf($mask, 'Status', $headerArray[0]);
      }
      // 200 response status
      else {
        $pageInfo = file_get_contents($urlToVisit, 1, $context);
        $subJSONObj = json_decode($pageInfo);
        printf("-----------------------------------------------------------------------\n");
        printf($mask, "URL", $urlToVisit);
        printf($mask, 'Status', $headerArray[0]);
        printf("-----------------------------------------------------------------------\n");
        printf($mask, 'Key', 'Value');
        // each sub directory of https://api.github.com/orgs/BoomTownROI
        if($urlToVisit !== $githubAPIURL){
          foreach($subJSONObj as $row) {
            foreach($row as $key => $val) {
              if($key === "id"){
                printf($mask, $key, $val);
              }
            }
          }
        }
        // main https://api.github.com/orgs/BoomTownROI page
        else{
          foreach($subJSONObj as $key => $val) {
            if($key === "id"){
              printf($mask, $key, $val);
            }
          }
        }
      }
    };
  }
};

// Create new instance and run functions
$apiData = new apiDataPull;
$mainArray = $apiData->getGithubAPIInfo($githubAPIURL, $context);
$urlAPIArray = $apiData->getGithubAPIURL($githubAPIURL, $mainArray);
$apiData->checkURLStatus($urlAPIArray, $context, $githubAPIURL);
?>