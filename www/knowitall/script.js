$(document).ready(function(){
  $(".ui.dropdown").dropdown({on: "click"});
  $(".ui.checkbox").checkbox();
  $(".ui.radio.checkbox").checkbox();
  $('.ui.rating').rating();
  $('.ui.rating.readonly').rating('disable');
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

$(document).on("click", "button.delete-opt", function(){
  var clicked = $(this);
  clicked.parent().remove();
});

$(".add-opt").on("click", function(){
  var clicked = $(this);
  var newOpt = clicked.siblings("input").val();
  var lastOpt = clicked.parent();
  if(newOpt != "")
    lastOpt.before("<div class=\"custom-pad-vert-small\"> <button class=\"ui mini button delete-opt\" type=\"button\">Delete</button><input readonly class=\"option\" name=\"options[]\" value=\"" + newOpt + "\"></input></div>");
  clicked.siblings("input").val('');
});

$("#show-results").on("click", function(){
  $(".dimmer").dimmer("hide");
});

$("input[name=createTitle]").on("keyup", function(){
  var title = $(this);
  var tokenized = title.val().split(" ");
  var nodupe = new Array(), i;
  $("input[name=tags]").val("");
  for(i = 0; i < tokenized.length; i++){
    if($.inArray(tokenized[i], nodupe) < 0){
      nodupe.push(tokenized[i]);
      $("input[name=tags]").val($("input[name=tags]").val() + " " + tokenized[i])
    }
  }
});

$("input[name=tags]").on("keyup", function(){
  var tagArea = $(this);
  if(tagArea.val().length > 2 && tagArea.val().charAt(tagArea.val().length-1) == ' ' && tagArea.val().charAt(tagArea.val().length-2) == ' '){
    var newTagArea = tagArea.val();
    newTagArea = newTagArea.substring(0, newTagArea.length-1);
    tagArea.val(newTagArea);
  }
  var tokenized = tagArea.val().split(" ");
  tokenized = tokenized.filter(function(v){return v !== ""});
  if(tokenized.length > 10){
    $(".label.no-more").addClass("active");
    var txt = tagArea.val();
    txt = txt.substring(0, txt.length-2);
    tagArea.val(txt);
  }else{
    $(".label.no-more").removeClass("active");
  }
});

$(".ui.rating").on("click", function(){  
  var rating = $(".ui.rating").rating("get rating");
  $("input[name=rating]").val(rating);
  //console.log(rating);
});

$(".ui.radio.checkbox").on("click", function(){
  var clicked = $(this);
  $(".match-radio").val("");
  clicked.find(".match-radio").val("on");
});

$(".delete-opt-btn").on("click", function(){
  var clicked = $(this);
  var optid = clicked.siblings(".match-radio").attr("name");
  var surveyid = clicked.siblings("input[name=surveyid]").val()
  window.location.replace("http://localhost/www/knowitall/delete-option-help.php?deleteID=" + optid + "&id="+surveyid);
});


$("input[name=signupEmail]").on("keyup", function(){
  var curr = $(this);
  var email = curr.val();
  var endNum = email.length;
  endNum = endNum - 8;
  var end = email.substring(endNum);
  //console.log(end);
  var valid = "@usc.edu";
  if(end === valid){
    $(".valid-email").removeClass("active");
    if(!($(".valid-id").hasClass("active"))){
      $("#signup-button").removeClass("disabled");
    }
    console.log("True");
  }else{
    $("#signup-button").addClass("disabled");
    $(".valid-email").addClass("active");
    console.log("False");
  }
});

$("input[name=signupID]").on("keyup", function(){
  var curr = $(this);
  var id = curr.val();
  if(id.length == 10){
    $(".valid-id").removeClass("active");
    if(!($(".valid-email").hasClass("active"))){
      $("#signup-button").removeClass("disabled");
    }
    console.log("True");
  }else{
    $("#signup-button").addClass("disabled");
    $(".valid-id").addClass("active");
    console.log("False");
  }
});