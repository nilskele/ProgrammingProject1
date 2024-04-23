<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "../bootstrap/css/bootstrap.min.css" />
    <link rel = "stylesheet" href = "../css/styles.css" />
    <link rel = "stylesheet" href = "../css/reserveren.css" />
<link rel="stylesheet" href="../fontawesome/css/all.css" /> 
<script src="../reserveren.js"></script>
</head>
<body>
<div id = "container">
    <?php
      include('header.php');
    ?>


<section class="up" > 
  <a class = "terug-btn" href = "catalogus.php" > &#8592terug </a>
    <h1  id="title">Reserveren</h1>
   


  </section>
    
    
       

<div class="main-container">
<section id="proditails" class="section-p1">
     
     <div class="single-pro-img">
        <div class="MainImg">
       <img src="../images/img1.jpg" width="60%" id="MainImg" alt="" />
    </div>
       <div class="small-img-group">
         <div class="small-img-col">
           <img
             src="../images/small1.jpeg"
             width="100%"
             class="small-img"
             alt=""
           />
         </div>
         <div class="small-img-col">
           <img
             src="../images/small2.jpeg"
             width="100%"
             class="small-img"
             alt=""
           />
         </div>
         <div class="small-img-col">
           <img
             src="../images/small3.jpeg"
             width="100%"
             class="small-img"
             alt=""
           />
         </div>
         <div class="small-img-col">
           <img
             src="../images/small4.jpeg"
             width="100%"
             class="small-img"
             alt=""
           />
         </div>
       </div>
     </div>


   <div class="single-pro-details">
    <h6 class="cc">canon></h6>
     <h3 class="canon">Canon M50</h3>
     
     
     <select class="reden" >
       <option>Reden</option>
       <option>Project</option>
       <option>Eindproject</option>
       <option>School</option>
       <option>Vrije tijd</option>
       <option>Andere</option>
     </select>
      <h6 class="h6" >aantal</h6>
<div class="antaal-dd">
    
     <input type="number" value="1" class="aantal"  />
      <p class="max">max antaal:4</p>
   </div>    
   
    </div>
    </div>
  
    
   
    

   </div>
 </section>
 </div>
 <div class="btn">
 <button class="reserveren-btn" >Nu reserveren</button>
 <a class = "verder-btn" href = "catalogus.php"> Verderzoeken </a>
 </div>
 
     
   
</body>  
</html>