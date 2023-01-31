<?php 
session_start(); 
$color="navbar-dark cyan darken-3";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="SHORTCUT ICON" href="images/fibble.png" type="image/x-icon" />
    <link rel="ICON" href="images/fibble.png" type="image/ico" />

    <title>CFCPD</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

  </head>
  <?php
    if( $_SESSION['role']==0 || $_SESSION['role']==1  ){
  ?>
  <body class="violetgradient">
    <?php include 'navbar.php'; ?>
    <center>
        <div class="customalert">
            <div class="alertcontent">
                <div id="alertText"> &nbsp </div>
                <img id="qrious">
                <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
                <button id="closebutton" class="formbtn"> Done </button>
            </div>
        </div>
    </center>

    <div class="bgroles">
      <center>
        <div class="mycardstyle">
            <div class="greyarea">
                <h5> Please fill the following information  </h5>
                <form id="form2" autocomplete="off">
                    <div class="formitem">
                        <label type="text" class="formlabel"> Product ID </label>
                        <input type="text" class="forminput" id="prodid" onkeypress="isInputNumber(event)" required>
                        <label class=qrcode-text-btn style="width:4%;display:none;">
                            <input type=file accept="image/*" id="selectedFile" style="display:none" capture=environment onchange="openQRCamera(this);" tabindex=-1>
                        </label>
                        <button class="qrbutton2" onclick="document.getElementById('selectedFile').click();" style="margin-bottom: 5px;margin-top: 5px;">
                        <i class='fa fa-qrcode'></i> Scan QR
		                </button
                    </div>
                    <div class="formitem">
                      <label type="text" class="formlabel">Customer Details</label>
                    </div>
                    <div class="formitem">
                        <label type="text" class="formlabel"> Name </label>
                        <input type="text" class="forminput" id="cust_name" required>
                    </div>
                    <div class="formitem">
                        <label type="text" class="formlabel"> Phone Number </label>
                        <input type="text" class="forminput" id="cust_ph_no" required>
                    </div>
                      <!-- <input type="text" class="forminput" id="currRole" required> -->
                    </div>
                    <button class="formbtn" id="mansub" type="submit">Update</button>
                </form>
            </div>
      </center>
    <?php
    }else{
        include 'redirection.php';
        redirect('index.php');
    }
    ?>

    <div class='box'>
      <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Web3.js -->
    <script src="web3.min.js"></script>

    <!-- QR Code Library-->
    <script src="./dist/qrious.js"></script>

    <!-- QR Code Reader -->
	<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <script src="app.js"></script>

    <!-- Web3 Injection -->
    <script>
      // Initialize Web3
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      } else {
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      }

      // Set the Contract
    var contract = new web3.eth.Contract(contractAbi, contractAddress);



    $("#manufacturer").on("click", function(){
        $("#districard").hide("slow");
        $("#manufacturercard").show("slow");
    });

    $("#distributor").on("click", function(){
        $("#manufacturercard").hide("fast","linear");
        $("#districard").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });

    // Code for detecting location

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    function showPosition(position) {
        var autoLocation = position.coords.latitude +", " + position.coords.longitude;
        $("#prodlocation").val(autoLocation);
    }

    $('#form2').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodid = $('#prodid').val();
        cust_name = $('#cust_name').val();
        cust_ph_no = $('#cust_ph_no').val()
        console.log(prodid);
        console.log(cust_name);
        console.log(cust_ph_no);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        var info = "<br><br>Customer Name: "+cust_name+"<br>Contact: "+cust_ph_no+"<br>Selling Time: "+today;
        web3.eth.getAccounts().then(async function(accounts) {
          var prod = await contract.methods.allProducts(prodid).call();
          var receipt = await contract.methods.sellProduct(prodid, info).send({ from: accounts[0], gas: 1000000 })
          console.log(prod["0"]+" product ");
          if (!prod["0"]){
            var msg="Item has been sold successfully !! ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          }
          else{
            var msg="Item has been already Sold !! ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          }
        });
        $("#prodid").val('');
      });


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }


    function openQRCamera(node) {
		var reader = new FileReader();
		reader.onload = function() {
			node.value = "";
			qrcode.callback = function(res) {
			if(res instanceof Error) {
				alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
			} else {
				node.parentNode.previousElementSibling.value = res;
				document.getElementById('searchButton').click();
			}
			};
			qrcode.decode(reader.result);
		};
		reader.readAsDataURL(node.files[0]);
	}

  function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    $("#aboutbtn").on("click", function(){
        showAlert("A Decentralised End to End Logistics Application that stores the whereabouts of product at every freight hub to the Blockchain. At consumer end, customers can easily scan product's QR CODE and get complete information about the provenance of that product hence empowering	consumers to only purchase authentic and quality products.");
    });

    </script>
  </body>
</html>

