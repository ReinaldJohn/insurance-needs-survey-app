!function(e){"use strict";e(window).on("load",(function(){e('[data-loader="circle-side"]').fadeOut(),e("#preloader").delay(350).fadeOut("slow"),e("body").delay(350).css({overflow:"visible"})})),new MutationObserver((function(){})).observe(document,{childList:!0,subtree:!0});var r=!1;e("#process").css("cursor","no-drop"),e("#termsCheckbox").on("change",(function(){r=e(this).is(":checked"),e("#process").css("cursor",r?"pointer":"no-drop")})),e("#wizard_container").wizard({stepsWrapper:"#wrapped",submit:".submit",beforeSelect:function(t,o){if(0!=e("input#website").val().length)return!1;if(!o.isMovingForward)return!0;var n=e(this).wizard("state").step.find(":input");return o.step.hasClass("submit")&&e("#process").on("click",(function(t){if(t.preventDefault(),!r)return toastr.warning("Please accept the terms and conditions."),!1;e("#loader_form").css("display","block");for(var o=new FormData(document.querySelector("#wrapped")),n={},s={},a=1;a<=7;a++){var i=e("#question_1_opt_"+a),c=e("#question_2_opt_"+a);n["q"+a]=i.is(":checked")?1:0,s["q"+a]=c.is(":checked")?1:0}o.append("question_1",JSON.stringify(n)),o.append("question_2",JSON.stringify(s)),axios.post("/submit-form",o,{headers:{"X-CSRF-TOKEN":e('meta[name="csrf-token"]').attr("content"),"Content-Type":"multipart/form-data"}}).then((function(r){e("#loader_form").css("display","none"),"success"===r.data.status?(e("#wrapped")[0].reset(),window.open("/thankyou","_blank"),location.reload()):console.error("Error in saving form:",r.data.message)})).catch((function(r){e("#loader_form").css("display","none"),console.error("Error in sending:",r.response.data.message)}))})),!n.length||!!n.valid()}}).validate({errorPlacement:function(e,r){r.is(":radio")||r.is(":checkbox")?e.insertBefore(r.next()):e.insertAfter(r)}}),e("#progressbar").progressbar(),e("#wizard_container").wizard({afterSelect:function(r,t){e("#progressbar").progressbar("value",t.percentComplete),e("#location").text("("+t.stepsComplete+"/"+t.stepsPossible+")")}}),e("#wrapped").validate({ignore:[],rules:{select:{required:!0}},errorPlacement:function(e,r){r.is("select:hidden")?e.insertAfter(r.next(".nice-select")):e.insertAfter(r)}});var t=e("form#wrapped");t.on("submit",(function(){t.validate(),t.valid()&&e("#loader_form").fadeIn()})),e("#modal_h").magnificPopup({type:"inline",fixedContentPos:!0,fixedBgPos:!0,overflowY:"auto",closeBtnInside:!0,preloader:!1,midClick:!0,removalDelay:300,closeMarkup:'<button title="%title%" type="button" class="mfp-close"></button>',mainClass:"my-mfp-zoom-in"}),e("#trades_performed").select2({placeholder:"Select the trade, or trades you perform here.."}),e("#phone_no").on("input",(function(){var r=e(this).val().replace(/[^\d]/g,"");r.length>10&&(r=r.slice(0,10)),7==r.length?r=r.replace(/(\d{3})(\d{4})/,"$1-$2"):10==r.length&&(r=r.replace(/(\d{3})(\d{3})(\d{4})/,"($1) $2-$3")),e(this).val(r)}))}(window.jQuery);
//# sourceMappingURL=common.js.map