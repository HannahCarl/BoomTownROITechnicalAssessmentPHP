# BoomTownROITechnicalAssessmentPHP
---

## To run 
1. Clone repo
2. In your console or terminal, 'cd' your path to the /src folder
3. Run 'php apiDataVerification.php'

---

## Output
**1. Lists URL's status codes and relevant ID's with object name if applicable**

-----------------------------------------------------------------------

|   URL |https://api.github.com/orgs/BoomTownROI/member               |

|Status |HTTP/1.1 404 Not Found                                       |

-----------------------------------------------------------------------

|   URL |https://api.github.com/orgs/BoomTownROI/public_members       |

|Status |HTTP/1.1 200 OK                                              |

-----------------------------------------------------------------------

|   Key |Value                                                        |

|    id |12473631                                                     |

|    id |5915162                                                      |

|    id |646406                                                       |

|    id |682368                                                       |

|    id |5933413                                                      |

|    id |171873                                                       |

|    id |3579671                                                      |

-----------------------------------------------------------------------

|   URL |https://api.github.com/orgs/BoomTownROI/member               |

|Status |HTTP/1.1 404 Not Found                                       |

**2. Date Verification**

-----------------------------------------------------------------------

Date Verification

Updated time of 2020-04-21T23:30:09Z is later than the created time of 2011-11-22T21:48:43Z

**3. Repository Count Verification**

-----------------------------------------------------------------------

Repository Count Verification

Repository Counter: Verified

Repository Count: 41