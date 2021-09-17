<?php
include 'header.php';
 ?>
 <title>My Open Diary | About</title>
 <div class="post_container">
   <h2>About</h2>
   <hr style='border: 1px solid gray'>
    <font size='5'>My Open Diary</font><br>
   <b>Creator:</b> Mir Anupam Hossain Akib<br>
   <b>Front-end:</b> HTML, CSS, Bootstrap, JavaScript<br>
   <b>Back-end:</b> PHP, PostgreSQL<br>
   <b>Date of finish:</b> 31<sup>st</sup> August, 2021<br>
 </div>
 <br>

 <div class="post_container">
   <h2>Version History</h2><hr style='border:1px solid gray'>
   <ul>
     <li>1.0 (Test) : Primary version of the site</li>
     <li>1.2 (Test) : Fixed some bugs, added profile view feature</li>
     <li>1.5 (Stable) : Added 'Dark Mode' feature, changed some back-end functionality</li>
     <li>2.1 (Stable) : Added 'Admin Panel', story view count etc.</li>
     <li>2.3 (Stable) : Fixed some minor bugs and backend functionalities.</li>
     <li>2.4 (Stable) : Fixed some bugs.</li>
     <li>2.5 (Stable) : Move to PostgreSQL database and added some features.</li>
   </ul>
 </div>

<br>

 <div class="post_container">
   <h2>Help</h2>
   <hr style='border: 1px solid gray'>
   <ul>
     <li>Every user can view all public stories wrote by other users.</li>
     <li>User need to login or register to write a story</li>
     <li>Only owner can edit/delete his own story</li>
     <li>User can set the visibility of stories while creating a new story.</li>
   </ul>
 </div>

 <br>
 <div class="post_container">
   <h2>Documentation</h2>
   <hr style='border: 1px solid gray'>
   <button type="button" name="button" class="btn btn-primary btn-lg" title="Download PDF documentation for this project (not available)" disabled><i class='fa fa-download'></i> Download</button>
 </div>

<?php include 'footer.php' ?>
