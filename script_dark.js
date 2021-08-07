//alert("connected");
function msg(txt, color){
  if(color=='green'){
    document.getElementById('tmp').innerHTML="<div class='msg_box' style='background:#87ff8d; color:darkgreen; border-left:5px solid green; '>"+txt+" <i class='fa fa-close' id='close' onclick='document.getElementById(\"tmp\").innerHTML=\"\"' ></i></div>";
  }
  else if(color=='red'){
    document.getElementById('tmp').innerHTML="<div class='msg_box' style='background:#ffb6ab; color:darkred; border-left:5px solid red;'>"+txt+" <i class='fa fa-close' id='close' onclick='document.getElementById(\"tmp\").innerHTML=\"\"' ></i></div>";
  }
  else{
    document.getElementById('tmp').innerHTML="<div class='msg_box' style='background:#fcffa1; color:#5e6100; border-left:5px solid #c5cc00;'>"+txt+" <i class='fa fa-close' id='close' onclick='document.getElementById(\"tmp\").innerHTML=\"\"' ></i></div>";
  }
  window.setTimeout(function() { document.getElementById('tmp').innerHTML=''; }, 4000);
}

function change_pp(){
  document.getElementById('upload_image').innerHTML = "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\"><h3>Select Profile Picture: (Max 2MB)</h3><font color='red' style='float:left; padding-bottom:5px;'>Square image recommended</font><br><input class='input_field' type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" required><br><input class='my_button' type=\"submit\" value=\"UPLOAD PICTURE\" name=\"submit_pp\"></form>";
}

function active_btn_effect(active){
  if(active=='first'){
    document.getElementById('first_btn').style.boxShadow = "inset -7px 0 7px -7px rgba(0,0,0,0.4)";
    document.getElementById('first_btn').style.background = "#262626";
    document.getElementById('second_btn').style.background = "#35353d";
    document.getElementById('second_btn').style.color = "#b5b5b5";
    document.getElementById('second_btn').style.fontWeight = "normal";
    document.getElementById('second_btn').style.boxShadow = "inset 0 -8px 7px -7px rgba(0,0,0,0.22)";
  }
  else{
    document.getElementById('second_btn').style.boxShadow = "inset 7px 0 7px -7px rgba(0,0,0,0.4)";
    document.getElementById('second_btn').style.background = "#262626";
    document.getElementById('first_btn').style.background = "#35353d";
    document.getElementById('first_btn').style.color = "#b5b5b5";
    document.getElementById('first_btn').style.fontWeight = "normal";
    document.getElementById('first_btn').style.boxShadow = "inset 0 -8px 7px -7px rgba(0,0,0,0.22)";
  }
}
