"use strict";$(function()
{
    var e=document.getElementById("createApp")
    ;const t=document.querySelector(".app-credit-card-mask"),
    n=document.querySelector(".app-expiry-date-mask"),
    c=document.querySelector(".app-cvv-code-mask");
    let r;function l(){t&&(r=new Cleave(
        t,{creditCard:!0,onCreditCardTypeChanged:function(e)
        {document.querySelector(".app-card-type").innerHTML=""!=e&&"unknown"!=e?'<img src="'+assetsPath+"img/icons/payments/"+e+'-cc.png" class="cc-icon-image" height="28"/>':""}}))}n&&new Cleave(n,{date:!0,delimiter:"/",datePattern:["m","y"]}),c&&new Cleave(c,{numeral:!0,numeralPositiveOnly:!0}),
    e.addEventListener("show.bs.modal",function(e){var t=document.querySelector("#wizard-create-app");if(null!==t){var n=[].slice.call(t.querySelectorAll(".btn-next")),c=[].slice.call(t.querySelectorAll(".btn-prev")),r=t.querySelector(".btn-submit");const a=new Stepper(t,{linear:!1});n&&n.forEach(e=>{e.addEventListener("click",e=>{a.next(),l()})}),c&&c.forEach(e=>{e.addEventListener("click",e=>{a.previous(),l()})}),r&&r.addEventListener("click",e=>{alert("Submitted..!!")})}})});
